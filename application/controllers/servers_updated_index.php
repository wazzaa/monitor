<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Servers extends CI_Controller

{
	public function __construct()

	{
		parent::__construct();
		$this->load->driver('cache');
	}
	
public function index()
{

			$gq = new GameQ();
			$gq->setOption('timeout', 5);
			$gq->setOption('debug', FALSE);
			$gq->setFilter('normalise');
			// Getting data from database
			$query = $this->database->get_entries($this->config->item('db_table') , 150); //gettings 150 servers from database
			$servers = array();
			
			foreach($query as $row)
			{
			
				
				if(!$this->cache->file->get('server_info_'.$row['id']))
				{
					$servers[] = array(
					'id' => $row['id'],
					'host' => $row['address'],
					'type' => 'cs16'
					);
					
					$gq->addServers($servers);
					$result_tmp = $gq->requestData();
					$result['content'] = html_escape($result_tmp);
					$this->cache->file->save('server_info_'.$row['id'], $result, 60 * 2);
					
				}

					$results = $this->cache->file->get('server_info_'.$row['id']);
				
			}
			
			$results['content'] = $this->parser->parse('serverlist_view', $results, TRUE);
			$this->parser->parse('main_view', $results);
			
}
}
