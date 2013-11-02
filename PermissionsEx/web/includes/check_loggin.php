<?php
$logged_in = false;
//Check if login session exists
if(isset($_SESSION['logged_into_pexinator']))
{
	$pexinator->connect();
	$user = mysql_real_escape_string($_SESSION['pexinator_user']);
	$query = mysql_query("SELECT * FROM pexinator_users WHERE name='$user'");
	$info = mysql_fetch_assoc($query);
	
	$current_session = session_id();
	$loggin_session = $info['session_id'];
	$pin = md5($info['pin']);
	
	//Check if the session when logged in is still the same, and pin.
	if($current_session == $loggin_session)
	{
		$logged_in = ($logged_in = true);
	}
	else
	session_destroy();

}
?>