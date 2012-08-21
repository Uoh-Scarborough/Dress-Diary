<?php

class Dresses extends CI_Controller{
	

	
	function __construct(){
		
		parent::__construct();
		
		$this->load->library('ion_auth');
		
		$this->load->model('page_model', 'pmod');
		
		$this->load->helper(array('form','url'));

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
		$group = 'admin';
		if(!$this->ion_auth->is_group($group)){
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			redirect('/admin');
		}else{
			$dresses = $this->get_dresses();
		
			$this->layout->setNavigation($this->pmod->admin_nav());
			$this->layout->loadView('admin/dresses/index', array('dresses' => $dresses), false, false);
		}
	}
	
	function get_dresses()
	{
		$table = '<p><a href="" class="btn btn-success add_dress" title="' . $this->getColours() . '~' . $this->getCategories() . '~'.$this->getLabels().'"><i class="icon-plus icon-white"></i> Add new dress</a></p>';
		$dresses = $this->db->get_where('dresses',array('deleted'=>0))->result();
		$table .= '<table class="table table-striped pagetable"><tbody>';
		foreach($dresses as $dress)
		{
			$table .= '<tr><td><img src="/uploads/thumbnails/'.$dress->picture.'" /></td><td class="span4"><h3>'.$dress->style_name.'</h3><p class="event_sub">SKU: '.$dress->style_number.'<br />Label: '.$this->getLabel($dress->label_id).'</p></td><td><a href="'.$dress->id.'" class="btn btn-info edit_dress" title="'.$this->getCurrentInfo($dress->id).'~'.$this->getColours() . '~' . $this->getCategories() . '~'.$this->getLabels().'"><i class="icon-pencil icon-white"></i> Edit Dress</a></td><td><a href="'.$dress->id.'" class="btn btn-danger  delete_event"><i class="icon-trash icon-white"></i> Remove Dress</a></td></tr>';
		}
		$table .= '</tbody></table>';
		return $table;
	}
	
	function add()
	{
	
		//Need to upload to DB and deal with file uploads
		
		$config['upload_path'] = '/uploads/';
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		
		$this->load->library('upload', $config);
		
		//Initialise the library to create thumbnail
	
		
		if( !$this->upload->do_upload())
		{
			echo $this->upload->display_errors();
		}
		else{
			$data = $this->upload->data();
			$imageName =  $data['file_name'];
			
			//Create a thumbnail instantly 
			
			$config['image_library'] = 'gd';
			$config['source_image']	= './uploads/'.$imageName;
			$config['new_image'] = './uploads/thumbnails/' . $imageName;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 75;
			$config['height']	= 50;

			$this->load->library('image_lib', $config);
			if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
			//Also need to deal with multiple selects
			$colourList = '';
			$colours = $this->input->post('colours');
			
			foreach($colours as $col)
			{
				$colourList .= $col.':';
			}
			
			//Remove the last element of the colourList
			$colourList = substr($colourList,0,-1);

			$data = array(
				'style_name' => $this->input->post('d_name'),
				'style_number' => $this->input->post('d_num'),
				'colours' => $colourList,
				'picture' => $imageName,
				'category_id' => $this->input->post('d_category'),
				'label_id' => $this->input->post('d_label'),
				'deleted' => 0
			);
			
			$this->db->insert('dresses', $data);
			
			redirect('admin/dresses');
			
		}
		
	}
	
	function edit($id)
	{

		
		//Initialise the library to create thumbnail
	
			//Also need to deal with multiple selects
			$colourList = '';
			$colours = $this->input->post('colours_edit');
			
			foreach($colours as $col)
			{
				$colourList .= $col.':';
			}
			
			//Remove the last element of the colourList
			$colourList = substr($colourList,0,-1);

			$data = array(
				'style_name' => $this->input->post('d_name'),
				'style_number' => $this->input->post('d_num'),
				'colours' => $colourList,
				'category_id' => $this->input->post('d_category_edit'),
				'label_id' => $this->input->post('d_label_edit'),
				'deleted' => 0
			);
			$this->db->where('id', $id);
			$this->db->update('dresses', $data);
			
			redirect('admin/dresses');
			
		
	}
	
	function delete($id)
	{
		$dress_id = $this->uri->segment(4);
		
		$data = array( 'deleted' => 1);
		
		$this->db->where('id', $dress_id);
		$this->db->update('dresses', $data);
		
		redirect('admin/dresses');
	}
	
	function getColours()
	{
		//Function to return all the colours for use in a select for example
		$colours = '';
		
		$get_em = $this->db->get('dress_colours')->result();
		
		foreach ($get_em as $colour)
		{
			$colours .= $colour->id.':'.$colour->colour.'|';
		}
		
		$colours = substr($colours,0,-1);
		
		return $colours;
	}
	
	function getLabels()
	{
		$labels = '';
		
		$get_em = $this->db->get('labels')->result();
		
		foreach ($get_em as $label)
		{
			$labels .= $label->id.':'.$label->name.'|';
		}
		
		$labels = substr($labels,0,-1);
		
		return $labels;
	}
	
	function getCategories()
	{
		//Function to return all the categories for use in a select for example
		$categories = '';
		
		$get_em = $this->db->get('dress_category')->result();
		
		foreach ($get_em as $category)
		{
			$categories .= $category->id.':'.$category->category_name.'|';
		}
		
		$categories = substr($categories,0,-1);
		
		return $categories;
	}
	
	function getCurrentInfo($did)
	{
		$ret = '';
		$colourList = '';
		$data = $this->db->get_where('dresses', array('id' => $did))->row();
		$colours = explode(":",$data->colours);
		$colours = implode("|", $colours);
		
		$ret = "$data->style_name:$data->style_number:$colours:$data->category_id:$data->label_id";
		
		return $ret;
	}
	
	function getLabel($id)
	{
		$label = $this->db->get_where('labels', array('id' => $id))->row();
		
		return $label->name;
	}
	
}