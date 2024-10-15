<?php
session_start();
?>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Raphaël GROUT">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Inscription à la lettre d'information de R2I-GROUT">
	<meta name="keywords" content="Lettre Information R2I-GROUT">
	<title>Inscription à la lettre d'information</title>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php'); wp_head(); get_header(); ?>
	<style>
		/* <921px -> body class="ast-header-break-point" <- "ast-desktop" */
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
		#TE {
			background-color: #000000;
			color : #FFFFFF;
		}
		#A,#B,#C
		{
			width : 100%;
			background-color : #FFFFFF;
			color : #000000;
		}
		.label {
			color : #FFFFFF;
			font-weight: normal !important;
		}
		table {
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
		fieldset {
			border : none;
		}
		
		#image{
			width: 100%;
			font-weight: 400;
			user-select: none;
			/*text-decoration:line-through;*/
			/*font-style: italic;*/
			font-size: x-large;
			border: red 2px solid;
			text-align:center;
		}
	</style>
</head>
<body>
<h1 style="color:red; text-align:center;">SYSTEME EN COURS DE TEST.<br> L'ENSEMBLE DES DONNEES RENTREES SERA SUPPRIME LE 31 OCTOBRE.<br>LE SYSTEME SERA EN PRODUCTION A PARTIR DU 1 NOVEMBRE</h1>
<?php

$domainname = '';
$dbname = '';
$dbuser = '';
$dbpass = '';
$dbhost = '';
$path_sensitive_data = "/home/cred.txt";

$myfile = fopen($path_sensitive_data, "r") or die("Unable to open file!");
while(!feof($myfile)) {
	preg_match('/([^=]*)=(.*)$/', fgets($myfile), $matches, PREG_OFFSET_CAPTURE);
	if (isset($matches[1][0]) && isset ($matches[2][0]))
	{
		if ("domainname" == $matches[1][0]) { $domainname=$matches[2][0]; }
		if ("dbname" == $matches[1][0]) { $dbname=$matches[2][0]; }
		if ("dbuser" == $matches[1][0]) { $dbuser=$matches[2][0]; }
		if ("dbpass" == $matches[1][0]) { $dbpass=$matches[2][0]; }
		if ("dbhost" == $matches[1][0]) { $dbhost=$matches[2][0]; }
	}
}

fclose($myfile);

try {	
	$link = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass);
	$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$link->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
} 
catch (Exception $e) {
	error_log($e->getMessage());
	exit('Something bad happened'); 
}

$correspondance = array();
$correspondance['A']=0;
$correspondance['B']=1;

$hideForm=0;

if (!empty($_SESSION['generated_captcha_expected'])) {
	if (!empty($_POST)) {
		if (!empty($_POST['captcha'])) {
			if ($_SESSION['generated_captcha_expected'] == $_POST['captcha']) {
				if (!empty($_POST['email']) and !empty($_POST['inscription'])) {
					$email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
					if (preg_match("/\S+@\S+\.\S+/",$email)) {
						$inscription=filter_var($_POST['inscription'],FILTER_SANITIZE_STRING);
						if (preg_match("/[AB]{1}/",$inscription)) {
							$hideForm=1;
							$result =$link->exec('INSERT IGNORE INTO lettre_information (EMAIL) VALUES (\''.$email.'\'); UPDATE lettre_information SET HASH_CONF=SHA2(CONCAT(CURRENT_TIMESTAMP,EMAIL,HEX(RANDOM_BYTES(8))),256), EXPIRE_HASH=CURRENT_TIMESTAMP, TO_SENT=1, INSCRIPTION='.$correspondance[$inscription].' WHERE EMAIL = \''.$email.'\'');
							if ($result >= 0) {
								echo '<p>La demande d\'inscription a bien été envoyé au serveur.</br>Vous aller recevoir un mail de confirmation prochainement.</p>';
							} else { 
								echo '<p>ERREUR de l\'envoi [4]</p>';
							}
						} else { $hideForm=1; echo '<p>ERREUR de l\'envoi [3]</p>'; }
					} else { $hideForm=1; echo '<p>ERREUR de l\'envoi [2]</p>'; }
				} else { $hideForm=1; echo '<p>ERREUR de l\'envoi [1]</p>'; }
			} else {
				$hideForm=1;
				echo "<p>Mauvaise saisie du CAPTCHA, veuillez recommencer en renvoyant le formulaire via le lien <a href=\"https://".$domainname."/lettre-information.php\" target=\"_self\" rel=\"noopener noreferrer\">lien</a>.</p>";
			}
		} else { $hideForm=1; echo '<p>ERREUR de l\'envoi [0]</p>'; }
	}
} #else correspond à un cas normal

#Latin Extended-A pour l'instant, puis ensuite si nécessaire ajout de : Letterlike_Symbols, Cyrillic, Greek_and_Coptic, Exposants_et_indices_Unicode + Latin étendu
#	Mauvais affichage du Latin Etendue A, trop niche donc aller sur de l'exposant et du cyrillic
#	/!\ Bien prendre sur la page wikipedia, la colonne la plus à gauche pour la valeur hexadécimal

