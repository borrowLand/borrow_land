<?
session_start();
//System 
/////////////////////////////////////////////
$includeName="../_00_basic_check.inc.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

//Funktionen 
/////////////////////////////////////////////
$includeName="../_00_basic_func.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="../_01_basic_db.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Sessions
/////////////////////////////////////////////
$includeName="../_01_basic_sess.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////




?>

<!DOCTYPE html> 
<html>
<head>
<?
echo eval(welcheEinstellung("SE_headBereich"));
?>
<link rel="stylesheet" type="text/css" href="../BL_CSS/Reg_slidingNav.css" />
</head>

       

    <body>
<NOSCRIPT>
<br><br><br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!
</div><br><br>
</NOSCRIPT>	
		
<section id="page"> <!-- Defining the #page section with the section tag -->

<header> <!-- Defining the header section of the page with the appropriate tag -->

           
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../index.php" title="Startseite"><img src="../BL_BILDER/start_00.png"></a> <a href="../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=1;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../">/Leihe</a>/Registrierung</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../">/Leihe</a>/Registrierung</div>
	</hgroup>
	<?
	}
}
//#############Ende Überschrift	


	//navigation
	/////////////////////////////////////////////
	$includeName="../_00_basic_nav.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
	exit();
	}
	/////////////////////////////////////////////
?>
            </header>
            
            <section id="articles"> <!-- A new section with the articles -->

				<!-- Article 1 start -->

                <? //<div class="line"></div>  <!-- Dividing line -->
				//<ul class="ui-widget ui-helper-clearfix" id="icons"><li class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-check"></span></li></ul>
				?>
                
                
<?

