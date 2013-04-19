<?php
$_dir = dirname(__FILE__) . '/';
define('GPF_DEBUG', true);
define('GPF_DEBUG_OUTPUT', "{$_dir}runtime/debug_output/");
define('GPF_DEBUG_PHP', "{$_dir}runtime/debug_php/");
define('GPF_DEBUG_JS_SCRIPT', 1);
define('GPF_DEBUG_JS_PHP', 1);
require "{$_dir}/gpf.inc.php";
if (!is_dir(GPF_DEBUG_OUTPUT))
	{
	mkdir(GPF_DEBUG_OUTPUT);
	mkdir(GPF_DEBUG_PHP);
	}

gpf_inc(dirname(__FILE__) . '/debug.test.php');
