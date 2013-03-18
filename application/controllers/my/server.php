<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Serverlist extends CI_Controller {

	public function index()
	{
	   
       $this->load->library('parser');
       $this->load->library('GameQ/GameQ'); //load Gameq
	   $this->load->model('serverlist_m'); //get data from database
       
        $result = $this->serverlist_m->get_entries('servers', 2);
       
       
        $gq = new GameQ(); // or $gq = GameQ::factory();
        $gq->setOption('timeout', 5); // Seconds
        $gq->setOption('debug', FALSE);
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
        
        }  
     
//        $replace = array(      
//        'content' => $results,
//        );
        
//		echo '<pre>';
//       print_r($results);
//		echo '</pre>';

        
//		$this->parser->parse('welcome_message', $replace);   
        
        		$this->load->view('welcome_message');
	}
}