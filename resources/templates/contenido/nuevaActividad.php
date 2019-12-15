<?php
session_start();

if( !isset($_SESSION['id'])){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id = $_SESSION['id'];
$descripcion= '';
$fecha = '';
$lugar = '';
$errores = [];


define("ERROR_FECHA_MAYOR", 0);
define("ERROR_FECHA_NO", 1);


  if (isset($_POST['enviar'])) {


    //DESCRIPCION
    if (isset($_POST['descripcion']) && $_POST['descripcion'] != '') {
      $descripcion=clean_input($_POST['descripcion']);
    }else{
      $errores['descripcion']= true;
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
    }else{
      $errores['lugar'] = 1;
    }



  if(count($errores)==0){
    $db= DWESBaseDatos::obtenerInstancia();
    ActividadManager::insert($descripcion,$fecha,$lugar);
    $id_actividad= $db->getLastId();
    ParticipaManager::insert($id,$id_actividad);
    header('Location: actividades.php');
    die();
  }



}
 ?>



     <form class="registro" action="nuevaActividad.php" method="post">
       <!-- Duracion-->
       <?php if (isset($errores['descripcion'])){ ?>
         <span class="error">Debe introducir una descripcion</span> <br>
       <?php } ?>
       <label for=""> Descripcion </label> <textarea name="descripcion" rows="8" cols="80"><?=$descripcion?></textarea><br><br>


       <?php if (isset($errores['fecha'])){
                if ($errores['fecha'] == ERROR_FECHA_MAYOR ){ ?>
                  <span class="error"> Introduce una fecha mayor a la actual </span> <br>
                <?php }else if($errores['fecha'] == ERROR_FECHA_NO){ ?>
                  <span class="error"> Introduce una fecha</span> <br>
          <?php }
              } ?>
       <label for=""> Fecha</label><input type="date" name="fecha" value="<?=$fecha?>"><br><br>


     <?php if (isset($errores['lugar'])){ ?>
         <span class="error">Debe introducir un lugar</span> <br>
       <?php } ?>
       <label for=""> Lugar </label><input type="text" name="lugar" value=" <?=$lugar?>"><br><br>

       <input type="submit" name="enviar" value="Enviar">
    </form>
