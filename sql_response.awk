#sudo apt install wkhtmltopdf
#sudo apt install curl
#sudo apt install gawk

function evtToMutt(evtType,DATE_CRENEAU,HEURE_CRENEAU_DEBUT,HEURE_CRENEAU_FIN,DATE_CRENEAU_RESERVE,HASH_ANNULATION_CLIENT,CIVILITE,NOM,PRENOM,NUMERO_TELEPHONE,EMAIL,ADRESSE,CODE_POSTAL,VILLE,SERVICE,LIEUX_SERVICE,COMMENTAIRE,timestamp2,subject_b64)
{
	output=sprintf("gawk -f /home/%s/sql_response.awk -v traitement=\"field_replace_csvToBody\" -v SENDER=\"%s\" -v DESTINATAIRE=\"%s\" -v SUBJECT_B64=\"%s\" -v DATE_CRENEAU=\"%s\" -v HEURE_CRENEAU_DEBUT=\"%s\" -v HEURE_CRENEAU_FIN=\"%s\" -v DATE_CRENEAU_RESERVE=\"%s\" -v HASH_ANNULATION_CLIENT=\"%s\" -v CIVILITE=\"%s\" -v NOM=\"%s\" -v PRENOM=\"%s\" -v NUMERO_TELEPHONE=\"%s\" -v EMAIL=\"%s\" -v ADRESSE=\"%s\" -v CODE_POSTAL=\"%s\" -v VILLE=\"%s\" -v SERVICE=\"%s\" -v LIEUX_SERVICE=\"%s\" /home/%s/modele_%s.txt > /home/%s/body_%s_%s.txt",usr_srv,smtp_sender,EMAIL,subject_b64, DATE_CRENEAU,HEURE_CRENEAU_DEBUT,HEURE_CRENEAU_FIN,DATE_CRENEAU_RESERVE,HASH_ANNULATION_CLIENT,CIVILITE,NOM,PRENOM,NUMERO_TELEPHONE,EMAIL,ADRESSE,CODE_POSTAL,VILLE,SERVICE,LIEUX_SERVICE,usr_srv,evtType,usr_srv,evtType,timestamp2);
	printf("\t[%s][%s][%s]\n",timestamp2,evtType,output);
	system(output);
	#> instead of >> (append)
	output=sprintf("curl --url '%s' --ssl-reqd --mail-from '%s' --mail-rcpt '%s' --user '%s:%s' -T /home/%s/body_%s_%s.txt",smtp_url,smtp_sender,EMAIL,smtp_sender,smtp_pwd,usr_srv,evtType,timestamp2);
	printf("\t[%s][%s][%s]\n",timestamp2,evtType,output);
	system(output);
}
function toB64(plain_subject)
{
	cmd=sprintf("echo \"%s\" |base64",plain_subject);
	subject_b64="";
	while ((cmd |getline output) > 0) {
		subject_b64=sprintf("%s%s",subject_b64,output);
	}
	close(cmd);
	gsub(/=/,"",subject_b64);
	return subject_b64;
}

