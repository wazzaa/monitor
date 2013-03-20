<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Model
{
    public $rules = array(
		array(
			'field' => 'address',
			'label' => 'Adress',
			'rules' => 'trim|required|callback_check_domain|xss_clean'
			),
			
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|xss_clean'
			),
			
		array(
			'field' => 'website',
			'label' => 'Website',
			'rules' => 'trim|valid_url|xss_clean'
			)
		);
			
		
   
   
}//class