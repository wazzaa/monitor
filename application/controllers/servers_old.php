<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Servers extends CI_Controller
    {     
        
        function __construct()
        {
            parent::__construct();     
$this->load->driver('cache');			
        }
        
		function index()
		{
	
//			$this->output->cache(2);
			/* GameQ library settings */
			$gq = new GameQ();
			$gq->setOption('timeout', 5);
			$gq->setOption('debug', TRUE);
			$gq->setFilter('normalise');
			/* Getting data from database */
			$query = $this->server_m->get_entries('servers', 20);
			$servers = array();
			foreach($query as $row)
			{
				/* Preparing array to send to GameQ.php */

					$servers[] = array(
						'id' => $row['id'],
						'host' => $row['address'],
						'type' => 'cs16'
					);
			}
				/* Getting array with data abot server from Gameq */
				$gq->addServers($servers);
				$results_tmp = $gq->requestData();
				/* Preparing array to parsing */
				$results['content'] = $results_tmp;
			
			/* Parsing */
			foreach($results['content'] as $key => $value)
			{
				$results['content'][$key]['id'] = $key;
				/* If server offline - don't show in list */
				if (!$results['content'][$key]['gq_online'])
				{
					//remove from database
					unset($results['content'][$key]);
				}
				
			}
	

//	$this->output->cache(2);
			$this->parser->parse('main_view', $results);		

		} //func

		
		
		
		
		
		
	function aa()
	{
	//$this->load->driver('cache');
	

		if (!$this->cache->file->get("name"))
		{
			$gq = new GameQ();
			$gq->setOption('timeout', 5);
			$gq->setOption('debug', TRUE);
			$gq->setFilter('normalise');
			// Getting data from database 
			$query = $this->server_m->get_entries('servers', 60 * 5);
			$servers = array();
			foreach($query as $row)
			{
				// Preparing array to send to GameQ.php

					$servers[] = array(
						'id' => $row['id'],
						'host' => $row['address'],
						'type' => 'cs16'
					);
			}
				// Getting array with data about server from Gameq 
				$gq->addServers($servers);
				$results_tmp = $gq->requestData();
				// Preparing array to parsing
			$results['content'] = $results_tmp;	
			
			foreach($results['content'] as $key => $value)
			{
				$results['content'][$key]['id'] = $key;
				if (!$results['content'][$key]['gq_online'])
				{
					$this->server_m->remove_entry($results['content'][$key]['id']);
					unset($results['content'][$key]);
				}
			}	
			$this->cache->file->save("name", $results, 60 * 2); // alive during 8 minutes.
		}
$results = $this->cache->file->get('name');
		
		$this->parser->parse('main_view', $results);
	}//func
		
		
		
/*************************************************************************/        
        
        function stats($id = NULL) //getting single server data
        {
 /*   
Old single-server data viewer
 //GameQ settings
		if (!$this->cache->file->get("name"))
		{			
            $gq = new GameQ();
    		$gq->setOption('timeout', 5); // Seconds
    		$gq->setOption('debug', FALSE);
    		$gq->setFilter('normalise');
			$query = $this->server_m->get_entry('servers', $id); //returns $query
			
            $servers = array(
    				array(
    					'id' => $query['id'],
    					'host' => $query['address'],
    					'type' => 'cs16'
    				)
    			);
                
            $gq->addServers($servers);
            $results = $gq->requestData(); 
			
                //if not online - fuck out			
                if(!$results[$query['id']]['gq_online'])
                {
                    $this->server_m->remove_entry($query['id']);
					unset($results[$query['id']]);
                }
//            echo '<pre>';
//            print_r($results[$query['id']]);
//           echo '</pre>';
			
//			$results[$query['id']]['title'] = $results[$query['id']]['gq_hostname']; //{title}
		}*/
		if(!$this->cache->file->get('name'))
		{
			//update-servers funtion
		}
		$query = $this->server_m->get_entry('servers', $id); //returns $query
		
		$results = $this->cache->file->get('name');
		$this->parser->parse('single_view', $results['content'][$query['id']]);
            
        }//func

/*************************************************************************/  

        function submit()
        {
		// move to model!
		$this->form_validation->set_rules('address', 'Address', 'trim|required|callback_check_domain|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('site', 'Web-site', 'trim|valid_url|xss_clean');


		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('submit_view');
		}
		else
		{
			$data = array(
					'address' => $_POST['address'],
					'email' => $_POST['email'],
					'site' => $_POST['site']
					);
			$this->server_m->insert_entry($data);
			$this->load->view('success_view');
		}
		
			
             //$this->parser->parse('submit_view', $parse);
             
        }//func        
        
		
		function check_domain($domain)
        {
		preg_match('/(^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}:\d{5}$)|(^[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}:\d{5}$)/', $domain, $match);			
		if($match)
			{
        		return true;
			}
        	else
        	{
				$this->form_validation->set_message('check_domain', 'The %s field contains incorrect letters!');
        		return false;
        	}
        }//func
     
 


	public	function updateServers()
		{
			if (!$this->cache->file->get("name"))
			{
				$gq = new GameQ();
				$gq->setOption('timeout', 5);
				$gq->setOption('debug', TRUE);
				$gq->setFilter('normalise');
				// Getting data from database 
				$query = $this->server_m->get_entries('servers', 60 * 5);
				$servers = array();
				foreach($query as $row)
				{
					// Preparing array to send to GameQ.php

						$servers[] = array(
							'id' => $row['id'],
							'host' => $row['address'],
							'type' => 'cs16'
						);
				}
				// Getting array with data about server from Gameq 
				$gq->addServers($servers);
				$results_tmp = $gq->requestData();
				// Preparing array to parsing
				$results['content'] = $results_tmp;	
				
				foreach($results['content'] as $key => $value)
				{
					$results['content'][$key]['id'] = $key;
					if (!$results['content'][$key]['gq_online'])
					{
						$this->server_m->remove_entry($results['content'][$key]['id']);
						unset($results['content'][$key]);
					}
				}	
				$this->cache->file->save("name", $results, 60 * 2); // alive during 8 minutes.
			}
			$results = $this->cache->file->get('name');
		} //func





 
        
                
        
    }//class
        
        