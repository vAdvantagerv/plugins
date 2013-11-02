<?php


class pexinator
{
	
	var $host;
	var $user;
	var $pass;
	var $db;
	
	
	function __construct($h,$u,$p,$db)
	{
		$this->host = $h;
		$this->user = $u;
		$this->pass = $p;
		$this->db = $db;	
	}

	function connect()
	{
		mysql_connect($this->host,$this->user,$this->pass);
		mysql_select_db($this->db);
	}
	
	function disconnect()
	{
		mysql_close();	
	}


	function groupListArray()
	{
		$this->connect();
		$query = mysql_query("SELECT * FROM permissions WHERE permission = 'rank' ORDER BY id ASC");
		$groupArray = array();
		while($data = mysql_fetch_assoc($query))
		{
			$groupArray[] = $data['name'];	
		}
		return $groupArray;
		$this->disconnect();
	}
	
	function getCurrentGroup($u)
	{
		$this->connect();
		$u = mysql_real_escape_string($u);
		$query = mysql_query("SELECT * FROM permissions_inheritance WHERE child = '$u'");
		$result = mysql_fetch_assoc($query);
		return $result['parent'];
		$this->disconnect();
	}
	
	function getPrefix($u)
	{
		$this->connect();
		$u = mysql_real_escape_string($u);
		$query = mysql_query("SELECT * FROM permissions_entity WHERE name = '$u'");
		$result = mysql_fetch_assoc($query);
		$prefix = $result['prefix'];
		
		$color = substr($prefix, 0, 2);
		$string = substr($prefix, 2);
		$string = substr($string,0,-2);
		
		return array('color' => $color, 'prefix' => $string);
		$this->disconnect();
	}
	function getSuffix($u)
	{
		$this->connect();
		$u = mysql_real_escape_string($u);
		$query = mysql_query("SELECT * FROM permissions_entity WHERE name = '$u'");
		$result = mysql_fetch_assoc($query);
		$suffix = $result['suffix'];
		
		$color = substr($suffix, 0, 2);
		$string = substr($suffix, 2);
		$string = substr($string,0,-2);
		
		return array('color' => $color, 'suffix' => $string);
		$this->disconnect();
	}
	
	
	function getColors()
	{
		
		$colors = array(
		'&0'=>'Black',
		'&1'=>'Dark Blue',
		'&2'=>'Dark Green',
		'&3'=>'Teal',
		'&4'=>'Dark Red',
		'&5'=>'Purple',
		'&6'=>'Gold',
		'&7'=>'Gray',
		'&8'=>'Dark Gray',
		'&9'=>'Blue',
		'&a'=>'Light Green',
		'&b'=>'Aqua',
		'&c'=>'Red',
		'&d'=>'Pink',
		'&e'=>'Yellow',
		'&f'=>'White'
		);	
		
		return $colors;
	}
	
	
	function getUserGroup($u)
	{
		$this->connect();
		$u = mysql_real_escape_string($u);
		$query = mysql_query("SELECT * FROM permissions_inheritance WHERE child = '$u'");
		$result = mysql_fetch_assoc($query);
		$group = $result['parent'];
		return $group;
		$this->disconnect();
		
	}
	
	function getSetting($s)
	{
		$this->connect();
		$s = mysql_real_escape_string($s);
		$query = mysql_query("SELECT * FROM pexinator_settings WHERE setting = '$s'");
		$result = mysql_fetch_assoc($query);
		return $result['value'];
		$this->disconnect();
	}
	function updateSetting($s,$v)
	{
		$this->connect();
		$s = mysql_real_escape_string($s);
		$v = mysql_real_escape_string($v);
		$query = mysql_query("UPDATE pexinator_settings SET value = '$v' WHERE setting = '$s'");
		$this->disconnect();
	}
	
	
}














?>