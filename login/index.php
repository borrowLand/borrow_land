<?
session_start();
$includeName="../_01_basic_db.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
exit();
}

//mode=1	login form pass
//mode=2	benutzernamen vergessen



//anfang mode 1
if (!isset($_SESSION["User_ID"]) && isset($_POST["login_input1"]) && isset($_POST["login_input2"]) && $_POST["login_input1"]!="" && $_POST["login_input2"]!="" && $_SESSION["login_check1"]=== $_POST["jdhd65vnjhz63"] && $_POST["mode"]=="1" && ctype_alnum($_POST["login_input2"]))
{
	
	/*
	captcha!!
	*/
	$execLogin=1;
	if ($execLogin==1)
	{
		$email=trim($_POST["login_input1"]);
		if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
		{
		$sql = "SELECT pw_hash,specid_cyrpt_md5,ProfOnOff,rechte_ausleihe,rechte_ausgabeberechtigt,rechte_bestaetiger,rechte_dauerleihe,rechte_admin,userreg_selbst,userreg_bestaet,lastlogin FROM `01_Benutzer` WHERE `email` = '".mysql_real_escape_string(htmlentities($email, ENT_QUOTES))."' LIMIT 1";
		$rsd = mysql_query($sql);
		$msg = @mysql_num_rows($rsd); //1 die mail adresse gibt es => okay; gibt NULL aus bei nicht vorhandener Mail Addy deshalb @

			if ($msg=="1")
			{
			//alle relevantendaten zum user holen
			$DatabaseUserArray= mysql_fetch_row($rsd);
			//pw aus db holen
			$pwDatabase=trim($DatabaseUserArray[0]);

	
			//vergleich eingegebendes pw mit db passwort
			$inputPw=hash('sha256', trim($_POST["login_input2"]));
	
				if ($inputPw===$pwDatabase)
				{
				unset($_SESSION["MailIntrChck"]);

				//registrierung ist okay.
				session_regenerate_id(true);
					
				$_SESSION["User_ID"]=trim($DatabaseUserArray[1]);
				$_SESSION["User_ProfOnOff"]=trim($DatabaseUserArray[2]);
				$_SESSION["User_Recht_Ausleihe"]=trim($DatabaseUserArray[3]);
				$_SESSION["User_Recht_Ausgabeber"]=trim($DatabaseUserArray[4]);
				$_SESSION["User_Recht_Bestaet"]=trim($DatabaseUserArray[5]);
				$_SESSION["User_Recht_Dauerleih"]=trim($DatabaseUserArray[6]);
				$_SESSION["User_Recht_Admin"]=trim($DatabaseUserArray[7]);
				$_SESSION["User_Dat_RegSelbst"]=trim($DatabaseUserArray[8]);
				$_SESSION["User_Dat_RegBestaet"]=trim($DatabaseUserArray[9]);
				$_SESSION["User_Dat_lastlog"]=trim($DatabaseUserArray[10]);	
					
				//loginZeit in db
				$jetztLoginZeit= new DateTime();
				$loginDB_zeitJetzt=$jetztLoginZeit->format('U');
				$sql = "UPDATE `01_Benutzer` SET `lastlogin` = '".$loginDB_zeitJetzt."' WHERE `specid_cyrpt_md5` ='".$_SESSION["User_ID"]."' LIMIT 1";
				$laLoginDB = @mysql_query($sql);
				
					//weiterleitungen, abhängig vom aktivierten profil 
					if($_SESSION["User_ProfOnOff"]=="0")
					{
					Header("Location: ".$_SESSION["SE_festUrl"]."account/inactive/");
					exit(); 
					}
					else
					{
						if ($_SESSION["User_Recht_Ausgabeber"]=="1" || $_SESSION["User_Recht_Admin"]=="1")
						{
						Header("Location: ".$_SESSION["SE_festUrl"]."admini/adminLeihe/");
						exit(); 							
						}
						else
						{
						Header("Location: ".$_SESSION["SE_festUrl"]);
						exit(); 
						}
					}
				}
				else
				{
				//abgeschwächte ausgabe aus sicherheitsgründen (hier könnte explizit das PW als Fehler genannt werden
				$fehlerEinloggVorgang[]="Bitte überprüfen Sie Ihre Zugangsdaten.";
				}
			}
			else
			{
			//abgeschwächte ausgabe aus sicherheitsgründen (hier könnte explizit der benutzername/Mail addy genannt werden
			$fehlerEinloggVorgang[]="Bitte überprüfen Sie Ihre Zugangsdaten";
			}
		}
		else
		{
		$fehlerEinloggVorgang[]="Bitte überprüfen Sie das Format Ihres Benutzernamens.";
		//$_SESSION["MailIntrChck"]++;
		}
	}
}
//ende mode1

