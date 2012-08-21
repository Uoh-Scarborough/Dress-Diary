<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller {
	
	//Global variable declarataions
	var $page_types = array();
	
	function __construct()
	{
			parent::__construct();
			//This loads the model and the main layout
			$this->load->model('page_model','pmod');
			
			//Grab all the custom page types so that we can play with them later
			$this->config->load('custom_page_types');
			$this->page_types = $this->config->item('custom_page_types');
			
	}

	public function index()
	{
		$this->search();

	}
	
	public function search()
	{
		$pageID = 3;
		$slug = 'events';
		$currentPage = $this->pmod->fetchPage($slug);
		
		$this->layout->setNavigation($this->pmod->get_nav());
		$this->layout->setMetaKeywords($this->pmod->get_description($pageID));
		$this->layout->setMetaDesc($this->pmod->get_keywords($pageID));
		$this->layout->setFooterNav($this->pmod->get_nav());

		$this->layout->setPageType('events');
		if($this->input->post('search_events')){
			$this->layout->view(array('page'=> $currentPage, 'postcode' => $this->input->post('search_events')));
		}else{
			$this->layout->view(array('page'=> $currentPage, 'postcode' => 'YO113AZ'));
			
		}
		$parameter = $this->input->post('search_events');
		
		
		
		
	}
}
