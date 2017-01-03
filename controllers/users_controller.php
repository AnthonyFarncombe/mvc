<?php
class users_controller extends controller {
	function authorize() {
		return parent::authorize(Array('Admin'));
	}
	
	function indexAction() {
		$conn = $GLOBALS['db']->get_conn();
		$result = $conn->query("SELECT id, firstname, lastname, email FROM users ORDER BY firstname");
		$viewdata['users'] = $result;
		$viewdata['title'] = 'Manage Users';
		$this->renderView($viewdata, 'users', 'index');
	}
	
	function createAction() {
		$viewdata['title'] = 'Add User';
		$this->renderView($viewdata, 'users', 'create');
	}
	
	function createActionPOST() {
		$form_valid = true;
		
		if (empty($_POST['firstname'])) {
			$viewdata['firstnameerror'] = 'First name is required';
			$form_valid = false;
		} else {
			$firstname = htmlspecialchars($_POST['firstname']);
		}
		
		if (empty($_POST['lastname'])) {
			$viewdata['lastnameerror'] = 'Last name is required';
			$form_valid = false;
		} else {
			$lastname = htmlspecialchars($_POST['lastname']);
		}
		
		if (empty($_POST['email'])) {
			$viewdata['emailerror'] = 'Email is required';
			$form_valid = false;
		} else {
			$email = $viewdata['email'] = htmlspecialchars($_POST['email']);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$viewdata['emailerror'] = 'Invalid email format';
				$form_valid = false;
			}
		}
		
		$roles = htmlspecialchars(implode('|', $_POST['roles']));
		
		if ($form_valid) {
			$sql = "INSERT INTO `users` (`firstname`, `lastname`, `email`, `roles`) VALUES('$firstname', '$lastname', '$email', '$roles')";
			$conn = $GLOBALS['db']->get_conn();
			$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, roles) VALUES (?, ?, ?, ?)");
			$stmt->bind_param('ssss', $firstname, $lastname, $email, $roles);
			if ($stmt->execute()) {
				$id = $conn->insert_id;
				header("Location: /users/details/$id");
				exit;
			} else {
				$viewdata['error'] = $conn->error;
			}
		}
		
		$viewdata['user'] = Array('id'=>$id, 'firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'roles'=>$roles);
		$viewdata['title'] = 'Add User';
		$this->renderView($viewdata, 'users', 'create');
	}
	
	function detailsAction() {
		if (!is_numeric($_GET['id'])) {
			include PAGENOTFOUND;
			exit;
		}
		$id = htmlspecialchars($_GET['id']);
		
		$conn = $GLOBALS['db']->get_conn();
		$result = $conn->query("SELECT `id`, `firstname`, `lastname`, `email`, `roles` FROM `users` WHERE `id` = $id");
		
		if ($result->num_rows !== 1) {
			include PAGENOTFOUND;
			exit;
		}
		
		$viewdata['user'] = $result->fetch_assoc();
		$viewdata['title'] = 'User Details';
		$this->renderView($viewdata, 'users', 'details');
	}
	
	function editAction() {
		if (!is_numeric($_GET['id'])) {
			include PAGENOTFOUND;
			exit;
		}
		$id = htmlspecialchars($_GET['id']);
		
		$conn = $GLOBALS['db']->get_conn();
		$result = $conn->query("SELECT `id`, `firstname`, `lastname`, `email`, `roles` FROM `users` WHERE `id` = $id");
		
		if ($result->num_rows !== 1) {
			include PAGENOTFOUND;
			exit;
		}
		
		$viewdata['user'] = $result->fetch_assoc();
		$viewdata['title'] = 'Edit User';
		$this->renderView($viewdata, 'users', 'edit');
	}
	
	function editActionPOST() {
		if (!is_numeric($_POST['id'])) {
			http_response_code(400);
			exit;
		}
		
		$id = htmlspecialchars($_POST['id']);
		$form_valid = true;
		
		if (empty($_POST['firstname'])) {
			$viewdata['firstnameerror'] = 'First name is required';
			$form_valid = false;
		} else {
			$firstname = htmlspecialchars($_POST['firstname']);
		}
		
		if (empty($_POST['lastname'])) {
			$viewdata['lastnameerror'] = 'Last name is required';
			$form_valid = false;
		} else {
			$lastname = htmlspecialchars($_POST['lastname']);
		}
		
		if (empty($_POST['email'])) {
			$viewdata['emailerror'] = 'Email is required';
			$form_valid = false;
		} else {
			$email = $viewdata['email'] = htmlspecialchars($_POST['email']);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$viewdata['emailerror'] = 'Invalid email format';
				$form_valid = false;
			}
		}
		
		$roles = htmlspecialchars(implode('|', $_POST['roles']));
		
		if ($form_valid) {
			$sql = "UPDATE `users` SET `firstname` = '$firstname', `lastname` = '$lastname', `email` = '$email', `roles` = '$roles' WHERE `id` = $id";
			$conn = $GLOBALS['db']->get_conn();
			$stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ?, roles = ? WHERE id = ?");
			$stmt->bind_param('ssssi', $firstname, $lastname, $email, $roles, $id);
			if ($stmt->execute()) {
				header("Location: /users/details/$id");
				exit;
			} else {
				$viewdata['error'] = $conn->error;
			}
		}
		
		$viewdata['user'] = Array('id'=>$id, 'firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'roles'=>$roles);
		$viewdata['title'] = 'Edit User';
		$this->renderView($viewdata, 'users', 'edit');
	}
	
	function deleteAction() {
		if (!is_numeric($_GET['id'])) {
			include PAGENOTFOUND;
			exit;
		}
		$id = htmlspecialchars($_GET['id']);
		
		$conn = $GLOBALS['db']->get_conn();
		$result = $conn->query("SELECT `id`, `firstname`, `lastname`, `email`, `roles` FROM `users` WHERE `id` = $id");
		
		if ($result->num_rows !== 1) {
			include PAGENOTFOUND;
			exit;
		}
		
		$viewdata['user'] = $result->fetch_assoc();
		$viewdata['title'] = 'Delete User';
		$this->renderView($viewdata, 'users', 'delete');
	}
	
	function deleteActionPOST() {
		if (!is_numeric($_POST['id'])) {
			http_response_code(400);
			exit;
		}
		
		$id = htmlspecialchars($_POST['id']);
		$sql = "DELETE FROM `users` WHERE `id` = $id";
		$conn = $GLOBALS['db']->get_conn();
		$result = $conn->query($sql);
		if ($result === true) {
			header("Location: /users");
			exit;
		} else {
			$viewdata['error'] = $conn->error;
		}
	}
}
?>