//nur formfelder ohne zwang abfragen: 		infotext +	infotext bestätigung	+	adresse	+	matr.id		sind optional
if ($_POST["reg_N"] !="" && $_POST["reg_Mail"] !="" && $_POST["reg_TN"] !="" && $_POST["reg_inDiesenRaeumenLiegtEsBequemer"]!="" && $_POST["reg_regFormPh"]=="1" && $_SESSION["reg_reCap"]!="" && $_POST["reg_regFormPh2"]==$_SESSION["reg_check2"])
{

//Check Formular
//$_POST["reg_Stadt"]="A";
//$_POST["reg_inDiesenRaeumenLiegtEsBequemer"]="0e2bbad40a98efc89748bab2d8a5a01c12db9d9a";



//Überprüfung der Registrationsdaten

	//Überprüfung Formulardaten

		//Eingabe-Okay	- Prüfung nur wenn in der Admin angegeben
		
		if ($_POST["reg_cbDiscl"]!="OK" && $_SESSION["SE_vortextJaNein"]=="1")
		{
		$fehlerRegForm[]="Bitte den Eingabetext mit OK bestätigen.";
		$fehlerFelder[]="reg_cbDiscl";
		}
//################################################################################################Ende 1.Block Eingabeinformationen

		//Name 1
		if (strlen($_POST["reg_N"]) <= 4)
		{
		$fehlerRegForm[]="Bitte geben Sie einen Namen mit mehr als 4 Zeichen ein.";
		$fehlerFelder[]="reg_N";
		}
		//Name 2
		if (strlen($_POST["reg_N"]) >= 99)
		{
		$fehlerRegForm[]="Bitte geben Sie einen Namen mit weniger als 100 Zeichen ein.";
		$fehlerFelder[]="reg_N";
		}
	
		//E-Mail 1
		if (strlen($_POST["reg_Mail"]) <= 4)
		{
		$fehlerRegForm[]="Bitte geben Sie eine E-Mail Adresse mit mehr als 4 Zeichen ein.";
		$fehlerFelder[]="reg_Mail";
		}
	
		//E-Mail 2
		if (strlen($_POST["reg_Mail"]) >= 99)
		{
		$fehlerRegForm[]="Bitte geben Sie eine E-Mail Adresse mit weniger  als 100 Zeichen ein.";
		$fehlerFelder[]="reg_Mail";
		}
	
		//E-Mail 3
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST["reg_Mail"]))
		{
		$fehlerRegForm[]="Bitte geben Sie eine gültige E-Mail Adresse ein.";
		$fehlerFelder[]="reg_Mail";
		}
	
	
		//E-Mail 4
		$sql = "SELECT id FROM `01_Benutzer` WHERE `email` = '".mysql_real_escape_string(htmlentities($_POST["reg_Mail"], ENT_QUOTES))."'";
		$rsd = mysql_query($sql);
		$msgEMailOk = mysql_num_rows($rsd); //0 die mail adresse gibts nicht
	
		if($msgEMailOk!="0")
		{
		$fehlerRegForm[]="Bitte geben Sie eine andere E-Mail Adresse ein.";
		$fehlerFelder[]="reg_Mail";
		
							//anfang protokoll
							if ($_SESSION["SE_ProtokollAnAus"]==1)
							{
							protokollEintrag("2","3","Die Mail Adresse ".mysql_real_escape_string(htmlentities($_POST["reg_Mail"], ENT_QUOTES))." wurde versucht bei der Registrierung (NACH Übersendung der Daten an den Server) anzugeben, obwohl ein Nutzer mit dieser Adresse schon vergeben ist.  IP:".getenv('REMOTE_ADDR'));
							}
							//ende protokoll
		
		}
	
		//Matrikel-ID	- Prüfung nur wenn in der Admin angegeben
		if ((!is_numeric($_POST["reg_MN"]) || strlen($_POST["reg_MN"]) != 8) && $_SESSION["SE_AccessContrYN"]=="1" )
		{
		$fehlerRegForm[]="Bitte die ". $_SESSION["SE_AccessContrName"] ." korrigieren.";
		$fehlerFelder[]="reg_MN";
		}	

		if (substr($_POST["reg_MN"], -8, 2)=="20")
		{
		}
		else
		{
			if ($_SESSION["SE_AccessContrYN"]=="1")
			{
			$fehlerRegForm[]="Bitte die ". $_SESSION["SE_AccessContrName"] ." korrigieren.";
			$fehlerFelder[]="reg_MN";
			}
		}

		//Telefonnummer 1
		if (!is_numeric($_POST["reg_TN"]) || strlen($_POST["reg_TN"]) <= 5 )
		{
		$fehlerRegForm[]="Bitte geben Sie eine Telefonnummer mit mehr als 5 Zeichen ein.";
		$fehlerFelder[]="reg_TN";
		}
	
		//Telefonnummer 2
		if (!is_numeric($_POST["reg_TN"]) || strlen($_POST["reg_TN"]) >= 19)
		{
		$fehlerRegForm[]="Bitte geben Sie eine Telefonnummer mit weniger als 20 Zeichen ein.";
		$fehlerFelder[]="reg_TN";
		}
	


//################################################################################################Ende 2.Block Allgemein


		//Adresse 1
		if (strlen($_POST["reg_Ad_StrasseHN"]) <= 5 && $_SESSION["SE_AdressModuleYesNo"]==1)
		{
		$fehlerRegForm[]="Bitte geben Sie eine Adresse mit mehr als 5 Zeichen ein.";
		$fehlerFelder[]="reg_Ad_StrasseHN";
		}
	
		//Adresse 2 
		if (strlen($_POST["reg_Ad_StrasseHN"]) >= 100 && $_SESSION["SE_AdressModuleYesNo"]==1 )
		{
		$fehlerRegForm[]="Bitte geben Sie eine Adresse mit weniger als 100 Zeichen ein.";
		$fehlerFelder[]="reg_Ad_StrasseHN";
		}	

		//PLZ
		if ((!is_numeric($_POST["reg_PLZ"]) || strlen($_POST["reg_PLZ"]) != 5) && $_SESSION["SE_AdressModuleYesNo"]=="1" )
		{
		$fehlerRegForm[]="Bitte die Postleitzahl korrigieren.";
		$fehlerFelder[]="reg_PLZ";
		}

		//Stadt 1
		if (strlen($_POST["reg_Stadt"]) <= 2 && $_SESSION["SE_AdressModuleYesNo"]==1)
		{
		$fehlerRegForm[]="Bitte geben Sie eine Stadt mit mehr als 2 Zeichen ein.";
		$fehlerFelder[]="reg_Stadt";
		}
	
		//Stadt 2 
		if (strlen($_POST["reg_Stadt"]) >= 100 && $_SESSION["SE_AdressModuleYesNo"]==1 )
		{
		$fehlerRegForm[]="Bitte geben Sie eine Stadt mit weniger als 100 Zeichen ein.";
		$fehlerFelder[]="reg_Stadt";
		}	





	
