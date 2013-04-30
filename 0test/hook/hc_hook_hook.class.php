<?php
class hc_hook_hook_hook
{
	public $name;

	function __construct()
	{//{{{
		$this->name = __CLASS__;
	}//}}}
	function test_call()
	{//{{{
		$GLOBALS['t_hook_test_call'] = true;
	}//}}}
}
