<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('Europe/Berlin');

//database credentials
define('DBHOST','localhost');
define('DBUSER','user');
define('DBPASS','password');
define('DBNAME','admin');

//application address
define('DIR','https://vd.example.tld/');
define('SITEEMAIL','noreply@openbsod.com');

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
?>
