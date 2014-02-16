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
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a>/Hauptgruppe hinzufügen</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a>/Hauptgruppe hinzufügen</div>
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

				/////////////////////////////////////////////
				$includeName="03_contentHGAdd.inc.php";
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
	if ($_POST['newHG_kurz']!="" && $_POST['newHG_lang']!="" && $_POST['newHG_lang']!="Ihre Beschreibung für die Hauptgruppe" && isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
	{
	//echo $_POST['newHG_cb']; //on
	
	$unique_id=sha1(uniqid(microtime(),1));
	$sql = "SELECT id FROM `03_obj_hauptgruppen` WHERE `specid_hg` = \"".$unique_id."\"";
 	$abfrageUniID = mysql_query($sql);
	$anzahlUniID = mysql_num_rows($abfrageUniID); 

	//ist eine hg mit der id schon da?
		if ($anzahlUniID=="0")
		{
			
			//Anfang Bild Upload 
			if ($_FILES['dateien']['name'][0]!="")
			{
				//pdf endung
				if (strstr($_FILES['dateien']['name'][0], 'jpg')=="jpg" || strstr($_FILES['dateien']['name'][0], 'JPG')=="JPG")
				{
					if (round($_FILES['dateien']['size'][0]/1048576)<5)
					{
						if (move_uploaded_file($_FILES['dateien']['tmp_name'][0], "../../../BL_MEDIA/PIC_HG/".base64_encode(serialize($unique_id)).".jpg")==TRUE)
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
				resizeImage("../../../BL_MEDIA/PIC_HG/".base64_encode(serialize($unique_id)).".jpg","../../../BL_MEDIA/PIC_HG/".base64_encode(serialize($unique_id)).".jpg",800,0);
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
						if (move_uploaded_file($_FILES['dateien']['tmp_name'][1], "../../../BL_MEDIA/PDF_HG/".base64_encode(serialize($unique_id)).".pdf")==TRUE)
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

			if ($_POST['newHG_cb']=="on")
			{
			$hgOnOff=1;
			}
			else
			{
			$hgOnOff=0;
			}
		
			$userDaten=benutzerDaten($_SESSION["User_ID"]);

			$ZeitJetzt= new DateTime();
			$zeitKlarText=$ZeitJetzt->format('U');

			
			$sql = "INSERT INTO `03_obj_hauptgruppen` (`specid_hg`, `Kurzbez`, `langeBeschre`, `ErstelltAm`, `ErstelltVon`, `HGruppenOnOff`) VALUES (\"".mysql_real_escape_string(utf8_decode($unique_id))."\", \"".mysql_real_escape_string(utf8_decode($_POST['newHG_kurz']))."\", \"".mysql_real_escape_string(utf8_decode($_POST['newHG_lang']))."\", \"".$zeitKlarText."\", \"".mysql_real_escape_string(utf8_decode($userDaten[0]))."\", \"".mysql_real_escape_string($hgOnOff)."\");"; 
			$EingabeHG = mysql_query($sql);
			$angabeErfolg = mysql_affected_rows(); 		
		
			if ($angabeErfolg=="1")
			{
				?>
				$.pnotify({
				pnotify_title: 'Neue Hauptgruppe',
				pnotify_text: 'Die Hauptgruppe wurde erfolgreich angelegt.',
				});
				<?
				
				
				//anfang twitter
				if (welcheEinstellung("SE_twitterModuleActi")=="1")
				{
				$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
				$consumerSecret = welcheEinstellung("SE_consumerSecret");
				$oAuthToken     = welcheEinstellung("SE_oAuthToken");
				$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");
				
				require_once('../../../BL_TWITR/twitteroauth.php');

				$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
				$inhalt="Es wurde eine neue Hauptgruppe (".mysql_real_escape_string(utf8_decode($_POST['newHG_kurz'])).") erstellt. #Ausleihsoftware http://ausleihsoftware.de";
				$tweet->post('statuses/update', array('status' => $inhalt));
				}
				//ende twitter			

			}
			
			else
			{
			?>
			$.pnotify({
			pnotify_title: 'Neue Hauptgruppe',
			pnotify_text: 'Die Hauptgruppe wurde leider nicht erfolgreich angelegt.',
			pnotify_type: 'error',
			});
			<?
			}			
		
		
		}
		else
		{
		//id schon da, nochmalige Übertragung
		?>
		$.pnotify({
		pnotify_title: 'Neue Hauptgruppe',
		pnotify_text: 'Bitte wiederholen Sie die Eingabe der Hauptgruppe',
		pnotify_type: 'error',
		});
		<?
		}
	
	}
?>

$("input:text:visible:first").focus();

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
	
$("input[value^=Haupt]").click(function(event) {
$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog-message" ).dialog({
		modal: true
	});
});

</script>

<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>