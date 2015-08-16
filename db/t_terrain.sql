CREATE TABLE IF NOT EXISTS t_terrain (
	id INT(11) NOT NULL AUTO_INCREMENT,
	numeroTitre VARCHAR(100) DEFAULT NULL,
	nom VARCHAR(50) DEFAULT NULL,
	superficie DECIMAL(12,2) DEFAULT NULL,
	emplacement VARCHAR(255) DEFAULT NULL,
	status VARCHAR(50) DEFAULT NULL,
	prix DECIMAL(12,2) DEFAULT NULL,
	idProjet INT(12) DEFAULT NULL,
	created DATE DEFAULT NULL,
	createdBy VARCHAR(50) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;