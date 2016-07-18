<?php
require_once(dirname(__FILE__) . '/../Temple.php');
require_once(dirname(__FILE__) . '/TodoApp.php');
use Temple\Temple;
use Temple\Examples\TodoApp\TodoApp;

$state = TodoApp::State();
$todoApp = TodoApp::TodoApp($state);

echo '<!DOCTYPE html>';
echo '<meta charset="utf-8" />';
echo '<title>TodoApp</title>';
echo '<script>window.__INITIAL_STATE__ = ' . json_encode($state) . '</script>';
echo '<div id="app">';
echo Temple::stringify($todoApp);
echo '</div>';
echo '<script src="index.js"></script>';
echo "\n";
