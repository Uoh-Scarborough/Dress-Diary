<?php

class Snippets extends CI_Controller{
	
	
	function __construct(){
		
		parent::__construct();
		
		$this->load->library('ion_auth');
		
		$this->load->model('page_model', 'pmod');
		
		// Make sure they are admin!
		if (!$this->ion_auth->is_admin())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			redirect('auth/login');
		}
		
		// Let the layout engine know this is an admin page
		$this->layout->changeLayout('layout_admin');
		$this->layout->updateUser($this->pmod->get_user_by_id($this->session->userdata('user_id')));
		
	}
	
	function index()
	{
		
		$snippets = $this->get_snippets();
		
		$this->layout->setNavigation($this->pmod->admin_nav());
		$this->layout->loadView('admin/snippets/index', array('snippets' => $snippets, 'user' => $this->session->userdata('username')), false, false);

	}
	
	function get_snippets()
	{
		
		$table = '<table class="table table-striped pagetable" id="tree"><tbody>';
		
		$snippets = $this->db->get('snippet')->result();
		foreach($snippets as $snippet)
		{
			if($snippet->deleted != 1){
			$table .= '<tr><td>'.$snippet->name.'</td><td><a class="btn btn-info edit_snippet" title="'.$snippet->name.'|'.$snippet->content.'" href="'.$snippet->id.'"><i class="icon-pencil icon-white"></i> Edit</a></td><td><a class="btn btn-danger delete_snippet" href="'.$snippet->id.'"><i class="icon-trash icon-white"></i> Delete</a></td></tr>';
			}
		}
		$table .= '</tbody></table>';
		return $table;
		
	}
	
	function add()
	{
		//Grab the posted stuff
		$data = array(
			'name' => $this->input->post('snippet_name'),
			'deleted' => 0
		);
		$this->db->insert('snippet', $data);
	
		redirect('admin/snippets');
	}
	
	function edit()
	{
		$snippet_id = $this->uri->segment(4);
		
		$data = array(
			'name' => $this->input->post('name'),
			'content' => $this->input->post('content')
		);
		
		$this->db->where('id', $snippet_id);
		$this->db->update('snippet', $data);
		
		redirect('admin/snippets');
	}
	
	function delete()
	{
		$snippet_id = $this->uri->segment(4);
		
		$data = array('deleted' => 1);
		
		$this->db->where('id', $snippet_id);
		$this->db->update('snippet', $data);
		
		redirect('admin/snippets');
	}
	
}