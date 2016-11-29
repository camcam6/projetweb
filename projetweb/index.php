<?php
use core\Autoloader;

require 'core/Autoloader.php';

Autoloader::register();

$dispatcher = new \core\Dispatcher($_GET);
$dispatcher->dispatch();