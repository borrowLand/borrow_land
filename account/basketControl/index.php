<?
session_start();


//System 
/////////////////////////////////////////////
$includeName="../../_00_basic_check.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

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
<br><br><br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	
		
<section id="page"> <!-- Defining the #page section with the section tag -->


            <header> <!-- Defining the header section of the page with the appropriate tag -->
          
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../index.php" title="Startseite"><img src="../../BL_BILDER/start_00.png"></a> <a href="../../index.php" title="Startseite">borrow land</a></h1>
<?
//anfang namensanzeige, nur für benutzerbereich
$nutzerInfos=benutzerDaten($_SESSION["User_ID"]);
//ende namensanzeige, nur für benutzerbereich

$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Benutzer</a>/Reservierungen</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/<? echo utf8_encode(htmlspecialchars($nutzerInfos[0])); ?></a>/Reservierungen</div>
	</hgroup>
	<?
	}
}
//#############Ende Überschrift	

	//navigation
	/////////////////////////////////////////////
	$includeName="../../_00_basic_nav.inc.php";
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
<div id="loadingAj"></div>


            <section id="articles"> 
			
<?
//anfang voraussetzung registriert
if (isset($_SESSION["User_ID"]))
{
?>

<article id="articleLogin2"> 
	<h2>Übersicht aller Reservierungen</h2>
	
	<div class="line"></div>
	
	<div class="articleBody clear" >
	
	<?

		
		//beginn, auswahl der warenkörbe
		$sql = "SELECT specid_wk,erstellt_am FROM `05_wk` WHERE `owner` = \"".$_SESSION["User_ID"]."\" AND `fuer_dritte` =0 ORDER BY `erstellt_am` DESC"; 
		$ReservWK = mysql_query($sql);
		$anzahlWK = mysql_num_rows($ReservWK); 

		if ($anzahlWK>0)
		{

			if ($anzahlWK=="1")
			{
			echo "<div id='outdata'>Von Ihnen liegt uns derzeit eine Reservierung vor.</div>";
			}
			else
			{
			echo "<div id='outdata'>Von Ihnen liegen uns derzeit ".$anzahlWK." Reservierungen vor.</div>";
			}

		?>
		<input aria-disabled="false" id="wkPDF" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-hover" style="float:right;margin-bottom:20px" value="Übersicht (PDF)" type="submit"> 
		<table class='ui-widget-content ui-corner-all' width='100%' border="0" cellspacing="0" cellpadding="0" id='wk_overview' style='padding:10px;'>
		<thead>
		<tr><td colspan='6'><br></td></tr>
		<tr><td colspan="2"><h4>Reservierung & Inhalte</h4></td><td width="35px"></td><td width="320px"><h4>Mietvertrag & Leihzeiten</h4></td><td width="35px"></td><td width="129px"><h4>Status & entfernen</h4></td></tr>
		<tr><td colspan='6'><br></td></tr>
		</thead>
		<tbody>
	<?		
		
			//echo unserialize(base64_decode($robert));
			
			while ($hauptGruppen = mysql_fetch_array($ReservWK, MYSQL_NUM))
			{
			//filter: nur warenkörbe, bei denen keine geräte schon verliehen worden sind
			$sql = "SELECT id FROM 06_wkObje WHERE wkid = \"".$hauptGruppen[0]."\" AND abgeholt IS NOT NULL"; 
			$AnzahlSchonResObj = mysql_query($sql);
			$anzahlSchonRes = mysql_num_rows($AnzahlSchonResObj); 

		
				//der warenkorb wurde noch nicht ausgeliehen
				if($anzahlSchonRes=="0")
				{
				
				echo "\n\n<tr id='s_".base64_encode(serialize($hauptGruppen[0]))."'><td width='20px'><div class='clear'><a href='#link' title='Details' showId='w_".base64_encode(serialize($hauptGruppen[0]))."'>";
				echo "<div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-circle-triangle-s'></span></div></a></div></td><td><b>".timeCdZuDatumMitZeit($hauptGruppen[1])."</b></td>";
				echo "<td width='35px'></td><td><a href='#link' pdfid='".base64_encode(serialize($hauptGruppen[0]))."'>";
				echo "<img src='../../BL_BILDER/pdf.png'></a>";	

				echo "</td><td width='35px'></td><td style='float:right'><div class='clear' style='display:inline;'><a href='#link' title='Warenkorb entfernen' delWK='".base64_encode(serialize($hauptGruppen[0]))."'><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-trash'></span></div></a></div></td></tr>\n\n";
				
				
				
				
				$sql2 = "SELECT id,geraet,von,bis,versandObj FROM `06_wkObje` WHERE `wkid` = \"".$hauptGruppen[0]."\" ORDER BY `geraet` DESC"; 
				$ReservWKobj = mysql_query($sql2);
				$anzahlWKobj = mysql_num_rows($ReservWKobj); 
					if ($anzahlWKobj>0)
					{
						//id='w_".($wkObjekte[0]+5428745)."'
						//echo "<div id='w_".$hauptGruppen[0]."'>";
						while ($wkObjekte = mysql_fetch_array($ReservWKobj, MYSQL_NUM))
						{
							
							
							if ($_SESSION["SE_ViewLeihmodHauptg"]=="1")
							{
							echo "<tr Obj='".($wkObjekte[0]+5428745)."' id='w_".base64_encode(serialize($hauptGruppen[0]))."'><td></td><td> ".utf8_encode(klarNameHG(hgNameAusGeraet($wkObjekte[1])))."</td>";
							echo "<td></td><td>".timeCdZuDatumMitZeit($wkObjekte[2])." - ".timeCdZuDatumMitZeit($wkObjekte[3])."</td><td>";
							//////////////Versand Start
							if ($wkObjekte[4]=="1")
							{
								echo "<div class='clear'><a href='#link' title='Versand angegeben'><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-mail-open'></span></div></a></div>";
							}
							//////////////Versand Ende
							echo "</td><td style='float:right'><div class='clear'><a href='#' itemId='".($wkObjekte[0]+5428745)."' title='Objekt entfernen' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-circle-close'></span></div></a></div></td></tr>\n";
							}
							else
							{
							echo "<tr Obj='".($wkObjekte[0]+5428745)."' id='w_".base64_encode(serialize($hauptGruppen[0]))."' ><td></td><td> ".utf8_encode(klarNameObj($wkObjekte[1]))."</td>";
							echo "<td></td><td>".timeCdZuDatumMitZeit($wkObjekte[2])." - ".timeCdZuDatumMitZeit($wkObjekte[3])."</td><td>";
							//////////////Versand Start
							if ($wkObjekte[4]=="1")
							{
								echo "<div class='clear'><a href='#link' title='Versand angegeben'><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-mail-open'></span></div></a></div>";
							}
							//////////////Versand Ende
							
							echo "</td><td style='float:right'><div class='clear'><a href='#' itemId='".($wkObjekte[0]+5428745)."' title='entfernen' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-circle-close'></span></div></a></div></td></tr>\n";
							}
						}
					}
				}
				else
				{
				//der warenkorb ist teilweise oder ganz im leihe-vorgang: funktionen werden eingeschränkt.
					
				//welche objekte sind schon verliehen worden?
				while ($objekteSchonVerliehen = mysql_fetch_array($AnzahlSchonResObj, MYSQL_NUM))
				{
				$verliehendeObjekteFuerDiesenWK[]=$objekteSchonVerliehen[0];
				}
										
				echo "\n\n<tr id='s_".base64_encode(serialize($hauptGruppen[0]))."'><td width='20px'><div class='clear'><a href='#link' title='Details' showId='w_".base64_encode(serialize($hauptGruppen[0]))."'>";
				echo "<div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-circle-triangle-s'></span></div></a></div></td><td><b>".timeCdZuDatumMitZeit($hauptGruppen[1])."</b></td>";
				echo "<td width='35px'></td><td><a href='#link' pdfid='".base64_encode(serialize($hauptGruppen[0]))."'><img src='../../BL_BILDER/pdf.png'></a>";

				echo "</td><td width='35px'></td>";
				echo "<td><div class='clear'><a href='#link' title='Leihe teilweise oder vollständig aktiv'><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-extlink'></span></div></a>";
				echo "</div></td></tr>\n\n";

				$sql2 = "SELECT id,geraet,von,bis,versandObj FROM `06_wkObje` WHERE `wkid` = \"".$hauptGruppen[0]."\" ORDER BY `geraet` DESC"; 
				$ReservWKobj = mysql_query($sql2);
				$anzahlWKobj = mysql_num_rows($ReservWKobj); 
					if ($anzahlWKobj>0)
					{
						//id='w_".($wkObjekte[0]+5428745)."'
						//echo "<div id='w_".$hauptGruppen[0]."'>";
						while ($wkObjekte = mysql_fetch_array($ReservWKobj, MYSQL_NUM))
						{
							if ($_SESSION["SE_ViewLeihmodHauptg"]=="1")
							{
								
								if (in_array($wkObjekte[0], $verliehendeObjekteFuerDiesenWK)==1)
								{
								echo "<tr id='w_".base64_encode(serialize($hauptGruppen[0]))."'><td></td><td> ".utf8_encode(klarNameHG(hgNameAusGeraet($wkObjekte[1])))."</td>";
								echo "<td></td><td>".timeCdZuDatumMitZeit($wkObjekte[2])." - ".timeCdZuDatumMitZeit($wkObjekte[3])."</td><td>";
								//////////////Versand Start
								if ($wkObjekte[4]=="1")
								{
								echo "<div class='clear'><a href='#link' title='Versand angegeben'><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-mail-open'></span></div></a></div>";
								}
								//////////////Versand Ende
								
								echo "</td><td><div class='clear'><a href='#link' title='Bereits ausgeliehen'><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-extlink'></span></div></a></div></td></tr>\n";
								}
								else
								{
								echo "<tr Obj='".($wkObjekte[0]+5428745)."' id='w_".base64_encode(serialize($hauptGruppen[0]))."'><td></td><td> ".utf8_encode(klarNameHG(hgNameAusGeraet($wkObjekte[1])))."</td>";
								echo "<td></td><td>".timeCdZuDatumMitZeit($wkObjekte[2])." - ".timeCdZuDatumMitZeit($wkObjekte[3])."</td><td>";
								//////////////Versand Start
								if ($wkObjekte[4]=="1")
								{
								echo "<div class='clear'><a href='#link' title='Versand angegeben'><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-mail-open'></span></div></a></div>";
								}
								//////////////Versand Ende
								
								echo "</td><td style='float:right'><div class='clear'><a href='#' itemId='".($wkObjekte[0]+5428745)."' title='entfernen' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-circle-close'></span></div></a></div></td></tr>\n";
								}
							}
							else
							{
								if (in_array($wkObjekte[0], $verliehendeObjekteFuerDiesenWK)==1)
								{
								echo "<tr id='w_".base64_encode(serialize($hauptGruppen[0]))."'><td></td><td> ".utf8_encode(klarNameHG($wkObjekte[1]))."</td><td>";
								//////////////Versand Start
								if ($wkObjekte[4]=="1")
								{
								echo "<div class='clear'><a href='#link' title='Versand angegeben'><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-mail-open'></span></div></a></div>";
								}
								//////////////Versand Ende
								
								echo "</td><td>".timeCdZuDatumMitZeit($wkObjekte[2])." - ".timeCdZuDatumMitZeit($wkObjekte[3])."</td><td></td><td><div class='clear'><a href='#link' title='Bereits ausgeliehen'><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-extlink'></span></div></a></div></td></tr>\n";
								}
								else
								{
								echo "<tr Obj='".($wkObjekte[0]+5428745)."' id='w_".base64_encode(serialize($hauptGruppen[0]))."'><td></td><td> ".utf8_encode(klarNameHG($wkObjekte[1]))."</td><td>";
								//////////////Versand Start
								if ($wkObjekte[4]=="1")
								{
								echo "Versand";
								}
								echo "<div class='clear'><a href='#link' title='Versand angegeben'><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-mail-open'></span></div></a></div>";
								
								echo "</td><td>".timeCdZuDatumMitZeit($wkObjekte[2])." - ".timeCdZuDatumMitZeit($wkObjekte[3])."</td><td></td><td style='float:right'><div class='clear'><a href='#' itemId='".($wkObjekte[0]+5428745)."' title='entfernen' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-circle-close'></span></div></a></div></td></tr>\n";
								}
							}
						}
					}
				unset($verliehendeObjekteFuerDiesenWK);
				}

			}
		?>
		<tr><td colspan='5'><br></td></tr>
		</tbody></table>
		<?
		}
		else
		{
		echo "Derzeit wurden von Ihnen keine Reservierungen vorgenommen.";
		}
	?>

  </div>

</article>


<?	

	
}//ende voraussetzung registriert
else
{
	//nicht eingeloggt
	/////////////////////////////////////////////
	$includeName="../../_02_NoLoginAllPages.inc.php";
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
}
?>
			


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
$includeName="../../_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}

/////////////////////////////////////////////			
?>  
	        
 
		 

        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
?>
<script>
  
$("tr[id^=w_]").hide();
$("a[showId^=w_]").click(function(event) {
$("tr[id^="+$(this).attr("showId")+"]").toggle();
});

$("a[itemId]").click(function(event) {
$("#outdata").load("03_ItemDrop.inc.php?i="+$(this).attr("itemId"));
});

$("a[pdfid]").click(function(event) {
window.open("01_pdf_mv.inc.php?o="+$(this).attr("pdfid"), "");
});

$("#wkPDF").click(function(event) {
window.open("04_WKpdf_overview.inc.php");
});

$("a[delWK]").click(function(event) {
$("#outdata").load("02_WKDrop.inc.php?w="+$(this).attr("delWK"));
});

$("#loadingAj").hide();
$("#loadingAj").ajaxStart(function(){
   $(this).show();
 });
 $("#loadingAj").ajaxStop(function(){
   $(this).hide();
 });

 $("tr[id]").mouseover(function() {
 $(this).css("background-color", "#204A27");
  }).mouseout(function(){
 $(this).css("background-color", "");
  });

</script>







<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>