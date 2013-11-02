<?php

if(!defined('IN_PEXINATOR'))
die('Access Denied');

echo '<div class="back1">';
	
	//
	echo '<div class="back1 lessdark">';
	echo '<div class="left">';
	echo '<form action="process.php" method="POST">';
	echo '<select name="value">';
	$tSel = '';
	$fSel = '';
	
	$cur = $pexinator->getSetting('wsEnabled');
		if($cur == 'true')
		{
			$tSel = 'selected';
		}
		if($cur == 'false')
		{
			$fSel = 'selected';	
		}
	
	echo '<option value="true" '.$tSel.'>True</option>';
	echo '<option value="false" '.$fSel.'>False</option>';
	echo '</select>';
	echo '</div>';
	echo '<div class="right">';
	echo 'Websend &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<input type="hidden" value="changeSetting" name="source" />';
	echo '<input type="hidden" value="wsEnabled" name="setting" />';
	echo '<input type="submit" name="submit" value="Update" />';
	echo '</div>';
	echo '</form>';
	
	echo '<div class="clear"></div>';
	echo '</div>';
	//
	
	//
	echo '<div class="back1 lessdark">';
	echo '<div class="left">';
	echo '<form action="process.php" method="POST">';
	echo '<input type="text" name="value" value="'.$pexinator->getSetting('wsAddress').'" />';
	echo '</div>';
	echo '<div class="right">';
	echo ' Websend IP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<input type="hidden" value="changeSetting" name="source" />';
	echo '<input type="hidden" value="wsAddress" name="setting" />';
	echo '<input type="submit" name="submit" value="Update" />';
	echo '</div>';
	echo '</form>';
	echo '<div class="clear"></div>';
	echo '</div>';
	//
	
	//
	echo '<div class="back1 lessdark">';
	echo '<div class="left">';
	echo '<form action="process.php" method="POST">';
	echo '<input type="text" name="value" value="'.$pexinator->getSetting('wsPassword').'" />';
	echo '</div>';
	echo '<div class="right">';
	echo 'Websend Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<input type="hidden" value="changeSetting" name="source" />';
	echo '<input type="hidden" value="wsPassword" name="setting" />';
	echo '<input type="submit" name="submit" value="Update" />';
	echo '</div>';
	echo '</form>';
	echo '<div class="clear"></div>';
	echo '</div>';
	//
	
	echo '<div class="spacer"></div>';
	
	//
	echo '<div class="back1 lessdark">';
	echo '<div class="left">';
	echo '<form action="process.php" method="POST">';
	
	
	echo '<select name="value">';
	$colors = $pexinator->getColors();
	$currentColor = $pexinator->getSetting('defaultColor');
	
	foreach($colors as $key => $value)
	{
		if($currentColor == $key)
			echo '<option value="'.$key.'" selected>'.$value.'</option>' . "\n";
		else
			echo '<option value="'.$key.'">'.$value.'</option>' . "\n";

	}
	
	echo '</select>';
	echo '</div>';
	echo '<div class="right">';
	echo 'Default Font Color &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<input type="hidden" value="changeSetting" name="source" />';
	echo '<input type="hidden" value="defaultColor" name="setting" />';
	echo '<input type="submit" name="submit" value="Update" />';
	echo '</div>';
	echo '</form>';
	echo '<div class="clear"></div>';
	echo '</div>';
	//
	
	echo '<div class="spacer"></div>';
	echo "Next update will include the ablilty to add new users to the panel";

echo '</div>';
?>