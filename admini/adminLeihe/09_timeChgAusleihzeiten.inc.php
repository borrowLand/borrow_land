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


//buttons (GET WERT h)
if (isset($_SESSION["User_ID"]) && isset($_GET['d']) && $_GET['d']!="" && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{
$wertInDB=$_GET['d']-6212;
//echo $wertInDB;

//anzeige alte ausleihdaten
$sql = "SELECT von,bis,geraet  FROM `06_wkObje` WHERE `id` = \"".mysql_real_escape_string($wertInDB)."\""; 
$DatenLeihe = mysql_query($sql);
$row = mysql_fetch_row($DatenLeihe);



?>
<style>
a.ui-dialog-titlebar-close{
display: none;
}
</style>
<div id="dialog-request" title="Eingabe des neuen Zeitraums.">
<p><div class="Standard_Verdana_12">Bitte geben Sie den neuen Leihe-Zeitraum für das Objekt an. Optional kann auch ein neues Objekt (z.B. bei Tausch) angegeben werden. </p>
<?
	if ($_SESSION['SE_versandMod']=="1")
	{	
	echo 'Versandoptionen werden bei einem Tausch nicht übernommen. ';
	}
?>


<br><br>Auswahl Tauschobjekt:<br>

<select name="obj" id="obj">
<?
//anzeige aller objekte,die aktiviert sind
$sql = "SELECT specid_obj,Kurzbez  FROM `04_obj_objekte` WHERE `ObjOnOff` = 1  "; 
$DatenVerfuegungObj = mysql_query($sql);

	while ($objdatenVerfueg = mysql_fetch_array($DatenVerfuegungObj, MYSQL_NUM))
	{
		//bei der if schleife wird geguckt, ob referenzobjekt gefunden wurde, wenn ja: vorauswahl.
		
		if ($row[2]==$objdatenVerfueg[0])
		{
		?>
		<option selected="selected" value="<? echo base64_encode(serialize($objdatenVerfueg[0])); ?>"><? echo utf8_encode($objdatenVerfueg[1]); ?></option>
		<?
		}
		else
		{
		?>
		<option value="<? echo base64_encode(serialize($objdatenVerfueg[0])); ?>"><? echo utf8_encode($objdatenVerfueg[1]); ?></option>
		<?		
		}
	

	}
?>
</select>	
<br><br>
		<hr>
	<br>Bisherige Leihzeit:<br> <? echo timeCdZuDatumMitZeit($row[0]); ?> - <? echo timeCdZuDatumMitZeit($row[1]); ?><br>
	
	<div class="articleBody clear">

		
		<br>
		<label for="ZeitObjAbholen"><h4>Datum Beginn</h4></label>
		<input type="text" id="ZeitObjAbholen" name="ZeitObjAbholen"/><br><br>
		
		<label for="cku7Vap"><h4>Uhrzeit Beginn</h4></label>
		<div id="cku7Vap">
			<select name="nix" id="nix" style="width:143px;">
			<option selected="selected">...</option>
			<option>Bitte erst</option>
			<option>Datum auswählen</option>
			</select>
		</div><br><br><br>
		
		<label for="datumsObjAbgabe"><h4>Datum Ende</h4></label>
		<input type="text" id="datumsObjAbgabe" name="datumsObjAbgabe"/><br><br>
		
		<label for="vls7Hr"><h4>Uhrzeit Ende</h4></label>
		<div id="vls7Hr">
			<select name="nix2" id="nix2" style="width:143px;">
			<option selected="selected">...</option>
			<option>Bitte erst</option>
			<option>Datum auswählen</option>
			</select>
		</div>
		
<br><br>
	</div>
	





</div>
	</div>
	
<script>

			<?

			
			
			//wieviele tage kann ein user buchen?
			if ($_SESSION["User_Recht_Dauerleih"]=="1")
			{
			$ausleihtageVoraus=$_SESSION["SE_DauerleiheMaxStar"];
			}
			else
			{
			$ausleihtageVoraus=$_SESSION["SE_normaloMaxStartTa"];
			}

			//berechnung der nächsten deaktivierten wochentage
			//grundlage: $ausleihtageVoraus
			
$datumJetzt=date("U", mktime(12, 0, 0, date("n"), date("j"), date("Y")));

			//anfang berechnung und anzeige der zu deaktivierenden tage
			for ($i=1;$i<($ausleihtageVoraus+10);$i++)
				{
				
				$wochentag=getdate($datumJetzt);

					//wenn wochentag zu, dann wird dies im kalender markiert
					if ($_SESSION["SE_MoGeschlOderZeite"]=="0" && $wochentag[wday]=="1")
					{
					$GeschlossMariert[].=$datumJetzt;
					}

					if ($_SESSION["SE_DiGeschlOderZeite"]=="0" && $wochentag[wday]=="2")
					{
					$GeschlossMariert[].=$datumJetzt;
					}

					if ($_SESSION["SE_MiGeschlOderZeite"]=="0" && $wochentag[wday]=="3")
					{
					$GeschlossMariert[].=$datumJetzt;
					}

					if ($_SESSION["SE_DoGeschlOderZeite"]=="0" && $wochentag[wday]=="4")
					{
					$GeschlossMariert[].=$datumJetzt;
					}

					if ($_SESSION["SE_FrGeschlOderZeite"]=="0" && $wochentag[wday]=="5")
					{
					$GeschlossMariert[].=$datumJetzt;
					}

					if ($_SESSION["SE_SaGeschlOderZeite"]=="0" && $wochentag[wday]=="6")
					{
					$GeschlossMariert[].=$datumJetzt;
					}

					if ($_SESSION["SE_SoGeschlOderZeite"]=="0" && $wochentag[wday]=="0")
					{
					$GeschlossMariert[].=$datumJetzt;
					}
				
				//$jetzt->add(new DateInterval('P1D'));
				$datumJetzt=$datumJetzt+86400;
				}

				if (count($GeschlossMariert)>0)
				{
				echo 'var bookedDays = [';
				for ($i=0;$i<count($GeschlossMariert);$i++)
				{
				
				
				$date = DateTime::createFromFormat('U', $GeschlossMariert[$i]);
				echo '"'.$date->format('Y-n-j').'"';

					if (($i+1)==count($GeschlossMariert))
					{
					}
					else
					{
					echo ",";
					}
				
				}
				echo '];';

				}
				else
				{
				echo "var bookedDays = [];";
				}
			//var bookedDays = ["2011-5-1","2011-4-1"];
			//ende berechnung und anzeige der zu deaktivierenden tage
			
			?>

			function isAvailable(date){
			var dateAsString = date.getFullYear().toString() + "-" + (date.getMonth()+1).toString() + "-" + date.getDate();
			var result = $.inArray( dateAsString, bookedDays ) ==-1 ? [true] : [false];
			return result
			}

			$.datepicker.regional['de'] = {
				closeText: 'Fertig',
				prevText: '< vor',
				nextText: 'zurück >',
				currentText: 'Heute',
				monthNames: ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
				monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'],
				dayNames: ['Sonntag','Montag','Dientag','Mittwoch','Donnerstag','Freitag','Sonnabend'],
				dayNamesShort: ['Son','Mon','Die','Mit','Don','Fre','Sam'],
				dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
				dateFormat: 'dd.mm.yy',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};

			$.datepicker.setDefaults($.datepicker.regional['de']);

				$(function() {
					var dates = $( "#ZeitObjAbholen" ).datepicker({
						showButtonPanel: true,
						changeMonth: true,
						minDate: 0,
						maxDate: +<?echo $ausleihtageVoraus; ?>,
						numberOfMonths: 2,
						onClose: function(dateText, inst) { contentloader($('#ZeitObjAbholen').val()) },
						beforeShowDay: isAvailable,

					});
				});
				
				$(function() {
					var dates = $("#datumsObjAbgabe" ).datepicker({
						showButtonPanel: true,
						changeMonth: true,
						minDate: 0,
						maxDate: +<?echo $ausleihtageVoraus; ?>,
						numberOfMonths: 2,
						onClose: function(dateText, inst) { contentloader2($('#datumsObjAbgabe').val())},
						beforeShowDay: isAvailable,
					});
				});
				
				function contentloader(datumOr) {
				$('#zeitStart').val("-");
				$("#cku7Vap").load("../../_05_oeffnungszeiten.inc.php?id="+datumOr+"");
				}
				
				function contentloader2(datumOr) {
				$('#zeitEnde').val("-");				
				$("#vls7Hr").load("../../_05_oeffnungszeiten2.inc.php?id2="+datumOr+"");
				}

				$('#cku7Vap').change(function() {
				});

				$('#vls7Hr').change(function() {
				});


$( "#dialog-request" ).dialog({
			resizable: false,
			autoOpen: false,
			height:420,
			modal: true,
			buttons: {
				"Überprüfen": function() {
				//alert($('#ZeitObjAbholen').val());
				$("#ajaWKCon").load("10_timeChg-pruef.inc.php?oz1="+encodeURI($('#ZeitObjAbholen').val())+"&oz2="+encodeURI($('#zeitStart').val())+"&oz3="+encodeURI($('#datumsObjAbgabe').val())+"&oz4="+encodeURI($('#zeitEnde').val())+"&w="+encodeURI($('#obj').val())+"&z=<? echo $_GET['d']; ?>");

				},
				"Abbrechen": function() {
					$("#dialog-request").remove();
					$( this ).dialog( "close" );
				}
			}
		});

$("#dialog-request" ).dialog('open');

</script>
	
<?
}
?>