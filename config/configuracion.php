<?php

$config = [
  'site' => 'hipets',
  'title' => 'hipets',
  'content' => 'estructura  del proyecto web',
  'content_text' => 'Información sacada del config',
  'proyecto'=>'hipets',
  'user'=>'admin',
  'pass'=>'1234',
  'db_engine' => 'sqlite',
  'db_file' => 'resources/test.sqlite3'
];

spl_autoload_register(function ($name){
  global $ROOT;
  $class_file = "$ROOT/src/$name.php";
  require($class_file);
});

function clean_input($data){
  $data=trim($data);
  $data=stripslashes($data);
  $data=htmlspecialchars($data);
  return $data;
}
