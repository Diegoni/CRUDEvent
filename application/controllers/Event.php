<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->model('m_events');
		$this->load->model('m_r_events_users');
		$this->load->model('m_positions');
	}


	public function index() {

	}

	public function get($id = null){
		if($id != null){

			if($this->input->post('name')){
				$row = [
					'event_id' => $id,
					'name' => $this->input->post('name'),
				];

				$r_events_users = $this->m_r_events_users->get($row);

				if(!$r_events_users){
					$row['position_id'] = $this->input->post('position');
					$this->m_r_events_users->insert($row);
				}
			}

			$db['event'] = $this->m_events->get($id);
			$db['r_events_users'] = $this->m_r_events_users->get(['event_id' => $id]);
			$db['positions'] = $this->m_positions->get();

			$this->load->view('event/get', $db);
		}

	}
}
