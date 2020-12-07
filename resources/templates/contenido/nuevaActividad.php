<?php
if( !isset($_SESSION['id'])){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}


$id = $_SESSION['id'];
$nombre = '';
$descripcion= '';
$fecha = '';
$lugar = '';
$errores = [];

define("TAMAÑO_NOMBRE",15);
define("TAMAÑO_DESCRIPCION",45);
define("TAMAÑO_LUGAR",45);

define("ERROR_NOMBRE_MAYOR", 0);
define("ERROR_NOMBRE_NO", 1);

define("ERROR_DESCRIPCION_MAYOR", 0);
define("ERROR_DESCRIPCION_NO", 1);

define("ERROR_FECHA_MAYOR", 0);
define("ERROR_FECHA_NO", 1);

define("ERROR_LUGAR_MAYOR", 0);
define("ERROR_LUGAR_NO", 1);

  if (isset($_POST['enviar'])) {

    //NOMBRE
    if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
      $nombre=clean_input($_POST['nombre']);
      if(strlen($nombre)>TAMAÑO_NOMBRE){
        $errores['nombre']= ERROR_NOMBRE_MAYOR;
      }
    }else{
      $errores['nombre']= ERROR_NOMBRE_NO;
    }

    //DESCRIPCION
    if (isset($_POST['descripcion']) && $_POST['descripcion'] != '') {
      $descripcion=clean_input($_POST['descripcion']);
      if(strlen($descripcion)>TAMAÑO_DESCRIPCION){
        $errores['descripcion']= ERROR_DESCRIPCION_MAYOR;
      }
    }else{
      $errores['descripcion']= ERROR_DESCRIPCION_NO;
    }


    //FECHA
    if (isset($_POST['fecha']) && $_POST['fecha'] != '') {
      if (validarFecha($_POST['fecha'])) {
        $fecha=clean_input($_POST['fecha']);

      }else{
        $errores['fecha'] = ERROR_FECHA_MAYOR;
      }
    }else{
      $errores['fecha'] = ERROR_FECHA_NO;
    }


    //LUGAR
    if (isset($_POST['lugar']) && $_POST['lugar'] != '') {
      $lugar=clean_input($_POST['lugar']);
      if(strlen($lugar)>TAMAÑO_LUGAR){
        $errores['lugar']= ERROR_LUGAR_MAYOR;
      }
    }else{
      $errores['lugar']= ERROR_LUGAR_NO;
    }


  if(count($errores)==0){
    $db= DWESBaseDatos::obtenerInstancia();
    ActividadManager::insert($nombre,$descripcion,$fecha,$lugar);
    $id_actividad= $db->getLastId();
    ParticipaManager::insert($id,$id_actividad);
    header('Location: actividades.php');
    die();
  }


}
 ?>

<div class="fomulario_registro">

     <form class="formulario" action="nuevaActividad.php" method="post">
       <h2>Rellena los campos</h2>
       <?php if (isset($errores['nombre'])){
                if ($errores['nombre'] == ERROR_NOMBRE_MAYOR ){ ?>
                  <span class="error"> El nombre no puede ser mayor de 15 caracteres</span> <br>
                <?php }else if($errores['nombre'] == ERROR_NOMBRE_NO){ ?>
                  <span class="error"> Introduce un nombre</span> <br>
          <?php }
              } ?>
            <p>
              <label for=""> Nombre </label>
             <input name="nombre" value="<?=$nombre?>"><br><br>
            </p>

       <?php if (isset($errores['descripcion'])){
                if ($errores['descripcion'] == ERROR_DESCRIPCION_MAYOR ){ ?>
                  <span class="error"> La descripción no puede ser mayor de 45 caracteres</span> <br>
                <?php }else if($errores['descripcion'] == ERROR_DESCRIPCION_NO){ ?>
                  <span class="error">Debe introducir una descripción</span> <br>
                <?php }
              } ?>
              <p>
                <label for=""> Descripcion </label>
                <textarea name="descripcion" rows="6" cols="55"><?=$descripcion?></textarea>
              </p>



       <?php if (isset($errores['fecha'])){
                if ($errores['fecha'] == ERROR_FECHA_MAYOR ){ ?>
                  <span class="error"> Introduce una fecha mayor a la actual </span> <br>
                <?php }else if($errores['fecha'] == ERROR_FECHA_NO){ ?>
                  <span class="error"> Introduce una fecha</span> <br>
          <?php }
        } ?>
      <p>
        <label for=""> Fecha</label>
         <input type="date" name="fecha" value="<?=$fecha?>">
      </p>

       <?php if (isset($errores['lugar'])){
               if ($errores['lugar'] == ERROR_LUGAR_MAYOR ){ ?>
                 <span class="error"> El lugar no puede ser mayor de 45 caracteres</span> <br>
               <?php }else if($errores['lugar'] == ERROR_LUGAR_NO){ ?>
                 <span class="error">Debe introducir un lugar</span> <br>
               <?php }
            }?>
        <p>
          <label for=""> Lugar </label>
          <input type="text" name="lugar" value="<?=$lugar?>">
        </p>

<p>
  <label for=""></label>
  <input type="submit" name="enviar" class='enviar' value="Enviar">
</p>

    </form>
</div>
