CREATE TABLE IF NOT EXISTS t_paiementEmploye (
	id INT(11) NOT NULL AUTO_INCREMENT,
	dateOperation DATE DEFAULT NULL,
	montant DECIMAL(12,2) DEFAULT NULL,
	numeroCheque VARCHAR(50) DEFAULT NULL,
	idProjet INT(12) DEFAULT NULL,
	idEmploye INT(12) DEFAULT NULL,
	created DATE DEFAULT NULL,
	createdBy VARCHAR(50) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;