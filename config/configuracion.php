<?php

$config = [
  'site' => 'hipets',
  'title' => 'hipets',
  'content' => 'hipets',
  'content_text' => 'Información sacada del config',
  'db_engine' => 'mysql',
  'db_file' => 'resources/db_hipets.sql'
];

spl_autoload_register(function ($name){
  global $ROOT;
  $class_file = "$ROOT/src/$name.php";
  require($class_file);
});
