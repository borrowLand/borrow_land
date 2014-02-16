<?
if (isset($_SESSION["User_ID"]))
{

if ($_SESSION["User_Dat_RegBestaet"]=="0")
{
?>
	<!-- Article articleLogin1 start -->
	<? //<div class="line"></div>  <!-- Dividing line --> ?>
	<article id="articleLogin1"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
	<h2>Benutzerinformation</h2>
	<div class="line"></div>
	<div class="articleBody clear">
	<p>Ihr Profil wurde noch nicht zur Nutzung freigegeben. <br>Sie können <a href="mailto:<?echo $_SESSION['SE_adminEMail'];?>"><b>hier</b></a> (<?echo $_SESSION['SE_adminEMail'];?>) eine Nachricht an die Verwaltung der Leihe schreiben. </p>
	</div>
	</article>
	<!-- Article articleLogin1 end -->
<?
}

//bestätigung okay & ausleihestatus gesetzt => include für ausleihe laden
if ($_SESSION["User_Dat_RegBestaet"]!="0" && $_SESSION["User_Recht_Ausleihe"]=="1")
{
			?>
			<article id="articleleihe1"> 
			<h2>1. Ausleihe-Zeitraum </h2>
			<h4>Bitte füllen Sie die Abhol- und Rückgabezeiten aus um mit der Auswahl der Mietobjekte fortzufahren. <br>
			Die möglichen Ausleihzeiten richten sich nach den festgelegten Öffnungszeiten.</h4>
			<div class="line"></div>
	<div class="articleBody clear">

		
		<div class="ui-widget-content ui-corner-all" style="width:200px; height: 150px; margin:10px; padding-left: 40px; float:left">
		<br>
		<label for="ZeitObjAbholen"><h4>Datum Beginn</h4></label>
		<input style="width:143px;" type="text" id="ZeitObjAbholen" name="ZeitObjAbholen"/><br><br><br>

		<label for="datumsObjAbgabe"><h4>Datum Ende</h4></label>
		<input style="width:143px;" type="text" id="datumsObjAbgabe" name="datumsObjAbgabe"/>
		<br><br>
		</div>

		<div class="ui-widget-content ui-corner-all" style="width:200px; height: 150px; margin:10px; padding-left: 40px; float:right">
		<br>
		<label for="cku7Vap"><h4>Uhrzeit Beginn</h4></label>
		<div id="cku7Vap">
			<select name="nix" id="nix" style="width:143px;">
			<option selected="selected">...</option>
			<option>Bitte erst</option>
			<option>Datum auswählen</option>
			</select>
		</div>
		<br><br>

		<label for="vls7Hr"><h4>Uhrzeit Ende</h4></label>
		<div id="vls7Hr">
			<select name="nix2" id="nix2" style="width:143px;">
			<option selected="selected">...</option>
			<option>Bitte erst</option>
			<option>Datum auswählen</option>
			</select>
		</div><br><br>
		</div>		
	</div>
			</article>
	<?
	if ($_SESSION["SE_ViewLeihmodHauptg"]=="1" || $_SESSION["SE_ViewLeihmodEinzel"]=="1" || $_SESSION["SE_ViewLeihmodTag"]=="1")
	{
	?>

	<?
	/*
	<div id="anzeigeZeit" class="ui-helper-hidden" style="cursor:pointer; width:300px">
	<br><br><h4>Abhol - oder Abgabedatum ändern</h4><br><br>
	</div>
	*/
	?>
	<article id="articleleihe2" class="ui-helper-hidden"> 
	<h2>2. Ausleihobjekte <div style="display:inline;" id="datumNachLoad"></div></h2>
	<div class="line"></div>
		<div class="articleBody clear">

				
			<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="tabs" >
				<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
					
					<?
					if ($_SESSION["SE_ViewLeihmodHauptg"]=="1")
					{
						?>
						<li class="ui-state-default ui-corner-top" id="tab_hg"><a href="#ladeHauptGr">Hauptgruppen</a></li>
						<?
					}
					?>
					
					<?
					if ($_SESSION["SE_ViewLeihmodEinzel"]=="1")
					{
						?>
						<li class="ui-state-default ui-corner-top" id="tab_eo"><a href="#ladeEinzelObj">Einzelobjekte</a></li>
						<?
					}
					?>
					
					<?
					if ($_SESSION["SE_ViewLeihmodTag"]=="1")
					{
						?>
						<li class="ui-state-default ui-corner-top" id="tab_tag"><a href="#ladeTags">Schlagwörter (tag) Suche</a></li>
						<?
					}
					?>					

				
				</ul>
				
					<?
					if ($_SESSION["SE_ViewLeihmodHauptg"]=="1")
					{
						?>
						<div class="ui-tabs-panel ui-widget-content ui-corner-bottom" id="ladeHauptGr"></div>
						<?
					}
					?>
					
					<?
					if ($_SESSION["SE_ViewLeihmodEinzel"]=="1")
					{
						?>
						<div class="ui-tabs-panel ui-widget-content ui-corner-bottom" id="ladeEinzelObj"></div>
						<?
					}
					?>					
					
					<?
					if ($_SESSION["SE_ViewLeihmodTag"]=="1")
					{
						?>
						<div class="ui-tabs-panel ui-widget-content ui-corner-bottom" id="ladeTags"></div>
						<?
					}
					?>						
			</div>
		
				
		</div>
				</article>
				<?			
				}
		
}


else
{
	//die user ohne bestätigung haben oben schon eine meldung bekommen, ne zweite verwirrt nur
	if ($_SESSION["User_Dat_RegBestaet"]=="0")
	{

	}
	else
	{
		?>
		<article id="articleLogin3">
		<h2>Start des Ausleihvorgangs</h2>
		<div class="line"></div>
		<div class="articleBody clear">
		<p>Sie verfügen leider nicht über ausreichend Rechte, um einen Ausleihvorgang zu beginnen. <br>Sie können <a href="mailto:<?echo $_SESSION['SE_adminEMail'];?>"><b>hier</b></a> (<?echo $_SESSION['SE_adminEMail'];?>) eine Nachricht an die Verwaltung der Leihe schreiben. </p>
		</div>
		</article>
		<?	
	}
}
}
?>