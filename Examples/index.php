<?php
require_once(dirname(__FILE__) . '/../Temple.php');
use function Temple\stringify;

require_once(dirname(__FILE__) . '/TodoApp.php');
use function Temple\Examples\TodoApp\State;
use function Temple\Examples\TodoApp\TodoApp;

$state = State();
$todoApp = TodoApp($state);

echo '<!DOCTYPE html>';
echo '<meta charset="utf-8" />';
echo '<title>TodoApp</title>';
echo stringify($todoApp);
echo '<script>window.__INITIAL_STATE__ = ' . json_encode($state) . '</script>';
echo "\n";
