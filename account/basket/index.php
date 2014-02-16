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
		
<section id="page"> 
<header> 


          
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
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Benutzer</a>/Warenkorb</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/<?echo utf8_encode(htmlspecialchars($nutzerInfos[0])); ?></a>/Warenkorb</div>
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
<div id="wkCheck"></div>

            <section id="articles"> 
			
<?
//anfang voraussetzung registriert
if (isset($_SESSION["User_ID"]))
{
	if (count($_SESSION["User_WK"])>0)
	{
		
	?>		
	<article id="articleLogin1"> 
	<h2>Warenkorb Inhalt</h2>
	
	<div class="line"></div>
	
	<div class="articleBody clear" id="contentAfterRes">
	<div id="hinweisWeiter">Klicken Sie <a href="../../"><b>hier</b></a> um weitere Objekte zu reservieren <br>oder auf die Schaltfläche "reservieren" um den Vorgang abzuschließen.<br><br></div>
	
	<div id="fehlermeldungenWK"></div>
	
	<?
	//anzeige der warenkorb reservierung als "für dritte"
	if ($_SESSION["User_Recht_Ausgabeber"]=="1")
	{
	?>
	<input aria-disabled="false" onmouseover="tooltip.pnotify_display();" onmousemove="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip.pnotify_remove();" id="letsTakeALook2" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-hover" style="float:right;margin-bottom:20px;margin-left:20px" value="Kundenleihe" type="submit">
	<?
	}
	?>
	
	<input aria-disabled="false" id="letsTakeALook" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-hover" style="float:right;margin-bottom:20px" value="Reservieren" type="submit"> 
	<div id="preLoadWK">
	
	<?	

	
	echo "<table class='ui-widget-content ui-corner-all' width='100%' id='wk_content_tab' style='padding:10px;>";
	echo "<tr><td colspan='5'><br></td></tr>";
	echo "<tr><td><h4></h4></td><td></td><td><h4>Ausleihezeitraum</h4></td>";
	//wenn versand, dann anderer tabellenteil
	if ($_SESSION['SE_versandMod']=="1")
	{
	echo "<td><h4>Versand?</h4></td>";
	}
	else
	{
	echo "<td></td>";
	}
	//ende andere darstellung bei versand
	echo "<td width='80px'><h4>entfernen</h4></td></tr>";
	echo "<tr><td colspan='5'><br></td></tr>";
	
	
	
	for($i=0;$i<count($_SESSION["User_WK"]);$i++)
	{
		if ($_SESSION["User_WK"][$i]["name"]!="")
		{

			//anzeige hg name, wenn hg aktiviert ist
			if ($_SESSION["SE_ViewLeihmodHauptg"]=="1")
			{
			echo "<tr id='tab_".(569823+$i)."'><td>".utf8_encode(klarNameHG($_SESSION["User_WK"][$i]["hgName"]))."</td><td></td><td>".date("d.m.Y G:i",$_SESSION["User_WK"][$i]["zeitStart"])." - ".date("d.m.Y G:i",$_SESSION["User_WK"][$i]["zeitEnde"])."</td>";
			}
			else
			{
			echo "<tr id='tab_".(569823+$i)."'><td>".utf8_encode(klarNameObj($_SESSION["User_WK"][$i]["name"]))."</td><td></td><td>".date("d.m.Y G:i",$_SESSION["User_WK"][$i]["zeitStart"])." - ".date("d.m.Y G:i",$_SESSION["User_WK"][$i]["zeitEnde"])."</td>";
			}
			//versandinfo
			if ($_SESSION['SE_versandMod']=="1" && $_SESSION["User_WK"][$i]["versand"]=="1")
			{
			echo "<td>ja</td>";
			$versandInfo=1;
			}
			else
			{
			echo "<td></td>";
			}
			//ende versandinfo
			echo "<td width='80px'><a href='#link' delwk='dWk__".(569823+$i)."' title='entfernen' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-trash'></span></div></a></td></tr>\n";
		}
		else
		{
		//jedes item im warenkorb muss eine id haben, sonst fehler
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Fehler Warenkorb',
		pnotify_text: 'Fehler 82',
		pnotify_type: 'error'
		});
		</script>	
		<?	
		}
	}
	echo "<tr><td colspan='5'><br></td></tr>";
	echo "</table>";
	?>
	
	
	</div>
	</div>
</article>
<?
	}
	else
	{
		?>
		<article id="articleLogin1"> 
		<h2>Warenkorb</h2>

		<div class="line"></div>

		<div class="articleBody clear">
		<p>Derzeit befinden sich keine Objekte im Warenkorb.</p>
		</div>

		</article>
		<?
	}
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
<script type="text/javascript">
$("a[delwk^=dWk__]").click(function(event) {
$("#preLoadWK").load("01_wkCheck.inc.php?o="+$(this).attr("delwk"));
});

$("#letsTakeALook").click(function(event) {
$("#letsTakeALook").hide();
$("#letsTakeALook2").hide();
$("#wkCheck").load("02_wkCheck.inc.php");
});

$("#letsTakeALook2").click(function(event) {
$("#letsTakeALook").hide();
$("#letsTakeALook2").hide();
$("#wkCheck").load("02_wkCheck.inc.php?fremd=1");
});

$("#loadingAj").hide();
$("#loadingAj").ajaxStart(function(){
   $(this).show();
 });
 $("#loadingAj").ajaxStop(function(){
   $(this).hide();
 });
 
<?
if ($_SESSION["User_Recht_Ausgabeber"]=="1")
{
?>
tooltip = $.pnotify({
	pnotify_title: "Hinweis Kundenleihe",
	pnotify_text: "Mit dieser Schalffläche hinterlegen Sie als Verantwortlicher in der Leihe den Vermerk, dass der Warenkorb für Dritte ausgeliehen worden ist. <br><br>Diese Funktion können Sie nutzen, falls sich nicht Kunden bei BORROW LAND registriert haben oder sofort eine Leihe tätigen möchten.",
	pnotify_hide: false,
	pnotify_closer: false,
	pnotify_history: false,
	pnotify_animate_speed: 100,
	pnotify_opacity: 1,
	pnotify_notice_icon: "ui-icon ui-icon-comment",
	// Setting stack to false causes Pines Notify to ignore this notice when positioning.
	pnotify_stack: false,
	pnotify_after_init: function(pnotify){
		// Remove the notice if the user mouses over it.
		pnotify.mouseout(function(){
			pnotify.pnotify_remove();
		});
	},
	pnotify_before_open: function(pnotify){
		// This prevents the notice from displaying when it's created.
		pnotify.pnotify({
			pnotify_before_open: null
		});
		return false;
	}
});
<?
}

//hinweis, dass objekte zum versand markiert worden sind.
if ($_SESSION['SE_versandMod']=="1" && $versandInfo=="1")
{
?>
	$.pnotify({
	pnotify_title: 'Hinweis',
	pnotify_text: 'Bitte beachten Sie, dass Sie einige Objekte zum Versand markiert haben.'
	});
<?

}
?>
 
 
</script>



<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>