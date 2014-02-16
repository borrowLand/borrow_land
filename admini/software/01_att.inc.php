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
if (isset($_SESSION["User_ID"]) && isset($_GET['h']) && $_GET['h']!="" && $_SESSION["User_Recht_Admin"]=="1")
{
	//Adresse
	if ($_GET['h']=="Mod_Adress")
	{
		switch (welcheEinstellung(SE_AdressModuleYesNo))
		{
		case "0":
			if (EinstellungSetzen(SE_AdressModuleYesNo,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_AdressModuleYesNo,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}

	//monMOdul
	if ($_GET['h']=="Mod_Money")
	{
		switch (welcheEinstellung(SE_MoneyModule))
		{
		case "0":
			if (EinstellungSetzen(SE_MoneyModule,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_MoneyModule,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}
	
	//monMOdul
	if ($_GET['h']=="Mod_Money2")
	{
		switch (welcheEinstellung(SE_MoneyModule_Mietp))
		{
		case "0":
			if (EinstellungSetzen(SE_MoneyModule_Mietp,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_MoneyModule_Mietp,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}

	//Zugang
	if ($_GET['h']=="Mod_access")
	{
		switch (welcheEinstellung(SE_AccessContrYN))
		{
		case "0":
			if (EinstellungSetzen(SE_AccessContrYN,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_AccessContrYN,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}

	//Vortext
	if ($_GET['h']=="Mod_Vortext")
	{
		switch (welcheEinstellung(SE_vortextJaNein))
		{
		case "0":
			if (EinstellungSetzen(SE_vortextJaNein,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_vortextJaNein,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}

	//GoogleTrans
	if ($_GET['h']=="Mod_UebersGoo")
	{
		switch (welcheEinstellung(SE_GooTrans))
		{
		case "0":
			if (EinstellungSetzen(SE_GooTrans,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_GooTrans,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}
	
	//leihe nach registrierung
	if ($_GET['h']=="Mod_LeiheAftReg")
	{
		switch (welcheEinstellung(SE_GleichLeiheMoegli))
		{
		case "0":
			if (EinstellungSetzen(SE_GleichLeiheMoegli,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_GleichLeiheMoegli,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}	
	//profil nach registrierung
	if ($_GET['h']=="Mod_ProfAftReg")
	{
		switch (welcheEinstellung(SE_ProfilOnOff))
		{
		case "0":
			if (EinstellungSetzen(SE_ProfilOnOff,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_ProfilOnOff,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}

	//leihmodus hauptgruppe
	if ($_GET['h']=="Mod_lendMod1")
	{
		switch (welcheEinstellung(SE_ViewLeihmodHauptg))
		{
		case "0":
			if (EinstellungSetzen(SE_ViewLeihmodHauptg,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_ViewLeihmodHauptg,"0")=="1")
			{
			$erfolg=1;
			}
			//wenn die anderen beiden auch aus sind, hinweis!
			if (welcheEinstellung(SE_ViewLeihmodTag)=="0" && welcheEinstellung(SE_ViewLeihmodEinzel)=="0")
			{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Leihe deaktiviert',
			pnotify_text: 'Da kein Leihmodus aktiviert ist, ist derzeit die Leihe deaktiviert.',
			pnotify_type: 'error',
			});
			</script>
			<?
			}
			break;
		}
	}
	

	//leihmodus einzelgerät
	if ($_GET['h']=="Mod_lendMod2")
	{
		switch (welcheEinstellung(SE_ViewLeihmodEinzel))
		{
		case "0":
			if (EinstellungSetzen(SE_ViewLeihmodEinzel,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_ViewLeihmodEinzel,"0")=="1")
			{
			$erfolg=1;
			}
			//wenn die anderen beiden auch aus sind, hinweis!
			if (welcheEinstellung(SE_ViewLeihmodTag)=="0" && welcheEinstellung(SE_ViewLeihmodHauptg)=="0")
			{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Leihe deaktiviert',
			pnotify_text: 'Da kein Leihmodus aktiviert ist, ist derzeit die Leihe deaktiviert.',
			pnotify_type: 'error',
			
			});
			</script>
			<?
			}
			break;
		}
	}
	

	//leihmodus tags
	if ($_GET['h']=="Mod_lendMod3")
	{
		switch (welcheEinstellung(SE_ViewLeihmodTag))
		{
		case "0":
			if (EinstellungSetzen(SE_ViewLeihmodTag,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_ViewLeihmodTag,"0")=="1")
			{
			$erfolg=1;
			}
			//wenn die anderen beiden auch aus sind, hinweis!
			if (welcheEinstellung(SE_ViewLeihmodEinzel)=="0" && welcheEinstellung(SE_ViewLeihmodHauptg)=="0")
			{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Leihe deaktiviert',
			pnotify_text: 'Da kein Leihmodus aktiviert ist, ist derzeit die Leihe deaktiviert.',
			pnotify_type: 'error',
			});
			</script>
			<?
			}

			break;
		}
	}
	
	
	//class="ui-state-disabled"
	//öffnungszeiten montag
	if ($_GET['h']=="geschl_mo24")
	{
		switch (welcheEinstellung(SE_MoGeschlOderZeite))
		{
		case "0":
			if (EinstellungSetzen(SE_MoGeschlOderZeite,"1")=="1")
			{
			//da die leihe 24h offen ist, wird der erste zeitwert von 00-24 uhr gesetzt, der zweite mit "-"
			?>
			<script>
			$("#geschl_mo24").closest("td").next().removeClass("ui-state-disabled").next().removeClass("ui-state-disabled");
			$("#sRgMo1, #sRgMo2").slider({ enable: true });
			$("#sRgMo1, #sRgMo2").slider({ disabled: false });
			</script>
			<?
			
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Montag ist die Leihe ab heute geöffnet. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter
			
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_MoGeschlOderZeite,"0")=="1")
			{
				//wenn alle anderen auch deaktivert: leihe aus!
				if (welcheEinstellung(SE_SoGeschlOderZeite)=="0" && welcheEinstellung(SE_SaGeschlOderZeite)=="0" && welcheEinstellung(SE_FrGeschlOderZeite)=="0" && welcheEinstellung(SE_MiGeschlOderZeite)=="0" && welcheEinstellung(SE_DiGeschlOderZeite)=="0" && welcheEinstellung(SE_DoGeschlOderZeite)=="0")
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Leihe deaktiviert',
				pnotify_text: 'Da kein anderer Tag mehr aktiviert ist, ist die Leihe derzeit deaktiviert.',
				pnotify_type: 'error',
				});
				</script>
				<?
				}
			?>
			<script>
			$("#geschl_mo24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
			$("#sRgMo1, #sRgMo2").slider({ disabled: true });
			$("#sRgMo1, #sRgMo2").slider({ enabled: false });
			</script>
			<?
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Montag ist die Leihe ab heute geschlossen. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	
			$erfolg=1;
			}
			break;
		}
	}	
	
	//öffnungszeiten dienstag
	if ($_GET['h']=="geschl_di24")
	{
		switch (welcheEinstellung(SE_DiGeschlOderZeite))
		{
		case "0":
			if (EinstellungSetzen(SE_DiGeschlOderZeite,"1")=="1")
			{
			//da die leihe 24h offen ist, wird der erste zeitwert von 00-24 uhr gesetzt, der zweite mit "-"
			?>
			<script>
			$("#geschl_di24").closest("td").next().removeClass("ui-state-disabled").next().removeClass("ui-state-disabled");
			$("#sRgDi1, #sRgDi2").slider({ enable: true });
			$("#sRgDi1, #sRgDi2").slider({ disabled: false });			
			</script>
			<?
			
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Dientag ist die Leihe ab heute geöffnet. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter			
			
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_DiGeschlOderZeite,"0")=="1")
			{
				//wenn alle anderen auch deaktivert: leihe aus!
				if (welcheEinstellung(SE_SoGeschlOderZeite)=="0" && welcheEinstellung(SE_SaGeschlOderZeite)=="0" && welcheEinstellung(SE_FrGeschlOderZeite)=="0" && welcheEinstellung(SE_MiGeschlOderZeite)=="0" && welcheEinstellung(SE_DoGeschlOderZeite)=="0" && welcheEinstellung(SE_MoGeschlOderZeite)=="0")
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Leihe deaktiviert',
				pnotify_text: 'Da kein anderer Tag mehr aktiviert ist, ist die Leihe derzeit deaktiviert.',
				pnotify_type: 'error',
				});
				</script>
				<?
				}
			?>
			<script>
			$("#geschl_di24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
			$("#sRgDi1, #sRgDi2").slider({ disabled: true });
			$("#sRgDi1, #sRgDi2").slider({ enabled: false });			
			</script>
			<?
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Dienstag ist die Leihe ab heute geschlossen. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	
			$erfolg=1;
			}
			break;
		}
	}	
	
	//öffnungszeiten mittwoch
	if ($_GET['h']=="geschl_mi24")
	{
		switch (welcheEinstellung(SE_MiGeschlOderZeite))
		{
		case "0":
			if (EinstellungSetzen(SE_MiGeschlOderZeite,"1")=="1")
			{
			//da die leihe 24h offen ist, wird der erste zeitwert von 00-24 uhr gesetzt, der zweite mit "-"
			?>
			<script>
			$("#geschl_mi24").closest("td").next().removeClass("ui-state-disabled").next().removeClass("ui-state-disabled");
			$("#sRgMi1, #sRgMi2").slider({ enable: true });
			$("#sRgMi1, #sRgMi2").slider({ disabled: false });			
			</script>
			<?

			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Mittwoch ist die Leihe ab heute geöffnet. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	

			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_MiGeschlOderZeite,"0")=="1")
			{
				//wenn alle anderen auch deaktivert: leihe aus!
				if (welcheEinstellung(SE_SoGeschlOderZeite)=="0" && welcheEinstellung(SE_SaGeschlOderZeite)=="0" && welcheEinstellung(SE_FrGeschlOderZeite)=="0" && welcheEinstellung(SE_DoGeschlOderZeite)=="0" && welcheEinstellung(SE_DiGeschlOderZeite)=="0" && welcheEinstellung(SE_MoGeschlOderZeite)=="0")
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Leihe deaktiviert',
				pnotify_text: 'Da kein anderer Tag mehr aktiviert ist, ist die Leihe derzeit deaktiviert.',
				pnotify_type: 'error',
				});
				</script>
				<?
				}
			?>
			<script>
			$("#geschl_mi24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
			$("#sRgMi1, #sRgMi2").slider({ disabled: true });
			$("#sRgMi1, #sRgMi2").slider({ enabled: false });
			</script>
			<?
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Mittwoch ist die Leihe ab heute geschlossen. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	
			$erfolg=1;
			}
			break;
		}
	}		
	
	
	//öffnungszeiten donnerstag
	if ($_GET['h']=="geschl_do24")
	{
		switch (welcheEinstellung(SE_DoGeschlOderZeite))
		{
		case "0":
			if (EinstellungSetzen(SE_DoGeschlOderZeite,"1")=="1")
			{
			//da die leihe 24h offen ist, wird der erste zeitwert von 00-24 uhr gesetzt, der zweite mit "-"
			?>
			
			<script>
			$("#geschl_do24").closest("td").next().removeClass("ui-state-disabled").next().removeClass("ui-state-disabled");
			$("#sRgDo1, #sRgDo2").slider({ enable: true });
			$("#sRgDo1, #sRgDo2").slider({ disabled: false });			
			</script>
			<?
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Donnerstag ist die Leihe ab heute geöffnet. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	

			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_DoGeschlOderZeite,"0")=="1")
			{
				//wenn alle anderen auch deaktivert: leihe aus!
				if (welcheEinstellung(SE_SoGeschlOderZeite)=="0" && welcheEinstellung(SE_SaGeschlOderZeite)=="0" && welcheEinstellung(SE_FrGeschlOderZeite)=="0" && welcheEinstellung(SE_MiGeschlOderZeite)=="0" && welcheEinstellung(SE_DiGeschlOderZeite)=="0" && welcheEinstellung(SE_MoGeschlOderZeite)=="0")
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Leihe deaktiviert',
				pnotify_text: 'Da kein anderer Tag mehr aktiviert ist, ist die Leihe derzeit deaktiviert.',
				pnotify_type: 'error',
				});
				</script>
				<?
				}
			?>
			<script>
			$("#geschl_do24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
			$("#sRgDo1, #sRgDo2").slider({ disabled: true });
			$("#sRgDo1, #sRgDo2").slider({ enabled: false });
			</script>
			<?
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Donnerstag ist die Leihe ab heute geschlossen. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	
			$erfolg=1;
			}
			break;
		}
	}		
	
	//öffnungszeiten freitag
	if ($_GET['h']=="geschl_fr24")
	{
		switch (welcheEinstellung(SE_FrGeschlOderZeite))
		{
		case "0":
			if (EinstellungSetzen(SE_FrGeschlOderZeite,"1")=="1")
			{
			//da die leihe 24h offen ist, wird der erste zeitwert von 00-24 uhr gesetzt, der zweite mit "-"
			?>
			<script>
			$("#geschl_fr24").closest("td").next().removeClass("ui-state-disabled").next().removeClass("ui-state-disabled");
			$("#sRgFr1, #sRgFr2").slider({ enable: true });
			$("#sRgFr1, #sRgFr2").slider({ disabled: false });
			</script>
			<?
			$erfolg=1;

			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Freitag ist die Leihe ab heute geöffnet. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	

			}
			break;
		case "1":
			if (EinstellungSetzen(SE_FrGeschlOderZeite,"0")=="1")
			{
				//wenn alle anderen auch deaktivert: leihe aus!
				if (welcheEinstellung(SE_SoGeschlOderZeite)=="0" && welcheEinstellung(SE_SaGeschlOderZeite)=="0" && welcheEinstellung(SE_DoGeschlOderZeite)=="0" && welcheEinstellung(SE_MiGeschlOderZeite)=="0" && welcheEinstellung(SE_DiGeschlOderZeite)=="0" && welcheEinstellung(SE_MoGeschlOderZeite)=="0")
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Leihe deaktiviert',
				pnotify_text: 'Da kein anderer Tag mehr aktiviert ist, ist die Leihe derzeit deaktiviert.',
				pnotify_type: 'error',
				});
				</script>
				<?
				}

			?>
			<script>
			$("#geschl_fr24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
			$("#sRgFr1, #sRgFr2").slider({ disabled: true });
			$("#sRgFr1, #sRgFr2").slider({ enabled: false });
			</script>
			<?
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Freitag ist die Leihe ab heute geschlossen. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	
			$erfolg=1;
			}
			break;
		}
	}
	
	//öffnungszeiten samstag
	if ($_GET['h']=="geschl_sa24")
	{
		switch (welcheEinstellung(SE_SaGeschlOderZeite))
		{
		case "0":
			if (EinstellungSetzen(SE_SaGeschlOderZeite,"1")=="1")
			{
			//da die leihe 24h offen ist, wird der erste zeitwert von 00-24 uhr gesetzt, der zweite mit "-"
			?>
			<script>
			$("#geschl_sa24").closest("td").next().removeClass("ui-state-disabled").next().removeClass("ui-state-disabled");
			$("#sRgSa1, #sRgSa2").slider({ enable: true });
			$("#sRgSa1, #sRgSa2").slider({ disabled: false });
			</script>
			<?
			
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Sonnabend ist die Leihe ab heute geöffnet. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter
			
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_SaGeschlOderZeite,"0")=="1")
			{
				//wenn alle anderen auch deaktivert: leihe aus!
				if (welcheEinstellung(SE_SoGeschlOderZeite)=="0" && welcheEinstellung(SE_FrGeschlOderZeite)=="0" && welcheEinstellung(SE_DoGeschlOderZeite)=="0" && welcheEinstellung(SE_MiGeschlOderZeite)=="0" && welcheEinstellung(SE_DiGeschlOderZeite)=="0" && welcheEinstellung(SE_MoGeschlOderZeite)=="0")
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Leihe deaktiviert',
				pnotify_text: 'Da kein anderer Tag mehr aktiviert ist, ist die Leihe derzeit deaktiviert.',
				pnotify_type: 'error',
				});
				</script>
				<?
				}

			?>
			<script>
			$("#geschl_sa24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
			$("#sRgSa1, #sRgSa2").slider({ disabled: true });
			$("#sRgSa1, #sRgSa2").slider({ enabled: false });
			</script>
			<?
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Sonnabend ist die Leihe ab heute geschlossen. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	

			$erfolg=1;
			}
			break;
		}
	}			
				
	
	//öffnungszeiten sonntag
	if ($_GET['h']=="geschl_so24")
	{
		switch (welcheEinstellung(SE_SoGeschlOderZeite))
		{
		case "0":
			if (EinstellungSetzen(SE_SoGeschlOderZeite,"1")=="1")
			{
			//da die leihe 24h offen ist, wird der erste zeitwert von 00-24 uhr gesetzt, der zweite mit "-"
			?>
			<script>
			$("#geschl_so24").closest("td").next().removeClass("ui-state-disabled").next().removeClass("ui-state-disabled");
			$("#sRgSo1, #sRgSo2").slider({ enable: true });
			$("#sRgSo1, #sRgSo2").slider({ disabled: false });
			</script>
			<?
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Sonntag ist die Leihe ab heute geöffnet. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	
			
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_SoGeschlOderZeite,"0")=="1")
			{
				//wenn alle anderen auch deaktivert: leihe aus!
				if (welcheEinstellung(SE_SaGeschlOderZeite)=="0" && welcheEinstellung(SE_FrGeschlOderZeite)=="0" && welcheEinstellung(SE_DoGeschlOderZeite)=="0" && welcheEinstellung(SE_MiGeschlOderZeite)=="0" && welcheEinstellung(SE_DiGeschlOderZeite)=="0" && welcheEinstellung(SE_MoGeschlOderZeite)=="0")
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Leihe deaktiviert',
				pnotify_text: 'Da kein anderer Tag mehr aktiviert ist, ist die Leihe derzeit deaktiviert.',
				pnotify_type: 'error',
				});
				</script>
				<?
				}
			
			?>
			<script>
			$("#geschl_so24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
			$("#sRgSo1, #sRgSo2").slider({ disabled: true });
			$("#sRgSo1, #sRgSo2").slider({ enabled: false });
			</script>
			<?
			//anfang twitter
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Am Sonntag ist die Leihe ab heute geschlossen. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter	
			
			
			$erfolg=1;
			}
			break;
		}
	}			
				
	//protokoll
	if ($_GET['h']=="Mod_ProtOnOff")
	{
		switch (welcheEinstellung(SE_ProtokollAnAus))
		{
		case "0":
			if (EinstellungSetzen(SE_ProtokollAnAus,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_ProtokollAnAus,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}

	//cronjob
	if ($_GET['h']=="Mod_AdStatOnOff")
	{
		switch (welcheEinstellung(SE_cronJob))
		{
		case "0":
			if (EinstellungSetzen(SE_cronJob,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_cronJob,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}
	
	//twitter
	if ($_GET['h']=="Mod_twitr")
	{
		switch (welcheEinstellung(SE_twitterModuleActi))
		{
		case "0":
			if (EinstellungSetzen(SE_twitterModuleActi,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_twitterModuleActi,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}
	
	
	
	//benachrichtigung bei fälligkeit
	if ($_GET['h']=="Mod_messFae")
	{
		switch (welcheEinstellung(SE_InfoFaellObj))
		{
		case "0":
			if (EinstellungSetzen(SE_InfoFaellObj,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_InfoFaellObj,"0")=="1")
			{
			$erfolg=1;
			}
			//wenn die anderen beiden auch aus sind, hinweis!
			break;
		}
	}

	//RFID
	if ($_GET['h']=="Mod_RFID")
	{
		switch (welcheEinstellung(SE_RFIDModule))
		{
		case "0":
			if (EinstellungSetzen(SE_RFIDModule,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_RFIDModule,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}

	//Versand
	if ($_GET['h']=="Mod_Versand")
	{
		switch (welcheEinstellung(SE_versandMod))
		{
		case "0":
			if (EinstellungSetzen(SE_versandMod,"1")=="1")
			{
			$erfolg=1;
			}
			break;
		case "1":
			if (EinstellungSetzen(SE_versandMod,"0")=="1")
			{
			$erfolg=1;
			}
			break;
		}
	}


	
}

//texte (POST WERT t) SPEZIALEINFÜHRUNG LANGE TEXTE
if (isset($_SESSION["User_ID"]) && isset($_POST['t']) && $_POST['t']!="" && $_SESSION["User_Recht_Admin"]=="1")
{
$teile = explode("|", $_POST['t']);
$inhalt=utf8_decode(rawurldecode($teile[1]));
		switch ($teile[0])
		{
		case "txt_vortxt":
			if (EinstellungSetzen(SE_vortextInhalt,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;
		
		case "txt_MailNachReg":
			if (EinstellungSetzen(SE_TextRegBestaetigu,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;			
			
		case "txt_imprint":
			if (EinstellungSetzen(SE_imprint,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;
		
		case "txt_gooTrCod":
			if (EinstellungSetzen(SE_GooTransScript,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;		

		}
}


//texte (GET WERT t)
if (isset($_SESSION["User_ID"]) && isset($_GET['t']) && $_GET['t']!="" && $_SESSION["User_Recht_Admin"]=="1")
{
$teile = explode("|", $_GET['t']);
$inhalt=utf8_decode(rawurldecode($teile[1]));
		switch ($teile[0])
		{
		case "txt_bezChec":
			if (EinstellungSetzen(SE_AccessContrName,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;

		case "txt_regOrgaNam":
			if (EinstellungSetzen(SE_Kundenname,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
		
		case "txt_regMail":
			if (EinstellungSetzen(SE_adminEMail,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
		
		
		case "txt_reCap1":
			if (EinstellungSetzen(SE_reCap_private,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;		
		
		case "txt_reCap2":
			if (EinstellungSetzen(SE_reCap_public,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
					
		case "txt_FutStdUsr":
			if (EinstellungSetzen(SE_normaloMaxStartTa,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;

		case "txt_FutAdvUsr":
			if (EinstellungSetzen(SE_DauerleiheMaxStar,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;				
		
		case "txt_MaxDaysStdUsr":
			if (EinstellungSetzen(SE_normaloMaxDauerTa,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;

		case "txt_MaxDaysAdvUsr":
			if (EinstellungSetzen(SE_DauerleiheMaxDaue,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;				
		
		case "txt_ElemWK":
			if (EinstellungSetzen(SE_AnzahlElemWKMax,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
	
		case "txt_AutoUserDel":
			if (EinstellungSetzen(SE_VerfallAccountTag,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
  
		case "txt_AutoWKDel":
			if (EinstellungSetzen(SE_VerfallWkTag,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;			
			
		case "minMinChg":
			$teile = explode(" ", $inhalt);
			if (is_numeric($teile[0]))
			{
			$teileZeit=round(60/$teile[0]);
				if (EinstellungSetzen(SE_IntervStunde,mysql_real_escape_string($teileZeit))=="1")
				{
				
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Festlegung Stunden-Einteilung',
				pnotify_text: 'Der Wert wurde auf <? echo 60/$teileZeit; ?> min festgelegt.',
				});
				</script>
				<?
				
				$erfolg=1;
				}
			}
			break;				
			
		case "txt_ZeiRes":
			if (EinstellungSetzen(SE_TimeFreigabeLeihe,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;				
			
		case "txt_twitr_1":
			if (EinstellungSetzen(SE_auth_consumerKey,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	

		case "txt_twitr_2":
			if (EinstellungSetzen(SE_consumerSecret,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	

		case "txt_twitr_3":
			if (EinstellungSetzen(SE_oAuthToken,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	

		case "txt_twitr_4":
			if (EinstellungSetzen(SE_oAuthSecret,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
		
		

		case "txt_OeffnNote_MO":
			if (EinstellungSetzen(SE_infoOeff_MO,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
		
				
		
		case "txt_OeffnNote_DI":
			if (EinstellungSetzen(SE_infoOeff_DI,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
		
					

		case "txt_OeffnNote_MI":
			if (EinstellungSetzen(SE_infoOeff_MI,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
		
					
		
		case "txt_OeffnNote_DO":
			if (EinstellungSetzen(SE_infoOeff_DO,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
		
			

		case "txt_OeffnNote_FR":
			if (EinstellungSetzen(SE_infoOeff_FR,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
		
			

		case "txt_OeffnNote_SA":
			if (EinstellungSetzen(SE_infoOeff_SA,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
		
		

		case "txt_OeffnNote_SO":
			if (EinstellungSetzen(SE_infoOeff_SO,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;	
		
		case "txt_VersandUrl":
			if (EinstellungSetzen(SE_versandURL,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;
		
		case "txt_VersandPreis":
			if (EinstellungSetzen(SE_versandPreisAll,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;		

		case "txt_Maxtags":
			if (EinstellungSetzen(SE_tagAnzahl,mysql_real_escape_string($inhalt))=="1")
			{
			$erfolg=1;
			}
			break;		

		}
}

//uhrzeit bei öffnungszeit (GET WERT u)
if (isset($_SESSION["User_ID"]) && isset($_GET['u']) && $_GET['u']!="" && $_SESSION["User_Recht_Admin"]=="1")
{
$teile = explode("|", $_GET['u']);

	//14 datenpaare -> 2x 7 tage -> okay
	if (count($teile)=="14")
	{

		for ($i=0;$i<count($teile);$i++)
		{
		$tmp = explode("-", $teile[$i]);
		$daten[]=$tmp[0];
		$daten[]=$tmp[1];
		}

		//var_dump($daten);
		//in demm array liegen nun 28 uhrzeiten zum vergleichn.
		
		//##################################################################################################################################moAnfang
		//montag: überprüfung 1. zeitraum mit 2. zeitraum
		if ($daten[2]<=$daten[1])
		{
			if ($daten[2]=="0" && $daten[3]=="0")
			{
			}
			else
			{
				if ($daten[1]+1<24)
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Montag folgt der 2. Zeitraum nicht dem 1. Zeitraum. Hinweis: Ab <? echo $daten[1]+1; ?> Uhr wäre die nächste mögliche Einstellung.',
				});
				</script>
				<?	
				}
				else
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Montag folgt der 2. Zeitraum nicht dem 1. Zeitraum.',
				});
				</script>
				<?	
				}
			$datumfehler=1;
			}
		}
		
		//montag: überprüfung gleiche zeiträume
		if ($daten[0]==$daten[1])
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Montag ist der Start- und Endzeitraum im 1. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		
		}	

		//montag: überprüfung gleiche zeiträume
		if ($daten[2]==$daten[3] && ($daten[2]!="0" && $daten[3]!="0"))
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Montag ist der Start- und Endzeitraum im 2. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	
		//##################################################################################################################################moEnde		
		
		
		
		//##################################################################################################################################moAnfang
		//dienstag: überprüfung 1. zeitraum mit 2. zeitraum
		if ($daten[6]<=$daten[5])
		{
			if ($daten[6]=="0" && $daten[7]=="0")
			{
			}
			else
			{
				if ($daten[5]+1<24)
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Dienstag folgt der 2. Zeitraum nicht dem 1. Zeitraum. Hinweis: Ab <? echo $daten[5]+1; ?> Uhr wäre die nächste mögliche Einstellung.',
				});
				</script>
				<?	
				}
				else
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Dienstag folgt der 2. Zeitraum nicht dem 1. Zeitraum.',
				});
				</script>
				<?	
				}
			$datumfehler=1;
			}
		}
		
		//dienstag: überprüfung gleiche zeiträume
		if ($daten[4]==$daten[5])
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Dienstag ist der Start- und Endzeitraum im 1. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	

		//dienstag: überprüfung gleiche zeiträume
		if ($daten[6]==$daten[7] && ($daten[6]!="0" && $daten[7]!="0"))
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Dienstag ist der Start- und Endzeitraum im 2. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	
		//##################################################################################################################################diEnde		
		
		//##################################################################################################################################miAnfang
		//Mittwoch: überprüfung 1. zeitraum mit 2. zeitraum
		if ($daten[10]<=$daten[9])
		{
			if ($daten[10]=="0" && $daten[11]=="0")
			{
			}
			else
			{
				if ($daten[9]+1<24)
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Mittwoch folgt der 2. Zeitraum nicht dem 1. Zeitraum. Hinweis: Ab <? echo $daten[9]+1; ?> Uhr wäre die nächste mögliche Einstellung.',
				});
				</script>
				<?	
				}
				else
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Mittwoch folgt der 2. Zeitraum nicht dem 1. Zeitraum.',
				});
				</script>
				<?	
				}
				$datumfehler=1;
			}
		}
		
		//Mittwoch: überprüfung gleiche zeiträume
		if ($daten[8]==$daten[9])
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Mittwoch ist der Start- und Endzeitraum im 1. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	

		//Mittwoch: überprüfung gleiche zeiträume
		if ($daten[10]==$daten[11] && ($daten[10]!="0" && $daten[11]!="0"))
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Mittwoch ist der Start- und Endzeitraum im 2. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	
		//##################################################################################################################################miEnde		
		
		
		//##################################################################################################################################doAnfang
		//Donnerstag: überprüfung 1. zeitraum mit 2. zeitraum
		if ($daten[14]<=$daten[13])
		{
			if ($daten[14]=="0" && $daten[15]=="0")
			{
			}
			else
			{
				if ($daten[13]+1<24)
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Donnerstag folgt der 2. Zeitraum nicht dem 1. Zeitraum. Hinweis: Ab <? echo $daten[13]+1; ?> Uhr wäre die nächste mögliche Einstellung.',
				});
				</script>
				<?	
				}
				else
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Donnerstag folgt der 2. Zeitraum nicht dem 1. Zeitraum.',
				});
				</script>
				<?	
				}
				$datumfehler=1;
			}
		}
		
		//Donnerstag: überprüfung gleiche zeiträume
		if ($daten[12]==$daten[13])
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Donnerstag ist der Start- und Endzeitraum im 1. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	

		//Donnerstag: überprüfung gleiche zeiträume
		if ($daten[14]==$daten[15] && ($daten[14]!="0" && $daten[15]!="0"))
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Donnerstag ist der Start- und Endzeitraum im 2. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	
		//##################################################################################################################################doEnde		
		
		//##################################################################################################################################frAnfang
		//Freitag: überprüfung 1. zeitraum mit 2. zeitraum
		if ($daten[18]<=$daten[17])
		{
			if ($daten[18]=="0" && $daten[19]=="0")
			{
			}
			else
			{
				if ($daten[17]+1<24)
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Freitag folgt der 2. Zeitraum nicht dem 1. Zeitraum. Hinweis: Ab <? echo $daten[17]+1; ?> Uhr wäre die nächste mögliche Einstellung.',
				});
				</script>
				<?	
				}
				else
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Freitag folgt der 2. Zeitraum nicht dem 1. Zeitraum.',
				});
				</script>
				<?	
				}
			$datumfehler=1;
			}
		}
		
		//Freitag: überprüfung gleiche zeiträume
		if ($daten[16]==$daten[17])
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Freitag ist der Start- und Endzeitraum im 1. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	

		//Freitag: überprüfung gleiche zeiträume
		if ($daten[18]==$daten[19] && ($daten[18]!="0" && $daten[19]!="0"))
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Freitag ist der Start- und Endzeitraum im 2. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	
		//##################################################################################################################################frEnde		
			
		//##################################################################################################################################saAnfang
		//Sonnabend: überprüfung 1. zeitraum mit 2. zeitraum
		if ($daten[22]<=$daten[21])
		{
			if ($daten[22]=="0" && $daten[23]=="0")
			{
			}
			else
			{
				if ($daten[21]+1<24)
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Sonnabend folgt der 2. Zeitraum nicht dem 1. Zeitraum. Hinweis: Ab <? echo $daten[21]+1; ?> Uhr wäre die nächste mögliche Einstellung.',
				});
				</script>
				<?	
				}
				else
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Sonnabend folgt der 2. Zeitraum nicht dem 1. Zeitraum.',
				});
				</script>
				<?	
				}
			$datumfehler=1;
			}
		}
		
		//Sonnabend: überprüfung gleiche zeiträume
		if ($daten[20]==$daten[21])
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Sonnabend ist der Start- und Endzeitraum im 1. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	

		//Sonnabend: überprüfung gleiche zeiträume
		if ($daten[22]==$daten[23] && ($daten[22]!="0" && $daten[23]!="0"))
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Sonnabend ist der Start- und Endzeitraum im 2. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	
		//##################################################################################################################################saEnde		
			
		//##################################################################################################################################soAnfang
		//Sonntag: überprüfung 1. zeitraum mit 2. zeitraum
		if ($daten[26]<=$daten[25])
		{
			if ($daten[26]=="0" && $daten[27]=="0")
			{
			}
			else
			{
				if ($daten[25]+1<24)
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Sonntag folgt der 2. Zeitraum nicht dem 1. Zeitraum. Hinweis: Ab <? echo $daten[25]+1; ?> Uhr wäre die nächste mögliche Einstellung.',
				});
				</script>
				<?	
				}
				else
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Öffnungszeiten-Überprüfung',
				pnotify_text: 'Am Sonntag folgt der 2. Zeitraum nicht dem 1. Zeitraum.',
				});
				</script>
				<?	
				}
			$datumfehler=1;
			}
		}
		
		//Sonntag: überprüfung gleiche zeiträume
		if ($daten[24]==$daten[25])
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Sonntag ist der Start- und Endzeitraum im 1. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	

		//Sonntag: überprüfung gleiche zeiträume
		if ($daten[26]==$daten[27] && ($daten[26]!="0" && $daten[27]!="0"))
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Öffnungszeiten-Überprüfung',
		pnotify_text: 'Am Sonntag ist der Start- und Endzeitraum im 2. Zeitsegment gleich.',
		});
		</script>
		<?
		$datumfehler=1;
		}	
		//##################################################################################################################################soEnde		
			

		//erzeugung von "-"
		if ($daten[2]=="0" && $daten[3]=="0")
		{
		$daten[2]="-";
		$daten[3]="-";
		}

		if ($daten[6]=="0" && $daten[7]=="0")
		{
		$daten[6]="-";
		$daten[7]="-";
		}

		if ($daten[10]=="0" && $daten[11]=="0")
		{
		$daten[10]="-";
		$daten[11]="-";
		}
		if ($daten[14]=="0" && $daten[15]=="0")
		{
		$daten[14]="-";
		$daten[15]="-";
		}

		if ($daten[18]=="0" && $daten[19]=="0")
		{
		$daten[18]="-";
		$daten[19]="-";
		}

		if ($daten[22]=="0" && $daten[23]=="0")
		{
		$daten[22]="-";
		$daten[23]="-";
		}

		if ($daten[26]=="0" && $daten[27]=="0")
		{
		$daten[26]="-";
		$daten[27]="-";
		}


		if ($datumfehler!="1" && EinstellungSetzen(SE_MoOffen11,$daten[0])=="1" && EinstellungSetzen(SE_MoOffen12,$daten[1])=="1" && EinstellungSetzen(SE_MoOffen21,$daten[2])=="1" && EinstellungSetzen(SE_MoOffen22,$daten[3])=="1" && EinstellungSetzen(SE_DiOffen11,$daten[4])=="1"  && EinstellungSetzen(SE_DiOffen12,$daten[5])=="1" && EinstellungSetzen(SE_DiOffen21,$daten[6])=="1" && EinstellungSetzen(SE_DiOffen22,$daten[7])=="1" && EinstellungSetzen(SE_MiOffen11,$daten[8])=="1" && EinstellungSetzen(SE_MiOffen12,$daten[9])=="1" && EinstellungSetzen(SE_MiOffen21,$daten[10])=="1" && EinstellungSetzen(SE_MiOffen22,$daten[11])=="1" && EinstellungSetzen(SE_DoOffen11,$daten[12])=="1" && EinstellungSetzen(SE_DoOffen12,$daten[13])=="1" && EinstellungSetzen(SE_DoOffen21,$daten[14])=="1" && EinstellungSetzen(SE_DoOffen22,$daten[15])=="1" && EinstellungSetzen(SE_FrOffen11,$daten[16])=="1" && EinstellungSetzen(SE_FrOffen12,$daten[17])=="1" && EinstellungSetzen(SE_FrOffen21,$daten[18])=="1" && EinstellungSetzen(SE_FrOffen22,$daten[19])=="1" && EinstellungSetzen(SE_SaOffen11,$daten[20])=="1" && EinstellungSetzen(SE_SaOffen12,$daten[21])=="1" && EinstellungSetzen(SE_SaOffen21,$daten[22])=="1" && EinstellungSetzen(SE_SaOffen22,$daten[23])=="1" && EinstellungSetzen(SE_SoOffen11,$daten[24])=="1"&& EinstellungSetzen(SE_SoOffen12,$daten[25])=="1" && EinstellungSetzen(SE_SoOffen21,$daten[26])=="1" && EinstellungSetzen(SE_SoOffen22,$daten[27])=="1")
		{
		$erfolg=1;
				
			//anfang twitter wenn erfolg
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
			$consumerSecret = welcheEinstellung("SE_consumerSecret");
			$oAuthToken     = welcheEinstellung("SE_oAuthToken");
			$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");
			
			require_once('../../BL_TWITR/twitteroauth.php');

			$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
			$inhalt="Die Öffnungszeiten wurden geändert. #Ausleihsoftware http://ausleihsoftware.de";
			$tweet->post('statuses/update', array('status' => $inhalt));
			}
			//ende twitter
		}
		
	}




}

//ausgabe erfolg
if ($erfolg==1)
{
?>
<script>
$.pnotify({
pnotify_title: 'Administrations-Einstellungen',
pnotify_text: 'Der Wert wurde erfolgreich geändert.',
});
</script>
<?
}
else
{
?>
<script>
$.pnotify({
pnotify_title: 'Administrations-Einstellungen',
pnotify_text: 'Der Wert wurde nicht erfolgreich geändert.',
pnotify_type: 'error',
});
</script>
<?
}








?>