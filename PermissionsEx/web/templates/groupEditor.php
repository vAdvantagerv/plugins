<?php
if(!defined('IN_PEXINATOR'))
die('Access Denied');


if(!isset($_GET['group']))
{
	$groups = $pexinator->groupListArray();
	foreach($groups as $key => $value)
	{
		echo '<div class="back1">' . "\n";
		echo $value;
		echo '<div class="right"><a href="index.php?action=groupEditor&group='.$value.'" class="button greenbutton">Edit</a></div>'. "\n";
  		echo '<div class="clear"></div>'. "\n";
		echo '</div>';	
	}
}
else
{
	$group = $_GET['group'];
	
echo '<div class="back1">' . "\n";
echo '<h1>'.$group .'</h1><div class="spacer"></div>'. "\n";

	$pexinator->connect();
	$sql = "SELECT * FROM permissions WHERE name = '$group'";
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
				echo '<div class="right"><input type="checkbox" name="deleteGroupPerm[]" value="' . $info['id'] . '" /></div>';
				echo '<div class="clear"></div>';
				echo '</div>';
			}
			
			$currentRow++;
		}
		echo '<input type="hidden" name="group" value="'.$group.'" />';
		echo '<input type="hidden" name="source" value="fromGroupRemove" />';
		$formKey->outputKey();
		echo '<input type="submit" name="submit" value="Remove Selected" class="button right redbutton" />';
		echo '</form>';
		echo '<div class="clear"></div>';
		echo '</div>';
	}
	else
	{
		echo '<div class="back1 lessdark">';
		echo '<h1>Permissions:</h1><br />';
		echo 'Group has no custom permissions';
		echo '</div>';
	}
		
	
	echo '<div class="back1 lessdark">';
	echo '<h1>Add Permission Nodes</h1><br />';
	echo '<form action="process.php" method="POST">';
	echo '<input type="text" placeholder="Node..." name="node" /><br />';
	echo '<input type="text" placeholder="World..." name="world" /><span class="redFont"> *Leave Blank for Global</span><br />';
	echo '<input type="hidden" name="group" value="'.$group.'" />';
	echo '<input type="hidden" name="source" value="fromGroupAdd" />';
	echo '<input type="submit" name="submit" value="Add Permission Node" class="right">';
	echo '</form>';
  	echo '<div class="clear"></div>' . "\n";
	echo '</div>' . "\n";
	

	
	echo '<div class="clear"></div>' . "\n";
	
	//PREFIX
	echo '<div class="back1 lessdark">';
	echo '<h1>Change Prefix</h1><br />';
	echo '<form action="process.php" method="POST">';

	echo '<div class="left">';
	echo '<select style="width: 120px;margin-right: 10px" name="prefixColor">';
	echo ' <option value="" selected>Color</option>';
	
	$colors = $pexinator->getColors();
	$groupPrefix = $pexinator->getPrefix($group);
	
	foreach($colors as $key => $value)
	{
		if($groupPrefix['color'] == $key)
			echo '<option value="'.$key.'" selected>'.$value.'</option>' . "\n";
		else
			echo '<option value="'.$key.'">'.$value.'</option>' . "\n";

	}

	
	echo '</select>';
	echo '<input type="text" placeholder="Prefix..." name="userPrefix" value="'.$groupPrefix['prefix'].'"/>';
	echo '</div>';
	echo '<input type="hidden" name="source" value="changeGroupPrefix" />';
	echo '<input type="hidden" name="user" value="'.$group.'" />';
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
	$groupSuffix = $pexinator->getSuffix($group);
	
	foreach($colors as $key => $value)
	{
		if($groupSuffix['color'] == $key)
			echo '<option value="'.$key.'" selected>'.$value.'</option>' . "\n";
		else
			echo '<option value="'.$key.'">'.$value.'</option>' . "\n";

	}

	
	echo '</select>';
	echo '<input type="text" placeholder="Suffix..." name="userSuffix" value="'.$groupSuffix['suffix'].'"/>';
	echo '</div>';
	echo '<input type="hidden" name="source" value="changeGroupSuffix" />';
	echo '<input type="hidden" name="user" value="'.$group.'" />';
	echo '<input type="submit" value="Change" class="right" name="submit"/>';
	echo '</form>';
	echo '<div class="clear"></div>';
	echo '</div>';
	//SUFFIX	 
	
echo '</div>';
echo '<div class="back1"><a href="index.php?action=groupEditor" class="button greenbutton"><< Back To List</a></div>' . "\n";
	
}




?>



