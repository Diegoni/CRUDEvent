<?php
class m_events extends MY_Model {

	public function __construct(){
		parent::construct(
			'events',
			'event_id',
			'event_id'
		);
	}

}
