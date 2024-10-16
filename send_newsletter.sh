#sudo apt install at
#sudo systemctl enable --now atd
#sudo at -f send_newsletter.sh -t 202408301543 
#OR sudo ./send_newsletter.sh

path_script="/home/cred.txt";
dbname=$(sed -n 's/^dbname=\(.*\)/\1/p' < "${path_script}");
usr_srv=$(sed -n 's/^usr_srv=\(.*\)/\1/p' < "${path_script}");

A="envoi_lettre_information";
B="modele_lettre-info_2024_10_02.txt";
sudo rm -f /var/lib/mysql/${dbname}/$A.csv;
sudo mysql -D ${dbname} -e "\
	SELECT \
		EMAIL \
		INTO OUTFILE \"$A.csv\" FIELDS TERMINATED BY \",\" ENCLOSED BY \"\\\"\" LINES TERMINATED BY \"\\n\" \
		FROM lettre_information \
		WHERE \
			INSCRIPTION_VALIDE=1 \
	";
if [ -f /var/lib/mysql/${dbname}/$A.csv ]; then
	sudo cat /var/lib/mysql/${dbname}/$A.csv;
fi
sudo gawk -f /home/sql_response.awk -v traitement=$A -v modele=$B /var/lib/mysql/${dbname}/$A.csv
#>> /home/envoi_lettres.sh.log;
