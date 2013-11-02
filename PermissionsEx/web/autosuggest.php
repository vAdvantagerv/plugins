<?php


if(isset($_POST['queryString'])) {
	
	define( 'ROOT' , dirname(__FILE__) . '/' );
	require(ROOT . 'includes/config.php');
	$conn = mysql_connect($settings['mysql']['host'],$settings['mysql']['username'],$settings['mysql']['password']) or trigger_error("SQL", E_USER_ERROR);
	$db = mysql_select_db($settings['mysql']['database'],$conn) or trigger_error("SQL", E_USER_ERROR);	
	
			$queryString = mysql_real_escape_string($_POST['queryString']);
			
			if(strlen($queryString) >0) 
			{

				$query = mysql_query("SELECT name FROM permissions_entity WHERE name LIKE '$queryString%' LIMIT 10");
				if($query) 
				{
					echo '<ul>';
						while ($result = mysql_fetch_array($query)) 
						{
							echo '<li><a href="index.php?player='.$result['name'].'">'.$result['name'].'</a></li>';
	         			}
					echo '</ul>';
				} 
				
				
				else 
				{
					echo 'OOPS we had a problem :(';
				}
			} 
			
			else 
			{
				// do nothing
			}
		} 
		
		else 
		{
			echo 'Access Denied.';
		}

?>