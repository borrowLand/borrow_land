		<article id="articleLogin2"> 
		<div style="display:inline-block;"><h2>Objekt Bearbeitung</h2>  o-<? echo $obCode; ?></div>
		<div class="line"></div>
		
		<div class="articleBody clear" >

		<?
		if ($_SESSION["SE_RFIDModule"]=="1")
		{
		echo '<a href="../../adminLeihe/rfid/" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right">RFID-Modus</a>';
		}
		?>		
		<a href="../../adminLeihe/barcode/" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right">Barcode-Modus</a>
		<a href="index.php" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right">Übersicht</a>
		

<table width="100%" class="clear">
		<tr>
		<td align="left" valign="top" width="50%"><span class="ui-icon ui-icon-person" title="Erstellt von" style="float:left;margin-right:2em;"></span><? echo utf8_encode(htmlspecialchars($objDaten[5])) ?> </td>
	    <td align="left" valign="top" width="50%"><span class="ui-icon ui-icon-clock" title="Erstellt am" style="float:left;margin-right:2em;"></span><? echo utf8_encode(htmlspecialchars(timeCdZuDatumMitZeit($objDaten[4]))) ?></td>
		</tr>
		
		<tr height="10px"><td colspan="2"></td></tr>
		
		<tr>
        <td align="left" valign="top" width="50%"><span class="ui-icon ui-icon ui-icon-image" title="Bild" style="float:left;margin-right:2em;"></span>
		<?
		//bild anzeige wenn vorhanden
		if (is_file('../../../BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($obCode)).'.jpg'))
		{
		echo '<a href="../../../BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($obCode)).'.jpg" id="picPrev" target="_blank"><img src="../../../galPrev3.php?a='.base64_encode(serialize($obCode)).'" style="border-width:0px;"></a>';
		echo ' <a href="#link" id="PICDel"><i>Bild löschen</i></a> <b>/</b> ';
		?>
		<a id='reqUp' href='#link'><i>ändern</i></a><br><br>
			<div id="hochladen" class="ui-helper-hidden">
			<form action="edit.php" method="post" enctype="multipart/form-data">
			<input type="file" name="dateiFuerBild">
			<input type="submit" onmouseover="tooltip.pnotify_display();" onmousemove="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip.pnotify_remove();" class="fg-button fg-button ui-state-default ui-corner-all" value="Bild Hochladen">
			<input name="djnzG4" type="hidden" value="<? echo base64_encode(serialize($obCode)); ?>" />
			<input name="upPic" type="hidden" value="1" />
			</form>
			</div>
		<?
		}
		else
		{
			?>
			Kein Bild vorhanden <a id='reqUp' href='#link'><i>hinzufügen</i></a><br><br>
			<div id="hochladen" class="ui-helper-hidden">
			<form action="edit.php" method="post" enctype="multipart/form-data">
			<input type="file" name="dateiFuerBild">
			<input type="submit" onmouseover="tooltip.pnotify_display();" onmousemove="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip.pnotify_remove();" class="fg-button fg-button ui-state-default ui-corner-all" value="Bild Hochladen">
			<input name="djnzG4" type="hidden" value="<? echo base64_encode(serialize($obCode)); ?>" />
			<input name="upPic" type="hidden" value="1" />
			</form>
			</div>
			<?
		}
		?>	
		</td>
        <td align="left" valign="top" width="50%"> <img src="../../../BL_BILDER/pdf.png" title="PDF Datei" style="float:left;margin-right:2em;">
		<?
		if (is_file('../../../BL_MEDIA/PDF_OBJ/'.base64_encode(serialize($obCode)).'.pdf'))
		{
		?>
		<span id='fileAv'>PDF vorhanden. <a href='../../../BL_MEDIA/PDF_OBJ/<? echo base64_encode(serialize($obCode)).".pdf";?>' target='_blank'><i>ansehen</i></a> <b>/</b></span>
		<a href="#link" id="pdfUp"><i>ändern</i></a> <b id="slashWeg">/</b> <a href="#link" id="pdfDes"><i>löschen</i></a>
		<br><br><div id="hochladenPDF" class="ui-helper-hidden">
		<form action="edit.php" method="post" enctype="multipart/form-data">
		<input type="file" name="dateiFuerBildObj">
		<input type="submit" onmouseover="tooltip2.pnotify_display();" onmousemove="tooltip2.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip2.pnotify_remove();" class="fg-button fg-button ui-state-default ui-corner-all" value="PDF Hochladen">
		<input name="djnzG4" type="hidden" value="<? echo base64_encode(serialize($obCode)); ?>" />
		<input name="up" type="hidden" value="1" />
		</form></div>
		<?
		}
		else
		{
		echo "<div id='fileAv'>Keine PDF vorhanden. <a href=\"#link\" id=\"pdfUp\"><i>hinzufügen</i></a></div><br>";
		?>
		<div id="hochladenPDF" class="ui-helper-hidden">
		<form action="edit.php" method="post" enctype="multipart/form-data">
		<input type="file" name="dateiFuerBildObj">
		<input type="submit" onmouseover="tooltip2.pnotify_display();" onmousemove="tooltip2.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip2.pnotify_remove();" class="fg-button fg-button ui-state-default ui-corner-all" value="PDF Hochladen">
		<input name="djnzG4" type="hidden" value="<? echo base64_encode(serialize($obCode)); ?>" />
		<input name="up" type="hidden" value="1" />
		</form></div>
		<?
		}
		?>
		</td>
		</tr>
		</table>

		<br><hr>
		<form id="newObj" autocomplete="off" method="post" action="edit.php">
		<table width="100%" style="margin-top:40px;">
		
		<tr>
		<td width="20%" align="left" valign="top">Objekt aktiv?</td>
	    <td width="80%">
		<?
		//suche nach aktivierten objekten, die möglicherweise ausgeliehen worden sind
		$sql = "SELECT wkid FROM `06_wkObje` WHERE `geraet` = \"".$obCode."\" "; 
		$objImVerleih = mysql_query($sql);
		$Zeilen = mysql_num_rows($objImVerleih); 
		

		
		if ($Zeilen=="0")
		{
			//objekt ist nicht ausgeliehen und aktiviert
			if ($objDaten[7]=="1")
			{
			echo '<p class="iphone-ui" id="iphoneP"><input checked="checked" id="newObj_cb" name="newObj_cb" type="checkbox" /></p>';
			}
			else
			{
			//objekt ist nicht ausgeliehen und nicht aktivert.
			echo '<p class="iphone-ui" id="iphoneP"><input id="newObj_cb" name="newObj_cb" type="checkbox" /></p>';
			}
		}
		else
		{
			//objekt ist ausgeliehen und aktiviert
			if ($objDaten[7]=="1")
			{
			echo 'Das Objekt ist derzeit aktiviert und '.$Zeilen.'x bei Ausleiheanfragen eingetragen worden. Eine Statusänderung ist erst nach Rücknahme aus den Anfragen möglich. <input name="newObj_cb" type="hidden" value="on" /> ';
			$d=1;
				while ($row = mysql_fetch_array($objImVerleih, MYSQL_NUM)) {
					$hgNeu=base64_encode(serialize($row[0]));
					printf("<a href=\"../../adminLeihe/wkEdit.php?wk=".$hgNeu."\" target=\"blank\">Anfrage <b>".$d."</b></a> ", $row[0]);
					$d++;
				}
			}
			else
			{
			//objekt ist ausgeliehen und nicht aktivert.
			echo 'Fehler 81 Es ist ein Fehler aufgetreten.';
			}		
		
		}
		?>
		</td>
		</tr>		
	
		<tr height="18px"><td colspan="2"></td></tr>
	
		<tr>
		<td width="20%" align="left" valign="top">Hauptgruppe </td>
	    <td width="80%"><select class="auswahlObjHg" name="hauptgruppen_input" id="hauptgruppen_input">
		<option value="0">- bitte Hauptgruppe auswählen-</option>
		<?
		//hauptgruppen
		$sql = 'SELECT Kurzbez,specid_hg FROM `03_obj_hauptgruppen` ORDER BY `ErstelltAm` DESC'; 
		$hgs = mysql_query($sql);
		while ($hgsDaten = mysql_fetch_array($hgs, MYSQL_NUM))
		{
			if ($hgsDaten[1]==hgNameAusGeraet(mysql_real_escape_string($obCode)))
			{
			echo '<option value="'.base64_encode(serialize($hgsDaten[1])).'" selected="selected">'.utf8_encode(htmlspecialchars($hgsDaten[0])).'</option>';
			}
			else
			{
			echo '<option value="'.base64_encode(serialize($hgsDaten[1])).'">'.utf8_encode(htmlspecialchars($hgsDaten[0])).'</option>';
			}
		}
		?>
		</select></td>
		</tr>
		
		<tr>
		<td width="20%" align="left" valign="top">Kurzbezeichnung </td>
	    <td width="80%"><input name="newObj_kurz" maxlength="50" class="inputObjHg" type="text" value="<? echo utf8_encode(htmlspecialchars($objDaten[2])); ?>" title="Diese Bezeichnung wird auf Ausleihscheinen stehen sowie in der Verwaltung.">
		</td>
		</tr>
		
		<tr>
		<td width="20%" align="left" valign="top">Lange Beschreibung</td>
	    <td width="80%">
		<textarea name="newObj_lang" class="input_longObjHg" cols="50" rows="10" ><? echo utf8_encode(htmlspecialchars($objDaten[3])); ?></textarea>
		</td>
		</tr>		
		
		<?
		if ($_SESSION["SE_MoneyModule"]=="1")
		{
		?>		
		<tr>
		<td width="20%" align="left" valign="top">Wiederbeschaffungswert in €</td>
	    <td width="80%">
		<input name="wiederbeschaff_input" id="wiederbeschaff_input" maxlength="20" class="inputObjHg" type="text" value="<? echo utf8_encode(htmlspecialchars($objDaten[13])); ?>" title="Dieser Wert wird später auf dem Ausleihschein stehen.">
		</td>
		</tr>	

		<tr>
		<td width="20%" align="left" valign="top">Mietpreise in €</td>
	    <td width="80%">
		
			<?
			if ($_SESSION["SE_MoneyModule_Mietp"]=="1")
			{
				$minuten=round(60/$_SESSION["SE_IntervStunde"]);

				if ($objDaten[11]=="0")
				{
				echo '<input checked="checked" type="radio" name="Mietpreis[]" value="0"> keine Angabe/erfolgt später<br>';
				}
				else
				{
				echo '<input type="radio" name="Mietpreis[]" value="0"> keine Angabe/erfolgt später<br>';
				}
				
				if ($objDaten[11]=="1" || $objDaten[11]=="2")
				{
				echo '<input checked="checked" type="radio" name="Mietpreis[]" value="1"> Mietpreis Angabe pro Mindest-Mietzeit<br>';
				}
				else
				{
				echo '<input type="radio" name="Mietpreis[]" value="1"> Mietpreis Angabe pro Mindest-Mietzeit<br>';
				}		
				
				if ($objDaten[11]=="3")
				{
				echo '<input checked="checked" type="radio" name="Mietpreis[]" value="3"> Es erfolgt eine individuelle Berechnung (z.B. bei Betriebsstunden)<br>';
				}
				else
				{
				echo '<input type="radio" name="Mietpreis[]" value="3"> Es erfolgt eine individuelle Berechnung (z.B. bei Betriebsstunden)<br>';
				}		
				?>
				<br><br>
				<div id="mietpreise" class="ui-helper-hidden">
				<h4>Miepreis pro Mindest-Mietzeit (derzeit <? echo $minuten; ?> Minuten); Komma: .</h4>
				<input value="<? echo utf8_encode(htmlspecialchars($objDaten[8])); ?>" name="mietpr_1" id="mietpr_1" maxlength="20" class="inputObjHg" type="text" title="Mithilfe dieser Angabe wird auf dem Ausleihscheinen automatisch der Mietpreis berechnet.">
				<br><br>
				<h4>Miepreis ab 24h (z.B. um Vergünstigungen anzubieten); Komma: .</h4>
				<input value="<? echo utf8_encode(htmlspecialchars($objDaten[9])); ?>" name="mietpr_2" id="mietpr_2" maxlength="20" class="inputObjHg" type="text" title="Mithilfe dieser Angabe wird auf dem Ausleihscheinen automatisch der Mietpreis berechnet.">
				<br><br></div>
				<?
			}
			else
			{
			echo "Sie haben in den Einstellungen die Verwendung von Mietpreise deaktivert.";
			}
			?>
		</td>
		</tr>	
		<?
		}
		?>
		
		<tr>
		<td width="20%" align="left" valign="top">Schlagwörter <br>(auch tags genannt)</td>
	    <td width="80%">
		<input name="tags" id="tags" value="<? echo utf8_encode(htmlspecialchars($objDaten[14])); ?>" /> 
		</td>
		</tr>
		
		<tr height="18px"><td colspan="2"><input name="djnzG4" type="hidden" value="<? echo base64_encode(serialize($obCode)); ?>" /></td></tr>
		
		<tr>
		<td width="20%" align="left" valign="top">Bildvorschau Startseite</td>
	    <td width="80%">
		<? 
		if ($objDaten[12]=="1")
		{
		echo '<p class="iphone-ui" id="iphoneP"><input checked="checked" name="newObj_preview" id="newObj_preview" type="checkbox" /></p>';
		}
		else
		{
		echo '<p class="iphone-ui" id="iphoneP"><input name="newObj_preview" id="newObj_preview" type="checkbox" /></p>';
		}
		?>  
		</td>
		</tr>	

		<tr>
		<td width="20%" align="left" valign="top"></td>
	    <td width="80%">
		<input aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all" value="Objektbearbeitung abschliessen" type="submit">
		</td>
		</tr>	
		
		</table>
		</form>
		</article>

<?
/*
		<article id="objeStat"> 
		<h2>Derzeitige Objekt Auslastung</h2>
			
		<div class="line"></div>
		<div class="articleBody clear" >
		TXT
		</div>		
		
		
		</article>	
*/
?>		
		
<div id="dialog-message" title="Bild Hochladen" class="ui-helper-hidden">
	<p>
		<span class="ui-icon ui-icon-flag" style="float:left; margin:0 7px 50px 0;"></span>
		Einen Moment noch bitte ...
	</p>
</div>	
<div id="dialog-message2" title="PDF Hochladen" class="ui-helper-hidden">
	<p>
		<span class="ui-icon ui-icon-flag" style="float:left; margin:0 7px 50px 0;"></span>
		Einen Moment noch bitte ...
	</p>
</div>	