BEGIN  {	
	#printf("=============================================================================================================================\n");
	
	usr_srv="";
	smtp_url="";
	smtp_sender="";
	smtp_pwd="";
	rdv_filename="";
	
	src="/home/cred.txt";
	cmd=sprintf("cat \"%s\"",src);
	while ((cmd |getline output) > 0)
	{
		#printf(">{%s}\n",output);
		match(output,/^usr_srv=(.*)$/,b); if (RLENGTH != -1 && RSTART != 0) { usr_srv=sprintf("%s", b[1]); }
		match(output,/^smtp_url=(.*)$/,b); if (RLENGTH = -1 && RSTART != 0) { smtp_url=sprintf("%s", b[1]); }
		match(output,/^smtp_sender=(.*)$/,b); if (RLENGTH != -1 && RSTART != 0) { smtp_sender=sprintf("%s", b[1]); }
		match(output,/^smtp_pwd=(.*)$/,b); if (RLENGTH != -1 && RSTART != 0) { smtp_pwd=sprintf("%s", b[1]); }
		match(output,/^rdv_filename=(.*)$/,b); if (RLENGTH != -1 && RSTART != 0) { rdv_filename=sprintf("%s", b[1]); }
	}
	
	#printf("usr_srv=[%s]\n",usr_srv);
	#printf("smtp_url=[%s]\n",smtp_url);
	#printf("smtp_sender=[%s]\n",smtp_sender);
	#printf("smtp_pwd=[%s]\n",smtp_pwd);
	#printf("rdv_filename=[%s]\n",rdv_filename);
	close(cmd);
}
{
	"date -Ins" | getline timestamp2;
	gsub(/[:,T]/,"-",timestamp2);
	timestamp2=substr(timestamp2,0,length(timestamp2)-6);
	if (traitement=="demande_confirmation_5m")
	{
		match($0,/"([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)"/,a); #
		if (RLENGTH != -1 && RSTART != 0)
		{
			#$(cat /proc/sys/kernel/random/uuid)
			#https://blog.ambor.com/2021/08/using-curl-to-send-e-mail-with.html
			cmd=sprintf("od -x /dev/urandom | head -1 | awk '{OFS=\"-\"; print $2$3,$4,$5,$6,$7$8$9}'")
			cmd | getline BOUNDARY_MIXED
			close(cmd);
			cmd | getline BOUNDARY_ALTERNATIVE
			close(cmd);
			printf("\tTEST[%s][%s]\n",BOUNDARY_MIXED,BOUNDARY_ALTERNATIVE);
			
			FILE_NAME=sprintf("D-%s.pdf",timestamp2);
						
			#PDF - Replace .html PUIS génération .pdf PUIS insertion base 64 PUIS fermeture boundary_mixed
			output=sprintf("gawk -f /home/%s/sql_response.awk -v traitement=\"field_replace_csvToBody\" -v SERVICE=\"%s\" -v NOM=\"%s\" -v PRENOM=\"%s\" -v ADRESSE=\"%s\" -v CODE_POSTAL=\"%s\" -v VILLE=\"%s\" -v EMAIL=\"%s\" /home/%s/modele_devis.html > /home/%s/D-%s.html", usr_srv,a[4],a[5],a[6],a[7],a[8],a[9],a[1],usr_srv,usr_srv,timestamp2);
			#D pour Devis, F pour Facture
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
			output=sprintf("wkhtmltopdf /home/%s/D-%s.html /home/%s/D-%s.pdf",usr_srv, timestamp2, usr_srv,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
			
			cmd=sprintf("file --mime-type /home/%s/D-%s.pdf | sed 's/.*: //'",usr_srv,timestamp2);
			cmd | getline FILE_TYPE
			close(cmd);
			
			output=sprintf("gawk -f /home/%s/sql_response.awk -v traitement=\"field_replace_csvToBody\" -v SENDER=\"%s\" -v DESTINATAIRE=\"%s\" -v SUBJECT_B64=\"%s\" -v FILE_TYPE=\"%s\" -v FILE_NAME=\"%s\" -v BOUNDARY_MIXED=\"%s\" /home/%s/modele_%s_1.txt > /home/%s/body_%s_%s.txt", usr_srv, smtp_sender, a[1], toB64("[R2i-Grout][À confirmer] Lien de votre prise de rendez-vous"),FILE_TYPE,FILE_NAME,BOUNDARY_MIXED,usr_srv, traitement, usr_srv,traitement,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
			
			output=sprintf("base64 \"/home/%s/D-%s.pdf\" >> \"/home/%s/body_%s_%s.txt\"",usr_srv, timestamp2, usr_srv,traitement,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
			
			output=sprintf("gawk -f /home/%s/sql_response.awk -v traitement=\"field_replace_csvToBody\" -v HASH_CONFIRMATION=\"%s\" -v EXPIRE_HASH=\"%s\" -v BOUNDARY_MIXED=\"%s\" -v CIVILITE=\"%s\" -v NOM=\"%s\" -v PRENOM=\"%s\" -v DATE_CRENEAU=\"%s\" -v HEURE_CRENEAU_DEBUT=\"%s\" -v HEURE_CRENEAU_FIN=\"%s\" -v DATE_CRENEAU_RESERVE=\"%s\" /home/%s/modele_%s_2.txt >> /home/%s/body_%s_%s.txt", usr_srv, a[2], a[3], BOUNDARY_MIXED, a[10], a[5], a[6], a[11], a[12], a[13], a[14], usr_srv, traitement, usr_srv,traitement,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
			
			output=sprintf("curl --url '%s' --ssl-reqd --mail-from '%s' --mail-rcpt '%s' --user '%s:%s' -T /home/%s/body_%s_%s.txt",smtp_url,smtp_sender,a[1],smtp_sender,smtp_pwd,usr_srv,traitement,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
		}
	}
	if (traitement=="lettre_info_5m")
	{
		match($0,/"([^"]*)","([^"]*)","([^"]*)"/,a);
		if (RLENGTH != -1 && RSTART != 0)
		{
			output=sprintf("gawk -f /home/%s/sql_response.awk -v traitement=\"field_replace_csvToBody\" -v SENDER=\"%s\" -v DESTINATAIRE=\"%s\" -v HASH_CONF=\"%s\" -v EXPIRE_HASH=\"%s\" -v SUBJECT_B64=\"%s\" /home/%s/modele_%s.txt > /home/%s/body_%s_%s.txt", usr_srv, smtp_sender, a[1], a[2], a[3], toB64("[R2i-Grout][À confirmer] Lien relatif à la lettre d'information"),usr_srv, traitement, usr_srv,traitement,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
			output=sprintf("curl --url '%s' --ssl-reqd --mail-from '%s' --mail-rcpt '%s' --user '%s:%s' -T /home/%s/body_%s_%s.txt",smtp_url,smtp_sender,a[1],smtp_sender,smtp_pwd,usr_srv,traitement,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
		}
	}
	if (traitement=="2fa_5m")
	{
		match($0,/"([^"]*)","([^"]*)","([^"]*)"/,a);
		if (RLENGTH != -1 && RSTART != 0)
		{
			output=sprintf("gawk -f /home/%s/sql_response.awk -v traitement=\"field_replace_csvToBody\" -v SENDER=\"%s\" -v DESTINATAIRE=\"%s\" -v HASH_LOGIN=\"%s\" -v EXPIRE_DATE=\"%s\" -v SUBJECT_B64=\"%s\" /home/%s/modele_%s.txt > /home/%s/body_%s_%s.txt", usr_srv, smtp_sender, a[1], a[2], a[3], toB64("[R2i-Grout] Lien de connexion à l'interface de prise de rendez-vous"),usr_srv, traitement, usr_srv,traitement,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
			output=sprintf("curl --url '%s' --ssl-reqd --mail-from '%s' --mail-rcpt '%s' --user '%s:%s' -T /home/%s/body_%s_%s.txt",smtp_url,smtp_sender,a[1],smtp_sender,smtp_pwd,usr_srv,traitement,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
		}
	}
	if (traitement=="evt_5m")
	{
		printf("[%s][%s][%s]\n",timestamp2,traitement,$0);
		match($0,/"([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)"/,a);
		if (RLENGTH != -1 && RSTART != 0)
		{
			printf("[1-%s][19-%s]\n",a[1],a[19]);
			if(a[1] == "1") { print "HERE"; evtToMutt("confirme",a[4],a[5],a[6],a[7],a[8],a[9],a[10],a[11],a[12],a[13],a[14],a[15],a[16],a[17],a[18],a[19],timestamp2,toB64("[R2i-Grout] Confirmation de votre prise de rendez-vous")); }
			if(a[2] == "1") { evtToMutt("annulation_perso",a[4],a[5],a[6],a[7],a[8],a[9],a[10],a[11],a[12],a[13],a[14],a[15],a[16],a[17],a[18],a[19],timestamp2,toB64("[R2i-Grout] Annulation de votre rendez-vous")); }
			if(a[3] == "1") { evtToMutt("annulation_client",a[4],a[5],a[6],a[7],a[8],a[9],a[10],a[11],a[12],a[13],a[14],a[15],a[16],a[17],a[18],a[19],timestamp2,toB64("[R2i-Grout][À confirmer] Annulation de votre rendez-vous")); }
		}
	}
	if (traitement=="envoi_lettre_information")
	{
		match($0,/"([^"]*)"/,a);
		if (RLENGTH != -1 && RSTART != 0)
		{
			output=sprintf("gawk -f /home/%s/sql_response.awk -v traitement=\"field_replace_csvToBody\" -v EMAIL=\"%s\" /home/%s/%s > /home/%s/body_%s_%s.txt", usr_srv,a[1],usr_srv,modele,usr_srv,traitement,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
			
			output=sprintf("curl --url '%s' --ssl-reqd --mail-from '%s' --mail-rcpt '%s' --user '%s:%s' -T /home/%s/body_%s_%s.txt",smtp_url,smtp_sender,a[1],smtp_sender,smtp_pwd,usr_srv,traitement,timestamp2);
			printf("\t[%s][%s][%s]\n",timestamp2,traitement,output);
			system(output);
		}
	}
	if (traitement=="field_replace_csvToBody")
	{
		if (length(DATE_CRENEAU) > 0) { $0=gensub(/\[DATE_CRENEAU\]/,DATE_CRENEAU,1,$0); }
		if (length(HEURE_CRENEAU_DEBUT) > 0) { $0=gensub(/\[HEURE_CRENEAU_DEBUT\]/,HEURE_CRENEAU_DEBUT,1,$0); }
		if (length(HEURE_CRENEAU_FIN) > 0) { $0=gensub(/\[HEURE_CRENEAU_FIN\]/,HEURE_CRENEAU_FIN,1,$0); }
		if (length(DATE_CRENEAU_RESERVE) > 0) { $0=gensub(/\[DATE_CRENEAU_RESERVE\]/,DATE_CRENEAU_RESERVE,1,$0); }
		if (length(HASH_ANNULATION_CLIENT) > 0) { $0=gensub(/\[HASH_ANNULATION_CLIENT\]/,HASH_ANNULATION_CLIENT,1,$0); }
		if (length(CIVILITE) > 0) { $0=gensub(/\[CIVILITE\]/,CIVILITE,1,$0); }
		if (length(NOM) > 0) { $0=gensub(/\[NOM\]/,NOM,1,$0); }
		if (length(PRENOM) > 0) { $0=gensub(/\[PRENOM\]/,PRENOM,1,$0); }
		if (length(NUMERO_TELEPHONE) > 0) { $0=gensub(/\[NUMERO_TELEPHONE\]/,NUMERO_TELEPHONE,1,$0); }
		if (length(EMAIL) > 0) { $0=gensub(/\[EMAIL\]/,EMAIL,1,$0); }
		if (length(ADRESSE) > 0) { $0=gensub(/\[ADRESSE\]/,ADRESSE,1,$0); }
		if (length(CODE_POSTAL) > 0) { $0=gensub(/\[CODE_POSTAL\]/,CODE_POSTAL,1,$0); }
		if (length(VILLE) > 0) { $0=gensub(/\[VILLE\]/,VILLE,1,$0); }
		if (length(SERVICE) > 0) { $0=gensub(/\[SERVICE\]/,SERVICE,1,$0); }
		if (length(LIEUX_SERVICE) > 0) { $0=gensub(/\[LIEUX_SERVICE\]/,LIEUX_SERVICE,1,$0); }
		
		if (length(rdv_filename) > 0) { $0=gensub(/\[PAGE_RDV\]/,rdv_filename,1,$0); }
		
		if (SERVICE==1) { $0=gensub(/\[DEVIS\]/,"        <tr><td>Installation OS</td><td>30/09</td><td>1</td><td>heure</td><td>45.00€</td></tr>\n    </table>\n    </br>\n    <table class=\"entete3\">\n      </tr><td>Total net de TVA</td><td>45.00€<td></tr>\n",1,$0); }
		if (SERVICE==2) { $0=gensub(/\[DEVIS\]/,"        <tr><td>Récupération de données</td><td>30/09</td><td>1</td><td>heure</td><td>40.00€</td></tr>\n    </table>\n    </br>\n    <table class=\"entete3\">\n      </tr><td>Total net de TVA</td><td>40.00€</td></tr>\n",1,$0); }
		
		if (length(FILE_TYPE) > 0) { $0=gensub(/\[FILE_TYPE\]/,FILE_TYPE,1,$0); }
		if (length(FILE_NAME) > 0) { $0=gensub(/\[FILE_NAME\]/,FILE_NAME,1,$0); }
		if (length(BOUNDARY_ALTERNATIVE) > 0) { $0=gensub(/\[BOUNDARY_ALTERNATIVE\]/,BOUNDARY_ALTERNATIVE,1,$0); }
		if (length(BOUNDARY_MIXED) > 0) { $0=gensub(/\[BOUNDARY_MIXED\]/,BOUNDARY_MIXED,1,$0); }

		if (length(SENDER) > 0) { $0=gensub(/\[SENDER\]/,smtp_sender,1,$0); }
		if (length(DESTINATAIRE) > 0) { $0=gensub(/\[DESTINATAIRE\]/,DESTINATAIRE,1,$0); }
		if (length(SUBJECT_B64) > 0) { $0=gensub(/\[SUBJECT_B64\]/,SUBJECT_B64,1,$0); }
		if (length(HASH_LOGIN) > 0) { $0=gensub(/\[HASH_LOGIN\]/,HASH_LOGIN,1,$0); }
		if (length(HASH_CONF) > 0) { $0=gensub(/\[HASH_CONF\]/,HASH_CONF,1,$0); }
		if (length(EXPIRE_DATE) > 0) { $0=gensub(/\[EXPIRE_DATE\]/,EXPIRE_DATE,1,$0); }
		if (length(EXPIRE_HASH) > 0) { $0=gensub(/\[EXPIRE_HASH\]/,EXPIRE_HASH,1,$0); }
		if (length(HASH_CONFIRMATION) > 0) { $0=gensub(/\[HASH_CONFIRMATION\]/,HASH_CONFIRMATION,1,$0); }

		printf("%s\n",$0);
	}
	if (traitement=="reminder_17h")
	{
		match($0,/"([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)"/,a);
		if (RLENGTH != -1 && RSTART != 0)
		{
			evtToMutt("reminder",a[1],a[2],a[3],a[4],a[5],a[6],a[7],a[8],a[9],a[10],a[11],a[12],a[13],a[14],a[15],a[16]);
		}
	}
}