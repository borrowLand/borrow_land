<?
session_start();

//Funktionen 
/////////////////////////////////////////////
$includeName="../../_00_basic_func.inc.php";
if (file_exists($includeName))
{
	require($includeName);
}	
else
{
	echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
	exit();
}

/////////////////////////////////////////////

//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="../../_01_basic_db.inc.php";
if (file_exists($includeName))
{
	require($includeName);
}	
else
{
	echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
	exit();
}

/////////////////////////////////////////////


//Sessions
/////////////////////////////////////////////
$includeName="../../_01_basic_sess.inc.php";
if (file_exists($includeName))
{
	require($includeName);
}	
else
{
	echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
	exit();
}

/////////////////////////////////////////////


//buttons (GET WERT h)
if ($_SESSION["User_Recht_Admin"]=="1" && $_GET['u']=="fjm_zQw")
{
	$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
	$consumerSecret = welcheEinstellung("SE_consumerSecret");
	$oAuthToken     = welcheEinstellung("SE_oAuthToken");
	$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");


	require_once('../../BL_TWITR/twitteroauth.php');

	// create a new instance
	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
	$user_info = $tweet->get('account/verify_credentials');  

	while (list($key, $value) = each($user_info)) 
	{
		//echo $key."_____".$value."<br>";

		if ($key=="profile_image_url" && $value!="")
		{
		echo "<br><br><img src='".$value."'><br>";
		$ok=1;
		}
		if ($key=="screen_name" && $value!="")
		{
		echo "<br><br>Profilname: ".$value;
		$profName=$value;
		$ok=1;
		}
		
		if ($key=="error" && $value=="Could not authenticate with OAuth.")
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'twitter test',
			pnotify_text: 'Die Daten konnten keinem twitter account zugeordnet werden.',
			pnotify_type: 'error'
			});
			</script>
			<?
			$ok=0;
		}
	}  
	if ($ok=="1")
	{
		
		if (EinstellungSetzen(SE_twitterName,mysql_real_escape_string($profName))=="1")
		{
		//anfang protokoll
		if ($_SESSION["SE_ProtokollAnAus"]==1)
		{
		protokollEintrag("0","2","Der twitter account ".$profName." wurde erfolgreich übernommen.");
		}
		//ende protokoll			
		
		?>
		<script>
		$.pnotify({
		pnotify_title: 'twitter Daten-Übernahme',
		pnotify_text: 'Das Profil wurde erfolgreich zugeordnet.'
		});
		</script>
		<?
		}
		else
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'twitter Daten-Übernahme',
		pnotify_text: 'Die Daten konnten leider nicht gespeichert werden.',
		pnotify_type: 'error'
		});
		</script>
		<?			
		}
	}
}


?>