<?php
session_start();
define( 'ROOT' , dirname(__FILE__) . '/' );

require(ROOT . 'includes/config.php');

require(ROOT . 'classes/formKey.class.php');
$formKey = new formKey();

require(ROOT . 'classes/pexinator.class.php');
	$pexinator = new pexinator(
	$settings['mysql']['host'],
	$settings['mysql']['username'],
	$settings['mysql']['password'],
	$settings['mysql']['database']
);

require(ROOT . 'classes/server.class.php');
$server = new server(
$pexinator->getSetting('wsAddress'),
$pexinator->getSetting('wsPassword')
);

require(ROOT . 'includes/check_loggin.php');



if(isset($_POST['submit']) && $logged_in)
{
	

	
	$source = $_POST['source'];
	
	if($source == 'fromPlayerRemove' || $source == 'fromGroupRemove')
	{
		if(!isset($_POST['form_key']) || !$formKey->validate())  
   		{  
         	die('A problem was detected, please press back and refresh your browser.');  
   		}	
	}
	
	
	
	switch($source)
	{	
	
		default:
			die('<h1>Not Authorized Foo!</h1><img src="http://i.imgur.com/iEGC2.jpg" alt="Not Autoized." />');
		break;
	//////////////////////////////
		
		case 'fromPlayerRemove':
			$array = $_POST['deleteUserPerm'];
			if(!$array)
			{
				header("location: index.php?player=" . $_POST['user'] . "&error=101");
				die();	
			}
			
			$pexinator->connect();
				foreach($array as $key => $value)
				{
					$value = mysql_real_escape_string($value);
					$delete_query = mysql_query("DELETE FROM permissions WHERE id=$value");
				}
			$pexinator->disconnect();
			if($delete_query)
			{
				header("location: index.php?player=" . $_POST['user'] . "&success");
				
				if($pexinator->getSetting('wsEnabled') == 'true')
				{
					$server->pexReload();
				}
			}
			else
				header("location: index.php?player=" . $_POST['user'] . "&error=102");	
		break;
		
///////////////////////////////////////////////

		case 'fromPlayerAdd':
			$pexinator->connect();
			$player = mysql_real_escape_string(trim($_POST['user']));
			$node = mysql_real_escape_string(trim($_POST['node']));
			$world = mysql_real_escape_string(trim($_POST['world']));
			
			if(!$player || !$node)
			{
				header("location: index.php?player=" . $_POST['user'] . "&error=201");
				die();	
			}
			
			$add_query = mysql_query("INSERT INTO permissions (id,name,type,world,permission,value) VALUES (NULL,'$player','1','$world','$node','')");
			$pexinator->disconnect();
			if($add_query)
			{
				header("location: index.php?player=" . $_POST['user'] . "&success");
				if($pexinator->getSetting('wsEnabled') == 'true')
				{
					$server->pexReload();
				}
			}
			else
				header("location: index.php?player=" . $_POST['user'] . "&error=202");
		break;
		
////////////////////////////////////////////////////////	
	
		case 'fromGroupRemove':
			$array = $_POST['deleteGroupPerm'];
			if(!$array)
			{
				header("location: index.php?action=groupEditor&group=" . $_POST['group'] . "&error=301");
				die();	
			}
			
			$pexinator->connect();
				foreach($array as $key => $value)
				{
					$value = mysql_real_escape_string($value);
					$delete_query = mysql_query("DELETE FROM permissions WHERE id=$value");
				}
			$pexinator->disconnect();
			if($delete_query)
			{
				header("location: index.php?action=groupEditor&group=" . $_POST['group'] . "&success");
				if($pexinator->getSetting('wsEnabled') == 'true')
				{
					$server->pexReload();
				}
			}
			else
				header("location: index.php?action=groupEditor&group=" . $_POST['group'] . "&error=302");	
		break;

////////////////////////////////////////

		case 'fromGroupAdd':
			$pexinator->connect();
			$group = mysql_real_escape_string(trim($_POST['group']));
			$node = mysql_real_escape_string(trim($_POST['node']));
			$world = mysql_real_escape_string(trim($_POST['world']));
			
			if(!$group || !$node)
			{
				header("location: index.php?action=groupEditor&group=" . $group . "&error=401");
				die();	
			}
			
			$add_query = mysql_query("INSERT INTO permissions (id,name,type,world,permission,value) VALUES (NULL,'$group','0','$world','$node','')");
			$pexinator->disconnect();
			if($add_query)
			{
				header("location: index.php?action=groupEditor&group=" . $group . "&success");
				if($pexinator->getSetting('wsEnabled') == 'true')
				{
					$server->pexReload();
				}
			}
			else
				header("location: index.php?action=groupEditor&group=" . $group . "&error=402");
		break;
		
/////////////////////////////////////////

		case 'changeGroup':
			$pexinator->connect();
			$user = mysql_real_escape_string($_POST['user']);
			$group = mysql_real_escape_string($_POST['newGroup']);
			
			$update_query = mysql_query("UPDATE permissions_inheritance SET parent = '$group' WHERE child = '$user'");
			
			if($update_query)
			{
				header("location: index.php?player=" . $_POST['user'] . "&success");
				
				if($pexinator->getSetting('wsEnabled') == 'true')
				{
					$server->pexReload();
					$server->consoleCommand("say ".$user." is now: ".$group);
				}
			}
			else
			{
				header("location: index.php?player=" . $_POST['user'] . "&error=502");
			}
				
			$pexinator->disconnect();
		break;
		
		
//////////////////////////////////////

	case 'changeUserPrefix':
		$pexinator->connect();
		$user = mysql_real_escape_string($_POST['user']);
		$prefix = mysql_real_escape_string($_POST['userPrefix']);
		$color = mysql_real_escape_string($_POST['prefixColor']);
		$fontColor = mysql_real_escape_string($pexinator->getSetting('defaultColor'));
		
		if(!$color || strtolower($color) == 'color' || strlen($color) > 2)
		{
			header("location: index.php?player=" . $_POST['user'] . "&error=601");
			die();
		}
		else
		{
			
			
		if(empty($prefix))
		{
			$color = '';
			$fontColor = '';	
		}
			
		$finalPrefix = $color.$prefix.$fontColor;
		$update_query = mysql_query("UPDATE permissions_entity SET prefix = '$finalPrefix' WHERE name = '$user'");
			if($update_query)
			{
				header("location: index.php?player=" . $_POST['user'] . "&success");
				
				if($pexinator->getSetting('wsEnabled') == 'true')
				{
					$server->pexReload();
					$server->consoleCommand("msg ".$user." Prefix updated: ".$prefix);
				}
			}
			else
				header("location: index.php?player=" . $_POST['user'] . "&error=602");
		}
	
	break;
	
/////////////////////////////////////////

	case 'changeUserSuffix':
		$pexinator->connect();
		$user = mysql_real_escape_string($_POST['user']);
		$suffix = mysql_real_escape_string($_POST['userSuffix']);
		$color = mysql_real_escape_string($_POST['suffixColor']);
		$fontColor = mysql_real_escape_string($pexinator->getSetting('defaultColor'));
		
		if(!$color || strtolower($color) == 'color' || strlen($color) > 2)
		{
			header("location: index.php?player=" . $_POST['user'] . "&error=701");
			die();
		}
		else
		{
		$finalSuffix = $color.$suffix.$fontColor;
			
		$update_query = mysql_query("UPDATE permissions_entity SET suffix = '$finalSuffix' WHERE name = '$user'");
			if($update_query)
			{
				header("location: index.php?player=" . $_POST['user'] . "&success");
				
				if($pexinator->getSetting('wsEnabled') == 'true')
				{
					$server->pexReload();
					$server->consoleCommand("msg ".$user." Suffix updated: ".$suffix);
				}
			}
			else
				header("location: index.php?player=" . $_POST['user'] . "&error=702");
		}
	
	break;	
	
////////////////////////////////////////////////////////////////////

	case 'changeGroupPrefix':
		$pexinator->connect();
		$user = mysql_real_escape_string($_POST['user']);
		$prefix = mysql_real_escape_string($_POST['userPrefix']);
		$color = mysql_real_escape_string($_POST['prefixColor']);
		$fontColor = mysql_real_escape_string($pexinator->getSetting('defaultColor'));
		
		if(!$color || strtolower($color) == 'color' || strlen($color) > 2 || empty($prefix))
		{
			header("location: index.php?action=groupEditor&group=" . $_POST['user'] . "&error=801");
			die();
		}
		else
		{
			
		$finalPrefix = $color.$prefix.$fontColor;
		$update_query = mysql_query("UPDATE permissions_entity SET prefix = '$finalPrefix' WHERE name = '$user'");
			if($update_query)
			{
				header("location: index.php?action=groupEditor&group=" . $_POST['user'] . "&success");
				
				if($pexinator->getSetting('wsEnabled') == 'true')
				{
					$server->pexReload();
				}
			}
			else
				header("location: index.php?action=groupEditor&group=" . $_POST['user'] . "&falied=802");
		}
	
	break;
	
//////////////////////////////////////////////////////////////////

	case 'changeGroupSuffix':
		$pexinator->connect();
		$user = mysql_real_escape_string($_POST['user']);
		$suffix = mysql_real_escape_string($_POST['userSuffix']);
		$color = mysql_real_escape_string($_POST['suffixColor']);
		$fontColor = mysql_real_escape_string($pexinator->getSetting('defaultColor'));
		
		if(!$color || strtolower($color) == 'color' || strlen($color) > 2)
		{
			header("location: index.php?action=groupEditor&group=" . $_POST['user'] . "&error=901");
			die();
		}
		else
		{
			
		if(empty($suffix))
		{
			$suffix='';
			$color='';
			$fontColor='';	
		}
			
		$finalSuffix = $color.$suffix.$fontColor;
			
		$update_query = mysql_query("UPDATE permissions_entity SET suffix = '$finalSuffix' WHERE name = '$user'");
			if($update_query)
			{
				header("location: index.php?action=groupEditor&group=" . $_POST['user'] . "&success");
				
				if($pexinator->getSetting('wsEnabled') == 'true')
				{
					$server->pexReload();
				}
			}
			else
				header("location: index.php?action=groupEditor&group=" . $_POST['user'] . "&error=902");
		}
	
	break;
	
////////////////////////////////////////////////////////////////////////////////////////////////

	case 'changeSetting';
		$pexinator->connect();
		$setting = mysql_real_escape_string($_POST['setting']);
		$value = mysql_real_escape_string($_POST['value']);
		$query = mysql_query("UPDATE pexinator_settings SET value = '$value' WHERE setting = '$setting'");
		if($query)
		{
			header("location: index.php?action=settings&success");
		}
		else
		{
			header("location: index.php?action=settings&error=1002");
		}
		
	break;

	
	}	
}
else
die('<h1>Not Authorized Foo!2</h1><img src="http://i.imgur.com/iEGC2.jpg" alt="Not Autoized." />');




?>