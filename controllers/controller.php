<?php
class controller {
	function authorize($controller_roles) {
		if (count($controller_roles) === 0) {
			return true;
		}
		foreach ($controller_roles as $role) {
			if (in_array($role, $_SESSION['roles'])) {
				return true;
			}
		}
		return false;
	}
	
	function renderView($viewdata, $controllername, $viewname, $layout = 'layout') {
		$viewpath = ABSPATH . "views/$controllername/$viewname.php";
		if (file_exists($viewpath)) {
			if (is_null($layout)) {
				require $viewpath;
				return;
			} else {
				$viewdata['view'] = $viewpath;
				$viewdata['script'] = preg_replace('/\.php$/', '.js.php', $viewpath);
			}
		} else {
			die('Cannot find view file');
		}
		
		$layoutpath = ABSPATH . "views/shared/$layout.php";
		if (file_exists($layoutpath)) {
			require $layoutpath;
		} else {
			die('Cannot find layout file');
		}
	}
}
?>