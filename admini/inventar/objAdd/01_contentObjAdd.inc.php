<article id="articleLogin2"> 
<h2>neues Objekt</h2> 
<div class="line"></div>
<div class="articleBody clear" >
	
<form id="newObj" autocomplete="off" method="post" enctype="multipart/form-data" action="index.php">

<table width="100%" class="clear">

<tr>

<td align="left" valign="top" width="50%"><span class="ui-icon ui-icon ui-icon-image" title="Bild" style="float:left;margin-right:2em;"></span>
<a id="reqUp" href="#link"><i onmouseover="tooltip.pnotify_display();" onmousemove="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip.pnotify_remove();">Bild hinzufügen</i></a><br><br>
<div id="hochladen" class="ui-helper-hidden">
<input type="file" name="dateien[]">
</div>
</td>

<td align="left" valign="top" width="50%"> <img src="../../../BL_BILDER/pdf.png" title="PDF Datei" style="float:left;margin-right:2em;">
<a href="#link" id="pdfUp"><i onmouseover="tooltip2.pnotify_display();" onmousemove="tooltip2.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip2.pnotify_remove();">PDF hinzufügen</i></a><br><br>
<div id="hochladenPDF" class="ui-helper-hidden">
<input type="file" name="dateien[]">
</div>
</td>

</tr>
</table>


<table width="100%">
	
	<tr>
	<td width="20%" align="left" valign="top">Hauptgruppe * </td>
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
	<td width="20%" align="left" valign="top">Kurzbezeichnung *</td>
	<td width="80%"><input name="newObj_kurz" maxlength="50" class="inputObjHg" type="text" value="<? echo utf8_encode(htmlspecialchars($objDaten[2])); ?>" title="Diese Bezeichnung wird auf Ausleihscheinen stehen sowie in der Verwaltung.">
	</td>
	</tr>
	
	<tr>
	<td width="20%" align="left" valign="top">Lange Beschreibung *</td>
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
	<input name="tags" id="tags"/> 
	</td>
	</tr>
	
	<tr height="18px"><td colspan="2"></td></tr>
	
	<tr>
	<td width="20%" align="left" valign="top">Bildvorschau Startseite</td>
	<td width="80%"><p class="iphone-ui" id="iphoneP"><input checked="checked" name="newObj_preview" id="newObj_preview" type="checkbox" /></p>
	</td>
	</tr>	

	<tr>
	<td width="20%" align="left" valign="top">Sofortige Aktivierung?</td>
	<td width="80%"><p class="iphone-ui" id="iphoneP"><input checked="checked" name="newObj_cb" id="newObj_cb" type="checkbox" /></p>
	</td>
	</tr>		
	
	<tr>
	<td width="20%"></td>
	<td width="80%"><input aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all" value="Neues Objekt anlegen" type="submit">
	</td>
	</tr>		
	
	
	
	
	
	
</table>
<br><br><br>
* Diese Felder sind notwendig für ein neues Objekt

	

</form>	
</div>
</article>
<?

$sql = 'SELECT Kurzbez FROM `04_obj_objekte` ORDER BY `id` DESC LIMIT 1 ';
$hgs = mysql_query($sql);
$row = mysql_fetch_row($hgs);
?>
<article id="Dupli"> 
<h2>Letztes erzeugtes Objekt (<? echo utf8_encode(htmlspecialchars($row[0])); ?>) duplizieren</h2>
<div class="line"></div>

<div class="articleBody clear" >
<form id="erzeugDupl" autocomplete="off" method="post" action="index.php"><br>
	<table width="100%">
		<tr>
		<td width="20%" align="left" valign="top">Anzahl der Kopien</td>
		<td width="80%"><input name="Dupl_anzahl" id="Dupl_anzahl" maxlength="3" class="inputObjHg" type="text" title="Bitte geben Sie die Anzahl an, wie oft das letzte Objekt kopiert werden soll.">
		</td>
		</tr>

		<tr height="18px"><td colspan="2"></td></tr>
		
		<tr>
		<td width="20%" align="left" valign="top">Bild Datei auch kopieren</td>
		<td width="80%"><p class="iphone-ui" id="iphoneP"><input checked="checked" name="Dupl_pic" id="Dupl_pic" type="checkbox" /></p>
		</td>
		</tr>	
		
		<tr>
		<td width="20%" align="left" valign="top">PDF Datei auch kopieren</td>
		<td width="80%"><p class="iphone-ui" id="iphoneP"><input checked="checked" name="Dupl_pdf" id="Dupl_pdf" type="checkbox" /></p>
		</td>
		</tr>		

		<tr>
		<td width="20%" ></td>
		<td width="80%"><input aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all" value="Duplizieren" type="submit">
		</td>
		</tr>	
		
	</table>
	<input name="d" type="hidden" value="mnbhz74SQ" />
	</form>
</div>		

</article>	


<div id="dialog-message" title="Duplizieren ist in Arbeit" class="ui-helper-hidden">
	<p>
		<span class="ui-icon ui-icon-flag" style="float:left; margin:0 7px 50px 0;"></span>
		Einen Moment noch bitte ...
	</p>
</div>
<div id="dialog-message2" title="Neues Objekt wird erstellt." class="ui-helper-hidden">
	<p>
		<span class="ui-icon ui-icon-flag" style="float:left; margin:0 7px 50px 0;"></span>
		Einen Moment noch bitte ...
	</p>
</div>