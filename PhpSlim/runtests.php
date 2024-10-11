<?php
error_reporting(E_ALL | E_STRICT);
require_once dirname(__FILE__) . '/autoload.php';

$exit_code = 0;
passthru(__DIR__ . '/../vendor/bin/phpunit --configuration ../phpunit.xml ' . __DIR__ . '/PhpSlim/Tests', $exit_code);

// Check that we are still E_STRICT
if (error_reporting() !== (E_ALL | E_STRICT)) {
    echo "Warning: E_STRICT compliance was turned off during tests.\n";
    exit(1);
}

exit($exit_code);