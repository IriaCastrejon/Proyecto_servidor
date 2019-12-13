
DROP TABLE IF EXISTS cliente;
DROP TABLE IF EXISTS anuncio;
DROP TABLE IF EXISTS factura;

DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS amigos;
DROP TABLE IF EXISTS publicacion;
DROP TABLE IF EXISTS actividad;
DROP TABLE IF EXISTS comentario;
DROP TABLE IF EXISTS participa;


CREATE TABLE cliente (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(45) NULL,
  pass VARCHAR(45) NULL,
  foto VARCHAR(255) NULL,
  localidad VARCHAR(45) NULL,
  cp INTEGER UNSIGNED NULL,
  cif VARCHAR(20) NULL,
  telefono INTEGER UNSIGNED NULL,
  PRIMARY KEY(id)
);
insert into cliente(id,email,pass,localidad,cp,cif,telefono) values (1,'cliente1@gmial.com','1234','madrid',28045,'cif-1',11111);
insert into cliente(id,email,pass,localidad,cp,cif,telefono) values (2,'cliente2@gmial.com','1234','madrid',28045,'cif-2',22222);

CREATE TABLE anuncio (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cliente_id INTEGER UNSIGNED NOT NULL,
  imagen VARCHAR(255) NULL,
  fecha_alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fecha_baja DATE NULL,
  url VARCHAR(255) NULL,
  PRIMARY KEY(id, cliente_id),
  INDEX anuncio_FKIndex1(cliente_id)
);

insert into anuncio(id,cliente_id,url) values (1,2,'www.anuncio_1');
insert into anuncio(id,cliente_id,url) values (2,2,'www.anuncio_2');
insert into anuncio(id,cliente_id,url) values (3,1,'www.anuncio_3');

CREATE TABLE factura (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cliente_id INTEGER UNSIGNED NOT NULL,
  importe INTEGER UNSIGNED NULL,
  iva INTEGER UNSIGNED NULL,
  PRIMARY KEY(id, cliente_id),
  INDEX factura_FKIndex1(cliente_id)
);
insert into factura(id,cliente_id,importe,iva) values (1,1,20,16);
insert into factura(id,cliente_id,importe,iva) values (1,2,40,16);

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
insert into usuario(id,email,pass,nombre) values(1,'bigotes@gmail.com','123','bigotes');
insert into usuario(id,email,pass,nombre) values(2,'zero@gmail.com','123','zero');
insert into usuario(id,email,pass,nombre) values(3,'coqui@gmail.com','123','coqui');

CREATE TABLE amigos (
  usuario_id INTEGER UNSIGNED NOT NULL,
  usuario_id2 INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(usuario_id, usuario_id2),
  INDEX usuario_has_usuario_FKIndex1(usuario_id),
  INDEX usuario_has_usuario_FKIndex2(usuario_id)
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
  INDEX publicacion_FKIndex1(usuario_id)
);

insert into publicacion(id,usuario_id,texto) values(1,1,'cansada');
insert into publicacion(id,usuario_id,texto) values(2,2,'paseando por madrid');
insert into publicacion(id,usuario_id,texto) values(3,3,'paseito');

CREATE TABLE actividad (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  descripcion VARCHAR(20) NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  n_participantes INTEGER UNSIGNED NULL,
  lugar VARCHAR(45) NULL,
  PRIMARY KEY(id)
);

insert into actividad(id,descripcion,n_participantes,lugar) values(1,'ida al parqie',5,'madrid rio');
insert into actividad(id,descripcion,n_participantes,lugar) values(2,'correr',3,'paseoDelicias');
insert into actividad(id,descripcion,n_participantes,lugar) values(3,'ida al parqie',1,'retiro');

CREATE TABLE comentario (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_id INTEGER UNSIGNED NOT NULL,
  publicacion_usuario_id INTEGER UNSIGNED NOT NULL,
  publicacion_id INTEGER UNSIGNED NOT NULL,
  actividad_id INTEGER UNSIGNED NOT NULL,
  texto VARCHAR(255) NULL,
  PRIMARY KEY(id, usuario_id, publicacion_usuario_id, publicacion_id, actividad_id),
  INDEX comentario_FKIndex1(usuario_id),
  INDEX comentario_FKIndex2(publicacion_id, publicacion_usuario_id),
  INDEX comentario_FKIndex3(actividad_id)
);



CREATE TABLE participa (
  usuario_id INTEGER UNSIGNED NOT NULL,
  actividad_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(usuario_id, actividad_id),
  INDEX usuario_has_actividad_FKIndex1(usuario_id),
  INDEX usuario_has_actividad_FKIndex2(actividad_id)
);

insert into participa(usuario_id,actividad_id) values(1,1);
insert into participa(usuario_id,actividad_id) values(1,2);
