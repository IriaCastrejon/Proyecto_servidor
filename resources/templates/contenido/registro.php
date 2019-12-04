<?php

 ?>

 <form class="formRegistro" action="registro.php" method="post">
   <table>
     <tr>
       <td>Nombre </td>
       <td><input type="text" name="nombre" value=""> </td>
     </tr>
     <tr>
       <td>Email </td>
       <td><input type="text" name="email" value=""> </td>
     </tr>
     <tr>
       <td>Contraseña </td>
       <td><input type="text" name="pss" value=""> </td>
     </tr>
     <tr>
       <td> Repite contraseña</td>
       <td><input type="text" name="passVer" value=""> </td>
     </tr>
     <tr>
       <td>Localidad </td>
       <td><input type="text" name="localidad" value=""> </td>
     </tr>
     <tr>
       <td>Codigo Postal </td>
       <td><input type="text" name="cp" value=""> </td>
     </tr>
     <tr>
       <td>Telefono </td>
       <td><input type="text" name="telefono" value=""> </td>
     </tr>
     <tr>
       <td>Foto </td>
       <td><input type="image" name="foto" value=""> </td>
     </tr>
   </table>
   <div class="cliente">
     <div>
       <p>Soy mascota</p>
       <input type="radio" name="usuario" value="mascota"><br><br>
     </div>
     <div>
       <p>Soy Empresa</p>
       <input type="radio" name="usuario" value="empresa"><br><br>
       <label for="">Denominacion social</label> <input type="radio" name="denominacion" value="">
       <label for=""> CIF</label><input type="text" name="cif" value="">
     </div>
   </div>

 </form>
