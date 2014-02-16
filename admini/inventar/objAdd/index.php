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
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a>/Objekt hinzufügen</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a>/Objekt hinzufügen</div>
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
<section id="articles"> 
<?
//anfang voraussetzung: registriert, admin oder ausgabeberechtigter
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
{

//anfang einzel objekt
	if ($_POST['newObj_kurz']!="" && $_POST['newObj_lang']!="" && $_POST['newObj_lang']!="Ihre Beschreibung für das Objekt" && isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1" && $_POST['hauptgruppen_input']!="" && $_POST['hauptgruppen_input']!="0")
	{

	$_POST['mietpr_1'] = str_replace(",",".",$_POST['mietpr_1']);
	$_POST['mietpr_2'] = str_replace(",",".",$_POST['mietpr_2']);
	
	$unique_id=sha1(uniqid(microtime(),1));
	$sql = "SELECT id FROM `04_obj_objekte` WHERE `specid_obj` = \"".$unique_id."\"";
 	$abfrageUniID = mysql_query($sql);
	$anzahlUniID = mysql_num_rows($abfrageUniID); 

	//ist eine hg mit der id schon da?
		if ($anzahlUniID=="0")
		{
			if ($_POST['newObj_cb']=="on")
			{
			$ObjOnOff=1;
			}
			else
			{
			$ObjOnOff=0;
			}
			

			if ($_POST['newObj_preview']=="on")
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

		$sql = "INSERT INTO `04_obj_objekte` (`specid_obj`, `Kurzbez`, `langeBeschre`, `ErstelltAm`, `ErstelltVon`, `ObjOnOff`, `HGruppe`,`aktivierterMietpreis`,`Mietpreis1`,`Mietpreis2`,`VorschauAnAus`,`Wiederbeschaffungswert`,`metatags`) VALUES (\"".mysql_real_escape_string(utf8_decode($unique_id))."\", \"".mysql_real_escape_string(utf8_decode($_POST['newObj_kurz']))."\", \"".mysql_real_escape_string(utf8_decode($_POST['newObj_lang']))."\", \"".$zeitKlarText."\", \"".mysql_real_escape_string(utf8_decode($userDaten[0]))."\", \"".mysql_real_escape_string($ObjOnOff)."\",\"".mysql_real_escape_string(unserialize(base64_decode($_POST['hauptgruppen_input'])))."\",\"".mysql_real_escape_string($_POST['Mietpreis'][0])."\",\"".mysql_real_escape_string($_POST['mietpr_1'])."\",\"".mysql_real_escape_string($_POST['mietpr_2'])."\",\"".mysql_real_escape_string($preView)."\",\"".mysql_real_escape_string($_POST['wiederbeschaff_input'])."\",\"".mysql_real_escape_string(utf8_decode($_POST['tags']))."\");"; 
		
		
		$EingabeObj = mysql_query($sql);
		$angabeErfolg = mysql_affected_rows(); 		
		
			if ($angabeErfolg=="1")
			{
			//variable für ausgabe okay
			$obj1="1";
			
			//Anfang Bild Upload 
			if ($_FILES['dateien']['name'][0]!="")
			{
				//pdf endung
				if (strstr($_FILES['dateien']['name'][0], 'jpg')=="jpg" || strstr($_FILES['dateien']['name'][0], 'JPG')=="JPG")
				{
					if (round($_FILES['dateien']['size'][0]/1048576)<5)
					{
						if (move_uploaded_file($_FILES['dateien']['tmp_name'][0], "../../../BL_MEDIA/PIC_OBJ/".base64_encode(serialize($unique_id)).".jpg")==TRUE)
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
				resizeImage("../../../BL_MEDIA/PIC_OBJ/".base64_encode(serialize($unique_id)).".jpg","../../../BL_MEDIA/PIC_OBJ/".base64_encode(serialize($unique_id)).".jpg",800,0);
				}
			}
			//Ende Bild Upload 
			
			//Anfang PDF Upload
			if ($_FILES['dateien']['name'][1]!="")
			{
				//pdf endung
				if (strstr($_FILES['dateien']['name'][1], 'pdf')=="pdf" || strstr($_FILES['dateien']['name'][1], 'PDF')=="PDF")
				{
					if (round($_FILES['dateien']['size'][1]/1048576)<20)
					{
						if (move_uploaded_file($_FILES['dateien']['tmp_name'][1], "../../../BL_MEDIA/PDF_OBJ/".base64_encode(serialize($unique_id)).".pdf")==TRUE)
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
			
				//anfang twitter
				if (welcheEinstellung("SE_twitterModuleActi")=="1")
				{
				$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
				$consumerSecret = welcheEinstellung("SE_consumerSecret");
				$oAuthToken     = welcheEinstellung("SE_oAuthToken");
				$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");
				
				require_once('../../../BL_TWITR/twitteroauth.php');

				$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
				$inhalt="Es wurde ein neues Ausleiheobjekt (".mysql_real_escape_string(utf8_decode($_POST['newObj_kurz'])).") eingestellt. #Ausleihsoftware http://ausleihsoftware.de";
				$tweet->post('statuses/update', array('status' => $inhalt));
				}
				//ende twitter
			}
			else
			{
			$obj2="1";
			}			
		}
		else
		{
		//id schon da, nochmalige Übertragung
		$obj3="1";
		}
	}


//ende einzel objekt

//anfang duplizieren


//duplizieren funktion anfang
if (is_numeric($_POST["Dupl_anzahl"]) && $_POST["d"]=="mnbhz74SQ")
{
	//mehr als 99 kopien sind nicht erlaubt
	if ($_POST["Dupl_anzahl"]>=99)
	{
	$tooMuchDupl=1;
	}
	else
	{
	$sql = 'SELECT Kurzbez,langeBeschre,HGruppe,ObjOnOff,Mietpreis1,Mietpreis2,aktivierterMietpreis,VorschauAnAus,Wiederbeschaffungswert,metatags,specid_obj FROM `04_obj_objekte` ORDER BY `id` DESC LIMIT 1 ';
	$hgs = mysql_query($sql);
	$row = mysql_fetch_row($hgs);
	$userDaten=benutzerDaten($_SESSION["User_ID"]);

	/*
	Kurzbez,							0
	langeBeschre,						1
	HGruppe,							2
	ObjOnOff,							3
	Mietpreis1,							4
	Mietpreis2,							5
	aktivierterMietpreis,				6
	VorschauAnAus,						7
	Wiederbeschaffungswert,				8
	metatags  							9
	speID								10
	*/
			

		for ($i=0;$i<$_POST["Dupl_anzahl"];$i++)
		{
		$unique_id=sha1(uniqid(microtime(),1));
		$ZeitJetzt= new DateTime();
		$zeitKlarText=$ZeitJetzt->format('U');
		$sql = "INSERT INTO `04_obj_objekte` (`specid_obj`, `Kurzbez`, `langeBeschre`, `ErstelltAm`, `ErstelltVon`, `ObjOnOff`, `HGruppe`,`aktivierterMietpreis`,`Mietpreis1`,`Mietpreis2`,`VorschauAnAus`,`Wiederbeschaffungswert`,`metatags`) VALUES (\"".$unique_id."\", \"".$row[0]."\", \"".$row[1]."\", \"".$zeitKlarText."\", \"".$userDaten[0]."\", \"".$row[3]."\",\"".$row[2]."\",\"".$row[6]."\",\"".$row[4]."\",\"".$row[5]."\",\"".$row[7]."\",\"".$row[8]."\",\"".$row[9]."\");"; 
		$schreiben = mysql_query($sql);
		
		//medien:pic
		if ($_POST["Dupl_pic"]=="on" || $_POST["Dupl_pic"]=="checked")
		{
			//wenn ursprungsdatei vorhanden, neu kopieren
			if (is_file('../../../BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($row[10])).'.jpg'))
			{
			copy('../../../BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($row[10])).'.jpg','../../../BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($unique_id)).'.jpg');
			}
		}
		
		//medien:pdf
		if ($_POST["Dupl_pdf"]=="on" || $_POST["Dupl_pdf"]=="checked")
		{
			//wenn ursprungsdatei vorhanden, neu kopieren
			if (is_file('../../../BL_MEDIA/PDF_OBJ/'.base64_encode(serialize($row[10])).'.pdf'))
			{
			copy('../../../BL_MEDIA/PDF_OBJ/'.base64_encode(serialize($row[10])).'.pdf','../../../BL_MEDIA/PDF_OBJ/'.base64_encode(serialize($unique_id)).'.pdf');
			}
		}

		//mehr als eine sekunde warten
		usleep(120000);
			if (mysql_affected_rows()=="1")
			{
			$r++;
			}
		}
		
		if ($r==$_POST["Dupl_anzahl"])
		{
		$obj4="1";
		}
	}
}
//ende duplizieren

	/////////////////////////////////////////////
	$includeName="01_contentObjAdd.inc.php";
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
<script type="text/javascript" src="../../../BL_JS/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="../../../BL_JS/jquery.ezmark.min.js"></script>

<?
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
{
?>
<script>
$('#tags').tagsInput({'width':'720px'}); 
$('#iphoneP input').ezMark({checkboxCls:'ez-checkbox-iphone', checkedCls: 'ez-checked-iphone'});

<?

if ($obj1=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Neues Objekt',
	pnotify_text: 'Das Objekt wurde erfolgreich angelegt.'
	});
	<?
}
if ($obj2=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Neues Objekt',
	pnotify_text: 'Das Objekt wurde leider nicht erfolgreich angelegt.',
	pnotify_type: 'error'
	});
	<?
}

if ($obj3=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Neues Objekt',
	pnotify_text: 'Bitte wiederholen Sie die Eingabe des Objektes',
	pnotify_type: 'error'
	});
	<?
}

if ($obj4=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Duplizieren',
	pnotify_text: 'Das Objekt wurde erfolgreich dupliziert.'
	});
	<?
}

