<?php

class Boutiques extends CI_Controller{
	
	
	function __construct(){
		
		parent::__construct();
		
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->model('page_model', 'pmod');
		$this->load->helper('form');
		$this->layout->setNavigation($this->pmod->admin_nav());
		// Make sure they are admin!
		if (!$this->ion_auth->is_admin())
		{
				$group = 'members';
				if(!$this->ion_auth->is_group($group)){
					$this->session->set_flashdata('message', 'You do not have the authorisation to view this page');
					redirect('auth/login');
				}else{
					$this->layout->setNavigation($this->pmod->boutique_nav());
				}
		}
		
		// Let the layout engine know this is an admin page
		$this->layout->changeLayout('layout_admin');
		$this->layout->updateUser($this->pmod->get_user_by_id($this->session->userdata('user_id')));
	}
	
	function index()
	{
		
		$thedata = $this->get_upcoming_events();
		$searchArea = $this->gen_search_form();
	
		
		$this->layout->loadView('admin/boutiques/index', array('dataZone' => $thedata, 'searchArea' => $searchArea), false, false);

	}
	
	function gen_search_form()
	{
	$this->pmod->get_user_by_id($this->session->userdata('user_id'));
		$form ='<div class="well">';
		$monthInputOptions = array(
							'jan' => 'January',
							'feb' => 'February',
							'mar' => 'March',
							'apr' => 'April',
							'may' => 'May',
							'jun' => 'June',
							'jul' => 'July',
							'aug' => 'August',
							'sep' => 'September',
							'oct' => 'October',
							'nov' => 'November',
							'dec' => 'December',
							) ;
		
		
		//Give them 10 years ahead of current year
		$currentYear = date('Y');
		$yearInputOptions = array() ;
		for($i = 0; $i < 10; $i++)
		{
			$yearInputOptions[$currentYear + $i] = $currentYear + $i; 
		}
		$eventInputOptions = array();
		//Find all the event types
		$eventTypes = explode('|',$this->get_event_types());
		foreach($eventTypes as $eventType)
		{
			$eventTypeData = explode(":", $eventType);
			$eventTypeID = $eventTypeData[0]; $eventTypeName = $eventTypeData[1];
			$eventInputOptions[$eventTypeID] = $eventTypeName;
		}
		
		$form .= form_open('/search');
		$form .= 'Date : ';					
		$form .= form_dropdown('month', $monthInputOptions, 'jan', 'style="width:100px; margin-right:20px;margin-top:7px;"');
		$form .= form_dropdown('year', $yearInputOptions, date('Y'), 'style="width:100px; margin-right:20px;margin-top:7px;"');
		$form .= form_dropdown('year', $eventInputOptions, $eventTypes[0], 'style="width:100px; margin-right:20px;margin-top:7px;"');
			
		$form .= form_button('updateResults', 'Search', 'id="eventSearch" class="btn"');
		$form .= form_close();
		$form .= "</div>";
		return $form;
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
	
	function get_upcoming_events($searchClause = false)
	{
		$table = '<h1>Select an event</h1>';
		if($searchClause)
		{
			//User has looked for a specific date/event type
			
		}else{
			
		
			//DB Stores data as YYYY-MM-DD
			$curdate = date('Y-m-d');
			$types = $this->get_event_types();
			$venues = $this->getVenues();
			$events = $this->db->get_where('events', array('date >=' => $curdate, 'deleted' => 0));
			if($events->num_rows() == 0)
			{
				return '<h4>There are currently no events</h4>';
			}else{
				$events = $events->result();
				$table .= '<table class="table table-striped pagetable"><tbody>';
				foreach($events as $event)
				{
					$currentdata = $this->get_current_data($event->id);
					$newDate = $this->dateToUK($event->date);
					$eventType = $this->getEventName($event->typeid);
					$table .= '<tr><td class="span5"><h3>'.$event->name.'</h3><p class="event_sub">Type: '.$eventType.'<br />Date: '.$newDate.'</p></td><td><a href="/admin/boutiques/event_chosen/'.$event->id.'"  class="btn edit_event"><i class="icon-ok"></i> Select Event</a></td></tr>';
				}
				$table .= '</tbody></table>';
				return $table;
			}
		}
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

	function event_chosen($event_id)
	{
		//place a list of dresses !
		$newdata = array('eventID' => $event_id);
		$this->session->set_userdata($newdata);
		
		$searchArea = null;
		
		$dataZone = $this->get_dresses();
		
		$this->layout->setNavigation($this->pmod->boutique_nav());
		$this->layout->loadView('admin/boutiques/index', array('searchArea' => '', 'dataZone' => $dataZone), false, false);
	}
	
	function dress_chosen($dress_id)
	{
		
		$newdata = array('dressID' => $dress_id);
		$this->session->set_userdata($newdata);
		
		$dataZone = $this->confirm_add();
		
		$this->layout->setNavigation($this->pmod->boutique_nav());
		$this->layout->loadView('admin/boutiques/index', array('dataZone' => $dataZone, 'searchArea' => ''), false, false);
	}
	
	function confirm_add()
	{
		$chosen =  $this->session->all_userdata();
		
		$theEvent = $chosen['eventID'];
		$theDress = $chosen['dressID'];
		$theUser = $chosen['user_id'];

		
		return "The event chosen is $theEvent and the dress chosen is $theDress added by the user with id : $theUser";
		
	}
	
	//FUCKING AWFUL FUNCTIONS FOR COLLECTING ALL OF THE INFORMATION
	//IT SHOULD HAVE BEEN PUT IN TO MODELS INSTEAD OF CONTROLLERS
	//BELOW IS ALL REPEATED CODE FROM DRESSES AND EVENTS CONTROLLERS !
	//MY BAD SORRY :(
	
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
	function get_dresses()
	{
		$table = '';
		$dresses = $this->db->get_where('dresses',array('deleted'=>0))->result();
		$table .= '<table class="table table-striped pagetable" style="width:700px; float:left"><tbody>';
		foreach($dresses as $dress)
		{
			$table .= '<tr><td><img src="/uploads/thumbnails/'.$dress->picture.'" /></td><td class="span4"><h3>'.$dress->style_name.'</h3><p class="event_sub">SKU: '.$dress->style_number.'<br />Label: '.$this->getLabel($dress->label_id).'</p></td><td><a href="/admin/boutiques/dress_chosen/'.$dress->id.'" class="btn edit_dress" ><i class="icon-ok"></i>Select Dress</a></td></tr>';
		}
		$table .= '</tbody></table>';
		return $table;
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