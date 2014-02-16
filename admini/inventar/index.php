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
$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Inventar</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Inventar</div>
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
	<div id="ajax"></div>
			
	<?
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
	{
	?>

		<article id="articleLogin1"> 
		<h2>Inventar-Verwaltung</h2>

		<div class="line"></div>

		<div class="articleBody clear">
		
		
		<a value="Hinweis" onmouseover="tooltip.pnotify_display();" onmousemove="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip.pnotify_remove();" href="inventar.php" class="fg-button ui-state-default ui-corner-all ui-state-hover" style="margin-bottom: 10px; float: right;">Inventarübersicht (EXCEL)</a>
		<a href="01_pdf_overviewObj.inc.php" class="fg-button ui-state-default ui-corner-all ui-state-hover" style="margin-bottom: 10px; float: right;">Objektübersicht (PDF)</a><br><br>

		<table class='ui-widget-content ui-corner-all' width='100%' id='wk_content_tab' style='padding:10px;margin-top:20px'>
			
			<?
			//menüpunkte admin
			if ($_SESSION["User_Recht_Admin"]=="1")
			{
			?>
			<tr><td colspan='5'><br></td></tr>
			<tr><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar/hgAdd" title="Hauptgruppe hinzufügen" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-circle-plus"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar/hgAdd" title="Hauptgruppe hinzufügen">Hauptgruppe hinzufügen</a></td><td width="70px"></td><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar/hgEdit" title="Hauptgruppe bearbeiten"><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-pencil"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar/hgEdit" title="Hauptgruppe bearbeiten">Hauptgruppe bearbeiten</a></td></tr>
			<tr><td colspan='5'><br></td></tr>
			<tr><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar/objAdd" title="Objekt hinzufügen" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-circle-plus"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar/objAdd" title="Objekt hinzufügen">Objekt hinzufügen</a></td><td width="70px"></td><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar/objEdit" title="Objekte bearbeiten"><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-pencil"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar/objEdit" title="Objekte bearbeiten">Objekte bearbeiten</a></td></tr>
			<tr><td colspan='5'><br></td></tr>
			<?
			}
			
			if ($_SESSION["SE_RFIDModule"]=="1")
			{
			?>
			
			<tr><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar/rfid" title="RFID Verwaltung" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-signal"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar/rfid" title="RFID Verwaltung">RFID Verwaltung</a></td><td width="70px"></td><td width="50px"></td><td></td></tr>			
            <tr><td colspan='5'><br></td></tr>
			<?
			}
			
			
			
			?>

		</table></div></article>
	<h4><div id="exHier" style="cursor:pointer; width:300px">Beispiel Hierarchie</div></h4><br>
		
		<article id="article2" class="ui-helper-hidden"> 
		<div align="center"><img src="../../BL_BILDER/Hierarchie.png"></div>
		</article>		

	<?
	}
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
</section>	        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
?>

<script>
    $("#exHier").click(function () {
      $("#article2").slideToggle("slow");
    });

tooltip = $.pnotify({
	pnotify_title: "Hinweis zu Excel",
	pnotify_text: "Für die Excel Ansicht benötigen Sie Microsoft Excel. Auf dieser Webseite: <b>http://the-ws.de/url/11</b> können Sie kostenfrei den Excel Viewer herunterladen, der Ihnen das Inventar anzeigen kann. <br><br>",
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

</script>



<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>