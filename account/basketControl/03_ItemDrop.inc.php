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
//$whatIDinWKObj=(unserialize(base64_decode($_GET['i']))-5428745);
$whatIDinWKObj=($_GET['i']-5428745);


if (isset($_SESSION["User_ID"]) && is_numeric($whatIDinWKObj))
{

	//1. exisitert das leihobjekt in der db mit einer dazugehörigen warenkorb-id?
	$sql = "SELECT `wkid`,`abgeholt` FROM `06_wkObje` WHERE id=\"".mysql_real_escape_string($whatIDinWKObj)."\" AND `abgeholt` IS NULL LIMIT 1 "; 
	$wkIdVonIdObjWK = mysql_query($sql);
	$anzahlId = mysql_num_rows($wkIdVonIdObjWK); 

	//2. falls ja, dann wird geschaut, ob diese warenorb id vom angemeldeten user auch reserviert wurde,
	//sonst könnte ein anderer user objekte von anderen leuten wahllos löschen.
	if ($anzahlId=="1")
	{
	$WKID = mysql_fetch_row($wkIdVonIdObjWK);
	
	//wieviele elemente der warenkorb id sind gerade ausgeliehen?
	//wenn es nur noch 1 objekt ist, wird löschung abgelehnt und auf
	//löschung warenkorb verwiesen
	

	$sql11 = "SELECT count( * ) FROM `06_wkObje` WHERE `wkid` = \"".$WKID[0]."\" LIMIT 1"; 
	$abfrageElementevonWK = mysql_query($sql11);
	$anzahlElementeAlleObjWK = mysql_fetch_row($abfrageElementevonWK);
	
		if ($anzahlElementeAlleObjWK[0]>1)
		{
			//3. exisitert das leihobjekt in der db mit einer dazugehörigen warenkorb-id?
			$sql2 = "SELECT `id` FROM `05_wk` WHERE specid_wk=\"".$WKID[0]."\" AND owner=\"".$_SESSION["User_ID"]."\" "; 
			$inWK = mysql_query($sql2);
			$inWKanzahl = mysql_num_rows($inWK); 

			//4. ja, der user hat den warenkorb mit der ausleih objekt id tatsächlich auch reserviert, löschung wäre okay.
			//es existiert logischerweise nur ein warenkorb
			
			if ($inWKanzahl=="1")
			{

				$sql3 = "DELETE FROM `06_wkObje` WHERE wkid=\"".$WKID[0]."\" AND id=\"".mysql_real_escape_string($whatIDinWKObj)."\" LIMIT 1"; 
				$delWKob = mysql_query($sql3);
				$anzahlDELobj = mysql_affected_rows(); 

				if ($anzahlDELobj=="1")
				{
				//objekt wurde erfoolgreich gelöscht.
				?>
				<script>
				$("[Obj=<? echo $_GET['i']; ?>]").slideToggle().remove();

				$.pnotify({
				pnotify_title: 'Objekt aus Warenkorb',
				pnotify_text: 'Das Objekt wurde erfolgreich gelöscht.',
				});
				</script>
				<?
			$sql = "SELECT specid_wk FROM `05_wk` WHERE `owner` = \"".$_SESSION["User_ID"]."\" ORDER BY `erstellt_am` DESC"; 
			$ReservWK = mysql_query($sql);
			$anzahlWK = mysql_num_rows($ReservWK); 

			if ($anzahlWK=="1")
					{
					echo "Von Ihnen liegt uns derzeit eine Reservierung vor.";
					}
					else
					{
					echo "Von Ihnen liegen uns derzeit ".$anzahlWK." Reservierungen vor.";
					}
				}
			}
			else
			{
			//die warenkorb id stimmt nicht mit dem angemeldeten benutzer überein,
			//da diese funktion kein admin bereich ist, muss von einem angriff
			//auf objekte anderer user ausgegangen werden
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Objekt aus Warenkorb',
			pnotify_text: 'Das Objekt konnte nicht gelöscht werden.',
			pnotify_type: 'error'
			});
			</script>
			<?							
				//anfang protokoll
				if ($_SESSION["SE_ProtokollAnAus"]==1)
				{
				protokollEintrag("2","3","Der Benutzer ".mysql_real_escape_string($_SESSION["User_ID"])." versuchte andere Objekte in Warenkörben zu löschen. IP:".getenv('REMOTE_ADDR'));
				}
				//ende protokoll
			
			}
		}
		else
		{
		//weniger als 1 element nach der löschung ist nicht vorgehsen
		$sql = "SELECT specid_wk FROM `05_wk` WHERE `owner` = \"".$_SESSION["User_ID"]."\" ORDER BY `erstellt_am` DESC"; 
		$ReservWK = mysql_query($sql);
		$anzahlWK = mysql_num_rows($ReservWK); 

		if ($anzahlWK=="1")
		{
		echo "Von Ihnen liegt uns derzeit eine Reservierung vor.";
		}
		else
		{
		echo "Von Ihnen liegen uns derzeit ".$anzahlWK." Reservierungen vor.";
		}
		
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Objekt aus Warenkorb',
		pnotify_text: 'Das Objekt wurde nicht gelöscht, da der Warenkorb mindestens ein Element aufweisen muss.',
		pnotify_type: 'error'
		});
		</script>
		<?
		}
	}
	else
	{
	//es konnte kein warenkorb id zu der anfrage gefunden werden, abbruch
	?>
	<script>
	$.pnotify({
	pnotify_title: 'Objekt aus Warenkorb',
	pnotify_text: 'Das Objekt konnte nicht gelöscht werden.',
	pnotify_type: 'error'
	});
	</script>
	<?
	}
}

?>