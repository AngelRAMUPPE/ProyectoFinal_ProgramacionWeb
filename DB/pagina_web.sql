-- Creacion de la BD
CREATE DATABASE pagina_web;
use pagina_web;

CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    correo VARCHAR(100),
    contrasena VARCHAR(100),
    codigo_medidor VARCHAR(20)
);


CREATE TABLE registros_humedad (
    id_registro INT PRIMARY KEY AUTO_INCREMENT,
    fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    valor_leido INT,
    codigo_medidor VARCHAR(20),
);

CREATE TABLE reg_valores (
  fecha_elim timestamp NOT NULL,
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  Valor_elim int NOT NULL,
  codigo_medidor varchar(100) NOT NULL
);

-- Funcion para la verificacion de usuario
CREATE FUNCTION verify_user( p_email VARCHAR(100), p_password VARCHAR(100) ) 
RETURNS INT DETERMINISTIC 
BEGIN 
DECLARE v_id INT; 
SELECT id_usuario INTO v_id FROM usuarios WHERE correo = p_email AND contrasena = p_password; 
RETURN v_id; 
END;

-- Creacion de triggers 
CREATE TRIGGER `Elim_valor` AFTER DELETE ON `registros_humedad`
 FOR EACH ROW INSERT INTO reg_valores
(fecha_elim,Valor_elim,codigo_medidor) 
VALUES (NOW(),OLD.valor_leido,OLD.codigo_medidor)