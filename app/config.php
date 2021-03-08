<?php
session_start();
require_once 'GoogleAPI\vendor\autoload.php';
$gClient = new  Google_Client();
$gClient -> setClientId("291847403883-14apau9f71ot65o89lbdgrfgd7napgnr.apps.googleusercontent.com");
$gClient -> setClientSecret("XHgwiVIBybWznw5ACC39VQms");
$gClient -> setApplicationName("Body Caliber Fitness");
$gClient -> setRedirectUri("http://localhost/caps/login.php");
$gClient -> addScope('email');
$gClient -> addScope('profile');

?>