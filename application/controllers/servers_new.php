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
		if (!$this->cache->file->get("cache"))
			{
			// Getting data about server
			$gq = new GameQ();
			$gq->setOption('timeout', 5);
			$gq->setOption('debug', TRUE);
			$gq->setFilter('normalise');
			// Getting data from database
			$query = $this->server_m->get_entries( $this->config->item('db_table'), 20);
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
			// Getting array with data abot server from Gameq
			$gq->addServers($servers);
			$results_tmp = $gq->requestData();
			/* Preparing array to parsing */
			$results['content'] = $results_tmp;
			// Parsing
			foreach($results['content'] as $key => $value)
				{
				$results['content'][$key]['id'] = $key;
				// If server offline - don't show in list
				if (!$results['content'][$key]['gq_online'])
					{
					// remove from database
					$this->server_m->remove_entry($results['content'][$key]['id']);
					unset($results['content'][$key]);
					}
				}
			$this->cache->file->save("cache", $results, 60 * 2); // alive during 2 minutes.
			}
		$results = $this->cache->file->get('cache');
		$this->parser->parse('main_view', $results);
		} //func index
	public function stats($id = NULL)

		{
		if (!$this->cache->file->get('cache'))
			{
			// update-servers funtion
			}
		$query = $this->server_m->get_entry('servers', $id); //returns $query
		$results = $this->cache->file->get('cache');
		$this->parser->parse('single_view', $results['content'][$query['id']]);
		} //func stats
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
		// $this->parser->parse('submit_view', $parse);
		} //func submit
	function check_domain($domain)
		{
		preg_match('/(^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}:\d{5}$)|(^[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}:\d{5}$)/', $domain, $match);
		if ($match)
			{
			return true;
			}
		  else
			{
			$this->form_validation->set_message('check_domain', 'The %s field contains incorrect letters!');
			return false;
			}
		} //func check_domain
	} //Class