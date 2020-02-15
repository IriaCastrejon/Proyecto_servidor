DROP TABLE IF EXISTS cliente;
DROP TABLE IF EXISTS anuncio;
DROP TABLE IF EXISTS factura;

DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS amigos;
DROP TABLE IF EXISTS publicacion;
DROP TABLE IF EXISTS actividad;
DROP TABLE IF EXISTS comentario_actividad;
DROP TABLE IF EXISTS comentario_publicacion;
DROP TABLE IF EXISTS participa;
DROP TABLE IF EXISTS megusta;


CREATE TABLE cliente (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(45) NOT NULL,
  email VARCHAR(45) NOT NULL,
  pass VARCHAR(100) NOT NULL,
  foto VARCHAR(255) NULL,
  localidad VARCHAR(45) NULL,
  cp INTEGER UNSIGNED NULL,
  cif VARCHAR(20) NOT NULL,
  telefono INTEGER UNSIGNED NULL,
  PRIMARY KEY(id)
);
insert into cliente(id,nombre,email,pass,foto,localidad,cp,cif,telefono)
  values (1,'empresa1','cliente1@gmial.com','$2y$10$2JnNTcrWG.9S8Wp/xYgVeOxXMBY/MNx5eqNWqDrbezFS.VmAobXRS','empresa.png','madrid',28045,'cif-1',11111);
insert into cliente(id,nombre,email,pass,foto,localidad,cp,cif,telefono)
  values (2,'empresa2','cliente2@gmial.com','$2y$10$2JnNTcrWG.9S8Wp/xYgVeOxXMBY/MNx5eqNWqDrbezFS.VmAobXRS','empresa2.png','madrid',28045,'cif-2',22222);

CREATE TABLE anuncio (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cliente_id INTEGER UNSIGNED NOT NULL,
  imagen VARCHAR(255) NULL,
  fecha_alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fecha_baja DATE NULL,
  url VARCHAR(255) NULL,
  PRIMARY KEY(id, cliente_id),
  FOREIGN KEY (cliente_id) REFERENCES cliente(id) ON DELETE CASCADE ON UPDATE CASCADE
);

insert into anuncio(id,cliente_id,imagen,url) values (1,2,'empresa.png','www.anuncio_1');
insert into anuncio(id,cliente_id,imagen,url) values (2,2,'empresa2.png','www.anuncio_2');
insert into anuncio(id,cliente_id,imagen,url) values (3,1,'juego_bola.png','www.anuncio_3');

CREATE TABLE factura (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cliente_id INTEGER UNSIGNED NOT NULL,
  importe INTEGER UNSIGNED NULL,
  iva INTEGER UNSIGNED NULL,
  PRIMARY KEY(id, cliente_id),
  FOREIGN KEY (cliente_id) REFERENCES cliente(id) ON DELETE CASCADE ON UPDATE CASCADE
);
insert into factura(id,cliente_id,importe,iva) values (1,1,20,21);
insert into factura(id,cliente_id,importe,iva) values (1,2,40,21);

CREATE TABLE usuario (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(45) NOT NULL,
  pass VARCHAR(100) NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  foto_perfil VARCHAR(255) NULL,
  localidad VARCHAR(45) NULL,
  cp INTEGER NULL,
  telefono INTEGER NULL,
  descripcion VARCHAR(255) NULL,
  nombre_dueno VARCHAR(45) NULL,
  PRIMARY KEY(id)
);
insert into usuario(id,email,pass,nombre,foto_perfil,localidad,cp,telefono,descripcion,nombre_dueno)
  values(1,'bigotes@gmail.com','$2y$10$2JnNTcrWG.9S8Wp/xYgVeOxXMBY/MNx5eqNWqDrbezFS.VmAobXRS','bigotes','01_DescargaWP.png','Madrid','28026','666958459','Hola','Petunio');
insert into usuario(id,email,pass,nombre,foto_perfil,localidad,cp,telefono,descripcion,nombre_dueno)
  values(2,'zero@gmail.com','$2y$10$2JnNTcrWG.9S8Wp/xYgVeOxXMBY/MNx5eqNWqDrbezFS.VmAobXRS','zero','2.png','Madrid','28026','666958459','Hola','Patricio');
insert into usuario(id,email,pass,nombre,foto_perfil,localidad,cp,telefono,descripcion,nombre_dueno)
  values(3,'coqui@gmail.com','$2y$10$2JnNTcrWG.9S8Wp/xYgVeOxXMBY/MNx5eqNWqDrbezFS.VmAobXRS','coqui','gatito.png','Madrid','28026','666958459','Hola','Paty');

