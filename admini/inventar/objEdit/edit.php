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
		
<section id="page"> 


<header> 
            
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../../index.php" title="Startseite"><img src="../../../BL_BILDER/start_00.png"></a> <a href="../../../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a><a href="index.php">/Objekt bearbeiten - Übersicht</a>/Objekt bearbeiten</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a><a href="index.php">/Objekt bearbeiten - Übersicht</a>/Objekt bearbeiten</div>
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
//anfang voraussetzung: registriert, admin
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
{
	//Änderungen vor Anzeige
	if ($_POST['newObj_kurz']!="" && $_POST['newObj_lang']!="" && isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1" && $_POST['hauptgruppen_input']!="" && $_POST['hauptgruppen_input']!="0" && $_POST['djnzG4']!="" && $_POST['up']!="1")
	{
		$check=1;
		$_POST['mietpr_1'] = str_replace(",",".",$_POST['mietpr_1']);
		$_POST['mietpr_2'] = str_replace(",",".",$_POST['mietpr_2']);
	
		if ($_POST['newObj_cb']=="on")
		{
		$ObjOnOff=1;
		}
		else
		{
		$ObjOnOff=0;
		}
		
		if ($_POST['newObj_preview']=="on" )
		{
		$preView=1;
		}
		else
		{
		$preView=0;
		}

		$userDaten=benutzerDaten($_SESSION["User_ID"]);
		$ZeitJetzt= new DateTime();
		$zeitKlarText=$ZeitJetzt->format('U');
		$sql = "UPDATE `04_obj_objekte` SET `Kurzbez` = \"".mysql_real_escape_string(utf8_decode($_POST['newObj_kurz']))."\", `langeBeschre` = \"".mysql_real_escape_string(utf8_decode($_POST['newObj_lang']))."\", `HGruppe` = \"".mysql_real_escape_string(unserialize(base64_decode($_POST['hauptgruppen_input'])))."\", `ObjOnOff` = \"".mysql_real_escape_string($ObjOnOff)."\", `Mietpreis1` = \"".mysql_real_escape_string($_POST['mietpr_1'])."\", `Mietpreis2` = \"".mysql_real_escape_string($_POST['mietpr_2'])."\", `aktivierterMietpreis` = \"".mysql_real_escape_string($_POST['Mietpreis'][0])."\", `VorschauAnAus` = \"".mysql_real_escape_string($preView)."\", `Wiederbeschaffungswert` = \"".mysql_real_escape_string($_POST['wiederbeschaff_input'])."\", `metatags` = \"".mysql_real_escape_string(utf8_decode($_POST['tags']))."\" WHERE `specid_obj` = \"".mysql_real_escape_string(unserialize(base64_decode($_POST['djnzG4'])))."\" LIMIT 1;"; 
		$EingabeObj = mysql_query($sql);
		$angabeErfolg = mysql_affected_rows(); 		
	}	
	//Ende Änderungen vor Anzeige

	//objekt-datenherkunft- steuerung
	//z=webseite //y=barcode //post= nach 1.änderung
	if (isset($_GET['y']) || isset($_GET['z']) || isset($_POST['djnzG4']))
	{
		//wenn der objektcode vom barcode scanner kommt, gibts klartext
		if ($_GET['y']!="")
		{
		$obCode=$_GET['y'];
		}
		
		//wenn der objektcode von der software selbt kommt, muss der erst zurückverschlüsselt werden
		if ($_GET['z']!="")
		{
		$obCode=unserialize(base64_decode($_GET['z']));
		}
		
		//übernahme post
		if ($_POST['djnzG4']!="")
		{
		$obCode=unserialize(base64_decode($_POST['djnzG4']));
		}
	
	//Anfang Bild Upload vor Anzeige
	if ($_POST['upPic']=="1" && $_POST['djnzG4']!="")
	{
		//pdf endung
		if (strstr($_FILES['dateiFuerBild']['name'], 'jpg')=="jpg" || strstr($_FILES['dateiFuerBild']['name'], 'JPG')=="JPG")
		{
			//größe unter 3 mb ist okay
			
			if (round($_FILES['dateiFuerBild']['size']/1048576)<5)
			{
				if (move_uploaded_file($_FILES['dateiFuerBild']['tmp_name'], "../../../BL_MEDIA/PIC_OBJ/".base64_encode(serialize($obCode)).".jpg")==TRUE)
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
		resizeImage("../../../BL_MEDIA/PIC_OBJ/".base64_encode(serialize($obCode)).".jpg","../../../BL_MEDIA/PIC_OBJ/".base64_encode(serialize($obCode)).".jpg",800,0);
		}
		
	}
	
	//Ende Bild Upload 

	//Anfang PDF Upload
	if ($_POST['up']=="1" && $_POST['djnzG4']!="")
	{
		//pdf endung
		if (strstr($_FILES['dateiFuerBildObj']['name'], 'pdf')=="pdf" || strstr($_FILES['dateiFuerBildObj']['name'], 'PDF')=="PDF")
		{
			//größe unter 20 mb ist okay
			if (round($_FILES['dateiFuerBildObj']['size']/1048576)<20)
			{
				if (move_uploaded_file($_FILES['dateiFuerBildObj']['tmp_name'], "../../../BL_MEDIA/PDF_OBJ/".base64_encode(serialize($obCode)).".pdf")==TRUE)
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
	//Ende PDF Upload
	

	//allgemeine daten für tabelle
	$sql = "SELECT * FROM `04_obj_objekte` WHERE `specid_obj` = \"".mysql_real_escape_string($obCode)."\" LIMIT 1 "; 
	$objAbfrage = mysql_query($sql);
	$objDaten = mysql_fetch_row($objAbfrage);
	$anzahlDatens=mysql_num_rows($objAbfrage);
	if ($anzahlDatens=="1")
	{
		/////////////////////////////////////////////
		$includeName="03_contentObjEdit.inc.php";
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
		<article id="objeStat"> 
		<h2>Fehler</h2>
			
		<div class="line"></div>
		<div class="articleBody clear" >
		Dieses Objekt konnte nicht gefunden werden.<br>
		<a href="../"><<< zurück</a>
		</div>		
		</article>	
		<?
	}
	//div aus clear vom start
	?>
	</div>
	<?


}
	//es wurde kein get parameter angegeben, login vorhanden => übertragungsfehler
	else
	{
	?>
	<article id="fehler"> 
	<h2>Objekt Bearbeitung</h2>
	<div class="line"></div>
		<div class="articleBody clear" >
		Leider ist ein Übertragungsfehler aufgetreten.<br><br><a href="<? echo $_SESSION["SE_festUrl"]."admini/inventar/objEdit"; ?>"><b>Übersicht Objekte</b></a><br><br>
	</div>
	</article>
	<?			
	}
}
//ende voraussetzung registriert
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

echo nl2br($_SESSION["SE_jQuerUI"]);
?>  

<!-- JavaScript Includes -->
<script type="text/javascript" src="../../../BL_JS/jquery.numeric.js"></script>
<script type="text/javascript" src="../../../BL_JS/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="../../../BL_JS/jquery.ezmark.min.js"></script>
<?
//js nur anzeigen wenn objekt gefunden
if ($fehlerObjektGefunden!="1")
{
?>
<script>
$('#iphoneP input').ezMark({checkboxCls:'ez-checkbox-iphone', checkedCls: 'ez-checked-iphone'});

	$('#tags').tagsInput({'width':'720px'}); 
	
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
	
	
<?
if (isset($angabeErfolg) && isset($EingabeObj))
{

	if ($angabeErfolg=="1")
	{
	?>
	$.pnotify({
	pnotify_title: 'Änderung der Objektdaten',
	pnotify_text: 'Das Objekt wurde erfolgreich geändert.',
	});
	<?
	}
	
	else
	{
	?>
	$.pnotify({
	pnotify_title: 'Änderung der Objektdaten',
	pnotify_text: 'Das Objekt wurde nicht erfolgreich geändert.',
	pnotify_type: 'error',
	});
	<?
	}
}

if ($_SESSION["SE_MoneyModule"]=="1" && $_SESSION["SE_MoneyModule_Mietp"]=="1")
{
	if ($objDaten[11]=="1" || $objDaten[11]=="2")
	{
	?>
	$("#mietpreise").show();
	<?
	}
?>

	$("#wiederbeschaff_input").numeric();
	$("#mietpr_1").numeric();
	$("#mietpr_2").numeric();
	
	$(":radio[value=1]").click(function () {
	$("#mietpreise").slideToggle("slow");
	});
	
	$(":radio[value=0]").click(function () {
	$("#mietpreise").hide("slow");
	});
	
	$(":radio[value=3]").click(function () {
	$("#mietpreise").hide("slow");
	});
<?
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
$("#pdfDes").click(function(event) {
$("#output").load("02_pdfDel.php?pI=<? echo base64_encode(serialize($obCode));?>");
});

$("#PICDel").click(function(event) {
$("#output").load("04_jpgDel.php?jI=<? echo base64_encode(serialize($obCode));?>");
});

</script>
<?
}
?>

<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>