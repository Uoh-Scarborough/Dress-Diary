<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
	
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
		//Lets work out where we are for db processing
		$slug = $this->uri->uri_string();
		//If no slug we assume that we're on the landing page
		if ($slug =='' || $slug =='home') {
			$currentPage = $this->pmod->homepage();
			$this->layout->changeLayout('layout_blank');
		}else{
			$currentPage = $this->pmod->fetchPage($slug);
		}
		
		//If the page doesn't exist we need to point them to an error page
		if(!$currentPage)
		{
			show_404();
		}
		
		$this->layout->setNavigation($this->pmod->get_nav());
		$this->layout->setMetaKeywords($this->pmod->get_description($currentPage->id));
		$this->layout->setMetaDesc($this->pmod->get_keywords($currentPage->id));
		$this->layout->setFooterNav($this->pmod->get_nav());
		
		if(file_exists(APPPATH . '/views/page_types/'.strtolower($currentPage->type) .'/index.php')){
			$page_type = strtolower($currentPage->type);

		}else{
			$page_type='page';
		}
		$this->layout->setPageType($page_type);
		$this->layout->view(array('page'=> $currentPage));

	}
}
