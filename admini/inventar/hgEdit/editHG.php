<?

session_start();

//System 
/////////////////////////////////////////////
$includeName="../../../_00_basic_check.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

//Funktionen 
/////////////////////////////////////////////
$includeName="../../../_00_basic_func.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="../../../_01_basic_db.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Sessions
/////////////////////////////////////////////
$includeName="../../../_01_basic_sess.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
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
<br><br><br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	
		
<section id="page"> <!-- Defining the #page section with the section tag -->


            <header> <!-- Defining the header section of the page with the appropriate tag -->
            
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../../index.php" title="Startseite"><img src="../../../BL_BILDER/start_00.png"></a> <a href="../../../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a><a href="index.php">/Hauptgruppe bearbeiten - Übersicht</a>/Hauptgruppe bearbeiten</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a><a href="index.php">/Hauptgruppe bearbeiten - Übersicht</a>/Hauptgruppe bearbeiten</div>
	</hgroup>
	<?
	}
}

//#############Ende Überschrift	
	//navigation
	/////////////////////////////////////////////
	$includeName="../../../_00_basic_nav.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
	exit();
	}
	/////////////////////////////////////////////
?>
			
</header>
<div id="output"></div>
<section id="articles"> 
<?


//anfang voraussetzung: registriert, admin oder ausgabeberechtigter
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
{
	//änderungen vor laden
	if ($_POST['newHG_kurz']!="" && $_POST['newHG_lang']!="" && isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1" && $_POST['fnn_2']!="")
	{

		if ($_POST['newHG_cb']=="on")
		{
		$ObjOnOff=1;
		}
		else
		{
		$ObjOnOff=0;
		}
		
	$userDaten=benutzerDaten($_SESSION["User_ID"]);
	$ZeitJetzt= new DateTime();
	$zeitKlarText=$ZeitJetzt->format('U');
	$sql = "UPDATE `03_obj_hauptgruppen` SET `Kurzbez` = \"".mysql_real_escape_string(utf8_decode($_POST['newHG_kurz']))."\", `langeBeschre` = \"".mysql_real_escape_string(utf8_decode($_POST['newHG_lang']))."\", `HGruppenOnOff` = \"".$ObjOnOff."\" WHERE `specid_hg` = \"".mysql_real_escape_string(unserialize(base64_decode($_POST['fnn_2'])))."\" LIMIT 1;"; 
	$EingabeObj = mysql_query($sql);
	$angabeErfolg = mysql_affected_rows(); 		
	}
	//änderungen vor laden
	
	//daten kommen vom update zur darstellung oder von der übersicht
	if (isset($_GET['g']) || isset($_POST['fnn_2']))
	{
		if (isset($_GET['g']))
		{
		$hgCode=unserialize(base64_decode($_GET['g']));
		}
		if (isset($_POST['fnn_2']))
		{
		$hgCode=unserialize(base64_decode($_POST['fnn_2']));
		}

	//bilder & pdf
	if ($_POST['up']=="1" && $_POST['fnn_2']!="")
	{
		//pdf endung
		if (strstr($_FILES['dateiFuerBildObj']['name'], 'pdf')=="pdf" || strstr($_FILES['dateiFuerBildObj']['name'], 'PDF')=="PDF")
		{
			//größe unter 20 mb ist okay
			if (round($_FILES['dateiFuerBildObj']['size']/1048576)<20)
			{
				if (move_uploaded_file($_FILES['dateiFuerBildObj']['tmp_name'], "../../../BL_MEDIA/PDF_HG/".base64_encode(serialize($hgCode)).".pdf")==TRUE)
				{
				$uploadOK=1;
				}
				else
				{
				$fehlerUP=1;
				}				
			}
			else
			{
			$fehlerUPSize=1;
			}			
		}
		else
		{
		$keinePDF=1;	
		}
	}
	
	//pic
	if ($_POST['upPic']=="1" && $_POST['fnn_2']!="")
	{
		//pdf endung
		if (strstr($_FILES['dateiFuerBild']['name'], 'jpg')=="jpg" || strstr($_FILES['dateiFuerBild']['name'], 'JPG')=="JPG")
		{
			//größe unter 3 mb ist okay
			if (round($_FILES['dateiFuerBild']['size']/1048576)<5)
			{
				if (move_uploaded_file($_FILES['dateiFuerBild']['tmp_name'], "../../../BL_MEDIA/PIC_HG/".base64_encode(serialize($hgCode)).".jpg")==TRUE)
				{
				$PICuploadOK=1;
				}
				else
				{
				$PICfehlerUP=1;
				}				
			}
			else
			{
			$PICfehlerUPSize=1;
			}			
		}
		else
		{
		$PICkeine=1;	
		}
		
		//verkleinern
		//800x600
		if ($PICuploadOK=="1")
		{
		resizeImage("../../../BL_MEDIA/PIC_HG/".base64_encode(serialize($hgCode)).".jpg","../../../BL_MEDIA/PIC_HG/".base64_encode(serialize($hgCode)).".jpg",800,0);
		}
	}
	
	//ende bilder & pdf

		
		//hg daten auslesen
		$sql = "SELECT * FROM `03_obj_hauptgruppen` WHERE `specid_hg` = \"".mysql_real_escape_string($hgCode)."\" LIMIT 1 "; 
		$HGAbfrage = mysql_query($sql);
		$HGDaten = mysql_fetch_row($HGAbfrage);
		$anzahlHG=mysql_num_rows($HGAbfrage);

		if ($anzahlHG=="1")
			{
				/////////////////////////////////////////////
				$includeName="03_contentHGEdit.inc.php";
				if (file_exists($includeName))
				{
				require($includeName);
				}	
				else
				{
				echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
				exit();
				}
				/////////////////////////////////////////////
			}
			else
			{
				$fehlerObjektGefunden=1;
				?>
				<article id="HGStat"> 
				<h2>Fehler</h2>
					
				<div class="line"></div>
				<div class="articleBody clear" >
				Diese Hauptgruppe konnte nicht gefunden werden.<br>
				<a href="../"><<< zurück</a>
				</div>		
				</article>	
				<?
			}

	}
	else
	{
		?>
		<article id="articleLogin2"> 
		<form id="form">
		<h2>Hauptgruppen Bearbeitung</h2>
			
		<div class="line"></div>
		<div class="articleBody clear" >
		Leider ist ein Übertragungsfehler aufgetreten.<br><br><a href="<? echo $_SESSION["SE_festUrl"]."admini/inventar/hgEdit"; ?>"><b>Übersicht Hauptgruppen</b></a><br><br>
		</div>
		</article>
		<?			
	}




}//ende voraussetzung registriert
else
{
	//nicht eingeloggt
	/////////////////////////////////////////////
	$includeName="../../../_02_NoLoginAllPages.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
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
$includeName="../../../_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}

/////////////////////////////////////////////			
?>  
	        
 
		 

        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
?>  
<script type="text/javascript" src="../../../BL_JS/jquery.numeric.js"></script>
<script type="text/javascript" src="../../../BL_JS/jquery.ezmark.min.js"></script>


<script>
<?
if ($fehlerObjektGefunden!="1")
{


	if (isset($angabeErfolg) && isset($EingabeObj))
	{

		if ($angabeErfolg=="1")
		{
		?>
		$.pnotify({
		pnotify_title: 'Änderung der Hauptgruppe',
		pnotify_text: 'Die Hauptgruppe wurde erfolgreich geändert.',
		});
		<?
		}
		
		else
		{
		?>
		$.pnotify({
		pnotify_title: 'Änderung der Hauptgruppe',
		pnotify_text: 'Die Hauptgruppe wurde nicht erfolgreich geändert.',
		pnotify_type: 'error',
		});
		<?
		}
	}
?>

<?
if ($keinePDF=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des PDF-Dokumentes',
	pnotify_text: 'Das Dokument ist leider keine PDF Datei.',
	pnotify_type: 'error',
	});
	<?	
}

if ($uploadOK=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des PDF-Dokumentes',
	pnotify_text: 'Das Dokument ist erfolgreich hochgeladen worden.',
	});
	
	$.pnotify({
	pnotify_title: 'PDF-Dokumente',
	pnotify_text: 'Hinweis: Bei einem erneuten Hochladevorgang überschreiben Sie die vorherige Version.',
	});
	
	
	<?	
}
if ($fehlerUPSize=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des PDF-Dokumentes',
	pnotify_text: 'Das Dokument überschreitet die zulässige Dateigröße von maximal 20 Megabyte.',
	pnotify_type: 'error',

	});
	<?	
}