//################################################################################################Ende 3.Block	Adresse

		//SpamSchutz
		if ($_SESSION["reg_reCap"]!="1")
		{
		$fehlerRegForm[]="Die SPAM-Schutz Wörter wurden falsch eingegeben.";
		$fehlerFelder[]="recaptcha_response_field";
		}
	
	

//################################################################################################Ende 4.Block Spam-Schutz
	
	
		//doppelte Registrierung verhinden
		$sql = "SELECT id FROM `01_Benutzer` WHERE `specid_cyrpt_md5` = '".mysql_real_escape_string($_POST["reg_inDiesenRaeumenLiegtEsBequemer"])."'";
		$rsd = mysql_query($sql);
		$msgRegZeit = mysql_num_rows($rsd); 
		
		if($msgRegZeit!="0")
		{
		//$fehlerRegForm[] = array(); //alle anderen Fehlermeldungen löschen und mit einziger Folgender Meldung ersetzen.
		$fehlerRegForm[]="Bitte nur einmal auf die Absenden-Schalterfläche klicken. Ihre Registrierung wurde bereits abgeschlossen.";
		$noInputFields=1; //ausnahme: fehler erkannt, aber kein kritischer, es wird nicht das formularfeld angezeigt
		}
//################################################################################################Ende Sonstiges	

			$fehlerFelder=array_unique($fehlerFelder);
			

			$anzahlFehlerMeldungen=count($fehlerRegForm);
			$anzahlFehlerFormfelder=count($fehlerFelder);

			//var_dump($fehlerRegForm);
			//var_dump($fehlerFelder);
			
			if (($anzahlFehlerMeldungen > 0 || $anzahlFehlerFormfelder > 0) && $noInputFields!=1 )
			{
                    echo '
					<article id="article2">
					<h2>Hinweis Registrierungsvorgang</h2>
					<div class="line"></div>Ihre Daten wurden leider nicht übermittelt. Bitte überprüfen Sie alle Angaben, die rot gekennzeichnet sind.
					</article>
					';	
					
					/////////////////////////////////////////////
                    $includeName="input_field.php";
                    if (file_exists($includeName))
                    {
                    include_once($includeName);
                    }	
                    else
                    {
                    echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>ERR_REG_INPUT_01</div><br><br>';	
                    exit();
                    }
                    /////////////////////////////////////////////
					
					unset($_SESSION["reg_reCap"]);
					$formular_jquery_check=1;
			}
			
			//keine fehler, die daten können weiterverarbeitet werden
			else
			{
			
					if ($noInputFields==1)
					{
					echo '
					<article id="article1">
					<h2>Hinweis Registrierungsvorgang</h2>
					<div class="line"></div>Es wurde festgestellt, dass mit hoher Übereinstimmung Ihre Anmeldung schon vorgenommen wurde.<br>
					Um das zu überprüfen können, Sie in Ihrem E-Mail Postfach nachsehen. <br><br><br>
					Falls Sie noch keine erfolgreiche Registrierung vorgenommen haben, klicken Sie bitte <a href="index.php">hier</a>.
					</article>
					';
					}

					else
					{
					//Anfang Schreiben Datenbank

//Modul Vortext					
					if ($_SESSION["SE_vortextJaNein"]=="1")		//Vortext wird angezeigt ist eingestellt und die Bestätigung des Vortextes ist Bedingung
                    {

						if ($_POST["reg_cbDiscl"]=="OK")
						{
						$dbRegData_VortextBestaetigt=1;	//der vortext wurde erfolgreich eingegeben
						}
						else
						{
						$dbRegData_VortextBestaetigt=0; //der vortext wurde nicht erfolgreich eingegeben
						}						
					}
					else
						{
						$dbRegData_VortextBestaetigt=9; //der vortext wurde nicht aktiviert und war nicht erforderlich bei der anmeldung
						}		
					
//Modul Pruef-ID					
					if ($_SESSION["SE_AccessContrYN"]=="1")		// Eine Pruef ID wie Matr ID wird erwartet
					{
						if ($_POST["reg_MN"]!="")
						{
						$dbRegData_PruefID=$_POST["reg_MN"];	//Die PrüfID wird gespeichert
						}
						else
						{
						$dbRegData_PruefID="Fehler: Es wurde keine Pruef-ID übermittelt."; // Fehler in der Übetragung, die Pruef ID wurde nicht eingegeben.
						}
					}
					else
						{
						$dbRegData_PruefID="Modul Pruef-ID war nicht aktiviert"; //Hinweis, dass das Modul nicht aktiviert war.
						}					
//Modul Adresse

                    if ($_SESSION["SE_AdressModuleYesNo"]=="1")
                    {
					$dbRegData_StrasseHN=$_POST["reg_Ad_StrasseHN"];
					$dbRegData_PLZ=$_POST["reg_PLZ"];
					$dbRegData_Stadt=$_POST["reg_Stadt"];					
					}
					else
					{
					$dbRegData_StrasseHN="Adress-Modul nicht aktiviert.";
					$dbRegData_PLZ="00000"; // Zahlen für deaktiviertes Modul
					$dbRegData_Stadt="Adress-Modul nicht aktiviert.";
					}

//profilaktiviertOderDeaktiviertNachRegistrierung

					if ($_SESSION["SE_ProfilOnOff"]=="1")
					{
					$dbRegData_ProfOnOff="1";
					}
					else
					{
					$dbRegData_ProfOnOff="0";
					}
//zeitRegistrierung					
					$jetztRegistrierungNutzer= new DateTime();
					$dbRegData_zeitRegistrierungUser=$jetztRegistrierungNutzer->format('U');
//rechte

					if ($_SESSION["SE_GleichLeiheMoegli"]=="1")	
					{
					$dbRegData_RechtAusleihe="1";
					$dbRegData_ProfBestaetigung=$dbRegData_zeitRegistrierungUser;
					}					
					else
					{
					$dbRegData_RechtAusleihe="0";
					$dbRegData_ProfBestaetigung="0";
					}					

//passwort
					$passWd=CreatePassword2();
					
//eineinddeutige id
					//ist $_POST["reg_inDiesenRaeumenLiegtEsBequemer"]			
					
					
$sql="INSERT INTO 01_Benutzer ( id , specid_cyrpt_md5 , vortextBe , vn_nn , tn , m_id , email , pw_hash , adr_strasse_hn , adr_plz , adr_stadt , ProfOnOff , userreg_selbst , userreg_bestaet , lastlogin , rechte_ausleihe , rechte_ausgabeberechtigt , rechte_bestaetiger , rechte_dauerleihe , rechte_admin ) VALUES (NULL , '".mysql_real_escape_string(utf8_decode($_POST["reg_inDiesenRaeumenLiegtEsBequemer"]))."', '".htmlspecialchars($dbRegData_VortextBestaetigt)."', '".mysql_real_escape_string(utf8_decode(htmlspecialchars($_POST['reg_N'])))."', '".mysql_real_escape_string(htmlspecialchars($_POST['reg_TN']))."', '".mysql_real_escape_string(utf8_decode(htmlspecialchars($dbRegData_PruefID)))."', '".mysql_real_escape_string(utf8_decode(htmlspecialchars($_POST['reg_Mail'])))."', '".FUNK_VerSchluesseln($passWd)."', '".mysql_real_escape_string(utf8_decode(htmlspecialchars($dbRegData_StrasseHN)))."', '".mysql_real_escape_string(htmlspecialchars($dbRegData_PLZ))."', '".mysql_real_escape_string(utf8_decode(htmlspecialchars($dbRegData_Stadt)))."', '".$dbRegData_ProfOnOff."', '".mysql_real_escape_string($dbRegData_zeitRegistrierungUser)."', '".$dbRegData_ProfBestaetigung."', '', '".$dbRegData_RechtAusleihe."', '', '', '', '' );";



$rs=mysql_query($sql);
$anfrageErfolgreich=mysql_affected_rows();

						if ($anfrageErfolgreich=="1")
						{
						echo '
						<article id="article2">
						<h2>Hinweis Registrierungsvorgang</h2>
						<div class="line"></div>Ihre Daten wurden erfolgreich übermittelt. Vielen Dank. <br><br>Sie haben eine E-Mail mit den Anmeldedaten erhalten und können sich jetzt <a href="../login"><b>hier</b></a> anmelden.
						</article>
						';		
$empfaenger=mysql_real_escape_string($_POST['reg_Mail']);						
$betreff="Registrierung Ausleihe ".$_SESSION["SE_Kundenname"];
$nachricht=utf8_encode(welcheEinstellung("SE_TextRegBestaetigu"))."\r\n\r\n\r\nBenutzername: ".htmlentities($_POST['reg_Mail'], ENT_QUOTES)."\r\nPasswort: ".$passWd."\r\n\nHinweis: Nach ".$_SESSION["SE_VerfallAccountTag"]." Tagen wird die Anmeldung automatisch\r\ngelöscht, wenn Sie sich bis dahin nicht mind. 1x angemeldet haben.\r\n\r\n\r\n\r\n\r\n--\r\n\r\nErstellt mit http://www.ausleihsoftware.de";
$header="From: \"Ausleihe ".$_SESSION["SE_Kundenname"]. "\" <".$_SESSION["SE_adminEMail"].">";				//$_SESSION["SE_Kundenname"]	
						
						mail(htmlentities($empfaenger, ENT_QUOTES),$betreff,utf8_decode($nachricht),$header);

							
							//anfang protokoll
							if ($_SESSION["SE_ProtokollAnAus"]==1)
							{
							protokollEintrag("1","1","Benutzer ".mysql_real_escape_string(htmlspecialchars($_POST["reg_N"]))." wurde hinzugefügt. Grund: Benutzer registrierte sich auf der Webseite.");
							}
							//ende protokoll
							
							//anfang twitter
							if (welcheEinstellung("SE_twitterModuleActi")=="1")
							{
							$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
							$consumerSecret = welcheEinstellung("SE_consumerSecret");
							$oAuthToken     = welcheEinstellung("SE_oAuthToken");
							$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");
							
							require_once('../BL_TWITR/twitteroauth.php');

							$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
							$tweet->post('statuses/update', array('status' => 'Es hat sich ein neuer Nutzer bei borrow land registriert. #Ausleihsoftware http://ausleihsoftware.de'));
							}
							//ende twitter
							
							
							
							
							
							
							
							
						unset($_POST);
						unset($_SESSION["reg_reCap"]);
						unset($_SESSION["reg_check2"]);
						unset($_POST["reg_N"]);
						unset($_POST["reg_Mail"]);
						unset($_POST["reg_TN"]);
						unset($_POST["reg_inDiesenRaeumenLiegtEsBequemer"]);
						unset($_POST["reg_regFormPh"]);
						unset($_POST["reg_regFormPh2"]);
						unset($_POST["reg_cbDiscl"]);
						unset($_POST["reg_MN"]);
						unset($_POST["reg_Ad_StrasseHN"]);
						unset($_POST["reg_PLZ"]);
						unset($_POST["reg_Stadt"]);

						
						
						
						
						}
						
						else
						{
						echo '
						<article id="article2">
						<h2>Fehler Registrierungsvorgang</h2>
						<div class="line"></div>Ihre Daten wurden nicht erfolgreich übermittelt. Der Administrator wurde benachrichtigt.
						</article>';
						mail($_SESSION[SE_adminEMail],"Fehler borrow land bei Kunde: ".$_SESSION[SE_Kundenname],"Eine Registrierung konnte nicht vollzogen werden.\n\nRegistration von: ".mysql_real_escape_string($_POST['reg_Mail']));
						
						
						}
						
						
					//Ende Schreiben Datenbank					
					}
					
					
					
					
					
					
					$formular_jquery_check=0;
			}



}
else
{


					/////////////////////////////////////////////
                    $includeName="input_field.php";
                    if (file_exists($includeName))
                    {
                    include_once($includeName);
                    }	
                    else
                    {
                    echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>ERR_REG_INPUT_01</div><br><br>';	
                    exit();
                    }
                    /////////////////////////////////////////////
					
					unset($_SESSION["reg_reCap"]);
					$formular_jquery_check=1;

}
?>                


				<!-- Article 1 end -->
            </section>
		
		 <?
		 if ($_SESSION["SE_GooTrans"]=="1")
		 {
					// Start Google Translate -->
   					echo $_SESSION["SE_GooTransScript"];
					// Ende Google Translate -->
		}
		?>		

