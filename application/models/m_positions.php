<?php
class m_positions extends MY_Model {

	public function __construct(){
		parent::construct(
			'positions',
			'position_id',
			'name'
		);
	}

}
