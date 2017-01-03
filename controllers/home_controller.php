<?php
class home_controller extends controller {
	function indexAction() {
		$viewdata['title'] = 'Furncare Home';
		$this->renderView($viewdata, 'home', 'index');
	}
}
?>