#$hideForm=1;

$charset_displayed	= array('\u0400','\u0401','\u0405','\u0406','\u0407','\u0408','\u040C','\u0410','\u0412','\u0415','\u041A','\u041C','\u041D','\u041E','\u0420','\u0421','\u0422','\u0425');
$charset_expected	= array('E'     ,'E'     ,'S'     ,'I'     ,'I'     ,'J'     ,'K'     ,'A'     ,'B'     ,'E'     ,'K'     ,'M'     ,'H'     ,'O'     ,'P'     ,'C'     ,'T'     ,'X'     );
$generated_captcha_displayed='';
$generated_captcha_expected='';
for ($x = 1; $x <= 10; $x++) {
	$rand_int=random_int(0,count($charset_displayed)-1);
	$generated_captcha_displayed=$generated_captcha_displayed.((string)$charset_displayed[$rand_int]);
	$generated_captcha_expected=$generated_captcha_expected.$charset_expected[$rand_int];
}
$test=json_decode('"'.$generated_captcha_displayed.'"');

$_SESSION['generated_captcha_expected'] = $generated_captcha_expected;
$generated_captcha_displayed = $charset_displayed;
#ALTCHA ? pas reCAPTCHA gros problème de RGPD

if (!empty($_GET['token'])) {
	$hash_conf = filter_var($_GET['token'],FILTER_SANITIZE_STRING);
	if(preg_match("/[a-z0-9]{64}/",$hash_conf)) {
		$result = $link->exec('UPDATE lettre_information SET INSCRIPTION_VALIDE=INSCRIPTION,HASH_CONF=NULL,EXPIRE_HASH=CURRENT_TIMESTAMP WHERE HASH_CONF = \''.$hash_conf.'\' AND CURRENT_TIMESTAMP < ADDDATE(EXPIRE_HASH, INTERVAL 30 MINUTE)');
		if ($result >= 0) {
			echo '<p>Votre demande d\'inscription a bien été prise en compte.</br>Merci.</p>';
		} else { 
			echo '<p>ERREUR de l\'envoi [5]</p>';
		}
		$hideForm=1;
	}
}

echo	"<form id=\"TE\" method=\"post\"".(($hideForm)?" style=\"display: none\"":"").">";
	?>
		<table>
			<tr>
				<td><input id="A" type="text" name="email" placeholder="Renseigner votre adresse e-mail" autofocus></td>
			</tr>
			<tr><td>
			<fieldset id="group2">
				<div>
					<input type="radio" id="inscription" name="inscription" value="A" />
					<label class="label" for="inscription">Se désinscrire de la lettre d'information</label>
				</div>
				<div>
					<input type="radio" id="desinscription" name="inscription" value="B" />
					<label class="label" for="desinscription">S'inscrire à la lettre d'information</label>
				</div>
			</fieldset>
			</td></tr>
			<tr><td>
				<div id="image" selectable="False"><?php echo $test;?></div>
			</td></tr>
			<tr><td>
				<p>Saisissez la chaîne de caractères comprenant uniquement les caractères (A à Z,a à z,0 à 9) qui se rapproche le plus de la chaîne de caractères donnée.<br>
				Ignorer les accents car aucun caractère avec accent n'est demandé pour faciliter la saisie par l'utilisateur.<br>
				Exemple : Ќ -> K, Џ -> U</p>
				<input type="text" id="C" name="captcha" placeholder="Renseigner le captcha ci-dessus" />
               		</td></tr>
			<tr>
				<td><button id="B" type="button">Envoyer le formulaire</button></td>
			</tr>
		</table>
	</form>
	<script type='text/javascript'>
		function myFunction2() {
			goodInput = true;
			var reg=/\S+@\S+\.\S+/;
			if (reg.test(document.forms["TE"]["email"].value)) {document.forms["TE"]["email"].style.backgroundColor = 'green'; goodInput = goodInput && true;}
			else {document.forms["TE"]["email"].style.backgroundColor = 'red'; goodInput = false;}
			var reg=/^[A-B]{1}$/;
			if (reg.test(document.forms["TE"]["inscription"].value)) {document.getElementById("group2").style.backgroundColor = 'green'; goodInput = goodInput && true;}
			else {document.getElementById("group2").style.backgroundColor = 'red'; goodInput = false;}
			return goodInput;
		}
		document.getElementById("TE").addEventListener('change', function(e) { myFunction2(); });
		document.getElementById("B").addEventListener("click", function(e) {
			if (myFunction2())
			{
				alert("Envoi du formulaire !");
				HTMLFormElement.prototype.submit.call(document.getElementById('TE'));
			}
			else {
				alert("Une des entrées n'est pas correcte. Veuillez la corriger.");
			}
		});	
	</script>
</body>
<footer>
	<?php get_footer(); ?>
</footer>
