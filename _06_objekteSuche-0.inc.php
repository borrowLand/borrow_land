<?
session_start();

//Funktionen 
/////////////////////////////////////////////
$includeName="_00_basic_func.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="_01_basic_db.inc.php";
if (file_exists($includeName))
{
	require($includeName);
}	
else
{
	echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
	exit();
}

/////////////////////////////////////////////


if (isset($_SESSION["User_ID"]))
{
$datum1=$_GET['oz1'];
$datum2=$_GET['oz2'];
$datum3=$_GET['oz3'];
$datum4=$_GET['oz4'];

$datumcheck1=explode(".", $datum1);
$datumcheck2=explode(".", $datum3);


	if ($datum1!="" && $datum2!="-" && $datum2!="undefined" && $datum3!="" && $datum4!="-" && $datum4!="undefined" && checkdate($datumcheck1[1],$datumcheck1[0],$datumcheck1[2])=="1" && checkdate($datumcheck2[1],$datumcheck2[0],$datumcheck2[2])=="1" && isset($_SESSION["User_ID"]))
	{
		$DatumBeginn = DateTime::createFromFormat('d.m.Y G.i', $datum1." ".$datum2);
		$DatumBeginn=$DatumBeginn->format('U');

		$DatumEnde = DateTime::createFromFormat('d.m.Y G.i', $datum3." ".$datum4);
		$DatumEnde=$DatumEnde->format('U');

		if ($_SESSION["User_Recht_Dauerleih"]=="1")
		{
			$maxDiffAusleiheTage=$_SESSION["SE_DauerleiheMaxDaue"];
		}
		else
		{
			$maxDiffAusleiheTage=$_SESSION["SE_normaloMaxDauerTa"];
		}

		$diffLeihe=$DatumEnde-$DatumBeginn;
		$diffTage=floor($diffLeihe/86400);

		//anfang diff beginn/ende leihe
		if ($DatumBeginn > $DatumEnde)
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Hinweis zu den Datumsangaben',
			pnotify_text: 'Ist der Abgabezeitpunkt und der Ausgabezeitpunkt vertauscht?',
			pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
			});
			$("#ZeitObjAbholen").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			$("#datumsObjAbgabe").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			</script>
			<?
			
			$fehlerDarstellungObjekte=1;
		}
		else
		{
			$mindestMietzeit=round(60/$_SESSION["SE_IntervStunde"])*60;
			
			//anfang mindest leihe, nur wenn daten nicht vertauscht wurden
			if ($diffLeihe<($mindestMietzeit))
			{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Ausleihezeit',
				pnotify_text: 'Bitte beachten Sie die Mindest-Ausleihefrist von <?echo $mindestMietzeit/60; ?> Minuten.',
				pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
				});
				$("#ZeitObjAbholen").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
				$("#datumsObjAbgabe").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
				</script>
				<?
				$fehlerDarstellungObjekte=1;
				
			}
			//ende mind. leihe
		}
		//ende diff beginn/ende leihe

		//anfang zeiträume gleich
		if ($DatumBeginn == $DatumEnde)
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Hinweis zu den Datumsangaben',
			pnotify_text: 'Der Zeitpunkt des Beginns und dem Ende der Leihe ist gleich.',
			pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
			});
			$("#ZeitObjAbholen").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			$("#datumsObjAbgabe").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			</script>
			<?
			
			$fehlerDarstellungObjekte=1;
		}
		//ende zeiträume gleich
		
		//anfang auswahl startzeit schon abgelaufen? 
		if (time() > $DatumBeginn)
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Hinweis zu den Datumsangaben',
			pnotify_text: 'Der Startzeitpunkt der Leihe ist bereits abgelaufen.',
			pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
			});
			$("#ZeitObjAbholen").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			$("#zeitStart").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			
			</script>
			<?
			
			$fehlerDarstellungObjekte=1;
		}
		//ende auswahl zeit schon abgelaufen?
		
		//anfang auswahl endzeit schon abgelaufen? 
		if (time() > $DatumEnde)
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Hinweis zu den Datumsangaben',
			pnotify_text: 'Der Endzeitpunkt der Leihe ist bereits abgelaufen.',
			pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
			});
			$("#datumsObjAbgabe").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			$("#zeitEnde").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			</script>
			<?
			
			$fehlerDarstellungObjekte=1;
		}
		//ende auswahl zeit schon abgelaufen?
		
		//anfang datum ist keine zahl
		if (!is_numeric($DatumBeginn) || !is_numeric($DatumEnde))
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Eingabefehler ',
			pnotify_text: 'Bitte geben Sie nochmals Ihre Ausleihezeiten ein.',
			pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
			});
			$("#ZeitObjAbholen").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			$("#datumsObjAbgabe").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			</script>
			<?
			
			$fehlerDarstellungObjekte=1;
		}
		//ende datum ist keine zahl
		
		

		//anfang max tage leihe
		if ($diffTage>$maxDiffAusleiheTage)
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Maximale Leihtage',
			pnotify_text: 'Zwischen Ausleihe und Abgabe können max. <b><?echo $maxDiffAusleiheTage; ?></b> Tage sein. Sie haben einen Zeitraum von <b><?echo $diffTage; ?></b> Tagen ausgewählt.',
			pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
			});
			$("#ZeitObjAbholen").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			$("#datumsObjAbgabe").animate({ backgroundColor: "#FF0000" }, 800).animate({ backgroundColor: "#FFFFFF" }, 800);
			</script>
			<?
			$fehlerDarstellungObjekte=1;
			
		}
		//ende max tage leihe

		//anfang warenjorb-elemente
		if (count($_SESSION["User_WK"])>=$_SESSION["SE_AnzahlElemWKMax"])
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Warenkorb-Hinweis',
			pnotify_text: 'Die maximale Anzahl an Elementen (<? echo $_SESSION["SE_AnzahlElemWKMax"]; ?>) pro Warenkorb wurde überschritten.',
			pnotify_type: 'error'
			});
			</script>
			<?
			$fehlerDarstellungObjekte=1;
			
		}
		//ende warenkorb-elemente

		//keine fehler, weiterleitung an alle drei module, wenn geladen.
		if ($fehlerDarstellungObjekte!="1")
		{

		/*die darstellung in den drei suchmöglichkeiten kann beginnen
		es folgt ein abgleich mit dem warenkorb und den derzeit möglichen ausleihobjekten
		am ende wird ein array produziert, welches als session zur verfügung steht und
		alle hauptgruppen mit einzelobjekten aufführt.
		filter: 
		1. alle objekte die aktiv geschaltet worden sind
		2. blacklist I: warenkorb objekte mit zeitstempel anfrage und warenkorb vergleichen
		3. blacklist II: nur objekte anzeigen, die noch nicht verliehen worden sind in dem angefragten zeitraum
		*/
		
		objekteDieZurVerfuegungStehen($DatumBeginn,$DatumEnde);
		
		if ($_SESSION["aktuelleObjekte"] && isset($_SESSION["aktuelleObjekte"]) && count($_SESSION["aktuelleObjekte"])>=1)
		{
		$_SESSION["aktuelleZeitStart"]=$DatumBeginn;
		$_SESSION["aktuelleZeitEnde"]=$DatumEnde;
		
			?>
			<script>
			$("#datumNachLoad").html("<? echo $datum1." ".$datum2." - ".$datum3." ".$datum4. " <a href='#link' id='anzeigeZeit'><font face='verdana' size='2'>ändern</font></span></a>"; ?>");		
			$("#articleleihe1").slideToggle("slow");
			$("#articleleihe2").slideToggle("slow");
			$("#anzeigeZeit").click(function () {
				$('#articleleihe1').slideToggle("slow");
				$('#articleleihe2').slideToggle("slow");
			});
			$("#anzeigeZeit2").click(function () {
				$('#articleleihe1').slideToggle("slow");
				$('#articleleihe2').slideToggle("slow");
			});
			</script>
			<?

				if (isset($_SESSION["aktuelleObjekte"]))
				{
					if ($_SESSION["SE_ViewLeihmodHauptg"]=="1")
					{
					?>
					<script>
					$("#ladeHauptGr").load("_06_objekteSuche-1.inc.php?oz1="+$('#ZeitObjAbholen').val()+"&oz2="+$('#zeitStart').val()+"&oz3="+$('#datumsObjAbgabe').val()+"&oz4="+$('#zeitEnde').val());
					</script>
					<?
					}

					if ($_SESSION["SE_ViewLeihmodEinzel"]=="1")
					{
					
					?>
					<script>			
					$("#ladeEinzelObj").load("_06_objekteSuche-2.inc.php?oz1="+$('#ZeitObjAbholen').val()+"&oz2="+$('#zeitStart').val()+"&oz3="+$('#datumsObjAbgabe').val()+"&oz4="+$('#zeitEnde').val());
					</script>
					<?
					}

					if ($_SESSION["SE_ViewLeihmodTag"]=="1")
					{
					?>
					<script>					
					$("#ladeTags").load("_06_objekteSuche-3.inc.php?oz1="+$('#ZeitObjAbholen').val()+"&oz2="+$('#zeitStart').val()+"&oz3="+$('#datumsObjAbgabe').val()+"&oz4="+$('#zeitEnde').val());
					</script>
					<?
					}

				}
			}
		}
	}
}


?>