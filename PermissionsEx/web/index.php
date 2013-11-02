<?php
session_start();
/////////////////////////////////
//        The PEXinator        //
//             BY              //
// Brant Wladichuk AKA Poonter //
/////////////////////////////////
//       RAGEBARREL.NET        //
/////////////////////////////////
//     DO NOT copy my work     //
//    without my permission    //
//   brantwladichuk@gmail.com  //
/////////////////////////////////

/////////////////////////////////
// THIS PAGE DOES NOT NEED TO  //
//       BE EDITED             //
/////////////////////////////////
define('VERSION','Version 2.2');

define('IN_PEXINATOR',true);

// DEFINE ROOT PATH
define( 'ROOT' , dirname(__FILE__) . '/' );

//REQUIRE EVERTHING
//require(ROOT . 'includes/global.php');

if(!file_exists(ROOT . 'includes/config.php'))
{
	echo 'Pexinator has not been set up. Please go through install process. /install/';
	die();
}

require(ROOT . 'includes/config.php');

require(ROOT . 'classes/formkey.class.php');
$formKey = new formKey();

//CALL MAIN CONTROLLER
require(ROOT . 'classes/pexinator.class.php');
$pexinator = new pexinator(
$settings['mysql']['host'],
$settings['mysql']['username'],
$settings['mysql']['password'],
$settings['mysql']['database']
);

require(ROOT . 'includes/check_loggin.php');


///////////////////////////////////////////
//     RENDER PAGE                       //
///////////////////////////////////////////



//GRAB PAGE VARIABLE
if(isset($_GET['action']))
	$page = $_GET['action'];
else
	$page = 'default';
	

$pageTitle = '';

// DISPLAY ACTION IF USER IS LOGGED IN

if($logged_in)
{
	switch($page)
	{
	
	default:
	case 'default':
		$pageTitle = 'Player Editor';
		require(ROOT . 'templates/header.php');
		require(ROOT . 'templates/home.php');
	break;

	case 'groupEditor':
		$pageTitle = 'Group Editor';
		require(ROOT . 'templates/header.php');
		require(ROOT . 'templates/groupEditor.php');
	break;
	
	case 'settings':
		$pageTitle = 'Settings';
		require(ROOT . 'templates/header.php');
		require(ROOT . 'templates/settings.php');
	break;	

	}
}
else
{
header("location: login");	
}

// DISPLAY FOOTER
require(ROOT . 'templates/footer.php');

?>
