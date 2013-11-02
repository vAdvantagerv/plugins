<?php

if(!defined('IN_PEXINATOR'))
die('Access Denied');

?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $pageTitle; ?> | thePexinator</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
<?php if(!isset($_GET['action'])) { ?> 
function suggest(inputString){
        if(inputString.length == 0) {
            $('#suggestions').fadeOut();
        } else {
            $.post("autosuggest.php", {queryString: ""+inputString+""}, function(data){
                if(data.length > 0) {
                    $('#suggestions').fadeIn();
                    $('#suggestionsList').html(data);
                }
            });
        }
    }
 
function fill(thisValue) {
    $('#players').val(thisValue);
    setTimeout("$('#suggestions').fadeOut();", 600);
}

$(document).ready(function() {
	$('#players').focusout(function() {
		$(this).val('');
		$('#suggestions').fadeOut();
	});
});
	
<?php } ?>

<?php if(isset($_GET['success'])) { ?>
$(document).ready(function() {
	$(".success").delay(1000).fadeOut(1000);
});
<?php } ?>

<?php if(isset($_GET['error'])) { ?>
$(document).ready(function() {
	$(".error").delay(1000).fadeOut(1000);
});
<?php } ?>
	
</script>

</head>
<body>

<div id="topBar">
	<div class="left" style="margin-top: 5px;">
		thePEXINATOR <?php echo '<span style="font-size: 10px;">'.VERSION.'</span>'; ?> | PermissionsEX Epic Web Based Control Panel
	</div>

	<div class="right">

    	<a href="logout.php" class="button right redbutton" >Logout</a>

    </div>
	
	<div class="clear"></div>
</div>

<!--
	<header>
	<span id="logo"><span class="the">the</span>PEXINATOR</span>
	</header> 
-->

    
    <div id="wrapper">
    
    <nav>
    	<ul>
        	<li><a href="index.php">Player Editor</a></li>
    		<li><a href="index.php?action=groupEditor">Group Editor</a></li>
            <li><a href="index.php?action=settings">Settings</a></li>
    	</ul>
	</nav>
    
<div id="content">

<!-- <div class="messageBox">Success!</div> -->

<span class="pageTitle"><?php echo $pageTitle; ?></span>

<?php 
if(isset($_GET['success']))
{
echo '<div class="success">Success!</div>';
}

if(isset($_GET['error']))
{
echo '<div class="error">Error: '.$_GET['error'].'</div>';	
}
?>
<!--  RENDERED PAGE AREA BELOW--->
    
