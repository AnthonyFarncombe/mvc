<?php
class customers_controller extends controller {
	function indexAction() {
		$viewdata['title'] = 'Customers';
		$this->renderView($viewdata, 'customers', 'index');
	}
}
?>