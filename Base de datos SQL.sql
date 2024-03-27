CREATE DATABASE hotel_keto;
USE hotel_keto;

CREATE TABLE clientes (
    id_cliente INT(40) PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    numero_personas INT,
    fecha_entrada DATE,
    fecha_salida DATE,
    tipo_habitacion VARCHAR(50),
    costo_total DECIMAL(10, 2)
);


CREATE TABLE restaurante (
    id INT(40) PRIMARY KEY AUTO_INCREMENT,
    nombre_cliente VARCHAR(30),
    numeroId INT(30),
    fecha DATE,
    platillos VARCHAR(255),
    costo_total INT(10)
);

CREATE TABLE empleados (
    id INT(40) PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    puesto VARCHAR(50),
    direccion VARCHAR(255),
    telefono VARCHAR(20)
);

CREATE TABLE administracion(
    id INT(40) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100),
    password VARCHAR(255)
);

INSERT INTO administracion(username, password) VALUES
	('administrador1','$2y$10$yLSUUWMWuxStvTveaxcx0elns909fDS5.ESfDjbbdIQZCcGuoV.7a'),
	('administrador2','$2y$10$fO3zuVM05Ae0LTdTnIGlvOo9a2nNwBFAZ.aSaiC7YRluhLFEc862O');

INSERT INTO EMPLEADOS(nombre, puesto, direccion, telefono) VALUES
	('Ana García', 'Gerente de Ventas', 'Calle Principal 123', '6144565652'),
	('Juan Martínez', 'Cocina', 'Avenida Central 456', '6147679836'),
	('María López', 'Recepcionista', 'Plaza Principal 789', '6149805345'),
	('Carlos Rodríguez', 'Cocina', 'Calle Secundaria 321', '6146673331');