//System 
/////////////////////////////////////////////
$includeName="../_00_basic_check.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
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
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
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
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////	

	
//anfang mode 2

if (!isset($_SESSION["User_ID"]) && isset($_POST["login_input3"]) && $_POST["login_input3"]!="" && $_SESSION["login_check2"]=== $_POST["mcGhzw72hjsn"] && $_POST["mode"]=="2")
{

	$email=trim($_POST["login_input3"]);
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
	$sql = "SELECT userreg_selbst FROM `01_Benutzer` WHERE `email` = '".mysql_real_escape_string(htmlentities($email, ENT_QUOTES))."' LIMIT 1";
	$rsd = mysql_query($sql);
	$msg = mysql_num_rows($rsd); //1 die mail adresse gibt es => okay
	
		if ($msg=="1")
		{
			//anfang protokoll
			if ($_SESSION["SE_ProtokollAnAus"]==1)
			{
			protokollEintrag("3","2","Das Passwort des Benutzers ".mysql_real_escape_string(htmlentities($email, ENT_QUOTES))." wurde via E-Mail neu zugesendet.  IP:".getenv('REMOTE_ADDR'));
			}
			//ende protokoll

		$neuPW=CreatePassword2();
		
		$empfaenger=mysql_real_escape_string($email);						
		$betreff="Passwort-Neuzusendung, Ausleihe ".$_SESSION["SE_Kundenname"];
		$nachricht=utf8_encode(welcheEinstellung("SE_MailRecov"))."\r\n\r\n\r\nBenutzername: ".htmlentities($email, ENT_QUOTES)."\r\nPasswort: ".$neuPW."\r\n\n\r\n\r\n\r\n\r\n\r\n--\r\n\r\nErstellt mit http://www.borrow-land.de";
		$header="From: \"Ausleihe ".$_SESSION["SE_Kundenname"]. "\" <".$_SESSION["SE_adminEMail"].">";	

		$sql = 'UPDATE `01_Benutzer` SET `pw_hash` = \''.FUNK_VerSchluesseln($neuPW).'\' WHERE `email` = \''.mysql_real_escape_string(htmlentities($email, ENT_QUOTES)).'\' LIMIT 1;';
		$updaPW = mysql_query($sql); 
		$geaendert=mysql_affected_rows();
		
			if ($geaendert=="1")
			{
			$successMailChg=1;
			mail(htmlentities($empfaenger, ENT_QUOTES),$betreff,utf8_decode($nachricht),$header);
			}
		}
		
		else
		{
		$fehlerMailSchick[]="Ihre E-Mail Adresse konnte nicht gefunden werden.";
		}
	}
	else
	{
	$fehlerMailSchick[]="Bitte überprüfen Sie das Format Ihrer E-Mail Adresse.";
	}
		
}

//ende mode 2


?>

<!DOCTYPE html> 
<html>
<head>
<?
echo eval(welcheEinstellung("SE_headBereich"));
?>
</head>
<body>
<NOSCRIPT>
<br><br><br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	

<section id="page"> 
    
<header> 
            
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../index.php" title="Startseite"><img src="../BL_BILDER/start_00.png"></a> <a href="../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=1;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../">/Leihe</a>/Login</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../">/Leihe</a>/Login</div>
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
            
<section id="articles">

<!-- Article 1 start -->
<article id="article1"> 
                    
<h2>Login</h2>

<div class="line"></div>

<div style="margin-left:251px" class="articleBody clear">

<h4>Benutzername<br>
<form id="signInForm" autocomplete="off" method="post" action="index.php">
<input name="login_input1" id="login_input1" class="login_inputtext" type="text">
<input name="jdhd65vnjhz63" type="hidden" value="<?
$zufallswert=md5(uniqid(mt_rand(),true));
$_SESSION["login_check1"]=$zufallswert;
echo $zufallswert;
?>">
<input name="mode" type="hidden" id="mode" value="1">

<br><br>

<h4>Passwort<br>
<input name="login_input2" class="login_inputtext" type="password">

