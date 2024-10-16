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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Raphaël GROUT">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="RDV R2I-GROUT">
	<meta name="keywords" content="RDV, R2I-GROUT">
	<title>Formulaire d'enregistrement</title>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php'); wp_head(); get_header(); ?>
	<style>
		@media (min-width : 922px) {
                        .site-content .ast-container {
                                display: flex;
                        }
                }
                @media (max-width : 921px) {
                        .site-content .ast-container {
                                flex-direction: column;
                        }
                }
                div#content{
                        display :grid;
                }
                div.ast-container {
                        display : grid;
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
	</style>
</head>
<body>
<h1 style="color:red; text-align:center;">SYSTEME EN COURS DE TEST.<br> L'ENSEMBLE DES DONNEES RENTREES SERA SUPPRIME LE 31 OCTOBRE.<br>LE SYSTEME SERA EN PRODUCTION A PARTIR DU 1 NOVEMBRE</h1>
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

#https://www.php.net/manual/fr/session.configuration.php
#cat /dev/urandom  |hexdump
#print_r($_SESSION);

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
	if ((time() - $_SESSION['LAST_ACTIVITY'] > 60)) {
		#1800 s = 30 minutes = 30 * 60
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
	echo '							<li class="inactive">'.$dateMIN->format("d").'</li>
';
	$dateMIN->modify('+1 day');
}

$arrayJourTravaille = array(1,2,3,4,5);
$arrayCreneau = array(
	["09:00","10:00"],["10:00","11:00"],["11:00","12:00"],["13:00","14:00"],["14:00","15:00"],["15:00","16:00"],["16:00","17:00"]
);
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
	echo '							<li class="inactive">'.($dateMAXM->format("j")).'</li>
';
}

# php -f /var/www/html/mariadb.php
#echo '&ensp;'.$dateMAX->format("Y-m-d H:i:s").'<br/>';
#date_creneau = \'2020-07-03\' and heure_creneau_debut = \'09:00\' group by date_creneau';
#MONTH(date_creneau) = :mt and YEAR(date_creneau) = :yr and heure_creneau_debut = :hr
#$year = 2020 $hour='09:00';$date='2020-07-03';

#$test = (((new DateTime()))->setTimeZone(new DateTimeZone("Europe/Paris")))->format("Y-m-d H:i:s P");
#$test = ((new DateTime())->add(new DateInterval('PT3H')))->format("Y-m-d H:i:s");
#if (((new DateTime())->add(new DateInterval('PT3H'))) < (DateTimeImmutable::createFromFormat("Y-m-d H:i:s e","2024-04-23 16:00:00 +01:00"))) {echo 'YES<br/>';}else{echo 'NO<br/>';}
#echo (DateTimeImmutable::createFromFormat("Y-m-d H:i:s e","2024-04-21 05:40:39 +02:00")->format("Y-m-d H:i:s P")).'<br/>';

