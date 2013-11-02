<?php
session_start();

if(isset($_SESSION['logged_into_pexinator']))
{
	header("location: ../index.php");	
}



if(isset($_POST['submit']))
{
	require("../includes/config.php");
	$user = $_POST['username'];	
	$pass = $_POST['password'];
	
	$regex = "/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/";
	
  	if(!preg_match($regex,$user) || !preg_match($regex,$pass) || strlen($user) > 32)
	{
		header("location: index.php?error");
	}
	else
	{
		$conn = mysql_connect($settings['mysql']['host'],$settings['mysql']['username'],$settings['mysql']['password']);
		$db = mysql_select_db($settings['mysql']['database']);
				
		if($conn && $db)
		{
			$user = mysql_real_escape_string($user);
			$query = mysql_query("SELECT * FROM pexinator_users WHERE name = '$user'");
			$result = mysql_fetch_assoc($query);
			$pin = $result['pin'];
			$pass = md5($pass . $pin);
			
			$query2 = mysql_query("SELECT * FROM pexinator_users WHERE name = '$user' AND password = '$pass'");
			$num = mysql_num_rows($query2);
			
			if($num > 0)
			{
				$session = session_id();
				$query = mysql_query("UPDATE pexinator_users SET session_id='$session' WHERE name='$user'");
				if($query)
				{
					$_SESSION['logged_into_pexinator'] = true;
					$_SESSION['pexinator_user'] = $user;
					$_SESSION['pexinator_pin'] = md5($pin);
					header("location: ../index.php");
				}
			}
			else
			header("location: index.php?error");
		}
		else
		header("location: index.php?error");	
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>

<style type="text/css">

body,html
{
	padding: 0px;
	margin: 0px;	
}
body
{
	background: url(../img/body_bg.png);
	font-family:Verdana, Geneva, sans-serif;
	color: #fff;
	font-size:12px;
}
#wrapper
{
	width: 700px;
	margin: auto;	
	
	
}


input[type='text'], input[type='password'], input[type='email'], select
{
	background: #111;
	color: #fff;
	padding: 8px;
	border: none;	
	border-radius: 5px;
	box-shadow: 0px 1px 1px #333;
	width: 200px;
	margin-top: 5px;
}

input[type='submit']
{
	background: #111;
	color: #fff;
	padding: 8px;
	border-radius: 5px;
	box-shadow: 1px 1px 1px #333;
	border: none;
	cursor: pointer;
	margin-top: 5px;
}
input:hover
{
	background: #000;		
}
#logo
{
	width: auto;
	text-shadow: 0px 1px 1px #333;
	color: #111;
	font: 70px 'impact';
	margin-top: 100px;
}
#logo .the
{
	font: 45px 'impact';
	margin-top: 100px;
}
h1
{
	font-family:Verdana, Geneva, sans-serif;
	color: #fff;
	margin: 2px;
	font-size:16px;	
}

.error
{
	width: auto;
	padding: 10px;
	background:#FF464A;
	border: 1px solid #FF0000;
	-moz-border: 1px solid #FF0000;
	-webkit-border: 1px solid #FF0000;
	margin: 20px;

	font-weight: bold;
}

.success
{
	width: auto;
	padding: 10px;
	background:#2CAE00;
	border: 1px solid #0F0;
	-moz-border: 1px solid #0F0;
	-webkit-border: 1px solid #0F0;
	margin: 20px;

	font-weight: bold;
}

</style>



</head>
<body>

<div id="wrapper">


	<header>
    	<div id="logo">
        	<span class="the">the</span>Pexinator
        </div>
    </header>
    <?php if(!file_exists('../install/index.php')) { ?>

	<form action="index.php" method="POST">
	
    	<input type="text" name="username" placeholder="Username..." />
        <input type="password" name="password" placeholder="Password..." />
        <input type="submit" name="submit" value="Login" />

	</form>
    
    <?php } else { ?>
    
    <div class="error">INSTALL directory still exists. You you be able to log in once it's deleted.</div>
    
    <?php } ?>

</div>





</body>
</html>