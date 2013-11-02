<?php


class server
{
	var $host;
	var $pass;
	
	function __construct($h,$p)
	{
		$this->host = $h;
		$this->pass = $p;
	}
	
	function consoleCommand($cmd)
	{
     	$sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("error: could not create socket\n");
     	$succ = socket_connect($sock, $this->host, 4445) or die("error: could not connect to host\n");
     	socket_write($sock, $command = md5($this->pass)."<Password>", strlen($command) + 1) or die("error: failed to write to socket\n");
	 	socket_write($sock, $command = "/Command/ExecuteConsoleCommand:$cmd;", strlen($command) + 1) or die("error: failed to write to socket\n");
		return true;
	}

	function pexReload()
	{
     	$sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("error: could not create socket\n");
     	$succ = socket_connect($sock, $this->host, 4445) or die("error: could not connect to host\n");
     	socket_write($sock, $command = md5($this->pass)."<Password>", strlen($command) + 1) or die("error: failed to write to socket\n");
	 	socket_write($sock, $command = "/Command/ExecuteConsoleCommand:pex reload;", strlen($command) + 1) or die("error: failed to write to socket\n");
		return true;
	}
	
	
}




?>