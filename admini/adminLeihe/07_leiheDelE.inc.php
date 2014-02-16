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
if (isset($_SESSION["User_ID"]) && isset($_GET['deE']) && $_GET['deE']!="" && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{
$quelle = explode("_", $_GET['deE']);

//ist das objekt im warenkorb wirklich noch nicht mit ausleihestart daten versehen?
$sql = "SELECT abgeholt,gebracht,wkid FROM `06_wkObje` WHERE  id = \"".mysql_real_escape_string($quelle[1]-7492)."\""; 
$DataDelE = mysql_query($sql);
$DatenDelE = mysql_fetch_row($DataDelE);

//anzahl aller objekte zum warenkorb, wenn 1 dann abbruch mit verweis auf warenkorb löschen unten
$sql = "SELECT count(*) FROM `06_wkObje` WHERE  wkid  = \"".$DatenDelE[2]."\""; 
$AnzahlAllerE = mysql_query($sql);
$DatenAnzahlAllerE = mysql_fetch_row($AnzahlAllerE);

if ($DatenAnzahlAllerE[0]!="1")
{
	//objekt hat status reserviert, kann gelöscht werden
	if ($DatenDelE[0]=="" && $DatenDelE[1]=="")
	{
	$loeschenOK=1;
	}
	else
	{
		//status zurückgebracht
		if ($DatenDelE[0]!="" && $DatenDelE[1]!="")
		{
		$loeschenOK=1;
		
		}
		else
		{
			//status ausgegeben darf nicht gesetzt sein
			if ($DatenDelE[0]!="" && $DatenDelE[1]=="")
			{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Löschen Leihe Objekt',
				pnotify_text: 'Das Objekt wurde nicht gelöscht, da es ausgegeben wurde.',
				pnotify_type: 'error',
				});
				</script>
				<?	
				//https://www.merchsociety.com/tocotronic/item/10769/Tocotronic+-+T-Shirt+-+Notenspirale+Schall+und+Wahn+-+dunkelblau/
			}
			else
			{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Löschen Leihe Objekt',
				pnotify_text: 'Das Objekt wurde nicht gelöscht, da der Status unbekannt ist.',
				pnotify_type: 'error',
				});
				</script>
				<?	
			}
		}
	}

	if ($loeschenOK=="1")
	{
	$sql = "DELETE FROM `06_wkObje` WHERE `id` = \"".mysql_real_escape_string($quelle[1]-7492)."\" LIMIT 1"; 
	$DelEinObj = mysql_query($sql);
	$okayOderNichtDelEinObj = mysql_affected_rows();

	if ($okayOderNichtDelEinObj=="1")
	{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Löschen Leihe Objekt',
		pnotify_text: 'Das Objekt wurde erfolgreich gelöscht.',
		});
		location.reload();

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
	pnotify_title: 'Löschen Leihe Objekt',
	pnotify_text: 'Es muss mind. 1 Objekt im Warenkorb vorhanden sein. Bitte klicken Sie auf "Warenkorb löschen" wenn Sie diesen nicht mehr benötigen.',
	pnotify_type: 'error',
	});
	</script>
	<?	
}





}
?>