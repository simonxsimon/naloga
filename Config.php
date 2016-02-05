<?php

session_start();

$db = new PDO('mysql:host=localhost;dbname=Blog;charset=utf8', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


date_default_timezone_set('Europe/London');


function __autoload($class){
 $class = strtolower($class);

   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }     

   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }

    $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }         
}

$user = new User($db);
?>