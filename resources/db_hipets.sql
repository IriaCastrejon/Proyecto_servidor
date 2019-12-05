DROP TABLE IF EXISTS actividad;
DROP TABLE IF EXISTS amigos;
DROP TABLE IF EXISTS anuncio;
DROP TABLE IF EXISTS cliente;
DROP TABLE IF EXISTS comentario;
DROP TABLE IF EXISTS factura;
DROP TABLE IF EXISTS participa;
DROP TABLE IF EXISTS publicacion;
DROP TABLE IF EXISTS usuario;

CREATE TABLE actividad (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  descripcion VARCHAR(20) NULL,
  fecha DATE NULL,
  n_participantes INTEGER UNSIGNED NULL,
  lugar VARCHAR(45) NULL,
  PRIMARY KEY(id)
);

CREATE TABLE amigos (
  usuario_id INTEGER UNSIGNED NOT NULL,
  usuario_id2 INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(usuario_id, usuario_id2),
  INDEX usuario_has_usuario_FKIndex1(usuario_id),
  INDEX usuario_has_usuario_FKIndex2(usuario_id)
);

CREATE TABLE anuncio (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cliente_id INTEGER UNSIGNED NOT NULL,
  imagen BLOB NULL,
  fecha_alta DATE NULL,
  fecha_baja DATE NULL,
  url VARCHAR(255) NULL,
  PRIMARY KEY(id, cliente_id),
  INDEX anuncio_FKIndex1(cliente_id)
);

CREATE TABLE cliente (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(45) NULL,
  pass VARCHAR(45) NULL,
  foto BLOB NULL,
  localidad VARCHAR(45) NULL,
  cp INTEGER UNSIGNED NULL,
  cif VARCHAR(20) NULL,
  telefono INTEGER UNSIGNED NULL,
  PRIMARY KEY(id)
);

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

CREATE TABLE factura (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cliente_id INTEGER UNSIGNED NOT NULL,
  importe INTEGER UNSIGNED NULL,
  iva INTEGER UNSIGNED NULL,
  PRIMARY KEY(id, cliente_id),
  INDEX factura_FKIndex1(cliente_id)
);

CREATE TABLE participa (
  usuario_id INTEGER UNSIGNED NOT NULL,
  actividad_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(usuario_id, actividad_id),
  INDEX usuario_has_actividad_FKIndex1(usuario_id),
  INDEX usuario_has_actividad_FKIndex2(actividad_id)
);

CREATE TABLE publicacion (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_id INTEGER UNSIGNED NOT NULL,
  imagen BLOB NULL,
  texto VARCHAR(255) NULL,
  fecha DATE NULL,
  PRIMARY KEY(id, usuario_id),
  INDEX publicacion_FKIndex1(usuario_id)
);

CREATE TABLE usuario (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(45) NULL,
  pass VARCHAR(45) NULL,
  nombre VARCHAR(45) NULL,
  foto_perfil BLOB NULL,
  localidad VARCHAR(45) NULL,
  cp INTEGER NULL,
  telefono INTEGER NULL,
  descripcion VARCHAR(255) NULL,
  nombre_dueno VARCHAR(45) NULL,
  PRIMARY KEY(id)
);


