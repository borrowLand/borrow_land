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


if (isset($_SESSION["User_ID"]) && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{
	$tageZeitleiste=90;
	?>
	<br>
	<input class="ui-state-disabled" onmouseover="tooltip5.pnotify_display();" onmousemove="tooltip5.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip5.pnotify_remove();" style="float:left;" value="Hinweis" type="button" /><br><br>
	Übersicht Zuordnung Objekte <-> Warenkörbe über <? echo $tageZeitleiste; ?> Tage <br>
	<a href="#link" id="moreInfosObjUsr" class="fg-button ui-state-default ui-corner-all ui-state-hover" style="margin-bottom: 10px; float: right;">Zusatzinformationen</a>
	<br><br><br>
	<hr>
	<br><br>
	<?

	//tabelle anfang
	echo '<table border="0" cellpadding="0" cellspacing="2" width="100%">';

	//gerätename
	$sql = 'SELECT specid_hg FROM `03_obj_hauptgruppen` WHERE `HGruppenOnOff` = 1'; 
	$hg = mysql_query($sql);
	$anzahlHGaktiv = mysql_num_rows($hg); 

	//sind aktivierte hauptgruppen verfügbar?
	if ($anzahlHGaktiv>0)
	{
		while ($hgData = mysql_fetch_array($hg, MYSQL_NUM))
		{
		$sql = 'SELECT specid_obj FROM `04_obj_objekte` WHERE `HGruppe` = \''.$hgData[0].'\' AND `ObjOnOff` =1'; 
		$objekte = mysql_query($sql);
		$anzahlObjAktiv = mysql_num_rows($objekte);
				
			if ($anzahlObjAktiv>0)
			{
			//zeile hauptgruppe
			echo "<tr><td class='ui-widget-header' colspan='2'><b>".utf8_encode(klarNameHG($hgData[0]))."</b></td></tr>";
			echo "<tr><td colspan='2'><br></td></tr>";
			
				while ($objekteData = mysql_fetch_array($objekte, MYSQL_NUM))
				{
				$sql = "SELECT von,bis,wkid FROM `06_wkObje` WHERE `geraet` = \"".$objekteData[0]."\"  ORDER BY `von` ASC"; 					
				$objekteInWKTab = mysql_query($sql);
				$anzahlObjInWKTab = mysql_num_rows($objekteInWKTab);					
				echo "<tr ><td colspan='2'>".utf8_encode(klarNameObj($objekteData[0]))." &middot; <i>".$anzahlObjInWKTab." Reservierung/en</i></td></tr>";
				
					//lauter grüner balken, wenn keine reservierungen vorliegen
					if ($anzahlObjInWKTab=="0")
					{
					//grafiken, zeile start
					echo "<tr><td class='ui-widget-content clear' style='height:30px'>";
					for ($i=0;$i<$tageZeitleiste;$i++)
					{
					$datum = date('d.m.Y',mktime(0,0,1,date('m'),date('d')+$i,date('Y')));
					//echo " <img src='../../BL_BILDER/tl_ok.png' width='4' height='11' title='".$datum."'> ";
					echo " <span class='t_OK' title='".$datum."'></span>";
					
						$wochentag=date("N",mktime(0,0,1,date('m'),date('d')+$i,date('Y')));
						if ($wochentag=="7")
						{
						echo " | ";
						}
					}
					echo "</td><td></td></tr>";	

					//grafiken ende
					}
					else
					{
						//datumsangaben für reseriverte objekte 
						while ($objekteInWK = mysql_fetch_array($objekteInWKTab, MYSQL_NUM))
						{
						//$objekteInWK[0]	von
						//$objekteInWK[1]	bis
						
						//grafiken, zeile start
						echo "<tr><td class='ui-widget-content clear' style='height:30px'>";
							for ($i=0;$i<$tageZeitleiste;$i++)
							{
							$datumAnzeige = date('d.m.Y',mktime(0,0,1,date('m'),date('d')+$i,date('Y')));
							$datumStart = date('U',mktime(0,0,1,date('m'),date('d')+$i,date('Y')));
							$datumEnde = date('U',mktime(23,59,59,date('m'),date('d')+$i,date('Y')));

								if (zeitCheckDBPruef($objekteInWK[0],$objekteInWK[1],$datumStart,$datumEnde)=="1" || zeitCheckDBPruef($objekteInWK[0],$objekteInWK[1],$datumStart,$datumEnde)=="2")
								{
								//echo " <img src='../../BL_BILDER/tl_ok.png' width='4' height='11' title='".$datumAnzeige."'>\n";
								echo " <span class='t_OK' title='".$datumAnzeige."'></span>";
								}
								else
								{
								//echo " <img src='../../BL_BILDER/tl_nok.png' width='4' height='11' title='".$datumAnzeige."'>\n";
								echo " <span class='t_NOK' title='".$datumAnzeige."'></span>";
								}
								
								$wochentag=date("N",mktime(0,0,1,date('m'),date('d')+$i,date('Y')));
								if ($wochentag=="7")
								{
								echo " | ";
								}										
								
							}
							echo '</td><td><a href=\'wkEdit.php?wk='.base64_encode(serialize($objekteInWK[2])).'\' title=\'bearbeiten\' ><div class=\'ui-state-default ui-corner-all\'><span class=\'ui-icon ui-icon-wrench\'></span></div></a> <a href=\''.$_SESSION["SE_festUrl"].'account/basketControl/01_pdf_mv.inc.php?o='.base64_encode(serialize($objekteInWK[2])).'\' title=\'Mietvertrag\' ><div style=\'width:28px;height:18px;vertical-align:middle;text-align:center\' class=\'ui-state-default ui-corner-all\'><img src=\'../../BL_BILDER/pdf.png\'></div></a></td></tr>';					
							//grafiken ende						
							
							//zusatzinfos ausleiher
							$sql = "SELECT owner FROM `05_wk` WHERE `specid_wk` = \"".$objekteInWK[2]."\"" ;
							$BenutzeID = mysql_query($sql);
							$BenutzeIDDaten = mysql_fetch_row($BenutzeID);
							$user=benutzerDaten($BenutzeIDDaten[0]);
							echo '<tr class="ui-helper-hidden" id="usrMoreIn_'.base64_encode(serialize($objekteInWK[2])).'"><td colspan="2" class="Standard_Verdana_10weiss"><i>Name:</i> '.$user[0].' <i>Telefonnummer:</i> '.$user[1].' <i>Leihedauer:</i> '.timeCdZuDatumMitZeit($objekteInWK[0]).' - '.timeCdZuDatumMitZeit($objekteInWK[1]).'<br><br></td></tr>';
						}					
					}
					echo "<tr><td colspan='2'><br></td></tr>";
					unset($anzahlObjInWKTab);
				}
				echo "<tr><td colspan='2'><br></td></tr>";
			}
			else
			{
			echo "<tr><td colspan='2' class='ui-widget-header' ><b>".utf8_encode(klarNameHG($hgData[0]))."</b></td></tr>";
			echo "<tr><td colspan='2'><br></td></tr>";
			echo "<tr><td colspan='2'>In dieser Hauptgruppe sind derzeit keine Objekte aktiv / zugeordnet.</td></tr>";
			echo "<tr><td colspan='2'><br></td></tr>";
			echo "<tr><td colspan='2'><br></td></tr>";
			}
		}
	}	
	else
	{
	echo "<tr><td colspan='2'>Derzeit sind keine Hauptgruppen aktiv.</td></tr>";
	}
	// ende
	echo "</table>";
}	
?>
<script>		
$("#tabsAusleiheAdmin ul").slideDown();
$("#moreInfosObjUsr").click(function(event) {
$("[id^=usrMoreIn_]").toggle();
});		
</script>		