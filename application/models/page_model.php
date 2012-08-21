<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}
	
	public function insert_snippet($snippet_name){
		
		$snippet = $this->db->get_where('snippet', array('name' => $snippet_name))->row();
		
		return $snippet->content;
		
	}
	
	public function get_nav()
	{
		
		$this->db->order_by('position', 'ASC');
		
		$pages = $this->db->get_where('pages', array('parentID' => 1, 'deleted'=> 0))->result();
		$nav = '';
		foreach($pages as $page)
		{
			$nav .= "<li><a href='/".$page->url_slug."'>".$page->title."</a></li>";
		}
		return $nav;
	}
	
	public function get_user_by_id($id)
	{
		
		$identity = $this->db->get_where('meta', array('user_id'=> $id))->row();
		
		$userIdentity = $identity->first_name . " " . $identity->last_name;
		
		return $userIdentity;
	}
	
	public function admin_nav()
	{
		//Find a better way to decide what can be done at later dates
		$pages = array();
		$pages[] = array('title' => 'Pages', 'slug' => 'admin/pages');
		$pages[] = array('title' => 'Snippets', 'slug' => 'admin/snippets');
		$pages[] = array('title' => 'Events', 'slug' => 'admin/events');
		$pages[] = array('title' => 'Dresses', 'slug' => 'admin/dresses');
		$pages[] = array('title' => 'Boutiques', 'slug' => 'auth/index');
		$pages[] = array('title' => 'Adverts', 'slug' => 'admin/adverts');
		$nav ="";
		foreach($pages as $page)
		{
			$nav .= "<li><a href='/".$page['slug']."'>".$page['title']."</a></li>";
		}
		
		return $nav;
	}
	
	public function boutique_nav()
	{
		$nav ='';
		return $nav;
	}
	
	public function get_super_parent(){
		
		//The current uri
		$slug = $this->uri->uri_string();
		
		//Search the database for this URI and find it's parent
		$parent = $this->db->get_where('pages', array('slug' => $slug))->row();
		
		
	}
	
	public function fetchPage($uri)
	{
		$this->db->limit(1);
		$page = $this->db->get_where('pages', array('slug' => $uri))->row();
		
		return $page;
	}
	
	public function homepage()
	{
		$this->db->limit(1);
		$page = $this->db->get_where('pages', array('slug' => 'home'))->row();
		
		return $page;
	}
	
	public function get_description($id)
	{
		$page = $this->db->get_where('pages', array('id' => $id))->row();
		return $page->meta_description;
	}
	public function get_keywords($id)
	{
		$page = $this->db->get_where('pages', array('id' => $id))->row();
		return $page->meta_keywords;
	}
}
