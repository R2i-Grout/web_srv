<?php
session_start();

#ini_set('session.cookie_lifetime', '0');
#ini_set('session.cache_expire', '1800');
#ini_set('session.use_strict_mode', 'true');
#ini_set('session.use_trans_sid', 'false');
#ini_set('session_cache_limiter', 'nocache');
#ini_set('session.name', 'R2IGROUT');
#ini_set('session.sid_length', '256');
#ini_set('session.sid_bits_per_character', '6');
#ini_set('session.hash_function', '1');
#ini_set('session.hash_bits_per_character', '6');
#ini_set('session.entropy_file', '/dev/urandom');
#ini_set('session.use_cookies', 'true');
#ini_set('session.cookie_httponly', 'true');
#ini_set('session.use_only_cookies', 'true');
#ini_set('session.cookie_secure', 'true');
#date.timezone = "Europe/Paris"

#https://www.php.net/manual/fr/session.configuration.php
#cat /dev/urandom  |hexdump
#print_r($_SESSION);

# php -f /var/www/html/mariadb.php
#sudo touch /var/www/html/test_log.txt
#sudo chown www-data:www-data /var/www/html/test_log.txt
#sudo ls -la /var/www/html/test_log.txt
#echo shell_exec('printenv;pwd;ls').'<br />';
#echo var_dump($_POST)."<br />";

#AJOUT <a><presta>...-> echo $presta

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Raphaël GROUT">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Prise de rendez-vous chez R2i-Grout.">
	<meta name="keywords" content="RDV, R2I-GROUT">
	<link rel="canonical" href="https://r2i-grout.fr/prise-de-rendez-vous.php" />
	<meta property="og:locale" content="fr_FR" >
	<meta property="og:type" content="website" >
	<meta property="og:title" content="Prendre rendez-vous chez R2i-Grout" >
	<meta property="og:description" content="Prise de rendez-vous chez R2i-Grout." >
	<meta property="og:url" content="https://r2i-grout.fr/prise-de-rendez-vous.php">
	
	<meta name="title" content="Prendre rendez-vous chez R2i-Grout">
	<meta name="robots" content="index,follow">
	
	
	<title>Formulaire d'enregistrement</title>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php'); wp_head(); get_header(); ?>
	<style>
		@media (min-width : 922px) {
                        .site-content .ast-container {
                                /*display: flex;*/
                                flex-direction: column;
                        }
                }
                @media (max-width : 921px) {
                        .site-content .ast-container {
                                flex-direction: column;
                        }
                }
                
                /*div#content{
                        display :grid;
                }
                div.ast-container {
                        display : grid;
                        align-items:center;
                }*/
                
                div#content {
			display : flex;
			align-items:center;
		}
                
                
		.wrapper2{
			display : flex;
			align-items :center;
			justify-content:center;
		}
		.wrapper {
			width: 350px;
			background-color: #000000;
			
			box-sizing: border-box; 
           		border: 2px solid white;
           		border-radius:6px;
		}
		.wrapper header {
			display: flex;
			align-items: center;
			justify-content: space-between;
		}
		header .icons {
			display: flex;
		}
		header .icons a {
			text-decoration: none;
			height: 38px;
			width: 38px;
			margin: 0 1px;
			cursor: pointer;
			color: #878787;
			text-align: center;
			line-height: 38px;
			font-size: 1.9rem;
			user-select: none;
			border-radius: 50%;
		}
		.icons span:last-child {
			margin-right: -10px;
		}
		header .icons span:hover {
			background: #f2f2f2;
		}
		header .current-date {
			font-size: 1.45rem;
			font-weight: 500;
		}
		.calendar ul {
			display: flex;
			flex-wrap: wrap;
			list-style: none;
			text-align: center;
		}
		.calendar .days {
			margin-bottom: 20px;
		}
		.calendar li {
			color : #FFFFFF;
			width: calc(100% / 7);
			font-size: 1.07rem;
		}
		.calendar .weeks li {
			font-weight: 500;
			cursor: default;
			color : #FFFFFF;
		}
		.calendar .days li {
			z-index: 1;
			cursor: pointer;
			position: relative;
			margin-top: 30px;
		}
		.days li.inactive {
			pointer-events:none;
			color : #808080;
		}
		.days li.active {
			color: #fff;
		}
		.days li::before {
			position: absolute;
			content: "";
			left: 50%;
			top: 50%;
			height: 40px;
			width: 40px;
			z-index: -1;
			border-radius: 50%;
			transform: translate(-50%, -50%);
		}
		.days li.active::before {
			background: #9B59B6;
		}
		.days li:not(.active):hover::before {
			background: #f2f2f2;
		}
		.tableFORM {
			table-layout: fixed;
			width: 100%;
			background : #808080;
			border-collapse:separate;
			border:solid white 1px;
			border-radius:6px;
		}
		td {
			border-left:solid white 1px;
			border-top:solid white 1px;
		}
		td:first-child, th:first-child {
			border-left: none;
		}
		.cle {
			width: 30%;
			text-align:center;
			color:#000000;
		}
		.valeur {
			width: 80%;
		}
		.button-pers {
			background-color : #FFFFFF;
			color : #000000;
		}
		#button {
			width: 100%;
		}
		.label {
			color : #000000;
			font-weight: normal !important;
		}
		fieldset {
			border : none;
		}
		address.address {
			color : #FFFFFF;
		}
		input.input {
			color : #000000;
		}
		.url-perso {
			text-decoration:underline;
		}
	</style>
</head>
<body>
<!-- <h1 style="color:red; text-align:center;">SYSTEME EN COURS DE TEST.<br> L'ENSEMBLE DES DONNEES RENTREES SERA SUPPRIME LE 31 OCTOBRE.<br>LE SYSTEME SERA EN PRODUCTION A PARTIR DU 1 NOVEMBRE</h1> -->
<?php

$rdv_filename = '';
$domainname = '';
$dbname = '';
$dbuser = '';
$dbpass = '';
$dbhost = '';
$adm_pwd = '';
$adm_url = '';
$nomtablecreneau = '';
$path_sensitive_data = "/home/cred.txt";

$myfile = fopen($path_sensitive_data, "r") or die("Unable to open file!");
while(!feof($myfile)) {
	preg_match('/([^=]*)=(.*)$/', fgets($myfile), $matches, PREG_OFFSET_CAPTURE);
	if (isset($matches[1][0]) && isset ($matches[2][0]))
	{
		if ("rdv_filename" == $matches[1][0]) { $rdv_filename=$matches[2][0]; }
		if ("domainname" == $matches[1][0]) { $domainname=$matches[2][0]; }
		if ("dbname" == $matches[1][0]) { $dbname=$matches[2][0]; }
		if ("dbuser" == $matches[1][0]) { $dbuser=$matches[2][0]; }
		if ("dbpass" == $matches[1][0]) { $dbpass=$matches[2][0]; }
		if ("dbhost" == $matches[1][0]) { $dbhost=$matches[2][0]; }
		if ("adm_pwd" == $matches[1][0]) { $adm_pwd=$matches[2][0]; }
		if ("adm_url" == $matches[1][0]) { $adm_url=$matches[2][0]; }
		if ("nomtablecreneau" == $matches[1][0]) { $nomtablecreneau=$matches[2][0]; }
		if ("\$arrayJourTravaille" == $matches[1][0]) { eval($matches[1][0]."=".$matches[2][0]); }
		if ("\$arrayCreneau" == $matches[1][0]) { eval($matches[1][0]."=".$matches[2][0]); }
	}
}
if (!empty($_GET[$adm_url])) {
	if (($_GET[$adm_url] == $adm_pwd) && (1==0)) {
		echo "rdv_filename=".$rdv_filename."</br>";
		echo "domainname=".$domainname."</br>";
		echo "dbname=".$dbname."</br>";
		echo "dbuser=".$dbuser."</br>";
		echo "dbpass=".$dbpass."</br>";
		echo "dbhost=".$dbhost."</br>";
		echo "adm_pwd=".$adm_pwd."</br>";
		echo "adm_url=".$adm_url."</br>";
		echo "nomtablecreneau=".$nomtablecreneau."</br>";
	}
}
fclose($myfile);

try {
	#';charset=utf8mb4'
	#$dbport = 3306;
	$link = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass);
	$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$link->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
} 
catch (Exception $e) {
	error_log($e->getMessage());
	exit('Something bad happened'); 
}

function generateAuthForm($url,$pwd) {
	echo "<form method=\"post\"><input type=\"text\" name=\"email\"><input type=\"password\" name=\"pwd\"><input formaction=\"?".$url."=".$pwd."\" type=\"submit\"></form>";
}

if (!empty($_GET[$adm_url])) {
	if ($_GET[$adm_url] == $adm_pwd) {
		if (empty($_SESSION['LAST_ACTIVITY'])) {
			if (!empty($_POST['pwd']) and !empty($_POST['email'])) { 
				$sql_2fa='SELECT EMAIL,HASH_PWD FROM 2fa';
				$statement_2fa = $link->prepare($sql_2fa);
				$statement_2fa->execute();
				while (($row2 = $statement_2fa->fetch(PDO::FETCH_ASSOC)) !== false) {
					$email=$row2['EMAIL'];
					$hash_pwd=$row2['HASH_PWD'];
				}
				if ((hash('sha256',filter_var($_POST['pwd'],FILTER_SANITIZE_STRING)) == $hash_pwd) and  (filter_var($_POST['email'],FILTER_SANITIZE_STRING) == $email)) {
					$result=$link->exec('UPDATE 2fa SET HASH_LOGIN=SHA2(CONCAT(CURRENT_TIMESTAMP,EMAIL,HEX(RANDOM_BYTES(8))),256), LAST_UPDATED_LOGIN=CURRENT_TIMESTAMP, TO_SENT=1 WHERE EMAIL = \''.$email.'\'');
					if ($result >= 0)
					{
						echo '<p>Vous allez recevoir un lien d\'accès.</p>';
					} else {
						echo '<p>Echec de la tentative de création du lien</p>';
					}
				} else { generateAuthForm($adm_url,$adm_pwd); }
			} else {
				generateAuthForm($adm_url,$adm_pwd);
			}
		}
	}
}

