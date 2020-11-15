<?php

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}
if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id = $_SESSION['id'];
$cordenadas = CoordenadasManager::getByUsuarioID($id)[0];
$lat=$cordenadas->getLatitud();
$long=$cordenadas->getLongitud();
echo '<pre>';
print_r($cordenadas);
echo '</pre>';
echo $lat;
echo '</br>';
echo $long;
echo '</br>';
$result= CoordenadasManager::getCercanos($lat, $long);
echo 'rsultad<pre>';
print_r($result);
echo '</pre>';
/*SELECT (acos(sin(radians(36.720139)) * sin(radians(40.425797)) +
cos(radians(36.720139)) * cos(radians(40.425797)) *
cos(radians(-4.419422) - radians(-3.690462))) * 6378) as
distanciaMalagaMadrid;

SELECT (acos(sin(radians(LATITUD_1)) * sin(radians(LATITUD_2)) +
cos(radians(LATITUD_1)) * cos(radians(LATITUD_2)) *
cos(radians(LONGITUD_1) - radians(LONGITUD_2))) * 6378) as
distanciaPunto1Punto2;*/
/*
$lat0 = 45.50;
$lng0 = 15.47;
$lat1 = 35.15;
$lng1 = 16.12;

// se pasan a radiantes
$rlat0 = deg2rad($lat0);
$rlng0 = deg2rad($lng0);
$rlat1 = deg2rad($lat1);
$rlng1 = deg2rad($lng1);

// diferencias entre estos valores
$latDelta = $rlat1 - $rlat0;
$lonDelta = $rlng1 - $rlng0;

// ley esferica de los cosenos
//6371 raadio de la tierra en kilometros
$distance = (6371 *
    acos(
        cos($rlat0) * cos($rlat1) * cos($lonDelta) +
        sin($rlat0) * sin($rlat1)
    )
);

echo 'distanct arcosine ' . $distance;*/
 ?>

 <div class="contenedor_amigos">
   <h1> Busca amigos que esten cerca de ti</h1>
   <form class="" action="cercaDeMi.php" method="post">
     <label for="">Distacia en kilometros</label>
     <select class="distancias" name="distancias">
       <option value="1">1Km</option>
       <option value="2">2Km</option>
       <option value="5">5Km</option>
       <option value="10">10Km</option>
       <option value="20">20Km</option>
       <option value="50">50Km</option>
     </select>
     <input type="submit" name="Enviar" value="Buscar">
   </form>

 </div>