<?
/*
//wenn zweimal das pw falsch eingegeben worden ist, captcha abfrage
if ($_SESSION["MailIntrChck"]>=3)
{
?>
<br><br>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<? echo welcheEinstellung("SE_reCap_public"); ?>">
</script><br />
<noscript>
<iframe src="http://www.google.com/recaptcha/api/noscript?k=<? echo welcheEinstellung("SE_reCap_public"); ?>" height="300" width="500" ></iframe><br>
<textarea name="recaptcha_challenge_field" id="recaptcha_challenge_field" rows="3" cols="40">
</textarea>
<input type="hidden" name="recaptcha_response_field"  id="recaptcha_response_field" value="manual_challenge">
</noscript>
<?
}
*/
?>


<br><br>

<input aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all" value="Ausleihe starten" type="submit">
</form>
</div>

</article>
<!-- Article 1 end -->

<h4><div id="pwForg" style="cursor:pointer; width:300px">Passwort vergessen?</div></h4><br>

<!-- Article 2 start -->
<article id="article2" class="ui-helper-hidden"> 
                    
<h2>Passwort vergessen?</h2>

<div class="line"></div>

<div style="margin-left:251px" class="articleBody clear">
<h4>Ihre E-Mail Adresse</h4>
<form id="BenForgForm" autocomplete="off" method="post" action="index.php">
<input name="login_input3" class="login_inputtext" type="text">
<input name="mcGhzw72hjsn" type="hidden" value="<?
$zufallswert=md5(uniqid(mt_rand(),true));
$_SESSION["login_check2"]=$zufallswert;
echo $zufallswert;
?>">
<br><br>
<input name="mode" type="hidden" id="mode" value="2">
<input aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-hover" value="Passwort neu zusenden" type="submit">
</form>
</div>

</article>
<!-- Article 2 end -->

<!-- Article 3 start -->
<article id="article3" class="ui-helper-hidden"> 
                    
<h2>Hinweis Login</h2>

<div class="line"></div>

Sie haben bereits sich erfolgreich eingeloggt. Klicken Sie bitte <a href="../">hier</a>.

</article>
<!-- Article 3 end -->

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
	        
       
		</section> <!-- Closing the #page section -->

		 

        
        <!-- JavaScript Includes -->

		
<?
echo $_SESSION["SE_jQuerUI"];
?>  

<script>
    $("#pwForg").click(function () {
      $("#article2").slideToggle("slow");
    });

$("input:text:visible:first").focus();

</script>

	<?
	//fehlerproducing mode1
	if (count($fehlerEinloggVorgang) > 0 )
	{
	echo "<script>";
	for ($i = 0; $i < (count($fehlerEinloggVorgang)); $i++)
		{
		?>
		$.pnotify({
		pnotify_title: 'Fehler Login',
		pnotify_text: '<? echo $fehlerEinloggVorgang[$i]; ?>',
		pnotify_type: 'error'
		});
		<?
		}
	echo "</script>";		
	}

	//fehlerproducing mode2
	if (count($fehlerMailSchick) > 0 )
	{
	echo "<script>";
	for ($i = 0; $i < (count($fehlerMailSchick)); $i++)
		{
		?>
		$.pnotify({
		pnotify_title: 'Fehler Passwort Zusendung',
		pnotify_text: '<? echo $fehlerMailSchick[$i]; ?>',
		pnotify_type: 'error'
		});
		<?
		}
	echo '$("#article2").show()';
	echo "</script>";		
	}
	
//erfolg pw chg
	if ($successMailChg=="1")
	{
	echo "<script>";
		?>
		$.pnotify({
		pnotify_title: 'Passwort-Änderung',
		pnotify_text: 'Das Passwort wurde erfolgreich geändert. Bitte überprüfen Sie Ihr E-Mail Postfach (inklusive dem Spam Ordner). ',
		});
		<?
	echo "</script>";		
	}	
	
	
	?>

	<?
	if (isset($_SESSION["User_ID"]))
	{
	?>
	<script>
	$('#article1').hide();
	$('#article2').hide();
	$('#pwForg').hide();
	$('#article3').show();
	$.pnotify({
					pnotify_title: 'Hinweis Login',
					pnotify_text: 'Sie sind bereits eingeloggt.',
					
					});
	</script>
	<?				
	}

	?>


<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

</body>
</html>