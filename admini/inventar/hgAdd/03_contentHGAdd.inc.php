	
	<article id="articleLogin2"> 
	<h2>Hauptgruppen Erstellung</h2>
		
	<div class="line"></div>
	<div class="articleBody clear" >
	
<form enctype="multipart/form-data" id="newObj" autocomplete="off" method="post" action="index.php">
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
	
	<br><hr>
	
	<table width="100%" style="margin-top:40px;">
	
	<tr>
	<td width="20%" align="left" valign="top">Objekt aktiv?</td>
	<td width="80%">
	<p class="iphone-ui" id="iphoneP"><input checked="checked" id="newHG_cb" name="newHG_cb" type="checkbox" /></p>
	</td>
	</tr>		

	<tr height="18px"><td colspan="2"></td></tr>

	<tr>
	<td width="20%" align="left" valign="top">Kurzbezeichnung</td>
	<td width="80%"><input name="newHG_kurz" maxlength="50" class="inputObjHg" type="text">
	</td>
	</tr>
	
	<tr>
	<td width="20%" align="left" valign="top">Lange Beschreibung</td>
	<td width="80%">
	<textarea name="newHG_lang" class="input_longObjHg" cols="50" rows="10" ></textarea>
	</td>
	</tr>		
	
	<tr height="18px"><td colspan="2"></td></tr>

	<tr>
	<td width="20%" align="left" valign="top"></td>
	<td width="80%">
	<input aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all" value="Hauptgruppe anlegen" type="submit">
	</td>
	</tr>	
	
	</table>
	</form>
	
	
	
<div id="dialog-message" title="Hauptgruppe anlegen" class="ui-helper-hidden">
	<p>
		<span class="ui-icon ui-icon-flag" style="float:left; margin:0 7px 50px 0;"></span>
		Einen Moment noch bitte ...
	</p>
</div>

</div>
</article>