<?php
class account_controller extends controller {
	function loginAction() {
		$viewdata['returnurl'] = urlencode($_REQUEST['returnurl']);
		$viewdata['email'] = htmlspecialchars($_GET['email']);
		$this->renderView($viewdata, 'account', 'login', NULL);
	}
	
	function loginActionPOST() {
		$form_valid = true;
		$returnurl = $_REQUEST['returnurl'];
		if (substr($returnurl, 0, 1 ) !== '/') {
			$returnurl = '/';
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
		
		if (empty($_POST['password'])) {
			$viewdata['passworderror'] = 'Password is required';
			$form_valid = false;
		} else {
			$password = htmlspecialchars($_POST['password']);
		}
		
		if ($form_valid) {
			$conn = $GLOBALS['db']->get_conn();
			$stmt = $conn->prepare("SELECT id, firstname, lastname, password, roles FROM users WHERE email = ?");
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows === 1) {
				$row = $result->fetch_assoc();
				$hash = $row['password'];
				
				if (password_verify($password, $hash)) {
					$_SESSION['id'] = $row['id'];
					$_SESSION['firstname'] = $row['firstname'];
					$_SESSION['lastname'] = $row['lastname'];
					$_SESSION['roles'] = explode('|', $row['roles']);
					
					header('Location: ' . $returnurl);
					exit;
				}
			}
			$viewdata['passworderror'] = 'Invalid password';
		}
		
		$viewdata['title'] = 'Log in';
		$viewdata['returnurl'] = urlencode($returnurl);
		$this->renderView($viewdata, 'account', 'login', NULL);
	}
	
	function logoffActionPOST() {
		session_unset();
		session_destroy();
		header('Location: ' . LOGIN);
		exit;
	}
	
	function forgotpasswordAction() {
		$viewdata['email'] = htmlspecialchars($_GET['email']);
		$this->renderView($viewdata, 'account', 'forgotpassword', NULL);
	}
	
	function forgotpasswordActionPOST() {
		$form_valid = true;
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
		
		if ($form_valid) {
			$token = urlencode(openssl_encrypt(date("YmdHis") . $_SERVER['REMOTE_ADDR'], ENCRYPT_METHOD, ENCRYPT_PASSWORD));
			
			$conn = $GLOBALS['db']->get_conn();
			$conn->query("UPDATE `users` SET `token` = '$token' WHERE `email` = '$email'");
			
				$url = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/account/resetpassword/$token";
			if ($onn->affected_rows === 1) {
				
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				
				$message = "<p style=\"font-family:arial\">Click <a href=\"$url\">here</a> to reset your password.</p>";
				
				mail($email, 'Password Reset', $message, $headers);
			}
			
			header('Location: /account/forgotpasswordconfirmation?debug=' . urlencode($url));
			exit;
		}
		
		$this->renderView($viewdata, 'account', 'forgotpassword', NULL);
	}
	
	function forgotpasswordconfirmationAction() {
		$viewdata['debug'] = $_GET['debug'];
		$this->renderView($viewdata, 'account', 'forgotpasswordconfirmation', NULL);
	}
}
?>