<?php

if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Layout
{
	//Global variable declarations
	var $obj;
	var $mainNav = '';
	var $theLayout;
	//Default this to page
	var $theType = 'page';
	var $footerNav = '';
	var $meta_desc;
	var $meta_keywords;
	var $currentUser='';
	
	function Layout($layout = "layout_main")
	{
		$this->obj =& get_instance();
		$this->obj->load->model('page_model');
		$this->theLayout = $layout;
	}
	
	function changeLayout($layout)
	{
		$this->theLayout = $layout;
	}
	
	function updateUser($identity)
	{
		$this->currentUser = $identity;
	}
	
	function setPageType($pageType)
	{
		$this->theType = $pageType;
	}
	
	function setNavigation($navigation)
	{
		$this->mainNav = $navigation;
	}
	
	function setFooterNav($footerNavigation)
	{
		$this->footerNav = $footerNavigation;
	}
	function setMetaKeywords($keywords)
	{
		$this->meta_keywords = $keywords;
	}
	function setMetaDesc($description)
	{
		$this->meta_desc = $description;
	}
	function view($data = null, $return = false)
	{
		
		$view = $this->theType . "/index.php";
		$this->loadView($view, $data, false);
	}
	
	function loadView($view, $data=null, $return = false, $page_type=true)
	{
		
		if($page_type)
		{
	       	//$this->obj->load->_ci_view_path = APPPATH.'page_types/';
	
	        $loadedData['yield'] = $this->obj->load->view('page_types/'. $view , $data, true);

			//$this->obj->load->_ci_view_path = APPPATH.'views/';
		}else{
			$loadedData['yield'] = $this->obj->load->view( $view, $data, true);
			
		}

		$loadedData['yield_nav'] = $this->mainNav;
		$loadedData['yield_footNav'] = $this->footerNav;
		$loadedData['yield_meta_desc'] = $this->meta_desc;
		$loadedData['yield_meta_keywords'] = $this->meta_keywords;
		$loadedData['yield_user'] = $this->currentUser;
	
		if($return)
		{
			$sendBack = $this->obj->load->view('layouts/' .$this->theLayout, $loadedData, true);
		}else{
			$this->obj->load->view('layouts/' . $this->theLayout, $loadedData, false);
		}
		
		if(@$output)
		{
			return $output;
		}
	}
	
}

?>