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
if (isset($_SESSION["User_ID"]) && $_GET['oz1']!="" && $_GET['oz2']!="" && $_GET['oz3']!="" && $_GET['oz4']!="" && $_GET['w']!="" && $_GET['z']!="" && $_GET['oz2']!="-" && $_GET['oz2']!="undefined" && $_GET['oz4']!="-" && $_GET['oz4']!="undefined" && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{
/*
$_GET['oz1']	datum start leihe neu
$_GET['oz2']	uhrzeit start leihe neu
$_GET['oz3']	datum ende leihe neu
$_GET['oz4']	uhrzeit ende leihe neu
$_GET['w']		gewünschtes objekt
$_GET['z']		leihedatensatz der geändert werden soll

*/

$datumcheck1=explode(".", $_GET['oz1']);
$datumcheck2=explode(".", $_GET['oz3']);

$DatumBeginn = DateTime::createFromFormat('d.m.Y G.i', $_GET['oz1']." ".$_GET['oz2']);
$DatumBeginn=$DatumBeginn->format('U');

$DatumEnde = DateTime::createFromFormat('d.m.Y G.i', $_GET['oz3']." ".$_GET['oz4']);
$DatumEnde=$DatumEnde->format('U');


	$diffLeihe=$DatumEnde-$DatumBeginn;
	$diffTage=floor($diffLeihe/86400);



	if (checkdate($datumcheck1[1],$datumcheck1[0],$datumcheck1[2])=="1")
	{
	}
	else
	{
	$fehlerDaten[]="Bitte geben Sie ein gültiges Startdatum an.";
	}

	if (checkdate($datumcheck2[1],$datumcheck2[0],$datumcheck2[2])=="1")
	{
	}
	else
	{
	$fehlerDaten[]="Bitte geben Sie ein gültiges Enddatum an.";
	}


	//anfang diff beginn/ende leihe
	if ($DatumBeginn > $DatumEnde)
	{
	$fehlerDaten[]="Ist der Abgabezeitpunkt und der Ausgabezeitpunkt vertauscht?";
	}
	else
	{
		$mindestMietzeit=round(60/$_SESSION["SE_IntervStunde"])*60;
		
		//anfang mindest leihe, nur wenn daten nicht vertauscht wurden
		if ($diffLeihe<($mindestMietzeit))
		{
		$fehlerDaten[]="Bitte beachten Sie die Mindest-Ausleihefrist von ". ($mindestMietzeit/60). " Minuten.";
		}
		//ende mind. leihe
	}
	//ende diff beginn/ende leihe

	//anfang zeiträume gleich
	if ($DatumBeginn == $DatumEnde)
	{
		$fehlerDaten[]="Der Zeitpunkt des Beginns und dem Ende der Leihe ist gleich.";
	}
	//ende zeiträume gleich
	
	//anfang auswahl startzeit schon abgelaufen? 
	if (time() > $DatumBeginn)
	{
		$fehlerDaten[]="Der Startzeitpunkt der Leihe ist bereits abgelaufen.";
	}
	//ende auswahl zeit schon abgelaufen?
	
	//anfang auswahl endzeit schon abgelaufen? 
	if (time() > $DatumEnde)
	{
		$fehlerDaten[]="Der Endzeitpunkt der Leihe ist bereits abgelaufen.";
	}
	//ende auswahl zeit schon abgelaufen?
	
	//anfang datum ist keine zahl
	if (!is_numeric($DatumBeginn) || !is_numeric($DatumEnde))
	{
		$fehlerDaten[]="Bitte geben Sie nochmals Ihre Ausleihezeiten ein.";
	}
	//ende datum ist keine zahl
	


	//wenn keine fehler in den formulardaten, dann kann es weitergehen
	if (!$fehlerDaten)
	{


		$uncheckDesDev=unserialize(base64_decode($_GET['w']));

		//anzeige aller objekte,die aktiviert sind
		$sql = "SELECT geraet,von,bis FROM `06_wkObje` WHERE `geraet` = \"".mysql_real_escape_string($uncheckDesDev)."\"  AND `id` != \"".mysql_real_escape_string($_GET['z']-6212)."\" "; 
		$LeihenInWK = mysql_query($sql);
		$anzahlObje = mysql_num_rows($LeihenInWK); 

		//wenn mehr als 1 objekt in der leihe ist, wird eine überprüfung stattfinden, falls nicht, kann das objekt gleich geändert werden
		if ($anzahlObje>0)
		{

			//alle leihen, die das wunschobjekt betreffen werden jetzt auf leihbarkeit in dem wunschzeitrum getestet.
			while ($objdatenVerfueg = mysql_fetch_array($LeihenInWK, MYSQL_NUM))
			{
				if (zeitCheckDBPruef($objdatenVerfueg[1],$objdatenVerfueg[2],$DatumBeginn,$DatumEnde)==1 || zeitCheckDBPruef($objdatenVerfueg[1],$objdatenVerfueg[2],$DatumBeginn,$DatumEnde)==2)
				{
				//es passiert nix, der mietzeitraum des mietobjektes liegt vor oder nach dem wunschzeitraum
				}
				else
				{
				//wenn objekt schon in einem zeitraum vergeben = >fehler => ganze aktion nicht mehr möglich.
				$fehlerObj=1;
				//echo $objdatenVerfueg[0];
				}
			}
			
			if ($fehlerObj!="1")
			{
			$aenderungOK="1";
			}
		}
		else
		{
		$aenderungOK="1";
		}

		//änderung in db vonehmen
		if ($aenderungOK=="1")
		{
		$nameLoescher=benutzerDaten($_SESSION["User_ID"]);
		$nachrichtObj="Das Objekt wurde am ".date("d.m.Y H.i")." von ".$nameLoescher[0]." getauscht.";
		
		$sql = "UPDATE `06_wkObje` SET `geraet` = \"".mysql_real_escape_string($uncheckDesDev)."\", `von` = \"".$DatumBeginn."\", `bis` = \"".$DatumEnde."\", `bemerkungen` = \"".$nachrichtObj."\" WHERE `id` = \"".mysql_real_escape_string($_GET['z']-6212)."\" LIMIT 1"; 
		$UpdateObj = mysql_query($sql);
		$anzahlObje = mysql_affected_rows(); 		
		
			if ($anzahlObje=="1")
			{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Überprüfung der neuen Ausleihedaten',
			pnotify_text: 'Die neuen Daten wurden erfolgreich übernommen.',
			});
			$("#dialog-request").remove();
			$( this ).dialog( "close" );
			location.reload();
			</script>
			<?	
			}
		
		
		}
		else
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Überprüfung der neuen Ausleihedaten',
		pnotify_text: 'Leider ist das Objekt schon in einem anderen Zeitraum angefragt worden.',
		pnotify_type: 'error',
		});
		</script>
		<?		
		}
		
		
		
		
		
		

	}
	else
	{
		//fehlerauswertung, pnotify meldungen
		for ($i=0;$i<count($fehlerDaten);$i++)
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Fehler Dateneingabe',
		pnotify_text: '<? echo $fehlerDaten[$i]; ?>',
		pnotify_type: 'error',
		});
		</script>
		<?
		}
	}
}
else
{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Fehler Dateneingabe',
		pnotify_text: 'Bitte überprüfen Sie die Eingabefelder.',
		pnotify_type: 'error',
		});
		</script>
		<?
}


?>