//sudo touch /var/www/html/test_log.txt
//sudo chown www-data:www-data /var/www/html/test_log.txt
//sudo ls -la /var/www/html/test_log.txt
#echo shell_exec('printenv;pwd;ls').'<br />';
#echo var_dump($_POST)."<br />";
?>

						</ul>
					</div>
				</div>
			</span>
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
										<input type="radio" id="repa" name="service" value="1" />
										<label class="label" for="repa">Installation de Linux</label>
									</div>
									<div>
										<input type="radio" id="recup" name="service" value="2" />
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
										<input type="radio" id="dom" name="endroit" value="dom" checked/>
										<label class="label" for="dom">A domicile</label>
									</div>
									<!-- <div>
										<input type="radio" id="par" name="endroit" value="par" disabled />
										<label class="label" for="par"><del>Chez moi au</del></label>
									</div> -->
								</fieldset>
							</td>
						</tr>
						<tr>
							<td class="cle">Nom</td>
							<?php echo "<td><input id=\"nom\" class=\"valeur input\" type=\"text\" name=\"nom\" value=\"".((!empty($_POST["nom"]))?$_POST["nom"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td class="cle">Prénom</td>
							<?php echo "<td><input id=\"prenom\" class=\"valeur input\" type=\"text\" name=\"prenom\" value=\"".((!empty($_POST["prenom"]))?$_POST["prenom"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td class="cle">Email</td>
							<?php echo "<td><input id=\"email\" class=\"valeur input\" type=\"text\" name=\"email\" value=\"".((!empty($_POST["email"]))?$_POST["email"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td class="cle">Téléphone</td>
							<?php echo "<td><input id=\"tel\" class=\"valeur input\" type=\"text\" name=\"tel\" value=\"".((!empty($_POST["tel"]))?$_POST["tel"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td id="c1" class="cle">Adresse</td>
							<?php echo "<td><input id=\"adresse\" class=\"valeur input\" type=\"text\" name=\"adresse\" value=\"".((!empty($_POST["adresse"]))?$_POST["adresse"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td id="c5" class="cle">Code postale</td>
							<?php echo "<td><input id=\"code\" class=\"valeur input\" type=\"text\" name=\"code\" value=\"".((!empty($_POST["code"]))?$_POST["code"]:'')."\"/></td>";?>
						</tr>
						<tr>
							<td id="c3" class="cle">Ville</td>
							<?php echo "<td><input id=\"ville\" class=\"valeur input\" type=\"text\" name=\"ville\" value=\"".((!empty($_POST["ville"]))?$_POST["ville"]:'')."\"/></td>";?>
						</tr>
						<tr><td colspan="2">
							<?php echo "<textarea placeholder=\"(FACULTATIF) Àjouter des détails sur la prestation demandée\" form=\"MyForm\" wrap=\"soft\" class=\"FormElement input\" name=\"commentaire\" id=\"commentaire\" cols=\"41\" rows=\"4\" style=\"resize: none;\" maxlength=\"100\"></textarea>
"; ?>
						</td></tr>
						<tr><td colspan="2">
							<input type="checkbox" id="connaissance_za" name="connaissance_za" />  <label for="connaissance_za">Je certifie que l'adresse renseignée se situe bien à l'intérieur de la <a href="https://r2i-grout.fr/za.jpeg" target="_blank" rel="noopener noreferrer">zone d'activité de R2i-Grout</a> délimitée par un trait noir.</label></br>
							<input type="checkbox" id="acceptation_cgv" name="acceptation_cgv" />  <label for="acceptation_cgv">J'accepte les <a href="https://r2i-grout.fr/mentions-legales#cgv" target="_blank" rel="noopener noreferrer">CGV</a>.</label></br>
							<input type="checkbox" id="consentement_rgpd" name="consentement_rgpd" />  <label for="consentement_rgpd">J'accepte les <a href="https://r2i-grout.fr/mentions-legales#rgpd" target="_blank" rel="noopener noreferrer">RGPD</a>.</label>
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
				
				/*
				
				Entrée par défaut sélectionné "-----", il faut cliquer dessus pour que s'actualise la liste
				Ajout liste déroulante
				Entrée que par clique
	
				Récupérer depuis adresse, coordonnées GPS via Nominatim
				https://operations.osmfoundation.org/policies/nominatim/
				
				puis fonction "est-ce que le point est à l'intérieur d'un polygone ?"
				https://github.com/mikolalysenko/robust-point-in-polygon?tab=readme-ov-file
				*/
				
				//https://operations.osmfoundation.org/policies/nominatim/
				//https://fr.javascript.info/xmlhttprequest
				//https://developer.mozilla.org/fr/docs/Web/API/XMLHttpRequest/setRequestHeader
				/*document.getElementById("adresse").addEventListener('focusout', function(e) {
					var xhr = new XMLHttpRequest();
					xhr.open('GET', 'https://nominatim.openstreetmap.org/search?countrycodes=FR&street=24%20rue%20lamartine&postalcode=37000&country=FR&format=json&limit=40', true);
					xhr.responseType = 'json';
					xhr.onload = function() {
						if (xhr.status === 200) {
							console.log(xhr.response);
							for (let i = 0; i<xhr.response.length; i++){
								alert(i + "\n\t" + xhr.response[i].display_name + "\n\t" + "https://www.openstreetmap.org/node/" + xhr.response[i].osm_id + "\n\t" + xhr.response[i].lat + "\n\t" + xhr.response[i].lon);
								# VALID ONE OF THE ADRESS FROM NOMINATIM RESULT
								# for (let i = 0; i<test.length; i++){ document.getElementById('group1').innerHTML=document.getElementById('group1').innerHTML+'<div><input type="radio" id="'+test[i]+'" name="creneau" value="'+test[i]+'"=""><label for="'+test[i]+'">'+test[i]+'</label></div>' }
								#.lat .lon
								#=> Cross-Origin Request Blocked: The Same Origin Policy disallows reading the remote resource
							}
						}
					};
					xhr.send(null);
				});*/
				/*document.getElementById("MyForm").addEventListener('onchange', function(e) { myFunction2(); });
				*/document.getElementById("button").addEventListener("click", function(e) {
					if (myFunction2()) {
						form=document.getElementById('MyForm');
						if (document.forms["MyForm"]["commentaire"].value == "") {form["commentaire"].value = "vide";}
						
						form.action='';
						var input = document.createElement('input');
						input.setAttribute('type','text');
						input.setAttribute('name','post_button');
						input.setAttribute('value', 'test');
						form.appendChild(input);

        					form.submit();
					}
					else {
						alert("Une des entrées n'est pas correcte. Veuillez la corriger.");
					}
				});
				function verifyInput(reg,formName,idvalue,idname,goodInput) {
					stringInput = document.forms[formName][idvalue].value;
                                        document.forms[formName][idvalue].value= stringInput +" ";
                                        document.forms[formName][idvalue].value= stringInput;
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
					console.log("myFunction2");
					goodInput = true;
					goodInput = verifyInput(/^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$/,"MyForm","jour","jour",goodInput);
					if (document.forms["MyForm"]["jour"].value != "") { goodInput = verifyInput(/^[0-9]{2}:[0-9]{2}\-[0-9]{2}:[0-9]{2}$/,"MyForm","group1","creneau",goodInput); }
					goodInput = verifyInput(/^M|Mme$/,"MyForm","group2","civilite",goodInput);
					goodInput = verifyInput(/^1|2$/,"MyForm","group3","service",goodInput);
					goodInput = verifyInput(/^dom|par$/,"MyForm","group4","endroit",goodInput);
					goodInput = verifyInput(/[A-zÀ-ú]+/,"MyForm","nom","nom",goodInput);
					goodInput = verifyInput(/[A-zÀ-ú]+/,"MyForm","prenom","prenom",goodInput);
					goodInput = verifyInput(/^[0-9]{10}$/,"MyForm","tel","tel",goodInput);
					goodInput = verifyInput(/\S+@\S+\.\S+/,"MyForm","email","email",goodInput);
					goodInput = verifyInput(/[A-zÀ-ú0-9]+/,"MyForm","adresse","adresse",goodInput);
					goodInput = verifyInput(/[A-z\-À-ú ]+/,"MyForm","ville","ville",goodInput); 
					goodInput = verifyInput(/^[0-9]{5}$/,"MyForm","code","code",goodInput);
					goodInput = verifyInput(/^[À-úA-z\-\.:;\?\'\"\n 0-9<>]{0,100}$/,"MyForm","commentaire","commentaire",goodInput);
					goodInput = verifyInput_checkbox(/^on$/,"MyForm","connaissance_za","connaissance_za",goodInput);
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
						$confi=TRUE;
						$jour="";$creneau="";$civilite="";$service="";$endroit="";$nom="";$prenom="";$adresse="";$code="";$ville="";
						if (!empty($_POST['jour'])) {
							$jour=filter_var($_POST['jour'],FILTER_SANITIZE_STRING);
							if (strtotime($jour)) { $confi = $confi AND TRUE;}
							else {$confi = FALSE; }
						} else { $confi = FALSE;}
						if (!empty($_POST["creneau"])) {
							$creneau=filter_var($_POST['creneau'],FILTER_SANITIZE_STRING);
							$creneau=explode('-',$creneau);
							if (strtotime($creneau[0])) { $confi = $confi AND TRUE; }
							else if (strtotime($creneau[1])) { $confi = $confi AND TRUE; }
							else { $confi = FALSE; }
						} else { $confi = FALSE;}
						if (!empty($_POST["civilite"])) {
							$civilite=filter_var($_POST['civilite'],FILTER_SANITIZE_STRING);
							if(in_array($civilite,array("M","Mme"),TRUE)) {$confi = $confi AND TRUE;}
							else {$confi = FALSE; }
						} else { $confi = FALSE;}
						if (!empty($_POST["service"])) {
							$service=filter_var($_POST['service'],FILTER_SANITIZE_STRING);
							if(in_array($service,array("1","2"),TRUE)) { $confi = $confi AND TRUE; }
							else {$confi = FALSE; }
						} else { $confi = FALSE;}
						if (!empty($_POST["endroit"])) {
							$endroit=filter_var($_POST['endroit'],FILTER_SANITIZE_STRING);
							if(in_array($endroit,array("dom","par"),TRUE)) { $confi = $confi AND TRUE; }
							else {$confi = FALSE;}
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
						if (!empty($_POST["code"])) {
							$code=filter_var($_POST['code'],FILTER_VALIDATE_INT);
							if (preg_match("/[0-9]{5}/",$code)) { $confi = $confi AND TRUE; }
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
						
						if (!empty($_POST['connaissance_za'])) {
							$connaissance_za=filter_var($_POST['connaissance_za'], FILTER_VALIDATE_BOOLEAN);
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
						
						if ($confi) {
							#echo 'CONFIRMATION<br/>JOUR=['.$jour.']<br/>CRENEAU=['.$creneau[0].']-['.$creneau[1].']<br/>CIVILITE=['.$civilite.']<br/>SERVICE=['.$service.']<br/>ENDROIT=['.$endroit.']<br/>NOM=['.$nom.']<br/>PRENOM=['.$prenom.']<br/>EMAIL=['.$email.']<br/>TEL=['.$tel.']<br/>ADRESSE=['.$adresse.']<br/>CODE=['.$code.']<br/>VILLE=['.$ville.']<br/>COMMENTAIRE=['.$commentaire.']<br/>CONNAISSANCE_ZA=['.$connaissance_za.']<br/>ACCEPTATION_CGV=['.$acceptation_cgv.']<br/>CONSENTEMENT_RGPD=['.$consentement_rgpd.']<br/>';
							$result=$link->exec('UPDATE '.$nomtablecreneau.' SET date_creneau_reserve=CURRENT_TIMESTAMP,evt_demande_confirmation=1,evt_confirmation=0,confirmation=0,expire_hash=CURRENT_TIMESTAMP,hash_confirmation=SHA2(CONCAT(id,CURRENT_TIMESTAMP,HEX(RANDOM_BYTES(8))),256),evt_annulation_perso=0,evt_annulation_client=0,civilite=\''.$civilite.'\',nom=\''.$nom.'\',prenom=\''.$prenom.'\',numero_telephone=\''.$tel.'\',email=\''.$email.'\',adresse=\''.$adresse.'\',code_postal=\''.$code.'\',ville=\''.$ville.'\',service=\''.$service.'\',lieux_service=\''.$endroit.'\',commentaire=\''.$commentaire.'\',hash_annulation_client=NULL, hash_annulation_perso=NULL,connaissance_za=\''.$connaissance_za.'\',acceptation_cgv=\''.$acceptation_cgv.'\',consentement_rgpd=\''.$consentement_rgpd.'\' WHERE date_creneau = \''.$jour.'\' AND heure_creneau_debut = \''.$creneau[0].'\' AND heure_creneau_fin = \''.$creneau[1].'\' AND creneau_reservable = 1 AND length(nom) IS NULL AND STR_TO_DATE(CONCAT(date_creneau,\' \',heure_creneau_debut),\'%Y-%m-%d %H:%i:%S\') >= ADDDATE(CURRENT_TIMESTAMP, INTERVAL 60 MINUTE)');
							if ($result >= 0) {
								echo '<p>Demande de réservation envoyée. Vous allez recevoir un mail de confirmation prochainement.</p>';
							} else {
								echo '<p>Erreur lors de l\'envoi [A4]</p>';
							}
							#echo shell_exec("echo $(date +%Y/%m/%d-%H:%M:%S) =\> ".str_replace(array("(",")",">",":civ",":nom",":pre",":num"),array("\(","\)","\>",$civilite,$nom,$prenom,$tel),$sql4)." >> /var/www/html/test_log.txt");
						} else {
							echo '<p>Erreur lors de l\'envoi [A5]</p>';
						}
					}
				}
				if (!empty($_GET['confirmation']))
				{
					$confirmation=filter_var($_GET['confirmation'],FILTER_SANITIZE_STRING);
					if(preg_match("/[a-z0-9]{64}/",$confirmation)) {
						$result = $link->exec('UPDATE '.$nomtablecreneau.' SET confirmation=1,evt_confirmation=1,hash_confirmation=NULL,hash_annulation_client=SHA2(concat(numero_telephone,id,CURRENT_DATE,CURRENT_TIME),256), hash_annulation_perso=SHA2(CONCAT(id,HEX(RANDOM_BYTES(8))),256) WHERE confirmation=0 AND hash_confirmation="'.$confirmation.'"');
						if ($result >= 0) {
							echo '<p>La demande de réservation de créneau est bien confirmée.</p>';
						} else {
							echo '<p>Erreur lors de l\'envoi</p>';
						}
					}
				}
				if (!empty($_GET['token'])) {
					$token=filter_var($_GET['token'],FILTER_SANITIZE_STRING);
					if(preg_match("/[a-z0-9]{64}/",$token)) {
						$result= $link->exec('UPDATE '.$nomtablecreneau.' SET evt_annulation_client = 1 WHERE hash_annulation_client = "'.$token.'" AND evt_annulation_client=0 AND date_creneau >= CURRENT_DATE AND STR_TO_DATE(CONCAT(date_creneau,\' \',heure_creneau_debut),\'%Y-%m-%d %H:%i:%S\') >= ADDDATE(CURRENT_TIMESTAMP, INTERVAL 60 MINUTE)');
						if ($result >= 0)
						{
							echo '<p>La demande d\'annulation de votre rendez-vous à bien été pris en compte.</br>Vous allez recevoir un email de confirmation prochainement.</p>';
						}else{
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
						$sql6='SELECT DATE_CRENEAU,HEURE_CRENEAU_DEBUT,HEURE_CRENEAU_FIN,CRENEAU_RESERVABLE FROM '.$nomtablecreneau.' WHERE MONTH(date_creneau)='.$mois.' AND YEAR(date_creneau)=20'.$annee.' ORDER BY date_creneau,heure_creneau_debut';
					}
					if ($_GET['req'] == "4") {
						$sql6='UPDATE '.$nomtablecreneau.' SET EVT_ANNULATION_PERSO=1 WHERE EVT_ANNULATION_PERSO=0 AND HASH_ANNULATION_PERSO="'.$_GET['token_bis'].'"';
					}
					#if ($_GET['req'] == "5") {
					#	$sql6='UPDATE '.$nomtablecreneau.' SET CRENEAU_RESERVABLE=(oppose valeur actuelle) WHERE HASH_RESERVABLE="'.$_GET['token_tis'].'"';
					#}
					if (($_GET['req'] == "1") or ($_GET['req'] == "2") or ($_GET['req'] == "3") or ($_GET['req'] == "4")) {	
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
								"<a href=\"https://".$domainname."/".$rdv_filename."?".$adm_url."=".$_GET[$adm_url]."&reserva=1\">",
								"<a href=\"https://".$domainname."/".$rdv_filename."?".$adm_url."=".$_GET[$adm_url]."&reserva=1\">"
							));
						}
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
