<?php
class m_r_events_users extends MY_Model {

	public function __construct(){
		parent::construct(
			'r_events_users',
			'r_id',
			'date_add',
			[
				'position_id' =>
					[
						'table'     => 'positions',
						'subjet'    => 'name as position'
					],
			]
		);
	}

}
