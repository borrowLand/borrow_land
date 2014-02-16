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
<input class="ui-state-disabled" onmouseover="tooltip6.pnotify_display();" onmousemove="tooltip6.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip6.pnotify_remove();" style="float:left;" value="Hinweis" type="button" /><br><br>
Übersicht Hauptgruppen <-> Warenkörbe über <? echo $tageZeitleiste; ?> Tage <br><br>
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
						//echo "<tr><td colspan='2'><b>".utf8_encode(klarNameHG($hgData[0]))."</b></td></tr>";
						
							while ($objekteData = mysql_fetch_array($objekte, MYSQL_NUM))
							{
								$sql = "SELECT von,bis,wkid FROM `06_wkObje` WHERE `geraet` = \"".$objekteData[0]."\"  "; 					
								$objekteInWKTab = mysql_query($sql);
								$anzahlObjInWKTab = mysql_num_rows($objekteInWKTab);					
								
								$summeHGRes=$summeHGRes+$anzahlObjInWKTab;
								
								//lauter grüner balken, wenn keine reservierungen vorliegen
								if ($anzahlObjInWKTab=="0")
								{

								}
								else
								{
									//datumsangaben für reseriverte objekte 
									while ($objekteInWK = mysql_fetch_array($objekteInWKTab, MYSQL_NUM))
									{
									//$objekteInWK[0]	von
									//$objekteInWK[1]	bis
									
										//grafiken, zeile start
										for ($i=0;$i<$tageZeitleiste;$i++)
										{
										$datumAnzeige = date('d.m.Y',mktime(0,0,1,date('m'),date('d')+$i,date('Y')));
										$datumStart = date('U',mktime(0,0,1,date('m'),date('d')+$i,date('Y')));
										$datumEnde = date('U',mktime(23,59,59,date('m'),date('d')+$i,date('Y')));
										
											if (zeitCheckDBPruef($objekteInWK[0],$objekteInWK[1],$datumStart,$datumEnde)=="1" || zeitCheckDBPruef($objekteInWK[0],$objekteInWK[1],$datumStart,$datumEnde)=="2")
											{
											
											}
											else
											{
											$datumHGNichtGut[]=$datumAnzeige;
											}
										
										}
										//grafiken ende						
									}					
								}
							unset($anzahlObjInWKTab);
							}
						}
						else
						{
						echo "<tr><td colspan='2' class='ui-widget-header'><b>".utf8_encode(klarNameHG($hgData[0]))."</b></td></tr>";
						echo "<tr><td >In dieser Hauptgruppe sind derzeit keine Objekte aktiv / zugeordnet.</td><td></td></tr>";
						echo "<tr><td colspan='2'><br></td></tr>";
						echo "<tr><td colspan='2'><br></td></tr>";
						}
					
						if ($anzahlObjAktiv>0)
						{
							echo "<tr><td colspan='2' class='ui-widget-header'><b>".utf8_encode(klarNameHG($hgData[0]))."</b> <i>".$summeHGRes." Reservierung/en; ".$anzahlObjAktiv." aktive/s Objekt/e</i></td></tr>";
							
							if($summeHGRes=="0")
							{
							//grafiken, zeile start
							echo "<tr><td colspan='2' style='height:30px' class='ui-widget-content'>";
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
							echo "</td></tr>";					
							//grafiken ende
							}
							else
							{

				
								//$datumHGNichtGutDoppelt = array_unique($datumHGNichtGut);
								
								//grafiken, zeile start
								echo "<tr><td style='height:30px' class='ui-widget-content'>";
								for ($i=0;$i<$tageZeitleiste;$i++)
								{
								$datumAnzeige = date('d.m.Y',mktime(0,0,1,date('m'),date('d')+$i,date('Y')));
									
									//wie oft ist das falsche datum enthalten? wenn es sooft wie die anzahl der geräte in einer hauptgruppe auftritt, dann 
									//wird es rot markiert, da es in allen geräten nicht verfügbar ist.
									$countDatum=0;
									foreach ($datumHGNichtGut as &$value) 
									{
										if ($datumAnzeige==$value)
										{
										$countDatum++;
										}
									}

									if ($countDatum==$anzahlObjAktiv)
									{
									//echo " <img src='../../BL_BILDER/tl_nok.png' width='4' height='11' title='".$datumAnzeige."'>\n";
									echo " <span class='t_NOK' title='".$datumAnzeige."'></span>";
									}
									
									else
									{
									//echo " <img src='../../BL_BILDER/tl_ok.png' width='4' height='11' title='".$datumAnzeige."'>\n";
									echo " <span class='t_OK' title='".$datumAnzeige."'></span>";
									}
									
										$wochentag=date("N",mktime(0,0,1,date('m'),date('d')+$i,date('Y')));
										if ($wochentag=="7")
										{
										echo " | ";
										}									
									
								}
								//grafiken ende								
							}
							echo "<tr><td colspan='2'><br></td></tr>";
							echo "<tr><td colspan='2'><br></td></tr>";
							
							unset($summeHGRes);
							unset($datumHGNichtGut);
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
	</script>	