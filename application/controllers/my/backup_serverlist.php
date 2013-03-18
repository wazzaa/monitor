<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Serverlist extends CI_Controller {


	public function index()
	{
	   
       $this->load->library('parser');
       $this->load->library('GameQ/GameQ'); //load Gameq
	   $this->load->model('serverlist_m'); //get data from database
       
        $result = $this->serverlist_m->get_entries('servers', 5);
       
       
        $gq = new GameQ(); // or $gq = GameQ::factory();
        $gq->setOption('timeout', 5); // Seconds
        $gq->setOption('debug', TRUE);
        $gq->setFilter('normalise');
       
       
        foreach($result as $row)
        {
            $servers = array(
        		array(
        			'id' => $row->id,
        			'type' => 'cs16',
        			'host' => $row->address,
        		)	
        	);
            
         $gq->addServers($servers);
         $results = $gq->requestData();  
//         $results[$row->id]['gq_hostname'] = nl2br(htmlspecialchars(iconv('CP1251', 'UTF-8//TRANSLIT', $results[$row->id]['gq_hostname'])));  
        }
        

      $replace = array(
      
      'content' => $results
      
      );
      
      
      

//        $replace = array(      
//        'content' => $results      
//        );
        
         echo '<pre>';
        print_r($replace);
        echo '</pre>';
        
		$this->parser->parse('welcome_message', $replace);
	}
}