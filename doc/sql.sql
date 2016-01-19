CREATE DATABASE IF NOT EXISTS time;

USE time;

CREATE TABLE IF NOT EXISTS tecnico (
  codigo_tecnico INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(30) NULL,
  data_nascimento CHAR(10) NULL,
  PRIMARY KEY(codigo_tecnico)
);

CREATE TABLE IF NOT EXISTS torcedor (
  codigo_torcedor INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(35) NULL,
  login VARCHAR(20) NULL,
  senha CHAR(128) NULL,
  token VARCHAR(64) NOT NULL,
  PRIMARY KEY(codigo_torcedor)
);

CREATE TABLE IF NOT EXISTS categoria (
  codigo_categoria INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(30) NULL,
  PRIMARY KEY(codigo_categoria)
);

CREATE TABLE IF NOT EXISTS divisao (
  codigo_divisao INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(25) NULL,
  PRIMARY KEY(codigo_divisao)
);

CREATE TABLE IF NOT EXISTS time (
  codigo_time INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  categoria_codigo_categoria INTEGER UNSIGNED NOT NULL,
  divisao_codigo_divisao INTEGER UNSIGNED NOT NULL,
  tecnico_codigo_tecnico INTEGER UNSIGNED NOT NULL,
  desempenho_time  CHAR(5),
  comprar_novo_jogador  CHAR(3),
  nome VARCHAR(35) NULL,
  capa VARCHAR(100) NULL,
  PRIMARY KEY(codigo_time),
  INDEX jogo_FKIndex1(tecnico_codigo_tecnico),
  INDEX jogo_FKIndex2(divisao_codigo_divisao),
  INDEX time_FKIndex3(categoria_codigo_categoria),
  FOREIGN KEY(tecnico_codigo_tecnico)
    REFERENCES tecnico(codigo_tecnico)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(divisao_codigo_divisao)
    REFERENCES divisao(codigo_divisao)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(categoria_codigo_categoria)
    REFERENCES categoria(codigo_categoria)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);
