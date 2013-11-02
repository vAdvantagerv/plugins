<?php

if(!defined('IN_PEXINATOR'))
die('Access Denied');

////////////////////////////
// PEXINATOR HOME PAGE    //
////////////////////////////


//SEARCH FORM
echo '<div class="back2" style="padding-left: 0px;">' . "\n";
echo '<form id="form" action="#">' . "\n";
echo '<div id="suggest">' . "\n";
echo '<input id="players" onkeyup="suggest(this.value);" size="25" type="text" placeholder="Search Players..." />' . "\n";
echo '<div id="suggestions" class="suggestionsBox" style="display: none;">' . "\n";
echo '<div class="load"></div>' . "\n";
echo '<div id="suggestionsList" class="suggestionList"></div>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '</form>' . "\n";
echo '<div class="clear"></div>' . "\n";
echo '</div>' . "\n";



// DISPLAY PLAYER ID SET
if(isset($_GET['player']))
{
	$pexinator->connect();
	$player = mysql_real_escape_string($_GET['player']);
		
	echo '<div class="back1">' . "\n";
	echo '<h1>'.$player .'</h1><div class="spacer"></div>'. "\n";
	
	$sql = "SELECT * FROM permissions WHERE name = '$player'";
	$result = mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($result);
	
	
	// LIST PERMISSIONS
	if($num > 0)
	{
		echo '<div class="back1 lessdark">';
		echo '<h1>Current Permission Nodes</h1><br />';
		echo '<form action="process.php" method="POST">';
		
		$currentRow = 0;
		while($info = mysql_fetch_array($result))
		{
			if($currentRow%2)
				$back = 'back3';
			else
				$back = 'back4';
			
			if($info['permission'] === 'rank')
			{
				echo '<div class="'.$back.'">';
				echo '<span class="left">' . $info['permission'] . '</span>';
				echo '<div class="right redFont">Do Not Delete</div>';
				echo '<div class="clear"></div>';
				echo '</div>';
			}
			else
			{
				echo '<div class="'.$back.'">';
				echo '<span class="left">' . $info['permission'] . '</span>';
				echo '<div class="right"><input type="checkbox" name="deleteUserPerm[]" value="' . $info['id'] . '" /></div>';
				echo '<div class="clear"></div>';
				echo '</div>';
			}
			
			$currentRow++;
		}
		echo '<input type="hidden" name="user" value="'.$player.'" />';
		echo '<input type="hidden" name="source" value="fromPlayerRemove" />';
		$formKey->outputKey();
		echo '<input type="submit" name="submit" value="Remove Selected" class="button right redbutton" />';
		echo '</form>';
		echo '<div class="clear"></div>';
		echo '</div>';
	}
	else
	{
		echo '<div class="back1 lessdark">';
		echo '<h1>Permissions</h1><br />';
		echo 'User has no custom permissions';
		echo '</div>';
	}
  


	//ADD PERMISSION FORM
	echo '<div class="back1 lessdark">';
	echo '<h1>Add Permission Nodes</h1><br />';
	echo '<form action="process.php" method="POST">';
	echo '<input type="text" placeholder="Node..." name="node" /><br />';
	echo '<input type="text" placeholder="World..." name="world" /><span class="redFont"> *Leave Blank for Global</span><br />';
	echo '<input type="hidden" name="user" value="'.$player.'" />';
	echo '<input type="hidden" name="source" value="fromPlayerAdd" />';
	echo '<input type="submit" name="submit" value="Add Permission Node" class="right">';
	echo '</form>';
  	echo '<div class="clear"></div>' . "\n";
	echo '</div>' . "\n"; 
	
	//CHANGE GROUP
	echo '<div class="back1 lessdark">';
	echo '<h1>Change Group</h1><br />';
	echo '<form action="process.php" method="POST">';
	echo '<select name="newGroup" class="left">';
	
		$groups = $pexinator->groupListArray();
		foreach($groups as $key => $value)
		{ 
			$selected = '';
			if($value == $pexinator->getCurrentGroup($player))
				$selected = 'selected';
			echo '<option value="'.$value.'"'.$selected.'>'.$value.'</option>';	
		}
	
	echo '</select>';
	echo '<input type="hidden" name="source" value="changeGroup" />';
	echo '<input type="hidden" name="user" value="'.$player.'" />';
	echo '<input type="submit" name="submit" value="Change" class="right" />';
	echo '</form>';
	echo '<div class="clear"></div>';
	echo '</div>';
	//GROUP




	//PREFIX
	echo '<div class="back1 lessdark">';
	echo '<h1>Change Prefix</h1><br />';
	echo '<form action="process.php" method="POST">';

	echo '<div class="left">';
	echo '<select style="width: 120px;margin-right: 10px" name="prefixColor">';
	echo ' <option value="" selected>Color</option>';
	
	$colors = $pexinator->getColors();
	$userPrefix = $pexinator->getPrefix($player);
	
	foreach($colors as $key => $value)
	{
		if($userPrefix['color'] == $key)
			echo '<option value="'.$key.'" selected>'.$value.'</option>' . "\n";
		else
			echo '<option value="'.$key.'">'.$value.'</option>' . "\n";

	}

	
	echo '</select>';
	echo '<input type="text" placeholder="Prefix..." name="userPrefix" value="'.$userPrefix['prefix'].'"/>';
	echo '</div>';
	echo '<input type="hidden" name="source" value="changeUserPrefix" />';
	echo '<input type="hidden" name="user" value="'.$player.'" />';
	echo '<input type="submit" value="Change" class="right" name="submit"/>';
	echo '</form>';
	echo '<div class="clear"></div>';
	echo '</div>';
	//PREFIX


	//SUFFIX
	echo '<div class="back1 lessdark">';
	echo '<h1>Change Suffix</h1><br />';
	echo '<form action="process.php" method="POST">';

	echo '<div class="left">';
	echo '<select style="width: 120px;margin-right: 10px" name="suffixColor">';
	echo ' <option value="" selected>Color</option>';
	
	$colors = $pexinator->getColors();
	$userSuffix = $pexinator->getSuffix($player);
	
	foreach($colors as $key => $value)
	{
		if($userSuffix['color'] == $key)
			echo '<option value="'.$key.'" selected>'.$value.'</option>' . "\n";
		else
			echo '<option value="'.$key.'">'.$value.'</option>' . "\n";

	}

	
	echo '</select>';
	echo '<input type="text" placeholder="Suffix..." name="userSuffix" value="'.$userSuffix['suffix'].'"/>';
	echo '</div>';
	echo '<input type="hidden" name="source" value="changeUserSuffix" />';
	echo '<input type="hidden" name="user" value="'.$player.'" />';
	echo '<input type="submit" value="Change" class="right" name="submit"/>';
	echo '</form>';
	echo '<div class="clear"></div>';
	echo '</div>';
	//SUFFIX



	echo '<div class="clear"></div>' . "\n";
	echo '</div>' . "\n"; //MAIN BACK1

	echo '<div class="back1"><a href="index.php" class="button greenbutton"><< Back To List</a></div>' . "\n";
	$pexinator->disconnect();
}