if ($fehlerUP=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des PDF-Dokumentes',
	pnotify_text: 'Das Dokument konnte leider nicht geladen werden.',
	pnotify_type: 'error',

	});
	<?	
}


//PIC
if ($PICkeine=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des Bildes',
	pnotify_text: 'Das Bild ist leider keine JPG Datei.',
	pnotify_type: 'error',
	});
	<?	
}

if ($PICuploadOK=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des Bildes',
	pnotify_text: 'Das Bild ist erfolgreich hochgeladen worden.',
	});
	
	$.pnotify({
	pnotify_title: 'Hochladen des Bildes',
	pnotify_text: 'Hinweis: Bei einem erneuten Hochladevorgang überschreiben Sie die vorherige Version.',
	});
	
	
	<?	
}
if ($PICfehlerUPSize=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des Bildes',
	pnotify_text: 'Das Bild überschreitet die zulässige Dateigröße von maximal 5 Megabyte.',
	pnotify_type: 'error',

	});
	<?	
}

if ($PICfehlerUP=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des Bildes',
	pnotify_text: 'Das Bild konnte leider nicht geladen werden.',
	pnotify_type: 'error',

	});
	<?	
}
?>
$('#iphoneP input').ezMark({checkboxCls:'ez-checkbox-iphone', checkedCls: 'ez-checked-iphone'});


$("#pdfDes").click(function(event) {
$("#output").load("02_pdfDel.php?pI=<? echo base64_encode(serialize($hgCode));?>");
});


$("#PICDel").click(function(event) {
$("#output").load("04_jpgDel.php?jI=<? echo base64_encode(serialize($hgCode));?>");
});
	$("#reqUp").click(function () {
	$("#hochladen").slideToggle();
	});
	
	$("#pdfUp").click(function () {
	$("#hochladenPDF").slideToggle();
	});


tooltip = $.pnotify({
	pnotify_title: "Upload Hinweis Bild",
	pnotify_text: "Es werden JPG Dateien für die Bildfunktion akzeptiert. Die maximale Dateigröße beträgt 5 Megabyte. Da das Bild automatisch maximal 800 Pixel verkleinert wird, müssen Sie Ihr Bildmaterial nicht vor dem Hochladen verkleinern.  <br><br>",
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

tooltip2 = $.pnotify({
	pnotify_title: "Upload Hinweis PDF",
	pnotify_text: "Die maximale Dateigröße beträgt 20 Megabyte. Nutzen Sie PDF's um Anleitungen oder weitergehende Informationen anzubieten. <br><br>",
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
	
$("input[value^=Bild]").click(function(event) {
$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog-message" ).dialog({
		modal: true
	});
});

$("input[value^=PDF]").click(function(event) {
$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog-message2" ).dialog({
		modal: true
	});
});
</script>

<?
}

echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>