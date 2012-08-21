<?php

class Events extends CI_Controller{
	
	
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
		
	}
	
	function index()
	{
		
		$upcoming_events = $this->get_upcoming_events();
		$past_events = $this->get_past_events();
		
		$this->layout->setNavigation($this->pmod->admin_nav());
		$this->layout->loadView('admin/events/index', array(
															'upcoming_events' => $upcoming_events,
															'past_events' => $past_events,
															'user' => $this->session->userdata('username')),
															false,
															false
															);

	}
	
	function get_event_types()
	{
		$types = $this->db->get('event_types')->result();
		$ret = '';
		
		foreach($types as $type)
		{
			$ret .= "$type->id:$type->type|";
		}
		//Remove the final | from the returned string
		$ret = substr($ret,0,-1);
		return $ret;
	}
	
	
	function get_current_data($id)
	{
		$ret = '';
		$data = $this->db->get_where('events', array('id' => $id))->row();
		
		$ret = "$data->name:$data->typeid:$data->date:$data->venue:$data->contact";
		//Grab the venue name for nice usability
		
		$venueName = $this->db->get_where('venues', array('id' =>$data->venue))->row();
		$venueName = $venueName->name;
		$ret.= ":$venueName";
		return $ret;
	}
	
	function get_upcoming_events()
	{
		//DB Stores data as YYYY-MM-DD
		$curdate = date('Y-m-d');
		$types = $this->get_event_types();
		$venues = $this->getVenues();
		$table = '<p><a href="" class="btn btn-success add_event" title="'.$types.'~'.$venues.'"><i class="icon-plus icon-white"></i> Add new event</a></p>';
		$events = $this->db->get_where('events', array('date >=' => $curdate, 'deleted' => 0))->result();
		$table .= '<table class="table table-striped pagetable"><tbody>';
		foreach($events as $event)
		{
			$currentdata = $this->get_current_data($event->id);
			$newDate = $this->dateToUK($event->date);
			$eventType = $this->getEventName($event->typeid);
			$table .= '<tr><td class="span5"><h3>'.$event->name.'</h3><p class="event_sub">Type: '.$eventType.'<br />Date: '.$newDate.'</p></td><td><a href="'.$event->id.'" title="'.$types.'~'.$currentdata.'~'.$venues.'" class="btn btn-info edit_event"><i class="icon-pencil icon-white"></i> Edit Event</a></td><td><a href="'.$event->id.'" class="btn btn-danger  delete_event"><i class="icon-trash icon-white"></i> Remove Event</a></td></tr>';
		}
		$table .= '</tbody></table>';
		return $table;
	}

	
	function get_past_events()
	{
	
		//DB Stores date as YYYY-MM-DD
		$curdate = date('Y-m-d');
		$types = $this->get_event_types();
		
		$events = $this->db->get_where('events', array('date <' => $curdate, 'deleted' => 0))->result();
		$table = '<table class="table table-striped pagetable"><tbody>';
		foreach($events as $event)
		{
			//Format the date to UK Format
			$currentdata = $this->get_current_data($event->id);
			$newDate = $this->dateToUK($event->date);
			$eventType = $this->getEventName($event->typeid);
			$venues = $this->getVenues();
			$table .= '<tr><td class="span5"><h3>'.$event->name.'</h3><p class="event_sub">Type: '.$eventType.'<br />Date: '.$newDate.'</p></td><td><a href="'.$event->id.'" class="btn btn-danger delete_event"><i class="icon-trash icon-white"></i> Remove Event</a></td></tr>';
		}
		$table .= '</tbody></table>';
		return $table;	
	}
	
	function dateToUK($db_date)
	{
		$boom = explode('-', $db_date);
		$reorderDate = array($boom[2], $boom[1],$boom[0]);
		$newDate = implode($reorderDate,'/');
		return $newDate;
	}
	
	function getEventName($typeid)
	{
		$types = $this->db->get_where('event_types', array('id'=>$typeid))->row();
		return $types->type;
	}

	function add()
	{

		
		//Check to see if they've added a new venue
		if($this->input->post('add_venue_flag') == 1)
		{
			//Get latitude and longitude from google regarding the postcode for location searches
			$URL = 'http://maps.googleapis.com/maps/api/geocode/xml?address='.$this->input->post('e_postcode').'&sensor=false';
			
			$xml = simplexml_load_file($URL);
			
			$latitude = $xml->result->geometry->location->lat;
			$longitude = $xml->result->geometry->location->lng;
			//Grab venue data and add it
			$venueData = array(
				'name' => $this->input->post('e_venue_name'),
				'addressL1' => $this->input->post('e_add1'),
				'addressL2' => $this->input->post('e_add2'),
				'town' => $this->input->post('e_town'),
				'region' => $this->input->post('region'),
				'postcode' => $this->input->post('e_postcode'),
				'latitude' => $latitude,
				'longitude' => $longitude,
			);
			

			
			$this->db->insert('venues', $venueData);
			$data = array(
				'name' => $this->input->post('e_name'),
				'typeid' => $this->input->post('e_type'),
				'date' => $this->input->post('e_date'),
				'venue' => $this->db->insert_id(),
				'contact' => $this->input->post('e_contact'),
				'deleted' => 0
			);
		}else{
			$data = array(
				'name' => $this->input->post('e_name'),
				'typeid' => $this->input->post('e_type'),
				'date' => $this->input->post('e_date'),
				'venue' => $this->input->post('venue'),
				'contact' => $this->input->post('e_contact'),
				'deleted' => 0
			);
		}
		
		//Grab the posted stuff
		
		$this->db->insert('events', $data);
	
		redirect('admin/events');
	}
	
	function edit($id)
	{
		//Check for a venue edit
		if($this->input->post('edit_venue') == 1)
		{
			
			$URL = 'http://maps.googleapis.com/maps/api/geocode/xml?address='.$this->input->post('e_postcode').'&sensor=false';

			$xml = simplexml_load_file($URL);

			$latitude = $xml->result->geometry->location->lat;
			$longitude = $xml->result->geometry->location->lng;
			//Edit the venue data
			$venueData = array(
				'name' => $this->input->post('e_venue_name'),
				'addressL1' => $this->input->post('e_add1'),
				'addressL2' => $this->input->post('e_add2'),
				'town' => $this->input->post('e_town'),
				'region' => $this->input->post('region'),
				'postcode' => $this->input->post('e_postcode'),
				'latitude' => $latitude,
				'longitude' => $longitude
			);
			$this->db->where('id', $this->input->post('v_id'));
			$this->db->update('venues', $venueData);
		}
		$data = array(
			'name' => $this->input->post('e_name'),
			'typeid' => $this->input->post('e_type'),
			'date' => $this->input->post('e_date'),
			'venue' => $this->input->post('v_id'),
			'contact' => $this->input->post('e_contact')
		);
		
		$this->db->where('id', $id);
		$this->db->update('events', $data);
		
		redirect('admin/events');
	}
	
	function delete($event_id)
	{
		$event_id = $this->uri->segment(4);
		
		$data = array( 'deleted' => 1);
		
		$this->db->where('id', $event_id);
		$this->db->update('events', $data);
		
		redirect('admin/events');
	}
	
	function getVenues()
	{
		$venues = $this->db->get('venues')->result();
		$ret = '';
		
		foreach($venues as $venue)
		{
			$ret .= "$venue->id:$venue->name|";
		}
		//Remove the final | from the returned string
		$ret = substr($ret,0,-1);
		return $ret;
	}
	
	function getvenuedata()
	{
		$vid = $this->input->post('vid');
		if($vid)
		{
			$venuedata = $this->db->get_where('venues', array('id' => $vid))->row();
			$ret = '';
			foreach($venuedata as $datasnip)
			{
				
				$ret .= "$datasnip:";
			}
			//Remove the final : from the returned string
			$ret = substr($ret,0,-1);
			echo $ret;
		}else{
			echo 'You have not entered a correct value here, you\'ve done something wrong' . $vid;
		}
	}
	
	function getregions()
	{
		$regions = $this->db->get('regions')->result();
		$ret = '';
		foreach($regions as $region)
		{
			$ret .= "$region->id:$region->name|";
		}
		$ret = substr($ret,0,-1);
		echo $ret;
	}

	
}