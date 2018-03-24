<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('Europe/Berlin');

//database credentials
define('servername','localhost');
define('username','user');
define('password','password');
define('dbname','vds');

try {

	//create PDO connection
	$db = new PDO("mysql:host=".servername.";dbname=".dbname, username, password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
  echo '<p class="bg-danger">'.$e->getMessage().'</p>';
 exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
// include('classes/phpmailer/mail.php');
$user = new User($db);
?>
