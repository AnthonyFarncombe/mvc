<?php

/** The name of the database for MVC */
define('DB_NAME', 'dbname');

/** MySQL database username */
define('DB_USER', 'username');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** The url to redirect unauthorized users to */
define('LOGIN', '/account/login');

/** 404 not found */
define('PAGENOTFOUND', ABSPATH . 'views/shared/pagenotfound.php');

/** Encryption for password reset token */
define('ENCRYPT_METHOD', 'aes-256-cbc');
define('ENCRYPT_PASSWORD', 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWZYZab');

/** Array of pages to allow unauthorized users */
$allow_unauthorized_pages = Array('^\/account\/login',
								  '^\/account\/forgotpassword');
?>
