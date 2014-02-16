<?
//warenkorb steuerung für hauptgruppen ohne/mit versand

session_start();

if (isset($_SESSION["User_ID"]))
{


	//Funktionen 
	/////////////////////////////////////////////
	$includeName="_00_basic_func.inc.php";
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

	//Datenbank Verbindung
	/////////////////////////////////////////////
	$includeName="_01_basic_db.inc.php";
	if (file_exists($includeName))
	{
		require($includeName);
	}	
	else
	{
		echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
		exit();
	}

	/////////////////////////////////////////////

	//Sessions
	/////////////////////////////////////////////
	$includeName="_01_basic_sess.inc.php";
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

	$zerHacktWk1 = explode("_", $_GET['wk1']);
	$zerHacktWk2 = explode("_", $_GET['wk2']);
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////mit oder ohne versand? 

	if ($_GET['wk1']=="" && $_GET['wk2']!="")
	{
	//versand
	$hauptgruppe=unserialize(base64_decode($zerHacktWk2[2]));
	$versand=1;
	}
	
	if ($_GET['wk1']!="" && $_GET['wk2']=="")
	{
	//kein versand
	$hauptgruppe=unserialize(base64_decode($zerHacktWk1[2]));
	$versand=0;
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////hg ist bekannt und versand eigenschaft auch

	$anzahlDerObjekteVorWKaktion=count($_SESSION["aktuelleObjekte"][$hauptgruppe]);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////begrenzungen des warenkorbs 	

	$anzahlElementeWK=count($_SESSION["User_WK"]);
	if ($anzahlElementeWK<$_SESSION["SE_AnzahlElemWKMax"])
	{

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////nur weitermachen wenn mind 1 objekt vorhanden ist


		if ($anzahlDerObjekteVorWKaktion >=1)
		{
			//wenn nur ein objekt vorhanden ist, erübrigt sich die zufallsbestimmung
			if ($anzahlDerObjekteVorWKaktion==1)
			{
			$reservierendesObjekt=$_SESSION["aktuelleObjekte"][$hauptgruppe][0];
			
			//objekt entfernen aus session daten
			unset($_SESSION["aktuelleObjekte"][$hauptgruppe][0]);
			}
		
			if ($anzahlDerObjekteVorWKaktion>1)
			{
			$zufallsObjekt=rand(0, $anzahlDerObjekteVorWKaktion-1);
			$reservierendesObjekt=$_SESSION["aktuelleObjekte"][$hauptgruppe][$zufallsObjekt];
			
			//objekt entfernen aus session daten
			unset($_SESSION["aktuelleObjekte"][$hauptgruppe][$zufallsObjekt]);
			}
			
			//neuinitialisierung des arrays wegen reihenfolge
			$_SESSION["aktuelleObjekte"][$hauptgruppe] = array_values($_SESSION["aktuelleObjekte"][$hauptgruppe]);

			//reservieren im warenkorb
			if (!isset($_SESSION["User_WK"]) && $anzahlElementeWK=="0")
			{
			$_SESSION["User_WK"][0]["name"]=$reservierendesObjekt;
			$_SESSION["User_WK"][0]["zeitStart"]=$_SESSION["aktuelleZeitStart"];
			$_SESSION["User_WK"][0]["zeitEnde"]=$_SESSION["aktuelleZeitEnde"];
			$_SESSION["User_WK"][0]["hgName"]=$hauptgruppe;
			$_SESSION["User_WK"][0]["versand"]=$versand;
			$anzahlElementeWK++;
			
			}
			else
			{
			$_SESSION["User_WK"][$anzahlElementeWK]["name"]=$reservierendesObjekt;
			$_SESSION["User_WK"][$anzahlElementeWK]["zeitStart"]=$_SESSION["aktuelleZeitStart"];
			$_SESSION["User_WK"][$anzahlElementeWK]["zeitEnde"]=$_SESSION["aktuelleZeitEnde"];
			$_SESSION["User_WK"][$anzahlElementeWK]["hgName"]=$hauptgruppe;
			$_SESSION["User_WK"][$anzahlElementeWK]["versand"]=$versand;
			$anzahlElementeWK++;
			}			
			
		}
		else
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Fehler Warenkorb',
		pnotify_text: 'Die Hauptgruppe konnte nicht reserviert werden.',
		pnotify_type: 'error'
		});
		</script>	
		<?	
		}