if (!empty($_GET['loginAdm'])) {
	$sql_2fa='SELECT HASH_LOGIN FROM 2fa';
	$statement_2fa = $link->prepare($sql_2fa);
	$statement_2fa->execute();
	$hash_login='';
	while (($row2 = $statement_2fa->fetch(PDO::FETCH_ASSOC)) !== false) {
		$hash_login=$row2['HASH_LOGIN'];
	}
	if ($hash_login == $_GET['loginAdm']) {
		$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
		$result=$link->exec('UPDATE 2fa SET HASH_LOGIN=NULL, LAST_UPDATED_LOGIN=CURRENT_TIMESTAMP, TO_SENT=0 WHERE HASH_LOGIN = \''.$hash_login.'\'');
	}
}

if (!empty($_SESSION['LAST_ACTIVITY'])) {
	if ((time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
		#1800 s = 30 minutes = 30 * 60, 60 = 60s
		$_SESSION = array();
		session_destroy();  // destroy session data in storage
		#session_unset($_SESSION); // unset $_SESSION variable for the run-time
		session_unset();
		header("Refresh:0");
	}
}

if (!empty($_SESSION)) {
	if ( $_SESSION['LAST_ACTIVITY']) {
		echo "<a href=\"https://".$domainname."/".$rdv_filename."?".$adm_url."=".$adm_pwd."\" target=\"_self\" rel=\"noopener noreferrer\">Accès à la console d'administration</a>
";
	}
}

if (!empty($_POST['post_button']) or !empty($_GET['token']) or !empty($_GET[$adm_url]) or !empty($_GET['confirmation'])) { $returnValue=TRUE; }
else { $returnValue = FALSE; }
echo "		<form id=\"MyForm\" onchange=\"myFunction2();\" method=\"post\"".(($returnValue)?" style=\"display: none\"":"").">
"; ?>
			<span class="wrapper2">
				<div class="wrapper">
					<header>
						<p class="current-date"><?php

$annee=-1;
$mois=-1;
if ((!empty($_GET["annee"])) and (!empty($_GET["mois"]))){
	$annee=filter_var($_GET["annee"],FILTER_VALIDATE_INT);
	$mois=filter_var($_GET["mois"],FILTER_VALIDATE_INT);
}
if (((1 <= $mois) and ($mois <= 12)) and ((0 <= $annee) and ($annee <= 99))) {

} else {
	$annee=(new DateTime())->format('y');
	$mois=(new DateTime())->format('n');
}
echo '20'.str_pad($annee, 2, "0", STR_PAD_LEFT).'-'. $mois;
$anneePREV = $annee;
$anneeNEXT = $annee;
$moisPREV = $mois -1;
$moisNEXT = $mois +1;
if ($mois == 1) {$moisPREV = 12; $anneePREV = $annee-1; } elseif ($mois == 12) {$moisNEXT = 1; $anneeNEXT = $annee+1; }
?></p>
						<div class="icons">
<?php echo "							<input class=\"button-pers\"  formaction=\"?annee=".$anneePREV."&mois=".$moisPREV."\" type=\"submit\" value=\"<\" />
							<input class=\"button-pers\" formaction=\"?annee=".$anneeNEXT."&mois=".$moisNEXT."\" type=\"submit\" value=\">\" />
						</div>
";?>
					</header>
					<div class="calendar">
						<ul class="weeks">
							<li>Lun</li>
							<li>Mar</li>
							<li>Mer</li>
							<li>Jeu</li>
							<li>Ven</li>
							<li>Sam</li>
							<li>Dim</li>
						</ul>
						<ul class="days" id="1111">
<?php

$dateMINM = new DateTime("20".$annee."-".$mois."-01");
$dateMIN = new DateTime("20".$annee."-".$mois."-01");
if ($dateMIN->format('N') > 1) {$dateMIN->modify('-'.($dateMIN->format('N')-1).' day');}
$dateMAX = new DateTime("20".$annee."-".$mois."-01");
$dateMAXM = new DateTime("20".$annee."-".$mois."-".($dateMAX->format('t')));
$dateMAX = new DateTime("20".$annee."-".$mois."-".($dateMAX->format('t')));
if ($dateMAX->format('N') < 7) {$dateMAX->modify('+'.(7-$dateMAX->format('N')).' day');}

while ($dateMIN->format('N') < $dateMINM->format('N')) {
	echo '							<li class="inactive"></li>
'; #'.$dateMIN->format("d").'
	$dateMIN->modify('+1 day');
}

$sql='INSERT INTO '.$nomtablecreneau.' (DATE_CRENEAU,HEURE_CRENEAU_DEBUT,HEURE_CRENEAU_FIN,CRENEAU_RESERVABLE) VALUES (:date,:heuredeb,:heurefin,1)';
$statement = $link->prepare($sql);

$sql2='select date_creneau,heure_creneau_debut,heure_creneau_fin from '.$nomtablecreneau.' WHERE date_creneau = :dt and creneau_reservable = 1 and length(nom) IS NULL';
$statement2 = $link->prepare($sql2);

$sql3='select count(*) from '.$nomtablecreneau.' where date_creneau = :dt and heure_creneau_debut = :hd and heure_creneau_fin = :hf';
$statement3 = $link->prepare($sql3);

for ($x = 1; $x <= (new DateTime("20".$annee."-".$mois."-01"))->format('t'); $x++) {
	if (date_time_set(new DateTime(),0,0,0,0) <= date_time_set(new DateTime("20".$annee."-".$mois."-".(str_pad($x,2,"0",STR_PAD_LEFT))),0,0,0,0)) {
		try {
			$statement2->execute(['dt' => ("20".$annee."-".$mois."-".str_pad($x,2,"0",STR_PAD_LEFT))]);
		}catch(PDOException $err){
			error_log($err->getMessage());
			exit('Something bad happened'); 
		}
		$datacren="";
		while (($row2 = $statement2->fetch(PDO::FETCH_ASSOC)) !== false) {
			if (((((new DateTime()))->setTimeZone(new DateTimeZone("Europe/Paris")))->add(new DateInterval('PT1H'))) <  (DateTimeImmutable::createFromFormat("Y-m-d H:i:s e","20".$annee."-".$mois."-".(str_pad($x,2,"0",STR_PAD_LEFT)." ".$row2['heure_creneau_debut']." +02:00"))))
			{
				$datacren=$datacren.''.substr($row2['heure_creneau_debut'],0,-3).'-'.substr($row2['heure_creneau_fin'],0,-3).';';
			}
		}
		$datacren=rtrim($datacren,";");
		if (strlen($datacren)) {$classDay="";}else{$classDay="inactive";}

		echo "							<li class=\"".$classDay."\" data-cren=\"".$datacren."\">".$x."</li>
";
	} else {
		echo "							<li class=\"inactive\" data-cren=\"\">".$x."</li>
";
	}

	$date=(new DateTime("20".$annee."-".$mois."-".(str_pad($x,2,"0",STR_PAD_LEFT))))->format('N');
	if (in_array((int)$date,$arrayJourTravaille,TRUE))
	{
		for ($y = 0; $y < sizeof($arrayCreneau);$y++)
		{
			try {
				$statement3->execute(['dt' => ('20'.$annee.'-'.$mois.'-'.$x),'hd' => $arrayCreneau[$y][0],'hf' => $arrayCreneau[$y][1]]);
			}catch(PDOException $err){
				error_log($err->getMessage());
				exit('Something bad happened'); 
			}
			$testVAL=-1;
			while (($row3 = $statement3->fetch(PDO::FETCH_ASSOC)) !== false) {
				$testVAL=$row3['count(*)'];
			}
			if ($testVAL == 0)
			{
				if (!empty($_SESSION)) {
					if ($_SESSION['LAST_ACTIVITY']) {
						try {
							$statement->execute(['date' => ('20'.$annee.'-'.$mois.'-'.$x),'heuredeb' => $arrayCreneau[$y][0],'heurefin' => $arrayCreneau[$y][1]]);
						}catch(PDOException $err){
							error_log($err->getMessage());
							exit('Something bad happened'); 
						}
					}
				}
			}
		}
	}
}

while ($dateMAXM->format('N') < $dateMAX->format('N')) {
	$dateMAXM->modify('+1 day');
	echo '							<li class="inactive"></li>
'; #'.($dateMAXM->format("j")).'
}
?>

						</ul>
					</div>
				</div>
			</span>
			</br>
			<span>
				<div>
					<table class="tableFORM">
						<tr>
							<td class="cle">Date</td>
							<td>
								 <input id="jour" class="valeur input" type="text" name="jour" hidden>
							</td>
						</tr>
						<tr>
							<td class="cle">Créneaux</td>
							<td>
								<fieldset id="group1">
								</fieldset>
							</td>
						</tr>
						<tr>
							<td class="cle">Statut</td>
							<td>
								<fieldset id="group5">
									<div>
										<input type="radio" id="particulier" name="statut" value="1" />
										<label class="label" for="particulier">Particulier</label>
									</div>
									<div>
										<input type="radio" id="entreprise" name="statut" value="2" />
										<label class="label" for="entreprise">Entreprise</label>
									</div>
								</fieldset>
							</td>
						</tr>
						<tr id="densoc_line">
							<td class="cle">Dénomination sociale</td>
							<?php echo "<td><input id=\"densoc\" class=\"valeur input\" type=\"text\" name=\"densoc\" maxlength=\"50\" value=\"".((!empty($_POST["densoc"]))?$_POST["densoc"]:'')."\"/></td>";?>
						</tr>
						<tr id="siren_line">
							<td class="cle">SIREN client</td>
							<?php echo "<td><input id=\"siren\" class=\"valeur input\" type=\"text\" name=\"siren\" maxlength=\"9\" value=\"".((!empty($_POST["siren"]))?$_POST["siren"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td class="cle">Civilité</td>
							<td>
								<fieldset id="group2">
									<div>
										<input type="radio" id="m" name="civilite" value="M" />
										<label class="label" for="m">M.</label>
									</div>
									<div>
										<input type="radio" id="mme" name="civilite" value="Mme" />
										<label class="label" for="mme">Mme.</label>
									</div>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td class="cle">Service</td>
							<td>
								<fieldset id="group3">
									<div>
										<input type="radio" id="diag" name="service" value="1" />
										<label class="label" for="diag">Diagnostique d'ordinateur</label>
									</div>
									<div>
										<input type="radio" id="repa" name="service" value="2" />
										<label class="label" for="repa">Réparation d'ordinateur</label>
									</div>
									<div>
										<input type="radio" id="install" name="service" value="3" />
										<label class="label" for="install">Installation de Linux</label>
									</div>
									<div>
										<input type="radio" id="recup" name="service" value="4" />
										<label class="label" for="recup">Récupération de données</label>
									</div>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td class="cle">Lieux RDV</td>
							<td>
								<fieldset id="group4">
									<div>
										<input type="radio" id="dom" name="lieux_service" value="1"/>
										<label class="label" for="dom">A votre domicile</br>&ensp;- Frais de déplacement applicables</br>&ensp;- L'adresse de facturation est utilisée comme adresse du rendez-vous</label>
									</div>
									<div>
										<input type="radio" id="par" name="lieux_service" value="2" />
										<label class="label" for="par">Vous déposez votre matériel informatique au 24 rue Lamartine, 37000, TOURS</br>&ensp;- Pas de frais de déplacement</br>&ensp;- R2i-Grout vous avertira par téléphone quand le matériel sera prêt à être récupéré</label>
									</div>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td class="cle">Nom</td>
							<?php echo "<td><input id=\"nom\" class=\"valeur input\" type=\"text\" name=\"nom\" maxlength=\"100\" value=\"".((!empty($_POST["nom"]))?$_POST["nom"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td class="cle">Prénom</td>
							<?php echo "<td><input id=\"prenom\" class=\"valeur input\" type=\"text\" name=\"prenom\" maxlength=\"100\" value=\"".((!empty($_POST["prenom"]))?$_POST["prenom"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td class="cle">Email</td>
							<?php echo "<td><input id=\"email\" class=\"valeur input\" type=\"text\" name=\"email\" maxlength=\"300\" value=\"".((!empty($_POST["email"]))?$_POST["email"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td class="cle">Téléphone</td>
							<?php echo "<td><input id=\"tel\" class=\"valeur input\" type=\"text\" name=\"tel\" maxlength=\"10\" value=\"".((!empty($_POST["tel"]))?$_POST["tel"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td id="c1" class="cle">Adresse</td>
							<?php echo "<td><input id=\"adresse\" class=\"valeur input\" type=\"text\" name=\"adresse\" maxlength=\"100\" value=\"".((!empty($_POST["adresse"]))?$_POST["adresse"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td id="c5" class="cle">Code postal</td>
							<?php echo "<td><input id=\"code_postal\" class=\"valeur input\" type=\"text\" name=\"code_postal\" maxlength=\"5\" value=\"".((!empty($_POST["code_postal"]))?$_POST["code_postal"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td id="c3" class="cle">Ville</td>
							<?php echo "<td><input id=\"ville\" class=\"valeur input\" type=\"text\" name=\"ville\" maxlength=\"50\" value=\"".((!empty($_POST["ville"]))?$_POST["ville"]:'')."\"/></td>";?>
						</tr>
						<tr id="osm_line">
							<td class="cle">Adresse valide</td>
							<td>
								<fieldset id="group6">
								</fieldset>
							</td>
						</tr>
						<tr><td colspan="2">
							<?php echo "<textarea placeholder=\"(FACULTATIF) Àjouter des détails sur la prestation demandée\" form=\"MyForm\" wrap=\"soft\" class=\"FormElement input\" name=\"commentaire\" id=\"commentaire\" cols=\"41\" rows=\"4\" style=\"resize: none;\" maxlength=\"250\"></textarea>
"; ?>
						</td></tr>
						<tr><td colspan="2">
							<input type="checkbox" id="acceptation_cgv" name="acceptation_cgv" />  <label for="acceptation_cgv">J'accepte les <a href="https://r2i-grout.fr/mentions-legales#cgv" target="_blank" rel="noopener noreferrer" class="url-perso">CGV</a>.</label></br>
							<input type="checkbox" id="consentement_rgpd" name="consentement_rgpd" />  <label for="consentement_rgpd">J'accepte le <a href="https://r2i-grout.fr/mentions-legales#rgpd" target="_blank" rel="noopener noreferrer" class="url-perso">traitement</a> de mes données.</label>
						</td></tr>
					</table>
					<h1></h1>
					<button class=\"button-pers\" type="button" id="button">Envoyer le formulaire</button>
					<h1></h1>
					<address class="address">
						<br/>
						Contacts<br/>
						Pour toute question, vous pouvez me contacter :<br/>
						&ensp;-Par téléphone au <a href="tel:+33610569197">06.10.56.91.97</a><br/>
						&ensp;-Par email à <a href="mailto:r2i-grout@mailo.fr">r2i-grout@mailo.fr</a></br>
					</address>
				</div>
			</span>
		</form>
		<span>
			<script type='text/javascript'>
				document.getElementById("densoc_line").hidden=true;
				document.getElementById("siren_line").hidden=true;
				document.getElementById("osm_line").hidden=true;
				
				polygon=[[47.39350899169679,0.6475928855649329],[47.39394981937181,0.6474618762805017],[47.39439064704684,0.6473308669960703],[47.39483147472186,0.6471998577116391],[47.39527230239688,0.6470688484272078],[47.395487322941165,0.6470049466142314],[47.39592049993264,0.6471831540405126],[47.39635367692412,0.647361361466794],[47.3967868539156,0.6475395688930753],[47.39722003090707,0.6477177763193566],[47.39765320789855,0.647895983745638],[47.39808638489003,0.6480741911719192],[47.398185439106186,0.6481149417133167],[47.398588669084155,0.6478209470729545],[47.39899189906212,0.6475269524325921],[47.39939512904009,0.6472329577922298],[47.39979835901806,0.6469389631518674],[47.40020158899602,0.6466449685115051],[47.40060481897399,0.6463509738711427],[47.40100804895196,0.6460569792307804],[47.40141127892992,0.6457629845904181] 
,[47.40181450890789,0.6454689899500557],[47.40220890538899,0.6451814358048864],[47.402536869925385,0.6447269230627187],[47.40286483446178,0.6442724103205509],[47.40319279899818,0.6438178975783833],[47.40352076353457,0.6433633848362156],[47.40384872807097,0.6429088720940478],[47.40417669260736,0.6424543593518801],[47.404504657143754,0.6419998466097124],[47.40483262168015,0.6415453338675446],[47.405160586216546,0.641090821125377],[47.40548855075294,0.6406363083832093],[47.405703643837626,0.6403382196056384],[47.406063084302076,0.6399390049694204],[47.40642252476653,0.6395397903332023],[47.406781965230984,0.6391405756969842],[47.40714140569544,0.6387413610607662],[47.40750084615989,0.638342146424548],[47.40786028662435,0.63794293178833],[47.4082197270888,0.6375437171521119] 
,[47.40857916755325,0.6371445025158938],[47.408938608017706,0.6367452878796758],[47.40929804848216,0.6363460732434577],[47.409657488946614,0.6359468586072397],[47.40971693413741,0.6358808354613643],[47.41016613303917,0.63585074319051],[47.41061533194094,0.6358206509196558],[47.4110645308427,0.6357905586488014],[47.41151372974447,0.6357604663779471],[47.41196292864623,0.6357303741070929],[47.412412127548,0.6357002818362386],[47.412861326449764,0.6356701895653843],[47.41331052535153,0.63564009729453],[47.413759724253296,0.6356100050236757],[47.41420892315506,0.6355799127528214],[47.41465812205683,0.6355498204819672],[47.41510732095859,0.6355197282111129],[47.41555651986036,0.6354896359402585],[47.41600571876212,0.6354595436694043],[47.416454917663884,0.63542945139855] 
,[47.416904116565654,0.6353993591276957],[47.417353315467416,0.6353692668568415],[47.417802514369185,0.6353391745859871],[47.41825171327095,0.6353090823151328],[47.41870091217272,0.6352789900442786],[47.41915011107448,0.6352488977734243],[47.41959930997625,0.63521880550257],[47.42004850887801,0.6351887132317157],[47.420497707779774,0.6351586209608614],[47.42094690668154,0.6351285286900071],[47.421396105583305,0.6350984364191529],[47.421845304485075,0.6350683441482986],[47.42229450338684,0.6350382518774443],[47.42274370228861,0.63500815960659],[47.42319290119037,0.6349780673357357],[47.42334157425114,0.6349681075829494],[47.42377257659568,0.635157572682984],[47.424203578940215,0.6353470377830185],[47.42463458128476,0.6355365028830531],[47.42506558362929,0.6357259679830877] 
,[47.42549658597383,0.6359154330831222],[47.42592758831837,0.6361048981831567],[47.42596203958527,0.6361200426778737],[47.42627578654497,0.6365961677956814],[47.42658953350467,0.6370722929134891],[47.426903280464366,0.6375484180312968],[47.42721702742406,0.6380245431491045],[47.427530774383754,0.6385006682669121],[47.42768258643417,0.6387310498790839],[47.42790408824605,0.6393094878309689],[47.428125590057924,0.6398879257828537],[47.4283470918698,0.6404663637347386],[47.428568593681675,0.6410448016866236],[47.428790095493554,0.6416232396385085],[47.429011597305426,0.6422016775903934],[47.4290589834207,0.6423254234290141],[47.42907408951728,0.6429897330540972],[47.429089195613855,0.6436540426791805],[47.42910430171043,0.6443183523042636],[47.42911940780701,0.6449826619293467] 
,[47.429134513903584,0.64564697155443],[47.42914962000016,0.6463112811795131],[47.42916472609674,0.6469755908045962],[47.42917983219331,0.6476399004296793],[47.42919493828989,0.6483042100547626],[47.429210044386465,0.6489685196798457],[47.42922515048305,0.6496328293049288],[47.429240256579625,0.6502971389300121],[47.42924250029921,0.6503958093251754],[47.42894156260131,0.6508896786375767],[47.428640624903416,0.6513835479499781],[47.428339687205515,0.6518774172623795],[47.42803874950762,0.6523712865747808],[47.42773781180972,0.6528651558871822],[47.42743687411183,0.6533590251995836],[47.427135936413926,0.6538528945119849],[47.42683499871603,0.6543467638243863],[47.42653406101813,0.6548406331367876],[47.42632909429889,0.655177004330568],[47.426555505049265,0.6557512631626549] 
,[47.42678191579964,0.6563255219947416],[47.42700832655001,0.6568997808268284],[47.42723473730039,0.6574740396589152],[47.42746114805076,0.658048298491002],[47.42768755880113,0.6586225573230887],[47.427913969551504,0.6591968161551756],[47.428140380301876,0.6597710749872623],[47.428347849471805,0.6602972911807115],[47.42852111941538,0.6609106425210759],[47.42869438935895,0.6615239938614402],[47.428867659302526,0.6621373452018047],[47.4290409292461,0.662750696542169],[47.42921419918967,0.6633640478825334],[47.42921956072436,0.6633830269646523],[47.42949183977536,0.663912010952139],[47.42976411882635,0.6644409949396258],[47.430036397877345,0.6649699789271125],[47.43030867692834,0.6654989629145992],[47.43058095597933,0.666027946902086],[47.430825306817866,0.6665026719330456] 
,[47.430882164478284,0.6671620438788562],[47.430939022138695,0.667821415824667],[47.43099587979911,0.6684807877704777],[47.43103282360133,0.6689092209239789],[47.430953384804894,0.6695634714540333],[47.43087394600847,0.6702177219840876],[47.430794507212035,0.670871972514142],[47.43071506841561,0.6715262230441963],[47.430635629619175,0.6721804735742507],[47.43055619082275,0.6728347241043051],[47.43055110681689,0.6728765955031122],[47.430480976656646,0.6735331601506933],[47.43041084649641,0.6741897247982745],[47.43034071633616,0.6748462894458557],[47.43027058617592,0.6755028540934368],[47.430200456015676,0.676159418741018],[47.43013032585544,0.6768159833885992],[47.43006019569519,0.6774725480361803],[47.42999006553495,0.6781291126837615],[47.429931750186086,0.6786750660416772] 
,[47.429966945775234,0.6793377242233581],[47.43000214136438,0.6800003824050391],[47.43003733695353,0.6806630405867201],[47.43007253254268,0.6813256987684011],[47.43010772813182,0.6819883569500821],[47.43014292372097,0.6826510151317631],[47.43017811931012,0.6833136733134441],[47.43021331489927,0.683976331495125],[47.43024851048842,0.684638989676806],[47.43028370607757,0.685301647858487],[47.430318901666716,0.685964306040168],[47.430354097255865,0.686626964221849],[47.430367594500865,0.6868810886745678],[47.430565187853816,0.6874781857273968],[47.43076278120676,0.6880752827802259],[47.43096037455971,0.6886723798330548],[47.431157967912654,0.6892694768858839],[47.431355561265605,0.689866573938713],[47.43155315461855,0.690463670991542],[47.4317507479715,0.691060768044371] 
,[47.43194834132444,0.6916578650972001],[47.43214593467739,0.6922549621500291],[47.43234352803034,0.6928520592028582],[47.432431055079945,0.6931165526313237],[47.432365944657086,0.6937742705997665],[47.432300834234226,0.6944319885682094],[47.43223572381136,0.6950897065366523],[47.4321706133885,0.6957474245050952],[47.43210550296564,0.696405142473538],[47.43204039254278,0.697062860441981],[47.43199431594721,0.6975283067330622],[47.43193746618579,0.698187692049225],[47.43188061642438,0.6988470773653879],[47.43182376666297,0.6995064626815506],[47.43176691690156,0.7001658479977134],[47.43175774740334,0.7002722025774233],[47.431568249477785,0.7008750025010121],[47.431378751552224,0.7014778024246008],[47.43118925362667,0.7020806023481896],[47.430999755701116,0.7026834022717783] 
,[47.430810257775555,0.7032862021953671],[47.43062075985,0.7038890021189558],[47.43043126192444,0.7044918020425446],[47.430320115695,0.7048453623172577],[47.43005094486444,0.7053778071594707],[47.429781774033884,0.7059102520016839],[47.42951260320333,0.7064426968438969],[47.42924343237277,0.7069751416861101],[47.428974261542216,0.7075075865283231],[47.42897389327305,0.7075083149988473],[47.42860341692609,0.7078849960017768],[47.42823294057912,0.7082616770047062],[47.427862464232156,0.7086383580076357],[47.42749198788519,0.7090150390105652],[47.427121511538225,0.7093917200134947],[47.42675103519126,0.7097684010164242],[47.42638055884429,0.7101450820193537],[47.42601008249733,0.7105217630222832],[47.42563960615036,0.7108984440252126],[47.4252691298034,0.7112751250281422] 
,[47.42489865345643,0.7116518060310717],[47.42473580667453,0.7118173801348746],[47.42441595071563,0.7122845121727553],[47.42409609475672,0.712751644210636],[47.42377623879781,0.7132187762485167],[47.4234563828389,0.7136859082863973],[47.42313652687999,0.7141530403242781],[47.42281667092109,0.7146201723621587],[47.42267788433381,0.7148228625404727],[47.42228243846729,0.7151392209999191],[47.42188699260077,0.7154555794593654],[47.42149154673425,0.7157719379188119],[47.42109610086773,0.7160882963782583],[47.42070065500121,0.7164046548377047],[47.42030520913469,0.7167210132971511],[47.420007365178094,0.7169592897927259],[47.41957502734688,0.7171419625872921],[47.41914268951566,0.7173246353818583],[47.418710351684446,0.7175073081764244],[47.41827801385323,0.7176899809709906] 
,[47.41784567602201,0.7178726537655568],[47.4174133381908,0.7180553265601229],[47.416981000359584,0.718237999354689],[47.41654866252836,0.7184206721492552],[47.41611632469715,0.7186033449438214],[47.415683986865936,0.7187860177383876],[47.41534444449738,0.7189294822905481],[47.41492763341231,0.7191787956871472],[47.41451082232725,0.7194281090837463],[47.414094011242184,0.7196774224803454],[47.413677200157125,0.7199267358769444],[47.41326038907206,0.7201760492735436],[47.412843577987,0.7204253626701427],[47.41274991534971,0.7204813864926223],[47.412302795143646,0.7205519095693258],[47.411855674937584,0.7206224326460292],[47.41140855473153,0.7206929557227327],[47.41096143452547,0.7207634787994361],[47.41051431431941,0.7208340018761397],[47.410067194113346,0.7209045249528431] 
,[47.409620073907284,0.7209750480295466],[47.40917295370123,0.7210455711062501],[47.40872583349517,0.7211160941829535],[47.40827871328911,0.721186617259657],[47.407831593083046,0.7212571403363605],[47.407384472876984,0.721327663413064],[47.40725156209331,0.7213486270762246],[47.406830532201816,0.7215819131269862],[47.40640950231033,0.7218151991777477],[47.40598847241884,0.7220484852285093],[47.40576876182561,0.7221702234177485],[47.40540285827703,0.7225563849630422],[47.405036954728445,0.7229425465083359],[47.40467105117986,0.7233287080536296],[47.40430514763128,0.7237148695989234],[47.40393924408269,0.7241010311442171],[47.40382252312864,0.7242242142731072],[47.40358722987435,0.7236580717334673],[47.403351936620055,0.7230919291938274],[47.40311664336577,0.7225257866541875] 
,[47.40288135011148,0.7219596441145476],[47.402646056857186,0.7213935015749077],[47.402410763602894,0.7208273590352677],[47.4023545758746,0.7206921649206208],[47.40226758550492,0.7200403729976411],[47.40218059513524,0.7193885810746613],[47.40209360476557,0.7187367891516816],[47.402006614395894,0.7180849972287019],[47.40191962402621,0.7174332053057221],[47.40183263365654,0.7167814133827424],[47.401745643286866,0.7161296214597627],[47.40166831910122,0.7155502552627695],[47.40149587219645,0.7151198649719674],[47.40152017235038,0.7144564992227391],[47.40154447250432,0.7137931334735108],[47.40156877265825,0.7131297677242824],[47.40159307281218,0.7124664019750541],[47.40161249243502,0.7119362690101809],[47.40122001450113,0.7116120734960091],[47.400827536567235,0.7112878779818371] 
,[47.40043505863334,0.7109636824676653],[47.40004258069945,0.7106394869534933],[47.399650102765555,0.7103152914393215],[47.39925762483166,0.7099910959251495],[47.39886514689777,0.7096669004109777],[47.398472668963876,0.7093427048968057],[47.39808019102998,0.7090185093826339],[47.39768771309609,0.7086943138684619],[47.3972952351622,0.7083701183542901],[47.396902757228304,0.7080459228401181],[47.39688863244322,0.7080342554530716],[47.3968822106136,0.7086984642412039],[47.39687578878397,0.7093626730293362],[47.39686936695435,0.7100268818174684],[47.396862945124724,0.7106910906056007],[47.3968565232951,0.7113552993937329],[47.396850101465475,0.7120195081818652],[47.39684367963585,0.7126837169699974],[47.396837257806226,0.7133479257581297],[47.3968308359766,0.714012134546262] 
,[47.39682441414698,0.7146763433343942],[47.39681799231735,0.7153405521225265],[47.39681157048773,0.7160047609106587],[47.3968051486581,0.716668969698791],[47.39679872682848,0.7173331784869232],[47.396792304998854,0.7179973872750555],[47.39678588316923,0.7186615960631878],[47.396779461339605,0.71932580485132],[47.39677303950998,0.7199900136394523],[47.396766617680356,0.7206542224275845],[47.39676019585073,0.7213184312157168],[47.39675377402111,0.721982640003849],[47.396747352191475,0.7226468487919813],[47.39674093036185,0.7233110575801136],[47.39673450853223,0.7239752663682458],[47.3967280867026,0.724639475156378],[47.39672166487298,0.7253036839445103],[47.39671524304335,0.7259678927326426],[47.39670882121373,0.7266321015207748],[47.396702399384104,0.7272963103089071] 
,[47.3966996412141,0.7275815873818487],[47.39630688224441,0.7272581562523653],[47.39591412327472,0.7269347251228818],[47.39552136430503,0.7266112939933984],[47.395128605335344,0.7262878628639149],[47.39505224614123,0.7262249822111357],[47.394627203323246,0.7260082140829712],[47.39420216050526,0.7257914459548068],[47.39377711768728,0.7255746778266423],[47.393574468581136,0.7254713285508672],[47.393125124124964,0.7254464375247289],[47.3926757796688,0.7254215464985908],[47.39222643521263,0.7253966554724526],[47.39216702285273,0.7253933643789878],[47.39172098061207,0.7254774517030889],[47.39127493837141,0.7255615390271899],[47.39082889613075,0.725645626351291],[47.39067786271204,0.7256740989820685],[47.390248465261976,0.725871234734759],[47.38981906781192,0.7260683704874494] 
,[47.38964499233481,0.7261482882890107],[47.38922899197162,0.7264004070015668],[47.38881299160844,0.7266525257141229],[47.38839699124525,0.726904644426679],[47.38798099088206,0.7271567631392352],[47.38756499051888,0.7274088818517912],[47.387148990155694,0.7276610005643473],[47.386732989792506,0.7279131192769035],[47.386316989429325,0.7281652379894595],[47.38590098906614,0.7284173567020157],[47.38548498870295,0.7286694754145718],[47.38506898833977,0.7289215941271279],[47.38465298797658,0.729173712839684],[47.38423698761339,0.7294258315522402],[47.38382098725021,0.7296779502647962],[47.38340498688702,0.7299300689773524],[47.382988986523834,0.7301821876899085],[47.38257298616065,0.7304343064024645],[47.382315903468225,0.7305901124141201],[47.38187024978955,0.7305016582766976] 
,[47.38161475664003,0.7304509475404473],[47.38117174616449,0.7305647313945076],[47.38072873568894,0.730678515248568],[47.38042209123131,0.7307572745333744],[47.3803836407923,0.7300956381033772],[47.3803451903533,0.7294340016733801],[47.380306739914296,0.728772365243383],[47.38026828947529,0.7281107288133858],[47.38022983903629,0.7274490923833887],[47.38019138859728,0.7267874559533916],[47.380182926667544,0.72664184718721],[47.380103029915,0.7259883481719897],[47.38002313316245,0.7253348491567694],[47.37995416118238,0.7247707070656304],[47.379784108203125,0.7241559784278124],[47.37961405522387,0.7235412497899946],[47.37944400224461,0.7229265211521766],[47.379273949265354,0.7223117925143587],[47.3791038962861,0.7216970638765408],[47.37893384330683,0.7210823352387229] 
,[47.378763790327575,0.7204676066009049],[47.37859373734832,0.7198528779630871],[47.37842368436906,0.7192381493252691],[47.3782536313898,0.7186234206874511],[47.378083578410546,0.7180086920496332],[47.37791352543129,0.7173939634118153],[47.37774347245203,0.7167792347739974],[47.377573419472775,0.7161645061361794],[47.37740336649352,0.7155497774983616],[47.37723331351425,0.7149350488605436],[47.37708570969147,0.714401472222761],[47.37664626374408,0.7145421965826205],[47.37620681779669,0.7146829209424801],[47.3757673718493,0.7148236453023397],[47.37532792590191,0.7149643696621991],[47.37488847995452,0.7151050940220587],[47.37444903400713,0.7152458183819183],[47.374009588059735,0.7153865427417778],[47.37399148077262,0.715392341262401],[47.37354187066493,0.7154022500270856] 
,[47.37309226055725,0.7154121587917701],[47.37264265044956,0.7154220675564545],[47.37219304034188,0.7154319763211391],[47.37174343023419,0.7154418850858236],[47.37129382012651,0.7154517938505082],[47.370844210018824,0.7154617026151927],[47.37039459991114,0.7154716113798771],[47.36994498980346,0.7154815201445617],[47.36953223390822,0.7154906166950354],[47.369096838152714,0.7153247208973463],[47.36866144239721,0.7151588250996573],[47.368226046641716,0.7149929293019682],[47.367790650886214,0.7148270335042791],[47.36735525513071,0.7146611377065901],[47.36691985937521,0.714495241908901],[47.366484463619706,0.7143293461112119],[47.36604906786421,0.7141634503135228],[47.36561367210871,0.7139975545158338],[47.36540543076728,0.713918209774846],[47.36531462864375,0.7132680161107827] 
,[47.36522382652022,0.7126178224467195],[47.36513302439669,0.7119676287826562],[47.36504222227315,0.7113174351185928],[47.36495142014962,0.7106672414545295],[47.36486061802609,0.7100170477904663],[47.36476981590256,0.709366854126403],[47.36467901377903,0.7087166604623397],[47.3645882116555,0.7080664667982765],[47.364497409531964,0.7074162731342131],[47.364406607408434,0.7067660794701498],[47.3643158052849,0.7061158858060865],[47.36422500316137,0.7054656921420233],[47.36413420103784,0.70481549847796],[47.36404339891431,0.7041653048138967],[47.36395259679078,0.7035151111498333],[47.363861794667244,0.7028649174857701],[47.363770992543714,0.7022147238217068],[47.36368019042018,0.7015645301576435],[47.3636477127188,0.701331971767587],[47.36369620290284,0.7006719831027547] 
,[47.36374469308688,0.7000119944379223],[47.363778966371,0.6995455087052846],[47.36420739616538,0.6993439299383111],[47.36463582595976,0.6991423511713374],[47.36475537857115,0.699086100956464],[47.3645177598397,0.698522498270581],[47.364280141108246,0.6979588955846981],[47.3640425223768,0.6973952928988152],[47.36380490364535,0.6968316902129323],[47.363681617859015,0.6965392713455856],[47.36349728484929,0.6959337604654479],[47.36331295183956,0.69532824958531],[47.36312861882983,0.6947227387051723],[47.36297750060845,0.6942263342501747],[47.3629205074121,0.6935678400709272],[47.362863514215746,0.6929093458916797],[47.362806521019394,0.6922508517124323],[47.36274952782304,0.6915923575331848],[47.36269253462669,0.6909338633539374],[47.362635541430336,0.6902753691746899] 
,[47.362578548233984,0.6896168749954424],[47.36257262893409,0.6895484839456856],[47.36302016375619,0.6896129519142895],[47.36337139234078,0.6896635468451109],[47.363582352844574,0.6890772832491253],[47.363748063376704,0.6886167702587045],[47.363813585511586,0.6879599929363559],[47.36387910764647,0.6873032156140072],[47.36394462978135,0.6866464382916586],[47.36401015191623,0.6859896609693099],[47.364075674051115,0.6853328836469613],[47.364141196186,0.6846761063246127],[47.36416904546948,0.6843969521445956],[47.364111335919965,0.6837385772716872],[47.36405590011131,0.6831061421931963],[47.36389859840039,0.6824842271753487],[47.363741296689476,0.6818623121575013],[47.363583994978555,0.6812403971396537],[47.36350216460252,0.6809168689372314],[47.3635698123781,0.6802605651549428] 
,[47.36363746015368,0.6796042613726543],[47.36370510792926,0.6789479575903657],[47.36377275570485,0.6782916538080771],[47.363830652470284,0.6777299521732232],[47.364086859621324,0.6771843901604744],[47.36431868781102,0.6766907401851654],[47.36461251882419,0.6761882090350617],[47.364906349837355,0.6756856778849579],[47.365200180850515,0.6751831467348542],[47.36526658970638,0.6750695694839237],[47.36569818755233,0.6752558545123024],[47.36612978539829,0.6754421395406811],[47.366561383244246,0.6756284245690598],[47.3669929810902,0.6758147095974385],[47.36742457893616,0.6760009946258172],[47.36785617678211,0.6761872796541959],[47.36828777462807,0.6763735646825746],[47.368719372474025,0.6765598497109533],[47.36915097031998,0.676746134739332],[47.36958256816594,0.6769324197677107] 
,[47.37001416601189,0.6771187047960894],[47.370445763857845,0.6773049898244681],[47.370877361703805,0.6774912748528468],[47.37130895954976,0.6776775598812255],[47.37174055739571,0.6778638449096042],[47.37217215524167,0.6780501299379829],[47.372603753087624,0.6782364149663616],[47.373035350933584,0.6784226999947403],[47.37346694877954,0.678608985023119],[47.37369392097247,0.6787069501121437],[47.37378355322017,0.6780562781178717],[47.37387318546787,0.6774056061235997],[47.373962817715565,0.6767549341293277],[47.374052449963266,0.6761042621350558],[47.374142082210966,0.6754535901407839],[47.374231714458666,0.6748029181465118],[47.37432134670636,0.6741522461522399],[47.37441097895406,0.673501574157968],[47.37450061120176,0.672850902163696],[47.37459024344946,0.672200230169424] 
,[47.374679875697154,0.671549558175152],[47.374769507944855,0.6708988861808801],[47.374859140192555,0.6702482141866081],[47.374948772440256,0.6695975421923361],[47.375038404687956,0.6689468701980642],[47.37512803693565,0.6682961982037923],[47.37521766918335,0.6676455262095202],[47.37530730143105,0.6669948542152483],[47.37539693367875,0.6663441822209764],[47.375486565926444,0.6656935102267043],[47.37556132097899,0.6651508370218266],[47.3756560894415,0.6645017399738781],[47.37575085790401,0.6638526429259294],[47.37584562636653,0.6632035458779808],[47.37594039482904,0.6625544488300321],[47.37597308773968,0.6623305254780405],[47.375891516938424,0.661677531305951],[47.375809946137174,0.6610245371338613],[47.37572837533592,0.6603715429617718],[47.37564680453467,0.6597185487896822] 
,[47.37556523373341,0.6590655546175926],[47.375492443365914,0.6584828499606488],[47.37551383152343,0.6578195929481746],[47.37553521968094,0.6571563359357003],[47.37554303771691,0.656913894894501],[47.3756432331581,0.6562665765573099],[47.37574342859929,0.6556192582201187],[47.375843624040485,0.6549719398829276],[47.37594381948168,0.6543246215457363],[47.37604401492287,0.6536773032085452],[47.37614421036407,0.653029984871354],[47.3761501661418,0.6529915072311212],[47.37612713691249,0.6523283626922108],[47.37610410768318,0.6516652181533005],[47.376099572373306,0.6515346203840693],[47.376455983803694,0.6511297577816504],[47.37681239523408,0.6507248951792314],[47.37716880666448,0.6503200325768125],[47.377414994575446,0.6500403774652739],[47.37784508438562,0.64984660565262] 
,[47.3782751741958,0.6496528338399661],[47.37870526400597,0.6494590620273123],[47.37890745310446,0.6493679681506705],[47.37935512556164,0.6494303383501875],[47.379802798018815,0.6494927085497044],[47.38024810017089,0.6495547485158113],[47.38066962298102,0.6497859738802046],[47.381091145791146,0.6500171992445979],[47.381512668601275,0.6502484246089912],[47.3819341914114,0.6504796499733845],[47.38235571422153,0.6507108753377778],[47.38277723703166,0.6509421007021711],[47.38290399840861,0.6510116353628632],[47.383352249181456,0.650959093303714],[47.383800499954305,0.6509065512445649],[47.38424875072715,0.6508540091854157],[47.3844974731293,0.6508248549977225],[47.38492749329553,0.6506307128776518],[47.385357513461756,0.6504365707575812],[47.38578753362798,0.6502424286375106] 
,[47.38621755379421,0.65004828651744],[47.386647573960445,0.6498541443973693],[47.38707759412667,0.6496600022772987],[47.3875076142929,0.6494658601572281],[47.38793763445913,0.6492717180371574],[47.388367654625355,0.6490775759170868],[47.38879767479158,0.6488834337970163],[47.38922769495781,0.6486892916769457],[47.38965771512404,0.648495149556875],[47.390087735290265,0.6483010074368044],[47.390133945925356,0.6482801446229871],[47.390575413227246,0.648153929506369],[47.39101688052913,0.6480277143897507],[47.39145834783102,0.6479014992731326],[47.3918998151329,0.6477752841565144],[47.39234128243479,0.6476490690398963],[47.392782749736675,0.647522853923278],[47.393224217038565,0.6473966388066599],[47.39345471363956,0.6473307400294459],[47.39350899169679,0.6475928855649329]]
				
				
				document.getElementById('1111').addEventListener('click', function(e) {
					if (e.target.attributes[1].nodeValue != 1111)
					{
						myNode2 = document.getElementById("group1"); while (myNode2.firstChild) { myNode2.removeChild(myNode2.lastChild); }
						document.forms["MyForm"]["jour"].hidden=false;
						document.forms["MyForm"]["jour"].value=document.getElementsByClassName("current-date")[0].innerText+"-"+e.target.innerText;
						test=(e.target.attributes[1].nodeValue).split(";");
						for (let i = 0; i<test.length; i++){
							document.getElementById('group1').innerHTML=document.getElementById('group1').innerHTML+'<div><input type="radio" id="'+test[i]+'" name="creneau" value="'+test[i]+'"=""><label class=\"label\" for="'+test[i]+'">'+test[i]+'</label></div>'
						}
						myFunction2();
					}
				});
				
				document.getElementById("group5").addEventListener("change", function(e) {
					if (document.forms["MyForm"]["statut"].value == "2")
					{
						document.getElementById("densoc_line").hidden=false;
						document.getElementById("siren_line").hidden=false;
					}
					if (document.forms["MyForm"]["statut"].value == "1")
					{
						document.getElementById("densoc_line").hidden=true;
						document.getElementById("siren_line").hidden=true;
					}
				});
				
				//https://www.algorithms-and-technologies.com/point_in_polygon/javascript
				function point_in_polygon(polygon, point) {
					let odd = false;
					for (let i = 0, j = polygon.length - 1; i < polygon.length; i++) {
						if (((polygon[i][1] >= point[1]) !== (polygon[j][1] >= point[1]))
							&& (point[0] <= ((polygon[j][0] - polygon[i][0]) * (point[1] - polygon[i][1]) / (polygon[j][1] - polygon[i][1]) + polygon[i][0]))) {
							odd = !odd;
						}
						j = i;
					}
					return odd;
				};
				
				//https://operations.osmfoundation.org/policies/nominatim/
				//https://fr.javascript.info/xmlhttprequest
				//https://developer.mozilla.org/fr/docs/Web/API/XMLHttpRequest/setRequestHeader
				//https://stackoverflow.com/questions/71126964/unable-to-get-json-data-from-nominatims-api
				
				/*
				DESACTIVER ADBLOCK PERMET D'AUTHORISER LES REQUETES VERS OSM
				ET EVITER Cross-Origin Request Blocked: The Same Origin Policy disallows reading the remote resource
				XHR - Console Firefox
				
				xhr.open('GET', , true);
				xhr.setRequestHeader()
				xhr.responseType = 'json';
				xhr.onload = function() {
				xhr.send(null);
				*/
				
				function findAdress(){
					var XHR = new XMLHttpRequest();
					XHR.onreadystatechange = function () {
						if (XHR.readyState == 4 && XHR.status == 200) {
							//console.log(XHR.response);
							var json = JSON.parse(XHR.response);
							document.getElementById('group6').innerHTML="";
						        for (let i = 0; i<json.length; i++){
								//console.log(i + "\n\t" + json[i].display_name + "\n\t" + "https://www.openstreetmap.org/node/" + json[i].osm_id + "\n\t" + json[i].lat + "\n\t" + json[i].lon);
								document.getElementById('group6').innerHTML=document.getElementById('group6').innerHTML+'<div><input type="radio" id="'+i+'" name="gps" value="'+json[i].lat+"-"+json[i].lon+'"=""><label for="'+i+'">'+json[i].display_name+'</label></div>';
							}
						} else { document.getElementById('group6').innerHTML="<p style=\"color:black;\">Veuillez correctement renseigner l'adresse, le code postal et la ville.</p>"; }
					};
					XHR.open("GET", ("https://nominatim.openstreetmap.org/search?countrycodes=FR&street="+document.forms["MyForm"]["adresse"].value.replace(" ","%20")+"&postalcode="+document.forms["MyForm"]["code_postal"].value+"&country=FR&format=json&limit=5"));
					XHR.send();
				}
				function check(){
					if (document.forms["MyForm"]["lieux_service"].value == "1" && document.forms["MyForm"]["adresse"].value != "" && document.forms["MyForm"]["code_postal"].value != "" && document.forms["MyForm"]["ville"].value != "") {
						findAdress();
					} else {
						if (typeof(document.forms["MyForm"]["gps"]) != "undefined") { document.forms["MyForm"]["gps"].value=""; }
						document.getElementById('group6').innerHTML="Veuillez correctement renseigner l'adresse, le code postal et la ville.";
					}
				}
				document.getElementById("group4").addEventListener("change", function(e) {
					if (document.forms["MyForm"]["lieux_service"].value == "1")
					{
						document.getElementById("osm_line").hidden=false;
						check();
					}
					if (document.forms["MyForm"]["lieux_service"].value == "2") { document.getElementById("osm_line").hidden=true; }
					
				});
				document.getElementById("adresse").addEventListener('focusout', function(e) {
					check();
				});
				document.getElementById("ville").addEventListener('focusout', function(e) {
					check();
				});
				document.getElementById("button").addEventListener("click", function(e) {
					if (myFunction2()) {
						form=document.getElementById('MyForm');
						if (document.forms["MyForm"]["commentaire"].value == "") {form["commentaire"].value = "vide";}
						
						form.action='';
						var input = document.createElement('input');
						input.setAttribute('type','text');
						input.setAttribute('name','post_button');
						input.setAttribute('value', 'test');
						form.appendChild(input);
						
						var input = document.createElement('input');
						input.setAttribute('type','text');
						input.setAttribute('name','creneau');
						input.setAttribute('value', document.forms["MyForm"]["creneau"].value);
						form.appendChild(input);
						
						var input = document.createElement('input');
						input.setAttribute('type','text');
						input.setAttribute('name','statut');
						input.setAttribute('value', document.forms["MyForm"]["statut"].value);
						form.appendChild(input);

        					form.submit();
					}
					else {
						alert("Une des entrées n'est pas correcte. Veuillez la corriger.");
					}
				});
				function verifyInput(reg,formName,idvalue,idname,goodInput) {
					/*stringInput = document.forms[formName][idvalue].value;
                                        document.forms[formName][idvalue].value= stringInput +" ";
                                        document.forms[formName][idvalue].value= stringInput;*/
					if (reg.test(document.forms[formName][idname].value)) {
						document.getElementById(idvalue).style.backgroundColor='green';
						goodInput = goodInput && true;
					}
					else {
						document.getElementById(idvalue).style.backgroundColor='red';
						goodInput = false;
					}
					return goodInput;
				}
				function verifyInput_gps(formName,idvalue,idname,goodInput) {
					//document.getElementById("group6").addEventListener("change", function(e) {
					if (document.forms["MyForm"]["lieux_service"].value == "1")
					{
						if (typeof(document.forms[formName][idname]) != "undefined")
						{
							if (document.forms[formName][idname].value != "")
							{
								if(point_in_polygon(polygon,(document.forms[formName][idname].value.split("-")).map(function(str) { return parseFloat(str); }))) {
									document.getElementById(idvalue).style.backgroundColor="green";
									goodInput = goodInput && true;
								} else {
									document.getElementById(idvalue).style.backgroundColor="red";
									goodInput = false;
									alert("L'adresse n'est pas desservie par R2i-Grout");
								}
							} else {
								document.getElementById(idvalue).style.backgroundColor="red";
								goodInput = false;
							}
						} else { goodInput = false; }
					} else { goodInput = true; }
					return goodInput;
					//});
				}
				function verifyInput_checkbox(reg,formName,idvalue,idname,goodInput) {
					stringInput = document.forms[formName][idvalue].value;
					if (document.getElementById(idvalue).checked) {
						document.getElementById(idvalue).labels[0].style.backgroundColor="green"
						goodInput = goodInput && true;
					}
					else {
						document.getElementById(idvalue).labels[0].style.backgroundColor="red"
						goodInput = false;
					}
					return goodInput;
				}
				function myFunction2() {
					goodInput = true;
					goodInput = verifyInput(/^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$/,"MyForm","jour","jour",goodInput);
					if (document.forms["MyForm"]["jour"].value != "") { goodInput = verifyInput(/^[0-9]{2}:[0-9]{2}\-[0-9]{2}:[0-9]{2}$/,"MyForm","group1","creneau",goodInput); }
					console.log(document.forms["MyForm"]);
					goodInput = verifyInput(/^M|Mme$/,"MyForm","group2","civilite",goodInput);
					goodInput = verifyInput(/^1|2$/,"MyForm","group5","statut",goodInput);
					if (document.forms["MyForm"]["statut"].value == "2")
					{
						goodInput = verifyInput(/^[0-9]{9}$/,"MyForm","siren","siren",goodInput);
						goodInput = verifyInput(/^[0-9A-zÀ-ú \-_]{1,250}$/,"MyForm","densoc","densoc",goodInput);
					}
					goodInput = verifyInput(/^[1-4]$/,"MyForm","group3","service",goodInput);
					goodInput = verifyInput(/^1|2$/,"MyForm","group4","lieux_service",goodInput);
					goodInput = verifyInput(/[A-zÀ-ú\- ]{1,100}/,"MyForm","nom","nom",goodInput);
					goodInput = verifyInput(/[A-zÀ-ú\- ]{1,100}/,"MyForm","prenom","prenom",goodInput);
					goodInput = verifyInput(/^[0-9]{10}$/,"MyForm","tel","tel",goodInput);
					goodInput = verifyInput(/\S+@\S+\.\S+/,"MyForm","email","email",goodInput);
					goodInput = verifyInput(/[A-zÀ-ú0-9]{1,100}/,"MyForm","adresse","adresse",goodInput);
					goodInput = verifyInput(/[A-z\-À-ú ]{1,50}/,"MyForm","ville","ville",goodInput); 
					goodInput = verifyInput(/^[0-9]{5}$/,"MyForm","code_postal","code_postal",goodInput);
					goodInput = verifyInput_gps("MyForm","group6","gps",goodInput);
					goodInput = verifyInput(/^[À-úA-z\-\.:;\?\'\"\n 0-9<>]{0,100}$/,"MyForm","commentaire","commentaire",goodInput);
					goodInput = verifyInput_checkbox(/^on$/,"MyForm","acceptation_cgv","acceptation_cgv",goodInput);
					goodInput = verifyInput_checkbox(/^on$/,"MyForm","consentement_rgpd","consentement_rgpd",goodInput);
					return goodInput;
				}
			</script>
			<?php
				function SQL_to_HTML($arrayString) {
					$str_echo ="			<tr>
";
					for ($y = 0; $y < sizeof($arrayString);$y++)
					{
						$str_echo = $str_echo."				<td>".$arrayString[$y]."</td>
";
					}
					$str_echo = $str_echo."			</tr>
";
					echo $str_echo;
				}
				if (!empty($_POST)) {
					if (!empty($_POST['post_button']))
					{
						#var_export($_POST);
						#echo 'CONFI=['.(var_export($confi, true)).']<br>';
						$confi=TRUE;
						$jour="";$creneau="";$civilite="";$service="";$lieux_service="";$nom="";$prenom="";$adresse="";$code_postal="";$ville="";$statut="";$densoc="";$siren="";
						if (!empty($_POST['jour'])) {
							$jour=filter_var($_POST['jour'],FILTER_SANITIZE_STRING);
							if (strtotime($jour)) { $confi = $confi AND TRUE;}
							else {$confi = FALSE; }
						} else { $confi = FALSE;}
						if (!empty($_POST["creneau"])) {
							$creneau=filter_var($_POST['creneau'],FILTER_SANITIZE_STRING);
							$creneau=explode('-',$creneau);
							if (strtotime($creneau[0]) && strtotime($creneau[1])) { $confi = $confi AND TRUE; }
							else { $confi = FALSE;  }
						} else { $confi = FALSE; echo 'creneau=['.(var_export($creneau, true)).']<br>';}
						if (!empty($_POST["civilite"])) {
							$civilite=filter_var($_POST['civilite'],FILTER_SANITIZE_STRING);
							if(in_array($civilite,array("M","Mme"),TRUE)) {$confi = $confi AND TRUE;}
							else {$confi = FALSE; }
						} else { $confi = FALSE;}
						if (!empty($_POST["statut"])) {
							$statut=filter_var($_POST['statut'],FILTER_SANITIZE_STRING);
							if(in_array($statut,array("1","2"),TRUE)) {$confi = $confi AND TRUE;}
							else {$confi = FALSE; }
							if ($_POST["statut"] == "2")
							{
								if (!empty($_POST["densoc"])) {
									$densoc=filter_var($_POST['densoc'],FILTER_SANITIZE_STRING);
									if (preg_match("/^[0-9A-zÀ-ú \-_]+$/",$densoc)) { $confi = $confi AND TRUE; }
									else { $confi = FALSE; }
								} else { $confi = FALSE;}
								if (!empty($_POST["siren"])) {
									$siren=filter_var($_POST['siren'],FILTER_VALIDATE_INT);
									if (preg_match("/^[0-9]{9}$/",$siren)) { $confi = $confi AND TRUE; }
									else { $confi = FALSE; }
									$confi = $confi AND TRUE;
								} else { $confi = FALSE;}
							}
						} else { $confi = FALSE;}
						if (!empty($_POST["service"])) {
							$service=filter_var($_POST['service'],FILTER_SANITIZE_STRING);
							if(in_array($service,array("1","2","3","4"),TRUE)) { $confi = $confi AND TRUE; }
							else {$confi = FALSE; }
						} else { $confi = FALSE;}
						if (!empty($_POST["lieux_service"])) {
							$lieux_service=filter_var($_POST['lieux_service'],FILTER_SANITIZE_STRING);
							if(in_array($lieux_service,array("1","2"),TRUE)) { $confi = $confi AND TRUE; }
							else {$confi = FALSE;}
							
							#if ($_POST["lieux_service"] == "1")
							#{
							#	osm_id ? + BDD ?	
							#}
						} else { $confi = FALSE;}
						if (!empty($_POST["nom"])) {
							$nom=filter_var($_POST['nom'],FILTER_SANITIZE_STRING);
							#htmlspecialchars($_POST["nom"])
							$confi = $confi AND TRUE;
						} else { $confi = FALSE;}
						if (!empty($_POST["prenom"])) {
							$prenom=filter_var($_POST['prenom'],FILTER_SANITIZE_STRING);
							$confi = $confi AND TRUE;
						} else { $confi = FALSE;}
						if (!empty($_POST["email"])) {
							$email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
							$confi = $confi AND TRUE;
						} else { $confi = FALSE;}
						if (!empty($_POST["tel"])) {
							$tel=filter_var($_POST['tel'],FILTER_SANITIZE_STRING);
							if (preg_match("/[0-9]{10}/",$tel)) { $confi = $confi AND TRUE; }
							else { $confi = FALSE; }
						} else { $confi = FALSE;}
						if (!empty($_POST["adresse"])) {
							$adresse=filter_var($_POST['adresse'],FILTER_SANITIZE_STRING);
							$confi = $confi AND TRUE;
						} else { $confi = FALSE;}
						if (!empty($_POST["code_postal"])) {
							$code_postal=filter_var($_POST['code_postal'],FILTER_VALIDATE_INT);
							if (preg_match("/[0-9]{5}/",$code_postal)) { $confi = $confi AND TRUE; }
							else { $confi = FALSE; }
							$confi = $confi AND TRUE;
						} else { $confi = FALSE;}
						if (!empty($_POST["ville"])) {
							$ville=filter_var($_POST['ville'],FILTER_SANITIZE_STRING);
							$confi = $confi AND TRUE;
						} else { $confi = FALSE;}
						if (!empty($_POST["commentaire"])) {
							$commentaire=filter_var($_POST['commentaire'],FILTER_SANITIZE_STRING);
							$confi = $confi AND TRUE;
						} else { $commentaire = ""; $confi = $confi AND TRUE;}
						if (!empty($_POST['acceptation_cgv'])) {
							$acceptation_cgv=filter_var($_POST['acceptation_cgv'], FILTER_VALIDATE_BOOLEAN);
							$confi = $confi AND TRUE;
						} else { $commentaire = ""; $confi = $confi AND TRUE;}
						if (!empty($_POST['consentement_rgpd'])) {
							$consentement_rgpd=filter_var($_POST['consentement_rgpd'], FILTER_VALIDATE_BOOLEAN);
							$confi = $confi AND TRUE;
						} else { $commentaire = ""; $confi = $confi AND TRUE;}
						#echo 'CONFIRMATION<br/>STATUT=['.$statut.']<br/>DENSOC=['.$densoc.']<br/>SIREN=['.$siren.']<br/>JOUR=['.$jour.']<br/>CRENEAU=['.$creneau[0].']-['.$creneau[1].']<br/>CIVILITE=['.$civilite.']<br/>SERVICE=['.$service.']<br/>lieux_service=['.$lieux_service.']<br/>NOM=['.$nom.']<br/>PRENOM=['.$prenom.']<br/>EMAIL=['.$email.']<br/>TEL=['.$tel.']<br/>ADRESSE=['.$adresse.']<br/>CODE=['.$code_postal.']<br/>VILLE=['.$ville.']<br/>COMMENTAIRE=['.$commentaire.']<br/>ACCEPTATION_CGV=['.$acceptation_cgv.']<br/>CONSENTEMENT_RGPD=['.$consentement_rgpd.']<br/>';
						if ($confi) {
							if ($_POST["statut"] == "1")
							{
								$densoc="3";
								$siren="3";
								
							}
							$result=$link->exec('UPDATE '.$nomtablecreneau.' SET date_creneau_reserve=CURRENT_TIMESTAMP,evt_demande_confirmation=1,evt_confirmation=0,confirmation=0,expire_hash=CURRENT_TIMESTAMP,hash_confirmation=SHA2(CONCAT(id,CURRENT_TIMESTAMP,HEX(RANDOM_BYTES(8))),256),evt_annulation_perso=0,evt_annulation_client=0,statut=\''.$statut.'\',densoc=\''.$densoc.'\',siren=\''.$siren.'\',civilite=\''.$civilite.'\',nom=\''.$nom.'\',prenom=\''.$prenom.'\',numero_telephone=\''.$tel.'\',email=\''.$email.'\',adresse=\''.$adresse.'\',code_postal=\''.$code_postal.'\',ville=\''.$ville.'\',service=\''.$service.'\',lieux_service=\''.$lieux_service.'\',commentaire=\''.$commentaire.'\',hash_annulation_client=NULL, hash_annulation_perso=NULL,acceptation_cgv=\''.$acceptation_cgv.'\',consentement_rgpd=\''.$consentement_rgpd.'\' WHERE date_creneau = \''.$jour.'\' AND heure_creneau_debut = \''.$creneau[0].'\' AND heure_creneau_fin = \''.$creneau[1].'\' AND creneau_reservable = 1 AND length(nom) IS NULL AND STR_TO_DATE(CONCAT(date_creneau,\' \',heure_creneau_debut),\'%Y-%m-%d %H:%i:%S\') >= ADDDATE(CURRENT_TIMESTAMP, INTERVAL 60 MINUTE)');
							
							print_r($result);
							if ($result > 0) {
								echo '<p>Demande de réservation envoyée. Vous allez recevoir un mail de confirmation prochainement.</p>';
							} else if ($result == 0) {
								echo '<p>Le lien a expiré.</p>';
							} else {
								echo '<p>Erreur lors de l\'envoi [A4].</p>';
							}
							#echo shell_exec("echo $(date +%Y/%m/%d-%H:%M:%S) =\> ".str_replace(array("(",")",">",":civ",":nom",":pre",":num"),array("\(","\)","\>",$civilite,$nom,$prenom,$tel),$sql4)." >> /var/www/html/test_log.txt");
						} else {
							echo '<p>Erreur lors de l\'envoi [A5].</p>';
						}
					}
				}
				if (!empty($_GET['confirmation']))
				{
					$confirmation=filter_var($_GET['confirmation'],FILTER_SANITIZE_STRING);
					if(preg_match("/[a-z0-9]{64}/",$confirmation)) {
						$result = $link->exec('UPDATE '.$nomtablecreneau.' SET confirmation=1,evt_confirmation=1,hash_confirmation=NULL,hash_annulation_client=SHA2(concat(numero_telephone,id,CURRENT_DATE,CURRENT_TIME),256), hash_annulation_perso=SHA2(CONCAT(id,HEX(RANDOM_BYTES(8))),256) WHERE confirmation=0 AND hash_confirmation="'.$confirmation.'"');
						print_r($result);
						if ($result > 0) {
							echo '<p>La demande de réservation de créneau est bien confirmée.<br>L\'acceptation du devis est validée</p>';
						}  else if ($result == 0) {
							echo '<p>Le lien a expiré.</p>';
						} else {
							echo '<p>Erreur lors de l\'envoi.</p>';
						}
					}
				}
				if (!empty($_GET['token'])) {
					$token=filter_var($_GET['token'],FILTER_SANITIZE_STRING);
					print_r($result);
					if(preg_match("/[a-z0-9]{64}/",$token)) {
						$result= $link->exec('UPDATE '.$nomtablecreneau.' SET evt_annulation_client = 1 WHERE hash_annulation_client = "'.$token.'" AND evt_annulation_client=0 AND date_creneau >= CURRENT_DATE AND STR_TO_DATE(CONCAT(date_creneau,\' \',heure_creneau_debut),\'%Y-%m-%d %H:%i:%S\') >= ADDDATE(CURRENT_TIMESTAMP, INTERVAL 60 MINUTE)');
						if ($result > 0)
						{
							echo '<p>La demande d\'annulation de votre rendez-vous à bien été pris en compte.</br>Vous allez recevoir un email de confirmation prochainement.</p>';
						}  else if ($result == 0) {
							echo '<p>Le lien a expiré.</p>';
						} else {
							echo '<p>Erreur lors de l\'envoi.</p>';
						}
					}
				}
				if (!empty($_SESSION['LAST_ACTIVITY']) and !empty($_GET[$adm_url])) {
					echo 'ADMINISTRATION<br/>
';
					echo "<table>";
					echo "<tr><td><a href=\"https://".$domainname."/".$rdv_filename."?".$adm_url."=".$_GET[$adm_url]."&annee=".$annee."&mois=".$mois."&req=1\" target=\"_self\" rel=\"noopener noreferrer\">Requête au quotidien</a></td></tr>
";
					echo "<tr><td><a href=\"https://".$domainname."/".$rdv_filename."?".$adm_url."=".$_GET[$adm_url]."&annee=".$annee."&mois=".$mois."&req=2\" target=\"_self\" rel=\"noopener noreferrer\">Requête historique par client</a></td></tr>
";
					echo "<tr><td><a href=\"https://".$domainname."/".$rdv_filename."?".$adm_url."=".$_GET[$adm_url]."&annee=".$annee."&mois=".$mois."&req=3\" target=\"_self\" rel=\"noopener noreferrer\">Requête tous les créneaux du mois => Changer pour créneau non-réservable</a></td></tr>
";
					echo "<tr><td><a href=\"https://".$domainname."/".$rdv_filename."?".$adm_url."=".$_GET[$adm_url]."&annee=".$anneePREV."&mois=".$moisPREV."&req=".$_GET['req']."\" target=\"_self\" rel=\"noopener noreferrer\">PREV</a></td></tr>
";
					echo "<tr><td><a href=\"https://".$domainname."/".$rdv_filename."?".$adm_url."=".$_GET[$adm_url]."&annee=".$anneeNEXT."&mois=".$moisNEXT."&req=".$_GET['req']."\" target=\"_self\" rel=\"noopener noreferrer\">NEXT</a></td></tr>
";
					echo "</table>";
					if ($_GET['req'] == "1") {
						$sql6='SELECT * FROM '.$nomtablecreneau.' WHERE LENGTH(nom) AND MONTH(date_creneau)='.$mois.' AND YEAR(date_creneau)='.$annee.' IS NOT NULL ORDER BY DATE_CRENEAU,HEURE_CRENEAU_DEBUT,HEURE_CRENEAU_FIN';
					}
					if ($_GET['req'] == "2") {
						$sql6='SELECT * FROM '.$nomtablecreneau.' WHERE CONCAT(nom,prenom,numero_telephone) REGEXP "'.$_GET['search'].'" ORDER BY numero_telephone,date_creneau,heure_creneau_debut';
					}
					if ($_GET['req'] == "3") {
						$sql6='SELECT id, DATE_CRENEAU,HEURE_CRENEAU_DEBUT,HEURE_CRENEAU_FIN,CRENEAU_RESERVABLE FROM '.$nomtablecreneau.' WHERE MONTH(date_creneau)='.$mois.' AND YEAR(date_creneau)=20'.$annee.' ORDER BY date_creneau,heure_creneau_debut';
					}
					if ($_GET['req'] == "4") {
						$sql6='UPDATE '.$nomtablecreneau.' SET EVT_ANNULATION_PERSO=1 WHERE EVT_ANNULATION_PERSO=0 AND HASH_ANNULATION_PERSO="'.$_GET['token_bis'].'"';
					}
					if ($_GET['req'] == "5") {
						$sql6='UPDATE '.$nomtablecreneau.' SET CRENEAU_RESERVABLE=NOT CRENEAU_RESERVABLE WHERE id='.$_GET['id'];
						echo $sql6;
					}
					if (($_GET['req'] == "1") or ($_GET['req'] == "2") or ($_GET['req'] == "3") or ($_GET['req'] == "4") or ($_GET['req'] == "5")) {	
						try {
							$statement6 = $link->prepare($sql6);
							$statement6->execute();
						}catch(PDOException $err){
							error_log($err->getMessage());
							exit('Something bad happened'); 
						}
					}
					if (($_GET['req'] == "1") or ($_GET['req'] == "2") or ($_GET['req'] == "3")) {
						echo "			<table style=\"border-style: solid;\">";
					}
					if ($_GET['req'] == "1") {
						while (($row2 = $statement6->fetch(PDO::FETCH_ASSOC)) !== false) {
							SQL_to_HTML(array(
								$row2['DATE_CRENEAU']." ".$row2['HEURE_CRENEAU_DEBUT']."-".$row2['HEURE_CRENEAU_FIN'],
								$row2['CRENEAU_RESERVABLE'],
								$row2['DATE_CRENEAU_RESERVE'],
								$row2['CIVILITE'],$row2['NOM'],$row2['PRENOM'],
								"<a href=\"tel:".$row2['NUMERO_TELEPHONE']."\">TEL</a>",
								"<a href=\"mailto:".$row2['EMAIL']."\">MAIL</a>",
								$row2['EVT_ANNULATION_PERSO'],
								"<a href=\"https://".$domainname."/".$rdv_filename."?".$adm_url."=".$_GET[$adm_url]."&req=4&token_bis=".$row2['HASH_ANNULATION_PERSO']."\" target=\"_blank\" rel=\"noopener noreferrer\">AN PERSO</a>",
								$row2['EVT_ANNULATION_CLIENT'],
								"<a href=\"https://".$domainname."/".$rdv_filename."?token=".$row2['HASH_ANNULATION_CLIENT']."\" target=\"_blank\" rel=\"noopener noreferrer\">AN CLIENT</a>",
								"<a href=\"https://www.openstreetmap.org/search?query=".str_replace(" ","%20",($row2['ADRESSE'].' '.$row2['VILLE'].' '.$row2['CODE_POSTAL']))."\" target=\"_blank\" rel=\"noopener noreferrer\">LOC</a>"
							));
						}
					}
					if ($_GET['req'] == "2") {
						while (($row2 = $statement6->fetch(PDO::FETCH_ASSOC)) !== false) {
							SQL_to_HTML(array(
								$row2['DATE_CRENEAU'],$row2['HEURE_CRENEAU_DEBUT'],$row2['HEURE_CRENEAU_FIN'],
								$row2['CRENEAU_RESERVABLE'],$row2['DATE_CRENEAU_RESERVE'],
								$row2['CIVILITE'],$row2['NOM'],$row2['PRENOM'],
								"<a href=\"tel:".$row2['NUMERO_TELEPHONE']."\">TEL</a>",
								"<a href=\"mailto:".$row2['EMAIL']."\">MAIL</a>",
								"<a href=\"https://www.openstreetmap.org/search?query=".str_replace(" ","%20",($row2['ADRESSE'].' '.$row2['VILLE'].' '.$row2['CODE_POSTAL']))."\" target=\"_blank\" rel=\"noopener noreferrer\">LOC</a>"
							));
						}
					}
					if ($_GET['req'] == "3") {
						while (($row2 = $statement6->fetch(PDO::FETCH_ASSOC)) !== false) {
							SQL_to_HTML(array(
								$row2['DATE_CRENEAU'],$row2['HEURE_CRENEAU_DEBUT'],$row2['HEURE_CRENEAU_FIN'],$row2['CRENEAU_RESERVABLE'],
								"<a href=\"https://".$domainname."/".$rdv_filename."?".$adm_url."=".$_GET[$adm_url]."&req=5&id=".$row2['id']."\">CHANGER ETAT</a>"
							));
						}
					}
					if ($_GET['req'] == "5") {
						header('Location: https://'.$domainname.'/'.$rdv_filename.'?'.$adm_url.'='.$_GET[$adm_url].'&req=3');
					}
					if (($_GET['req'] == "1") or ($_GET['req'] == "2") or ($_GET['req'] == "3")) {
						echo '			</table>';
					}
					$link=null;
				}
			?>
			</span>
	</body>
	<footer>
		<?php get_footer(); ?>
	</footer>
</html>
