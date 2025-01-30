#	USE $dbname;
#	DROP DATABASE IF EXISTS $dbname;
#	DELETE IGNORE FROM $dbname.$db_table_rdv;
#	TO_CHAR(CURRENT_DATE,'YYYY-MM-DD');
#	Exit;

#	-D $dbname
#	sudo rm -r /var/lib/mysql/$dbname/
#	sudo systemctl restart mariadb
#	https://www.mariadbtutorial.com/mariadb-basics/mariadb-data-types/
#	sudo mysql < crea.sql
#	clear && ./crea_sql.sh

PATH_CRED="/home/cred.txt"
dbname=$(sed -n 's/^dbname=\(.*\)/\1/p' < "${PATH_CRED}");
dbhost=$(sed -n 's/^dbhost=\(.*\)/\1/p' < "${PATH_CRED}");
dbpass=$(sed -n 's/^dbpass=\(.*\)/\1/p' < "${PATH_CRED}");
dbuser=$(sed -n 's/^dbuser=\(.*\)/\1/p' < "${PATH_CRED}");
db_table_rdv=$(sed -n 's/^db_table_rdv=\(.*\)/\1/p' < "${PATH_CRED}");
db_table_li=$(sed -n 's/^db_table_li=\(.*\)/\1/p' < "${PATH_CRED}");
db_table_2fa=$(sed -n 's/^db_table_2fa=\(.*\)/\1/p' < "${PATH_CRED}");
auth_email=$(sed -n 's/^auth_email=\(.*\)/\1/p' < "${PATH_CRED}");
auth_pwd=$(sed -n 's/^auth_pwd=\(.*\)/\1/p' < "${PATH_CRED}");
echo "auth_pwd=[${auth_pwd}]";

sudo mysql -e "\
	SHOW DATABASES;
	DROP TABLE IF EXISTS $dbname.$db_table_rdv;
	SHOW TABLES FROM $dbname;
	SELECT host,user FROM mysql.user;
	DELETE FROM mysql.user WHERE user = '$dbuser' AND host = '$dbhost';
	SELECT host,user FROM mysql.user;
	DROP TABLE IF EXISTS $dbname.$db_table_li;
	DROP TABLE IF EXISTS $dbname.$db_table_2fa;
	DROP USER IF EXISTS $dbuser@$dbhost;
	CREATE DATABASE IF NOT EXISTS $dbname;
	CREATE USER IF NOT EXISTS $dbuser@$dbhost IDENTIFIED BY '$dbpass';
	GRANT ALL ON $dbname.* TO $dbuser@$dbhost IDENTIFIED BY '$dbpass';
	FLUSH PRIVILEGES;
	CREATE TABLE IF NOT EXISTS $dbname.$db_table_rdv (
		\`id\` INT(11) NOT NULL AUTO_INCREMENT,
		\`DATE_CRENEAU\` DATE NOT NULL,
		\`HEURE_CRENEAU_DEBUT\` TIME NOT NULL,
		\`HEURE_CRENEAU_FIN\` TIME NOT NULL,
		\`CRENEAU_RESERVABLE\` TINYINT(1) NOT NULL,
		\`DATE_CRENEAU_RESERVE\` TIMESTAMP,
		\`STATUT\` VARCHAR(3),
		\`DENSOC\` VARCHAR(50),
		\`SIREN\` VARCHAR(9),
		\`HASH_ANNULATION_CLIENT\` VARCHAR(64) UNIQUE,
		\`HASH_ANNULATION_PERSO\` VARCHAR(64) UNIQUE,
		\`EVT_DEMANDE_CONFIRMATION\` TINYINT(1),
		\`HASH_CONFIRMATION\` VARCHAR(64) UNIQUE,
		\`EVT_CONFIRMATION\` TINYINT(1),
		\`CONFIRMATION\` TINYINT(1),
		\`EXPIRE_HASH\` TIMESTAMP,
		\`EVT_ANNULATION_PERSO\` TINYINT(1),
		\`EVT_ANNULATION_CLIENT\` TINYINT(1),
		\`CIVILITE\` VARCHAR(3),
		\`NOM\` VARCHAR(100) CHARACTER SET utf8,
		\`PRENOM\` VARCHAR(100) CHARACTER SET utf8,
		\`NUMERO_TELEPHONE\` VARCHAR(10),
		\`EMAIL\` VARCHAR(300) CHARACTER SET utf8,
		\`ADRESSE\` VARCHAR(100),
		\`CODE_POSTAL\` VARCHAR(5),
		\`VILLE\` VARCHAR(50),
		\`SERVICE\` VARCHAR(50),
		\`LIEUX_SERVICE\` VARCHAR(50),
		\`COMMENTAIRE\` VARCHAR(250),
		\`ACCEPTATION_CGV\` TINYINT(1),
		\`CONSENTEMENT_RGPD\` TINYINT(1),
		PRIMARY KEY  (\`id\`)
	);
	CREATE TABLE IF NOT EXISTS $dbname.$db_table_li (
		\`EMAIL\` VARCHAR(300) CHARACTER SET utf8,
		\`HASH_CONF\` VARCHAR(64) UNIQUE DEFAULT NULL,
		\`EXPIRE_HASH\` TIMESTAMP NOT NULL,
		\`TO_SENT\` TINYINT(1),
		\`INSCRIPTION\` TINYINT(1),
		\`INSCRIPTION_VALIDE\` TINYINT(1) DEFAULT 0,
		PRIMARY KEY  (\`EMAIL\`)
	);
	CREATE TABLE IF NOT EXISTS $dbname.$db_table_2fa (
		\`EMAIL\` VARCHAR(100),
		\`HASH_PWD\` VARCHAR(64),
		\`HASH_LOGIN\` VARCHAR(64),
		\`LAST_UPDATED_LOGIN\` TIMESTAMP NOT NULL,
		\`TO_SENT\` TINYINT(1),
		PRIMARY KEY  (\`EMAIL\`)
	);
	INSERT INTO $dbname.$db_table_2fa (
		EMAIL,
		HASH_PWD,
		HASH_LOGIN,
		LAST_UPDATED_LOGIN,
		TO_SENT
	) VALUES (
		'$auth_email',
		SHA2('$auth_pwd',256),
		NULL,
		CURRENT_TIMESTAMP,
		0
	);
	SELECT * FROM $dbname.$db_table_2fa;
	SHOW DATABASES;
	SHOW TABLES FROM $dbname;
	SHOW COLUMNS FROM $dbname.$db_table_rdv;
	SHOW COLUMNS FROM $dbname.$db_table_li;
	SHOW COLUMNS FROM $dbname.$db_table_2fa;
	GRANT FILE ON *.* TO $dbuser@$dbhost;
	FLUSH PRIVILEGES;
";