CREATE TABLE amigos (
  usuario_id INTEGER UNSIGNED NOT NULL,
  usuario_id2 INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(usuario_id, usuario_id2),
  FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (usuario_id2) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE
);
insert into amigos(usuario_id,usuario_id2) values(1,2);
insert into amigos(usuario_id,usuario_id2) values(1,3);
insert into amigos(usuario_id,usuario_id2) values(2,1);
insert into amigos(usuario_id,usuario_id2) values(3,1);
insert into amigos(usuario_id,usuario_id2) values(2,3);
insert into amigos(usuario_id,usuario_id2) values(3,2);

CREATE TABLE publicacion (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_id INTEGER UNSIGNED NOT NULL,
  imagen VARCHAR(255) NULL,
  texto VARCHAR(255) NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id, usuario_id),
  FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE
);

insert into publicacion(id,usuario_id,imagen,texto,fecha) values(1,1,'2.png','cansada',"2020-02-15");
insert into publicacion(id,usuario_id,imagen,texto,fecha) values(4,2,'2.png','cansada',"2020-02-15");
insert into publicacion(id,usuario_id,imagen,texto,fecha) values(2,2,'jugando_cat.png','paseando por madrid',"2020-02-15");
insert into publicacion(id,usuario_id,imagen,texto,fecha) values(3,3,'rick_and_morty.png','paseito',"2020-02-15");

CREATE TABLE actividad (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(15) NOT NULL,
  descripcion VARCHAR(45) NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  lugar VARCHAR(45) NULL,
  PRIMARY KEY(id)
);
insert into actividad(id,nombre,descripcion,fecha,lugar) values(1,"Salir a pasear","sjgfasgfhdgfhjgfsj","2020-02-15",'madrid');
insert into actividad(id,nombre,descripcion,fecha,lugar) values(2,"Actividad2","descripcion2222","2020-02-15",'madrid');
insert into actividad(id,nombre,descripcion,fecha,lugar) values(3,"Actividad3","descripcion3333","2020-02-14",'alicante');
insert into actividad(id,nombre,descripcion,fecha,lugar) values(4,"Actividad4","descripcion4444","2020-01-15",'zaragoza');

CREATE TABLE comentario_actividad (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_id INTEGER UNSIGNED NOT NULL,
  publicacion_id INTEGER UNSIGNED NOT NULL,
  texto VARCHAR(255) NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (publicacion_id) REFERENCES publicacion(id) ON DELETE CASCADE ON UPDATE CASCADE
);

insert into comentario_actividad(id,usuario_id,publicacion_id,texto) values(1,1,1,'Comentario1');
insert into comentario_actividad(id,usuario_id,publicacion_id,texto) values(2,2,1,'Comentario2');
insert into comentario_actividad(id,usuario_id,publicacion_id,texto) values(3,1,2,'Comentario3');
insert into comentario_actividad(id,usuario_id,publicacion_id,texto) values(4,3,3,'Comentario4');
insert into comentario_actividad(id,usuario_id,publicacion_id,texto) values(5,1,3,'Comentario5');




CREATE TABLE comentario_publicacion(
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_id INTEGER UNSIGNED NOT NULL,
  actividad_id INTEGER UNSIGNED NOT NULL,
  texto VARCHAR(255) NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (actividad_id) REFERENCES actividad (id) ON DELETE CASCADE ON UPDATE CASCADE
);

insert into comentario_publicacion(id,usuario_id,actividad_id,texto) values(1,1,1,'Comentario1');
insert into comentario_publicacion(id,usuario_id,actividad_id,texto) values(2,2,1,'Comentario2');
insert into comentario_publicacion(id,usuario_id,actividad_id,texto) values(3,1,2,'Comentario3');
insert into comentario_publicacion(id,usuario_id,actividad_id,texto) values(4,3,3,'Comentario4');
insert into comentario_publicacion(id,usuario_id,actividad_id,texto) values(5,1,3,'Comentario5');


CREATE TABLE megusta (
  usuario_id INTEGER UNSIGNED NOT NULL,
  publicacion_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(usuario_id, publicacion_id),
  FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (publicacion_id) REFERENCES publicacion (id) ON DELETE CASCADE ON UPDATE CASCADE
);

insert into megusta(usuario_id,publicacion_id) values(1,1);
insert into megusta(usuario_id,publicacion_id) values(1,2);
insert into megusta(usuario_id,publicacion_id) values(1,3);
insert into megusta(usuario_id,publicacion_id) values(2,1);
insert into megusta(usuario_id,publicacion_id) values(2,2);
insert into megusta(usuario_id,publicacion_id) values(2,3);

CREATE TABLE participa (
  usuario_id INTEGER UNSIGNED NOT NULL,
  actividad_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(usuario_id, actividad_id),
  FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (actividad_id) REFERENCES actividad (id) ON DELETE CASCADE ON UPDATE CASCADE
);

insert into participa(usuario_id,actividad_id) values(1,1);
insert into participa(usuario_id,actividad_id) values(1,2);
