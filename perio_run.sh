#/!\ Don't forget to run :
#	chmod +x perio_run.sh

#    setterm -linewrap off	

path_script="/home/cred.txt";
dbname=$(sed -n 's/^dbname=\(.*\)/\1/p' < "${path_script}");

if [ "$1" = "backup_3h" ]; then
	echo $(date +%Y/%m/%d-%H:%M:%S) : $1;
	#https://mariadb.com/kb/en/full-backup-and-restore-with-mariabackup/
		#mariabackup --backup --target-dir=/var/mariadb/backup/ --user=rolodex --password=password
		#ls /var/mariadb/backup/
		
		#SHUTDOWN WAIT FOR ALL REPLICAS;
		#mariabackup --prepare --target-dir=/var/mariadb/backup/
		#mariabackup --copy-back --target-dir=/var/mariadb/backup/
		#chown -R mysql:mysql /var/lib/mysql/
		
		#systemctl start mariadb
		#systemctl stop mariadb
	#https://mariadb.com/kb/en/making-backups-with-mariadb-dump/
	#https://mariadb.com/kb/en/mariadb-dump/
	##https://mariadb.com/kb/en/restoring-data-from-dump-files/
		sudo mariadb-dump --lock-tables --databases ${dbname} wp_db > /home/${dbname}_and_wordpress_backup.sql
		#wp db export yourwpdatabase.sql
		#mariadb --user admin_restore --password < /home/<...>/test.sql
fi
if [ "$1" = "reminder" ]; then
	#echo $(date +%Y/%m/%d-%H:%M:%S) : $1;
	sudo rm -f /var/lib/mysql/${dbname}/$1.csv;
	sudo mysql -D ${dbname} -e "\
		SELECT \
			DATE_CRENEAU,HEURE_CRENEAU_DEBUT,HEURE_CRENEAU_FIN,DATE_CRENEAU_RESERVE,HASH_ANNULATION_CLIENT, \
			CIVILITE,NOM,PRENOM,EMAIL,ADRESSE,CODE_POSTAL,VILLE,SERVICE,LIEUX_SERVICE \
			INTO OUTFILE \"$1.csv\" FIELDS TERMINATED BY \",\" ENCLOSED BY \"\\\"\" LINES TERMINATED BY \"\\n\" \
			FROM rendez_vous \
			WHERE \
				DATE(date_creneau_reserve) IS NOT NULL \
				AND ADDDATE(CURRENT_DATE, INTERVAL 1 DAY) = DATE_CRENEAU; \
	";
	if [ -f /var/lib/mysql/${dbname}/$1.csv ]; then
		sudo cat /var/lib/mysql/${dbname}/$1.csv;
	fi
	sudo gawk -f /home/sql_response.awk -v traitement=$1 /var/lib/mysql/${dbname}/$1.csv;
fi
if [ "$1" = "2fa_5m" ]; then
	sudo rm -f /var/lib/mysql/${dbname}/$1.csv;
	sudo mysql -D ${dbname} -e "\
		SELECT \
			EMAIL,HASH_LOGIN,ADDDATE(LAST_UPDATED_LOGIN,INTERVAL 30 MINUTE) \
			INTO OUTFILE \"$1.csv\" FIELDS TERMINATED BY \",\" ENCLOSED BY \"\\\"\" LINES TERMINATED BY \"\\n\" \
			FROM 2fa \
			WHERE \
				TO_SENT = 1 \
				AND HASH_LOGIN IS NOT NULL \
				AND CURRENT_TIMESTAMP < ADDDATE(LAST_UPDATED_LOGIN, INTERVAL 30 MINUTE); \
	";
	if [ -f /var/lib/mysql/${dbname}/$1.csv ]; then
		sudo cat /var/lib/mysql/${dbname}/$1.csv;
	fi
	sudo gawk -f /home/sql_response.awk -v traitement=$1 /var/lib/mysql/${dbname}/$1.csv;
	sudo mysql -D ${dbname} -e "\
		UPDATE 2fa \
			SET TO_SENT = 0 \
			WHERE \
				TO_SENT = 1; \
		UPDATE 2fa \
			SET HASH_LOGIN = NULL \
			WHERE \
				HASH_LOGIN IS NOT NULL \
				AND CURRENT_TIMESTAMP > ADDDATE(LAST_UPDATED_LOGIN, INTERVAL 30 MINUTE); \
	";
fi
if [ "$1" = "lettre_info_5m" ]; then
	sudo rm -f /var/lib/mysql/${dbname}/$1.csv;
	sudo mysql -D ${dbname} -e "\
		SELECT \
			EMAIL,HASH_CONF,ADDDATE(EXPIRE_HASH,INTERVAL 30 MINUTE) \
			INTO OUTFILE \"$1.csv\" FIELDS TERMINATED BY \",\" ENCLOSED BY \"\\\"\" LINES TERMINATED BY \"\\n\" \
			FROM lettre_information \
			WHERE \
				TO_SENT = 1 \
				AND HASH_CONF IS NOT NULL \
				AND CURRENT_TIMESTAMP < ADDDATE(EXPIRE_HASH, INTERVAL 30 MINUTE); \
	";
	if [ -f /var/lib/mysql/${dbname}/$1.csv ]; then
		sudo cat /var/lib/mysql/${dbname}/$1.csv;
	fi
	sudo gawk -f /home/sql_response.awk -v traitement=$1 /var/lib/mysql/${dbname}/$1.csv;
	sudo mysql -D ${dbname} -e "\
		UPDATE lettre_information \
			SET TO_SENT = 0 \
			WHERE \
				TO_SENT = 1; \
		UPDATE lettre_information \
			SET HASH_CONF = NULL \
			WHERE \
				HASH_CONF IS NOT NULL \
				AND CURRENT_TIMESTAMP > ADDDATE(EXPIRE_HASH, INTERVAL 30 MINUTE); \
	";
