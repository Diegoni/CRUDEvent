<?php
class MY_Model extends CI_Model {

	protected $_table		= NULL;
	protected $_id			= NULL;
	protected $_order		= NULL;
	protected $_relation	= NULL;
	protected $_values = 'descripcion';
	protected $field_date_add = 'date_add';
	protected $field_date_upd = 'date_upd';
	protected $field_state = 'active';
	protected $table_logs = 'logs';

	public function construct($table, $id, $order, $relation = NULL)
	{
		$this->_table			= $table;
		$this->_id				= $id;
		$this->_order			= $order;
		$this->_relation	= $relation;
	}

	public function getTableName(){
		return $this->_table;
	}

	public function getIdTable(){
		return $this->_id;
	}

	public function getFieldState(){
		return $this->field_state;
	}

	/**********************************************************************************
	 **********************************************************************************
	 *
	 * 				Trae todos los registros
	 *
	 * ********************************************************************************
	 **********************************************************************************/

	function get($datos = null, $condicion = null)
	{
		$this->getRelations();
		$this->getFilters($datos, $condicion);
		$this->getOrden();
		return $this->getQuery();
	}

	private function getRelations()
	{
		$fields = $this->db->list_fields($this->_table);

		foreach ($fields as $field) {
			$this->db->select($this->_table.'.'.$field);
		}

		$this->db->from($this->_table);

		if($this->_relation != null){
			foreach ($this->_relation as $fieldRelation => $relation) {
				$this->db->select($relation['table'].'.'.$relation['subjet']);
				$this->db->join($relation['table'], "$this->_table.$fieldRelation = $relation[table].$fieldRelation", 'left');
			}
		}
	}

	private function getFilters($datos = null, $condicion = null)
	{
		if($datos != NULL) {
			if (is_array($datos)) {
				foreach ($datos as $key => $value) {
					switch ($condicion) {
						case CONDICIONES_LOGICAS::AND:
							$this->db->where($this->_table.".".$key, $value);
							break;
						case CONDICIONES_LOGICAS::OR:
							$this->db->or_where($this->_table.".".$key, $value);
							break;
						case CONDICIONES_LOGICAS::LIKE:
							$this->db->like($this->_table.".".$key, $value);
							break;
						case CONDICIONES_LOGICAS::ANY:
							$this->db->or_like($this->_table.".".$key, $value, 'both');
							break;
						case CONDICIONES_LOGICAS::IN:
							$this->db->where_in($this->_table.".".$key, $value);
							break;
						case CONDICIONES_LOGICAS::NOT_IN:
							$this->db->where_not_in($this->_table.".".$key, $value);
							break;
						default:
							$this->db->where($this->_table.".".$key, $value);
					}
				}
			} else if(is_numeric( $datos )) {
				$this->db->where($this->_table.".".$this->_id, $datos);
			}
		}

		if ($this->db->field_exists($this->field_state, $this->_table) and $condicion != null) {
			$this->db->where($this->_table.".".$this->field_state, ESTADOS::ALTA);
		}
	}

	private function getOrden()
	{
		$this->db->order_by($this->_table.".".$this->_order);
	}

	public function getQuery($sql = NULL)
	{
		$query = ($sql == NULL) ? $this->db->get() : $this->db->query($sql);

		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		} else {
			return FALSE;
		}
	}

	public function fieldsExists($fields)
	{
		if(is_array($fields)) {
			foreach ($fields as $key => $value) {
				if (!$this->db->field_exists($key, $this->_table)){
					return false;
				}
			}
		} else {
			if (!$this->db->field_exists($fields, $this->_table)){
				return false;
			}
		}
		return true;
	}

	/**********************************************************************************
	 **********************************************************************************
	 *
	 * 				Insert de registro
	 *
	 * ********************************************************************************
	 **********************************************************************************/

	public function insert($datos)
	{
		$id = 0;

		if(is_array($datos)) {
			$datos = $this->addDataInsert($datos);

			$this->db->insert($this->_table , $datos);
			$id	=	$this->db->insert_id();

			$this->insertLog(TIPOS_LOGS::ALTA, $datos, $id);
		}

		return $id;
	}

	public function addDataInsert($datos)
	{
		if ($this->db->field_exists($this->field_date_add, $this->_table) && empty($datos[$this->field_date_add])) {
			$datos[$this->field_date_add] = getNowDateHour();
		}
		if ($this->db->field_exists($this->field_state, $this->_table) && empty($datos[$this->field_state])) {
			$datos[$this->field_state] = ESTADOS::ALTA;
		}

		return $datos;
	}

	/**********************************************************************************
	 **********************************************************************************
	 *
	 * 				Update de registros
	 *
	 * ********************************************************************************
	 **********************************************************************************/

	public function update($datos, $id)
	{
		if (is_array($datos)) {
			$datos = $this->addDataUpdate($datos);
			$this->insertLog(TIPOS_LOGS::MODIFICACION, $datos, $id);

			$this->db->update(
				$this->_table,
				$datos,
				array($this->_id => $id)
			);
		}
	}

	public function addDataUpdate($datos)
	{
		if ($this->db->field_exists($this->field_date_upd, $this->_table) && empty($datos[$this->field_date_upd])) {
			$datos[$this->field_date_upd] = getNowDateHour();
		}
		if ($this->db->field_exists($this->field_state, $this->_table) && empty($datos[$this->field_state])) {
			$datos[$this->field_state] = ESTADOS::ALTA;
		}

		return $datos;
	}

	public function insertLog($id_action, $datos, $id)
	{
		if ($this->getTableName() != $this->table_logs) {
			$session_data = $this->session->userdata('logged_in');

			$registro = [
				"tabla"     => $this->getTableName(),
				"id_tabla"  => $id,
				"id_accion" => $id_action,
				"id_usuario"=> $session_data['id_usuario'],
				"ip"        => $this->input->ip_address(),
				$this->field_date_add => getNowDateHour(),
				"url"       => current_url(),
				"data"      => json_encode($datos),
			];

			$this->db->insert($this->table_logs, $registro);
		}
	}

	public function getLastQuery(){
		return $this->db->last_query();
	}
}
?>
