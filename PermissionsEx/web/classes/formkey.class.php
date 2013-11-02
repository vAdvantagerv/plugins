<?php


class formKey
{

	private $formKey;

	private $old_formKey;

	function __construct()
	{

		if(isset($_SESSION['form_key']))
		{
			$this->old_formKey = $_SESSION['form_key'];
		}
	}

	private function generateKey()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$uniqid = uniqid(mt_rand(), true);
		return md5($ip . $uniqid);
	}

	public function outputKey()
	{
		$this->formKey = $this->generateKey();
		$_SESSION['form_key'] = $this->formKey;
		echo "<input type='hidden' name='form_key' id='form_key' value='".$this->formKey."' />";
	}


	public function validate()
	{
		if($_POST['form_key'] == $this->old_formKey)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>
