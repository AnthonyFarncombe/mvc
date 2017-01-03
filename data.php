<?php
class datacontext {
	private $conn;
	
	public function get_conn() {
		if (!$this->conn || !$this->conn->ping()) {
			$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			if ($this->conn->connect_error) {
				die('Connection failed: ' . $this->conn->connect_error);
			}
		}
		return $this->conn;
	}
}
?>