//###################################################################################################eigenes anfang	

//jquery remove hauptgruppen
//entfernen aus allen drei html bäumen

//nur noch 1 objekt in der hauptgruppe vorhanden...
if ($anzahlDerObjekteVorWKaktion==1)
{
?>
<script>
$("#<? echo base64_encode(serialize($hauptgruppe)); ?>").remove();
</script>	
<?
}
//###################################################################################################eigenes ende
		
//###################################################################################################einzelobjekt anfang
	//wenn objekte tab freigeschaltet, dann entfernen aus jquery
	if ($_SESSION["SE_ViewLeihmodEinzel"]=="1")
	{
		?>
		<script>
		$("table[obj_id=<? echo base64_encode(serialize($reservierendesObjekt));?>]").remove();
		</script>	
		<?
		//wenn letztes objekt aus einer hg, dann überschrift auch entfernen
		if ($anzahlDerObjekteVorWKaktion=="1")
		{
			?>
			<script>
			$("div[id^=d3f<? echo base64_encode(serialize($hauptgruppe)); ?>]").remove();
			</script>	
			<?			
		}
	}
//###################################################################################################einzelobjekt ende
	
//###################################################################################################einzelobjekt tag anfang

if ($_SESSION["SE_ViewLeihmodTag"]=="1")
{
	?>
	<script>
	$("table[objT_id=<? echo base64_encode(serialize($reservierendesObjekt));?>]").remove();
	</script>	
	<?		
}
//###################################################################################################einzelobjekt tag ende
		
		
		
		//usability hinweis für das erste objekt im warenkorb
		if ($anzahlElementeWK==1)
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Hinweis Warenkorb',
			pnotify_text: 'Sie können jetzt auf das Symbol Warenkorb klicken und die Reservierung abschliessen oder weitere Objekte hinzufügen.'
			});
			</script>
			<?
		}

		
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Hinweis Warenkorb',
			pnotify_text: 'Die Hauptgruppe <b><? echo htmlspecialchars(utf8_encode(klarNameHG($hauptgruppe))); ?></b> wurde erfolgreich hinzugefügt.'
			});
			</script>
			<?		
		
		
		//wenn alle hauptgruppen weg sind, hinweis anzeigen dass nix mehr da ist.
		?>
		<script>
		if ($("#ladeHauptGr table").length==0)
		{
		$("#ladeHauptGr").append("Weitere Objekte stehen in diesem Zeitraum leider nicht zur Verfügung.<br><br>Sie können mit der Änderung des Zeitraums weitere Objekte hinzufügen.");
		}
		</script>
		<?

		//am ende wieder alle knöpfe zum reservieren anzeigen

			?>
			<script>
			<?
				if ($_SESSION['SE_versandMod']=="1")
				{
				?>
				$("a[inWK_HG_mV^=_2_]").show();
				<?
				}
			?>			
			
			$("a[inWK_HG_oV^=_1_]").show();
			</script>
			<?			
	
	//warenkorb header aktualisierung
	echo '<li><a href="'.$_SESSION["SE_festUrl"].'account/basket" title="Warenkorb">'.wkCountOhneLeer().'<div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-cart"></span></div></a></li>';

	
	}					
	else
	{
	?>
	<script>
	$.pnotify({
	pnotify_title: 'Hinweis Warenkorb',
	pnotify_text: 'Die maximale Anzahl an Elementen (<? echo $_SESSION["SE_AnzahlElemWKMax"]; ?>) pro Warenkorb wurde überschritten.',
	pnotify_type: 'error'
	});
	$("table").remove();
	</script>
	<?
	//warenkorb header aktualisierung
	echo '<li><a href="'.$_SESSION["SE_festUrl"].'account/basket" title="Warenkorb">'.wkCountOhneLeer().'<div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-cart"></span></div></a></li>';
	}
}