// ELSE DISPLAY LIST
else 
{
$pexinator->connect();
$sql = "SELECT COUNT(*) FROM permissions_entity WHERE type = '1'";
$result = mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);
$r = mysql_fetch_row($result);
$numrows = $r[0];


$rowsperpage = 10;

$totalpages = ceil($numrows / $rowsperpage);


if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage']))
   $currentpage = (int) $_GET['currentpage'];
else 
   $currentpage = 1;

if ($currentpage > $totalpages)
	$currentpage = $totalpages;

if ($currentpage < 1)
	$currentpage = 1;


$offset = ($currentpage - 1) * $rowsperpage;

 
$sql = "SELECT * FROM permissions_entity WHERE type = '1' ORDER BY name ASC LIMIT $offset, $rowsperpage";
$result = mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);

	echo '<div class="back2">' . "\n";
	echo '<span class="right">Page: ' . $currentpage . ' / ' . $totalpages . '</span>'."\n";
	echo '<span class="left">Total Players: '.$numrows . '</span>';
	echo '<div class="clear"></div>'. "\n";
	echo '</div>'. "\n";

echo '<div id="loopContainer">'. "\n";

while ($row = mysql_fetch_assoc($result))
{
	echo '<div class="back1">' . "\n";
	echo '<div class="left">'.$row['name'].'</div>'. "\n";
	echo '<div class="right"><a href="index.php?player='.$row['name'].'" class="button greenbutton">Edit</a></div>'. "\n";
  	echo '<div class="clear"></div>'. "\n";
	echo '</div>'. "\n";  
}

echo '</div>';

$range = 3;

echo '<div id="pagenation">';

if ($currentpage > 1)
{
   echo '<div class="left" style="margin-right: 50px;">';	
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'>First</a> ";
   $prevpage = $currentpage - 1;
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Prev</a> ";
   echo '</div>';
} 


for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) 
{
   if (($x > 0) && ($x <= $totalpages)) 
   {
      if ($x == $currentpage) 
         echo " <b>$x</b> ";
	  else 
         echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
   }
}
                  
if ($currentpage != $totalpages)
{
   $nextpage = $currentpage + 1;
   echo '<div class="right">';
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next</a> ";
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>Last</a> ";
   echo '</div>';
}

echo '<div class="clear"></div>';
echo '</div>';
$pexinator->disconnect();
}





?>