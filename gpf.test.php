<?php
$_dir = dirname(__FILE__) . '/';
define('GPF_RUNTIME', $_dir . 'runtime/');
define('GPF_DEBUG', true);
define('GPF_DEBUG_OUTPUT', "{$_dir}runtime/debug_output/");
define('GPF_DEBUG_PHP', "{$_dir}runtime/debug_php/");
define('GPF_DEBUG_JS_SCRIPT', 1);
define('GPF_DEBUG_JS_PHP', 1);
define('GPF_TEST', true);

require dirname(__FILE__) . '/debug.inc.php';
require gpfd_file("{$_dir}/gpf.inc.php");

gpf_inc(dirname(__FILE__) . '/debug.test.php');

if (!is_dir(GPF_DEBUG_OUTPUT))
	{
	mkdir(GPF_DEBUG_OUTPUT);
	mkdir(GPF_DEBUG_PHP);
	}

//测试 gpf_copy 功能
function test_gpf_copy()
{//{{{
	$is_ok = is_dir(GPF_RUNTIME) && is_writable(GPF_RUNTIME);
	gpfd_test(true === $is_ok);
	if (!$is_ok)
		{
		return ;
		}
	$_dir777 = GPF_RUNTIME.'static/';
	`rm -rf {$_dir777}`;
	gpfd_test(!is_dir($_dir777));
	`mkdir -p {$_dir777}to/`;
	gpfd_test(is_dir($_dir777.'to'));
	
	`mkdir -p {$_dir777}copy`;
	touch($_dir777.'copy/js.js');
	gpf_copy($_dir777.'notexists.js', '');
	gpfd_test(true===$GLOBALS['t_staticcopy_not_sour']);

	gpf_copy($_dir777.'copy/js.js', $_dir777.'to/copy/js.js');
	gpfd_test(true===$GLOBALS['t_staticcopy_is_copy']);
	gpfd_test(is_file($_dir777.'to/copy/js.js'));

	gpf_copy($_dir777.'copy/js.js', $_dir777.'to/copy/js.js');
	gpfd_test(false===$GLOBALS['t_staticcopy_is_copy']);
	gpfd_test(false===$GLOBALS['t_staticcopy_not_sour']);

	`rm -rf {$_dir777}to/copy/`;
	gpf_copy($_dir777.'copy', $_dir777.'to/copy');
	gpfd_test(true===$GLOBALS['t_staticcopy_is_copy']);
	gpfd_test(is_file($_dir777.'to/copy/js.js'));

	`rm -rf {$_dir777}`;
}//}}}
// test_gpf_copy();

//测试 gpf_hook 功能
function test_gpf_hook()
{//{{{
	$list = gpf_hook(dirname(__FILE__) . 'notexists.notexists', 'h_hook_hook', 'test_call');
	gpfd_test(array() === $list, __FILE__,__LINE__);
	gpfd_test(false === $GLOBALS['t_hmf_is_cache'],__FILE__,__LINE__);
	$list = gpf_hook(dirname(__FILE__) . 'notexists.notexists', 'h_hook_hook', 'test_call');
	gpfd_test(true === $GLOBALS['t_hmf_is_cache'],__FILE__,__LINE__);

	$callback_list_path = dirname(__FILE__) . "/0test/hook/hook.inc.php";

	$list = gpf_hook($callback_list_path, 'h_hook_hook', 'test_call');
	gpfd_test(count($list) === 1,__FILE__,__LINE__);
	gpfd_test('hc_hook_hook_hook' === $list[0]->name, __FILE__,__LINE__);
	gpfd_test(false===$GLOBALS['t_gpf_hook_obj_list_cache'],__FILE__,__LINE__);

	$list = gpf_hook($callback_list_path, 'h_hook_hook', 'test_call');
	gpfd_test(true===$GLOBALS['t_gpf_hook_obj_list_cache'],__FILE__,__LINE__);

	$hook = gpf_load(dirname(__FILE__) . '/0test/hook/h_hook.class', 'h_hook_hook');
	$hook->test_call();
	gpfd_test(true===$GLOBALS['t_hook_test_call'], __FILE__,__LINE__);
}//}}}
test_gpf_hook();
