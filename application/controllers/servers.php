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
		if (!$this->cache->file->get('cache'))
		{
			// Getting data about server
			$gq = new GameQ();
			$gq->setOption('timeout', 5);
			$gq->setOption('debug', FALSE);
			$gq->setFilter('normalise');
			// Getting data from database
			$query = $this->database->get_entries($this->config->item('db_table') , 150); //gettings 150 servers from database
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
					$this->database->remove_entry($results['content'][$key]['id']);
					unset($results['content'][$key]);
				}
				$results = html_escape($results); //Later fix spec chars!
			}
			$this->cache->file->save('cache', $results, 60 * 2); // alive during 2 minutes.
		}

		// Template parser {content}
		$results = $this->cache->file->get('cache');
		$results['content'] = $this->parser->parse('serverlist_view', $results, TRUE); //TRUE makes RETURN data instead put it to browser
		$this->parser->parse('main_view', $results);
	} //func index
	public function stats($id = NULL)

	{
		if (!$this->cache->file->get('cache'))
		{
			//Need to fix!
			die('Needs to update cache! Visit home page!');
		}
		$query = $this->database->get_entry($id); //returns $query
		$results = $this->cache->file->get('cache');
		$results['content'] = $this->parser->parse('single_view', $results['content'][$query['id']], TRUE);
		$this->parser->parse('main_view', $results);
	} //func stats
	function submit()
	{
		$rules = $this->form->rules;
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('submit_view');
		}
		else
		{
			// checking
			$gq = new GameQ();
			$gq->setOption('timeout', 5); // Seconds
			$gq->setOption('debug', FALSE);
			$gq->setFilter('normalise');
			
			$address = $this->input->post('address');
			$email = $this->input->post('email');
			$website = $this->input->post('site');
			
			$servers = array(
				array(
					'id' => 'server',
					'host' => $address,
					'type' => 'cs16'
				)
			);
			$gq->addServers($servers);
			$results = $gq->requestData();
			// check if server online and game type
			if ((!$results['server']['gq_online']) or ($results['server']['game_engine'] != 'goldsrc_engine'))
			{
				// show fucking error
				echo 'Server is offline or not counter-strike 1.6!';
				$this->load->view('submit_view');
			}
			else
			{
				// add to DB, needs to check is empty $website
				$data = array(
					'address' => $address,
					'email' => $email,
					'site' => $website
				);
				$this->database->insert_entry($data);
				$this->load->view('success_view');
			}
		}
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