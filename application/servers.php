<?php

    class Servers extends CI_Controller
    {     
        
        function __construct()
        {
            parent::__construct();           
        }
        
        function index()//lists all servers to a table
        {
            //all includes must to be loaded!
//            $this->output->cache(2);//cache
            
            //GameQ settings
            $gq = new GameQ();
    		$gq->setOption('timeout', 5); // Seconds
    		$gq->setOption('debug', FALSE);
    		$gq->setFilter('normalise');
			$gq->setOption('sock_start', 10000);

$gq->setOption('sock_count', 8);
            
            //getting servers data from the database
            //params: table name, query limit
            $query = $this->server_m->get_entries('servers', 3);
            
            foreach($query as $row)
            {
                //generating array to send to GameQ
    			$servers = array(
    				array(
    					'id' => $row['id'],
    					'host' => $row['address'],
    					'type' => 'cs16'
    				)
    			);
                //getting array with data from the GameQ
    			$gq->addServers($servers);
    			$results_tmp = $gq->requestData();
                
                //if not online - fuck out
                if(!$results_tmp[$row['id']]['gq_online'])
                {
                    $this->server_m->remove_entry($row['id']);
                }
                
    			//preparing array to parsing
    			$results['content'] = $results_tmp;
            }         
            //parsing
            foreach($results['content'] as $key => $value)
            {
    			$results['content'][$key]['id'] = $key;
            }

		$this->parser->parse('main_view', $results);
 
        }//func        

/*************************************************************************/        
        
        function stats($id = '') //getting single server data
        {
//            $this->output->cache(2);//cache
      		$query = $this->server_m->get_entry('servers', $id); //returns $query
            
            
            //GameQ settings
            $gq = new GameQ();
    		$gq->setOption('timeout', 5); // Seconds
    		$gq->setOption('debug', FALSE);
    		$gq->setFilter('normalise');
			$gq->setOption('sock_start', 10000);

$gq->setOption('sock_count', 8);
            
            
            $servers = array(
    				array(
    					'id' => $query['id'],
    					'host' => $query['address'],
    					'type' => 'cs16'
    				)
    			);
                
            $gq->addServers($servers);
            $results = $gq->requestData();       
//            echo '<pre>';
//            print_r($results[$query['id']]);
//            echo '</pre>';
            $this->parser->parse('single_view', $results[$query['id']]);
            
        }//func
        
    }//class
        
        