fi
if [ "$1" = "demande_confirmation_5m" ]; then
	sudo rm -f /var/lib/mysql/${dbname}/$1.csv;
	sudo mysql -D ${dbname} -e "\
		SELECT \
			EMAIL,HASH_CONFIRMATION,ADDDATE(EXPIRE_HASH,INTERVAL 30 MINUTE),SERVICE,NOM,PRENOM,ADRESSE,CODE_POSTAL,VILLE,CIVILITE,DATE_CRENEAU,HEURE_CRENEAU_DEBUT,HEURE_CRENEAU_FIN,DATE_CRENEAU_RESERVE, \
			LIEUX_SERVICE,STATUT,DENSOC,SIREN,
			DATE_FORMAT(DATE_CRENEAU_RESERVE,\"%Y\"),DATE_FORMAT(DATE_CRENEAU_RESERVE, \"%d/%c/%Y\"),DATE_FORMAT(DATE_ADD(DATE_CRENEAU_RESERVE, INTERVAL 7 DAY),\"%d/%c/%Y\")
			INTO OUTFILE \"$1.csv\" FIELDS TERMINATED BY \",\" ENCLOSED BY \"\\\"\" LINES TERMINATED BY \"\\n\" \
			FROM rendez_vous \
			WHERE \
				EVT_DEMANDE_CONFIRMATION = 1 \
				AND HASH_CONFIRMATION IS NOT NULL \
				AND CURRENT_TIMESTAMP < ADDDATE(EXPIRE_HASH, INTERVAL 30 MINUTE); \
	";
	if [ -f /var/lib/mysql/${dbname}/$1.csv ]; then
		sudo cat /var/lib/mysql/${dbname}/$1.csv;
	fi
	sudo gawk -f /home/sql_response.awk -v traitement=$1 /var/lib/mysql/${dbname}/$1.csv;
	sudo mysql -D ${dbname} -e "\
		UPDATE rendez_vous \
			SET EVT_DEMANDE_CONFIRMATION = 0 \
			WHERE \
				EVT_DEMANDE_CONFIRMATION = 1; \
		UPDATE rendez_vous \
			SET HASH_CONFIRMATION = NULL \
			WHERE \
				HASH_CONFIRMATION IS NOT NULL \
				AND CURRENT_TIMESTAMP > ADDDATE(EXPIRE_HASH, INTERVAL 30 MINUTE); \
	";
fi
if [ "$1" = "evt_5m" ]; then
	sudo rm -f /var/lib/mysql/${dbname}/$1.csv;
	sudo mysql -D ${dbname} -e "\
		SELECT \
			EVT_CONFIRMATION,EVT_ANNULATION_PERSO,EVT_ANNULATION_CLIENT, \
			DATE_CRENEAU,HEURE_CRENEAU_DEBUT,HEURE_CRENEAU_FIN,DATE_CRENEAU_RESERVE,HASH_ANNULATION_CLIENT, \
			CIVILITE,NOM,PRENOM,NUMERO_TELEPHONE,EMAIL,ADRESSE,CODE_POSTAL,VILLE,SERVICE,LIEUX_SERVICE,COMMENTAIRE \
			INTO OUTFILE \"$1.csv\" FIELDS TERMINATED BY \",\" ENCLOSED BY \"\\\"\" LINES TERMINATED BY \"\\n\" \
			FROM rendez_vous \
			WHERE \
				DATE(DATE_CRENEAU_RESERVE) IS NOT NULL \
				AND (EVT_CONFIRMATION=1 or EVT_ANNULATION_PERSO=1 or EVT_ANNULATION_CLIENT=1); \
	";
	if [ -f /var/lib/mysql/${dbname}/$1.csv ]; then
		sudo cat /var/lib/mysql/${dbname}/$1.csv;
	fi
	sudo gawk -f /home/sql_response.awk -v traitement=$1 /var/lib/mysql/${dbname}/$1.csv;
	sudo mysql -D ${dbname} -e "\
		UPDATE rendez_vous \
			SET EVT_CONFIRMATION=0 \
			WHERE \
				DATE(DATE_CRENEAU_RESERVE) IS NOT NULL \
				AND (EVT_CONFIRMATION=1); \
		UPDATE rendez_vous \
			SET \
				EVT_ANNULATION_PERSO=0, EVT_ANNULATION_CLIENT=0, \
				DATE_CRENEAU_RESERVE=NULL,HASH_ANNULATION_CLIENT=NULL,HASH_ANNULATION_PERSO=NULL, \
				CIVILITE=NULL,NOM=NULL,PRENOM=NULL,NUMERO_TELEPHONE=NULL,EMAIL=NULL,ADRESSE=NULL,CODE_POSTAL=NULL,VILLE=NULL,SERVICE=NULL,LIEUX_SERVICE=NULL, \
				EVT_DEMANDE_CONFIRMATION=NULL,HASH_CONFIRMATION=NULL,EVT_CONFIRMATION=NULL,CONFIRMATION=NULL,COMMENTAIRE=NULL,ACCEPTATION_CGV=NULL,CONSENTEMENT_RGPD=NULL \
			WHERE \
				DATE(date_creneau_reserve) IS NOT NULL \
				AND ((CONFIRMATION=1 AND (EVT_ANNULATION_PERSO=1 or EVT_ANNULATION_CLIENT=1)) \
				OR (CONFIRMATION=0 AND (CURRENT_TIMESTAMP > ADDDATE(DATE_CRENEAU_RESERVE, INTERVAL 30 MINUTE)))); \
	";
fi


