CREATE TABLE IF NOT EXISTS t_caisse (
	id INT(11) NOT NULL AUTO_INCREMENT,
	nom VARCHAR(255) DEFAULT NULL,
	dateCreation DATE DEFAULT NULL,
	created DATE DEFAULT NULL,
	createdBy VARCHAR(50) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;