<?
//Footer 
/////////////////////////////////////////////
$includeName="../_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}

/////////////////////////////////////////////			
?>        

</section>
<!-- Closing the #page section -->        
         
		 


        
<!-- JavaScript Includes -->


<?
echo nl2br($_SESSION["SE_jQuerUI"]);
?>

<script type="text/javascript" src="../BL_JS/sliding.form.js"></script>
<script type="text/javascript" src="../BL_JS/jquery.numeric.js"></script>



<script type="text/javascript">

<?
			if ($anzahlFehlerMeldungen > 0 || $anzahlFehlerFormfelder > 0 )
			{
				for ($i = 0; $i <= $anzahlFehlerMeldungen-1; $i++)
				{
				echo "
				$.pnotify({
				pnotify_title: 'Fehler Registrierung',
				pnotify_text: '".$fehlerRegForm[$i]."',
				pnotify_type: 'error'
				});
				";


				}

				if ($anzahlFehlerFormfelder>0)
				{
					for ($i = 0; $i <= $anzahlFehlerFormfelder-1; $i++)
					{
					echo '$("#'.$fehlerFelder[$i].'").css("background-color","#FFEDEF");'."\n";
					}
				}
	
			}
?>

	

/*-----------------------------------------------------------------------------------------------*/			
/*Anfang Cookie Check*/

var dt = new Date();  
dt.setSeconds(dt.getSeconds() + 60);  
document.cookie = "cookietest=1; expires=" + dt.toGMTString();  
var cookiesEnabled = document.cookie.indexOf("cookietest=") != -1;  


if(!cookiesEnabled)  
{

//alert("Bitte aktivieren Sie Cookies. Ohne diese wichtige Funktion kann das Programm nicht gestartet werden.");
$("#page #articles").fadeOut();
$("#page header").after('<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Cookie" target="_blank">Cookies</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div><br><br>');
} 
				
/*-----------------------------------------------------------------------------------------------*/			
/*Ende Cookie Check*/

<?
                    if($formular_jquery_check=="1")
					{
						/////////////////////////////////////////////
						$includeName="input_hilfe.php";
						if (file_exists($includeName))
						{
						include_once($includeName);
						}	
						else
						{
						echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>ERR_REG_INPUT_02</div><br><br>';	
						exit();
						}
						/////////////////////////////////////////////
					}
?>	
	
	
</script> 
		

<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>
</body>
</html>