<?php
class h_hook_hook
{
	function test_call()
	{//{{{
		$path = dirname(__FILE__) . "/hook.inc.php";
		$list = gpf_hook($path, __CLASS__, __FUNCTION__);
		//debug/dump/$list
		foreach ($list as $k => $v)
			{
			$v->test_call();
			}
		return true;
	}//}}}
}
