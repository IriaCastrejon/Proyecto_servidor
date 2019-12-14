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
  'db_file' => 'resources/test.sqlite3',
  'img_path' => '/resources/images',
  'img_in_url' => '/images',
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
function startsWith ($string, $startString) {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}
