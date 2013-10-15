<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/StationEdit
 *
 * Allows the user to edit, delete and add stations 
 * 
 * Author: Jason Helms, Josh Smith
 *
 * Created: 2013-07 
 * Last Edited: 2013-08-28
*/
class StationEdit extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->validuser();
			
		//Models
		$this->load->model('station_edit');
			
		//Helpers
		$this->load->helper('form');
		$this->load->helper('array');
			
		//Libraries
		$this->load->library('form_validation');
	}
		
	// default view (loads add/delete view)
    public function view($page = 'Edit Stations', $success = 0)
    {
        if( (! file_exists('application/views/addStation.php')) || (! file_exists('application/views/stationDelete.php')) || (! file_exists('application/views/editStations.php')))
        {
            //Whoops, we don't have a page for that!
            show_404();
        }

		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['success'] = $success;
				
		$this->load->view('templates/header', $data);

		// set TA accordion open
		$data['accordion'] = 2;
				
        $this->load->view('templates/dynamicnavbar', $data);
                
		//load model
		$this->load->model('station_edit');
				
		//load views:
		$this->load->view('editStations');
				
		$this->load->view('addStation');
				
		$this->load->view('stationDelete');
				
		// load footer:
        $this->load->view('templates/footer');
				
    }
		
	// removes all stations that were checked on the add/delete page
	public function setCurrent()
	{
		$form_data= $this->input->post();
		$result = 0;
			
		$default_station = $form_data['def_station_id'];
		$delete_station = $form_data['kill_station_id'];

		if ($default_station != $delete_station)
		{
			$this->station_edit->removeStation($default_station, $delete_station);
		}
		else
		{
			$result = 1;
		}
		
		$this->view('Edit Stations', $result);
	}
		
	// adds a new station
	public function addStation()
	{
		$this->form_validation->set_rules('name', 'stationName', 'trim|required');
		$this->form_validation->set_rules('name', 'stationValue', 'trim|required');
		
		$form_data= $this->input->post();
			
		$this->station_edit->addStation(element('stationName',$form_data), element('stationValue',$form_data));
			
		$this->view('Edit Stations');
	}
		
	// saves the edits to stations made by the user
	public function saveStations()
	{
		$form_data= $this->input->post();
		
		$count = element('counter', $form_data); // number of records we displayed on page
			
		for ($i = 1; $i <= $count; $i++)
		{	
			$this->station_edit->updateStation(element('station_id'.$i, $form_data), element('station'.$i, $form_data), element('value'.$i, $form_data));
		}
			
		$this->view('Edit Stations');	 
	}
}