<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller{
	
	//Global variable declarations
	
	var $page_types = array();
	
	function __construct(){
		
		parent::__construct();
		
		$this->load->library('ion_auth');
		
		$this->load->model('Page_model', 'pmod');
		
		
		// Make sure they are admin!
		if (!$this->ion_auth->is_admin())
		{
			$group = 'members';
			if(!$this->ion_auth->is_group($group)){
				$this->session->set_flashdata('message', 'You must be an admin to view this page');
				redirect('auth/login');
			}else{
				$this->layout->setNavigation($this->pmod->boutique_nav());
			}
		}
		
		// Let the layout engine know this is an admin page
		$this->layout->changeLayout('layout_admin');

		// Load and set the page types array to a class variable
		$this->config->load('custom_page_types');
		$this->page_types = $this->config->item('custom_page_types');
		$this->layout->updateUser($this->pmod->get_user_by_id($this->session->userdata('user_id')));
		
	}
	
	function index()
	{
		//As requested load a read-me file for the admin page
		if($this->ion_auth->is_admin()){
			if($this->uri->segment(2)){
			
				$pages = $this->page_list();
			
			}else{

				$pages = fopen( APPPATH .'help_file/admin/readme.html', 'r');
				$pages = fread($pages, filesize(APPPATH .'help_file/admin/readme.html'));
		
			}
			// Load view (page, data, return, page_type?)
				$this->layout->setNavigation($this->pmod->admin_nav());
				$this->layout->loadView('admin/index', array('pages' => $pages, 'user' => $this->session->userdata('username')), false, false);
		}else{
				redirect('admin/boutiques');
		}
		

	}
	
	function order($parent)
	{
		$pages = $this->order_table($parent);
		$this->layout->setNavigation($this->pmod->admin_nav());
		$this->layout->loadView('admin/pages/order', array('pages' => $pages), false, false);
	}
	
	
	function order_table($id)
	{
		$this->db->order_by('position', 'ASC');
		$pages = $this->db->get_where('pages', array('parentID' => $id, 'deleted' => 0 ))->result();
		$ret = '<ul id="orderable">';
		
		foreach($pages as $page)
		{
			$ret .= '<li id="pageItem_'.$page->id.'"><i class="icon-resize-vertical big_pad"></i><span class="order_lineheight '.strtolower($page->type).'">'.$page->title.'</span></li>';
			
		}
		
		$ret .= '</ul>';
		
		return $ret;
	}
	
	function update_order()
	{
		$ordered_pages = $this->input->post('pageItem');
		
		foreach ($ordered_pages as $position => $item) {
			$this->db->where('id', $item);
			$this->db->update('pages', array('position' => $position));
		}
	}
	
	function edit($id)
	{
				$page_id = $id;

				$this->load->library('form_validation');

				$this->form_validation->set_rules('array[title]', 'Title', 'required');
				$this->layout->setNavigation($this->pmod->admin_nav());
				if ($this->form_validation->run() == FALSE)
				{
					$page = $this->db->get_where('pages', array('id' => $page_id))->row();


					if (file_exists(APPPATH . 'page_types/'.strtolower($page->type).'/admin.php')) {
						$page_type = strtolower($page->type);
					} else {
						$page_type = "page";
					}


					$this->layout->loadView($page_type.'/admin.php', array('page' => $page));	
				}
				else
				{
					$data = $this->input->post('array');

					// First remove all rel="external"
					$data['body'] = str_replace(' rel="external"', '', $data['body']);
					//$data['intro'] = str_replace(' rel="external"', '', $data['intro']);

					// Add rel external to links for 
					$data['body'] = str_replace('<a href', '<a rel="external" href', $data['body']);
					//$data['intro'] = str_replace('<a href', '<a rel="external" href', $data['intro']);

					$this->db->where('id', $page_id);
					$this->db->update('pages', $data);
					
					// See if we are saving or applying!
					if ($this->input->post('apply')) {
						redirect('admin/pages/edit/' . $page_id);
					} else {
						redirect('admin/pages');
					}
				}
		
	}
	
	
	function page_list()
	{
		$table = '<table class="table table-striped pagetable" id="tree"><tbody>';
		$table .= $this->page_table_recurse(0);
		$table .= '</tbody></table>';
		return $table;
	}
	
	function page_table_recurse($parent)
	{
		//Should return the main navigation
		$this->db->select('id, title, type, parentID, editable, deleted');
		$this->db->from('pages');
		$this->db->order_by('position', 'ASC');
		$this->db->where('parentID',$parent);
		$this->db->where('deleted',0);
		$pages = $this->db->get();
		
		$tableInner = '';
		
		if($pages->num_rows() > 0)
		{	
			foreach($pages->result() as $page)
			{
				//The page has children
				if($page->deleted != 1)
				{
				$child = ($parent != 0) ? ' class="child-of-node-'.$parent.'"' : '';
				$allowed_children = $this->page_types[$page->type]['allowed_children'];
				
				$order = ($this->has_children($page->id)) ? "<a class='btn' href='/admin/pages/order/$page->id'><i class='icon-repeat'></i> Order Children</a>" : '';
				
				$delete_children = ($page->editable != 0) ? "<a class='btn btn-danger delete_page' href='$page->id'><i class='icon-trash icon-white'></i> Delete</a>" : '';
				$add_children = ($this->page_types[$page->type]['children']) ? "<a class='btn btn-success add_child' href='$page->id' title='$allowed_children'><i class='icon-plus icon-white'></i> Add Child</a>" : '';
				if($page->editable > 0){
					$tableInner .= "<tr id='node-$page->id'$child>\n<td>\n<span class='".strtolower($page->type)."'><a href='/admin/pages/edit/$page->id'>$page->title</a></span></td\n><td>$order</td><td>$page->type</td>\n<td>$add_children</td>\n<td>$delete_children</td>\n</tr>\n";
				} else {
					$tableInner .= "<tr id='node-$page->id'$child>\n<td>\n<span class='".strtolower($page->type)."'>$page->title</span></td\n><td>$order</td><td>$page->type</td>\n<td>$add_children</td>\n<td>$delete_children</td>\n</tr>\n";
				}
				
				$tableInner .= $this->page_table_recurse($page->id);
				}
			}
		}
		return $tableInner;
		
	}
	
	
	function has_children($pageID)
	{
		//Confirms whether or not a page has children
		
		$this->db->select('id, title');
		$this->db->where('parentID', $pageID);
		$this->db->where('deleted', 0);
		$this->db->from('pages');
		
		if($this->db->count_all_results() > 0)
		{
			return true;
		} else {
			return false;
		}
		
	}
	
	function add()
	{
		
			//Grab the posted stuff
			
			$this->db->select_max('position');
			$max_order = $this->db->get_where('pages', array('parentID' => $this->input->post('parent_id'), 'deleted' => 0))->row();
			$max_order = $max_order->position + 1;
			
			$data = array(
				'title' => $this->input->post('title'),
				'type' => $this->input->post('page-type'),
				'parentID' => $this->input->post('parent_id'),
				'slug' => $this->gen_slug($this->input->post('title')),
				'url_slug' => $this->gen_slug($this->input->post('title')),
				'position' => $max_order,
				'editable' => 1,
				'deleted' => 0
			);
			$this->db->insert('pages', $data);
		
			redirect('admin/pages/edit/' . $this->db->insert_id());
		
	}
	
	function gen_slug($title)
	{
		$title = strtolower($title);
		$title = stripslashes($title);
		$title = str_replace(' ', '', $title);
		return $title;
	}
	
	function delete()
	{
		$page_id = $this->uri->segment(4);
		
		$data = array('deleted' => 1);
		
		$this->db->where('id', $page_id);
		$this->db->update('pages', $data);
		
		redirect('admin/pages');
		
	}
	
	function get_children($pageID)
	{
		//Returns all of the children belonging to a specified pageID
		$children = $this->db->get_where('pages', array('parentID' => $pageID));
		return $children;
	}
	
	
}