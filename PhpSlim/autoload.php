<?php
require_once dirname(__FILE__) . '/PhpSlim/AutoLoader.php';
if(file_exists(dirname(__FILE__) . '../vendor/autoload.php')) {
	require_once dirname(__FILE__) . '../vendor/autoload.php';
}
PhpSlim_AutoLoader::start();