if ($tooMuchDupl=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Duplizieren',
	pnotify_text: 'Mehr als 99 Kopien werden aus Sicherheitsgründen nicht zugelassen.',
	pnotify_type: 'error'
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
	pnotify_type: 'error'
	});
	<?	
}

if ($PICuploadOK=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des Bildes',
	pnotify_text: 'Das Bild ist erfolgreich hochgeladen worden.'
	});

	<?	
}
if ($PICfehlerUPSize=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des Bildes',
	pnotify_text: 'Das Bild überschreitet die zulässige Dateigröße von maximal 5 Megabyte.',
	pnotify_type: 'error'
	});
	<?	
}

if ($PICfehlerUP=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des Bildes',
	pnotify_text: 'Das Bild konnte leider nicht hochgeladen werden.',
	pnotify_type: 'error'
	});
	<?	
}
//ende bilder

//pdf
if ($keinePDF=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des PDF-Dokumentes',
	pnotify_text: 'Das Dokument ist leider keine PDF Datei.',
	pnotify_type: 'error'
	});
	<?	
}

if ($uploadOK=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des PDF-Dokumentes',
	pnotify_text: 'Das Dokument ist erfolgreich hochgeladen worden.'
	});

	<?	
}
if ($fehlerUPSize=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des PDF-Dokumentes',
	pnotify_text: 'Das Dokument überschreitet die zulässige Dateigröße von maximal 20 Megabyte.',
	pnotify_type: 'error'
	});
	<?	
}

if ($fehlerUP=="1")
{
	?>
	$.pnotify({
	pnotify_title: 'Hochladen des PDF-Dokumentes',
	pnotify_text: 'Das Dokument konnte leider nicht geladen werden.',
	pnotify_type: 'error'
	});
	<?	
}
//ende pdf


if ($_SESSION["SE_MoneyModule"]=="1" && $_SESSION["SE_MoneyModule_Mietp"]=="1")
{
?>
	$("#wiederbeschaff_input").numeric();
	$("#mietpr_1").numeric();
	$("#mietpr_2").numeric();
	$("#Dupl_anzahl").numeric();
		
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

$("input:text:visible:first").focus();
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


$("input[value^=Neues]").click(function(event) {
$( "#dialog:ui-dialog" ).dialog( "destroy" );
$( "#dialog-message2" ).dialog({
	modal: true
});
});

$("input[value=Duplizieren]").click(function(event) {
$( "#dialog:ui-dialog" ).dialog( "destroy" );
$( "#dialog-message" ).dialog({
	modal: true
});
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