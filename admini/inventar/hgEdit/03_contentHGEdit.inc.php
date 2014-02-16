	<article id="articleLogin2"> 
	<h2>Hauptgruppen Bearbeitung</h2>
		
	<div class="line"></div>
	<div class="articleBody clear" >
	<a href="index.php" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right">Übersicht</a>


<table width="100%" class="clear">
	<tr>
	<td align="left" valign="top" width="50%"><span class="ui-icon ui-icon-person" title="Erstellt von" style="float:left;margin-right:2em;"></span><? echo utf8_encode(htmlspecialchars($HGDaten[5])) ?> </td>
	<td align="left" valign="top" width="50%"><span class="ui-icon ui-icon-clock" title="Erstellt am" style="float:left;margin-right:2em;"></span><? echo utf8_encode(htmlspecialchars(timeCdZuDatumMitZeit($HGDaten[4]))) ?></td>
	</tr>
	
	<tr height="10px"><td colspan="2"></td></tr>
	
	<tr>
	<td align="left" valign="top" width="50%"><span class="ui-icon ui-icon ui-icon-image" title="Bild" style="float:left;margin-right:2em;"></span>
	<?
	//bild anzeige wenn vorhanden
	if (is_file('../../../BL_MEDIA/PIC_HG/'.base64_encode(serialize($hgCode)).'.jpg'))
	{
	echo '<a href="../../../BL_MEDIA/PIC_HG/'.base64_encode(serialize($hgCode)).'.jpg" id="picPrev" target="_blank"><img src="../../../galPrev2.php?a='.base64_encode(serialize($hgCode)).'" style="border-width:0px;"></a>';
	echo ' <a href="#link" id="PICDel"><i>Bild löschen</i></a> <b>/</b> ';
	?>
	<a id='reqUp' href='#link'><i>ändern</i></a><br><br>
		<div id="hochladen" class="ui-helper-hidden">
		<form action="editHG.php" method="post" enctype="multipart/form-data">
		<input type="file" name="dateiFuerBild">
		<input type="submit" onmouseover="tooltip.pnotify_display();" onmousemove="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip.pnotify_remove();" class="fg-button fg-button ui-state-default ui-corner-all" value="Bild Hochladen">
		<input name="fnn_2" type="hidden" value="<? echo base64_encode(serialize($hgCode)); ?>" />
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
		<form action="editHG.php" method="post" enctype="multipart/form-data">
		<input type="file" name="dateiFuerBild">
		<input type="submit" onmouseover="tooltip.pnotify_display();" onmousemove="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip.pnotify_remove();" class="fg-button fg-button ui-state-default ui-corner-all" value="Bild Hochladen">
		<input name="fnn_2" type="hidden" value="<? echo base64_encode(serialize($hgCode)); ?>" />
		<input name="upPic" type="hidden" value="1" />
		</form>
		</div>
		<?
	}
	?>	
	</td>
	<td align="left" valign="top" width="50%"> <img src="../../../BL_BILDER/pdf.png" title="PDF Datei" style="float:left;margin-right:2em;">
	<?
	if (is_file('../../../BL_MEDIA/PDF_HG/'.base64_encode(serialize($hgCode)).'.pdf'))
	{
	?>
	<span id='fileAv'>PDF vorhanden. <a href='../../../BL_MEDIA/PDF_HG/<? echo base64_encode(serialize($hgCode)).".pdf";?>' target='_blank'><i>ansehen</i></a> <b>/</b></span>
	<a href="#link" id="pdfUp"><i>ändern</i></a> <b id="slashWeg">/</b> <a href="#link" id="pdfDes"><i>löschen</i></a>
	<br><br><div id="hochladenPDF" class="ui-helper-hidden">
	<form action="editHG.php" method="post" enctype="multipart/form-data">
	<input type="file" name="dateiFuerBildObj">
	<input type="submit" onmouseover="tooltip2.pnotify_display();" onmousemove="tooltip2.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip2.pnotify_remove();" class="fg-button fg-button ui-state-default ui-corner-all" value="PDF Hochladen">
	<input name="fnn_2" type="hidden" value="<? echo base64_encode(serialize($hgCode)); ?>" />
	<input name="up" type="hidden" value="1" />
	</form></div>
	<?
	}
	else
	{
	echo "<div id='fileAv'>Keine PDF vorhanden. <a href=\"#link\" id=\"pdfUp\"><i>hinzufügen</i></a></div><br>";
	?>
	<div id="hochladenPDF" class="ui-helper-hidden">
	<form action="editHG.php" method="post" enctype="multipart/form-data">
	<input type="file" name="dateiFuerBildObj">
	<input type="submit" onmouseover="tooltip2.pnotify_display();" onmousemove="tooltip2.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip2.pnotify_remove();" class="fg-button fg-button ui-state-default ui-corner-all" value="PDF Hochladen">
	<input name="fnn_2" type="hidden" value="<? echo base64_encode(serialize($hgCode)); ?>" />
	<input name="up" type="hidden" value="1" />
	</form></div>
	<?
	}
	?>
	</td>
	</tr>
	</table>
	
	<br><hr>
	
	<form id="newObj" autocomplete="off" method="post" action="editHG.php">
	<input name="fnn_2" type="hidden" value="<? echo base64_encode(serialize($hgCode)); ?>" />
	<table width="100%" style="margin-top:40px;">
	
	<tr>
	<td width="20%" align="left" valign="top">Objekt aktiv?</td>
	<td width="80%">
	<?
		//objekt ist nicht ausgeliehen und aktiviert
		if ($HGDaten[6]=="1")
		{
		echo '<p class="iphone-ui" id="iphoneP"><input checked="checked" id="newHG_cb" name="newHG_cb" type="checkbox" /></p>';
		}
		else
		{
		//objekt ist nicht ausgeliehen und nicht aktivert.
		echo '<p class="iphone-ui" id="iphoneP"><input id="newHG_cb" name="newHG_cb" type="checkbox" /></p>';
		}
	?>
	</td>
	</tr>		

	<tr height="18px"><td colspan="2"></td></tr>

	<tr>
	<td width="20%" align="left" valign="top">Kurzbezeichnung</td>
	<td width="80%"><input name="newHG_kurz" maxlength="50" class="inputObjHg" type="text" value="<? echo utf8_encode(htmlspecialchars($HGDaten[2])); ?>" title="Diese Bezeichnung wird auf Ausleihscheinen stehen sowie in der Verwaltung.">
	</td>
	</tr>
	
	<tr>
	<td width="20%" align="left" valign="top">Lange Beschreibung</td>
	<td width="80%">
	<textarea name="newHG_lang" class="input_longObjHg" cols="50" rows="10" ><? echo utf8_encode(htmlspecialchars($HGDaten[3])); ?></textarea>
	</td>
	</tr>		
	
	<tr height="18px"><td colspan="2"><input name="djnzG4" type="hidden" value="<? echo base64_encode(serialize($hgCode)); ?>" /></td></tr>

	<tr>
	<td width="20%" align="left" valign="top"></td>
	<td width="80%">
	<input aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all" value="Hauptgruppen-Bearbeitung abschliessen" type="submit">
	</td>
	</tr>	
	
	</table>
	</form>
	
	
	
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