<?
session_start();

//System 
/////////////////////////////////////////////
$includeName="../../_00_basic_check.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

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
<br><br><br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	
		
<section id="page"> <!-- Defining the #page section with the section tag -->


<header> 
 <?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../index.php" title="Startseite"><img src="../../BL_BILDER/start_00.png"></a> <a href="../../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=1;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Toolbar</a>/Öffnungszeiten</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Toolbar</a>/Öffnungszeiten</div>
	</hgroup>
	<?
	}
}
//#############Ende Überschrift	


	//navigation
	/////////////////////////////////////////////
	$includeName="../../_00_basic_nav.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
	exit();
	}
	/////////////////////////////////////////////
?>
            </header>
            <section id="articles"> <!-- A new section with the articles -->


						<article id="articleLogin1"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
							<h2>Öffnungszeiten</h2>
							
							<div class="line"></div>
							
<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">

<table width="700" border="0" cellpadding="0" cellspacing="0" class="ui-widget">
  <tr class="ui-widget-header">
    <td width="350">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="350" class="ui-widget-content">Montag</td>
    <td class="ui-widget-content">
	<?
	if ($_SESSION["SE_MoGeschlOderZeite"]=="0")
	{
	echo "geschlossen";
	}
	else
	{
	echo $_SESSION["SE_MoOffen11"]."-".$_SESSION["SE_MoOffen12"]. " Uhr";
		if ($_SESSION["SE_MoOffen21"]=="-" && $_SESSION["SE_MoOffen22"]=="-")
		{
		}
		else
		{
		echo " und ".$_SESSION["SE_MoOffen21"]."-".$_SESSION["SE_MoOffen22"]." Uhr";
		}
	}
	?></td></tr>
	<tr><td class="ui-widget-content ui-priority-secondary" colspan="2">Bemerkungen: <? 
	if (welcheEinstellung(SE_infoOeff_MO)!="")
	{
	echo utf8_encode(welcheEinstellung(SE_infoOeff_MO));
	}
	else
	{
	echo "-";
	}
	?><br><br></td></tr>

  <tr>
    <td width="350" class="ui-widget-content">Dienstag</td>
    <td class="ui-widget-content">	<?
	if ($_SESSION["SE_DiGeschlOderZeite"]=="0")
	{
	echo "geschlossen";
	}
	else
	{
	echo $_SESSION["SE_DiOffen11"]."-".$_SESSION["SE_DiOffen12"]. " Uhr";
		if ($_SESSION["SE_DiOffen21"]=="-" && $_SESSION["SE_DiOffen22"]=="-")
		{
		}
		else
		{
		echo " und ".$_SESSION["SE_DiOffen21"]."-".$_SESSION["SE_DiOffen22"]." Uhr";
		}
	}
	?></td>
  </tr>
	<tr><td class="ui-widget-content ui-priority-secondary" colspan="2">Bemerkungen: <? 
	if (welcheEinstellung(SE_infoOeff_DI)!="")
	{
	echo utf8_encode(welcheEinstellung(SE_infoOeff_DI));
	}
	else
	{
	echo "-";
	}
	?><br><br></td></tr>  
  
  <tr>
    <td width="350" class="ui-widget-content">Mittwoch</td>
    <td class="ui-widget-content"><?
	if ($_SESSION["SE_MiGeschlOderZeite"]=="0")
	{
	echo "geschlossen";
	}
	else
	{
	echo $_SESSION["SE_MiOffen11"]."-".$_SESSION["SE_MiOffen12"]. " Uhr";
		if ($_SESSION["SE_MiOffen21"]=="-" && $_SESSION["SE_MiOffen22"]=="-")
		{
		}
		else
		{
		echo " und ".$_SESSION["SE_MiOffen21"]."-".$_SESSION["SE_MiOffen22"]." Uhr";
		}
	}
	?></td>
  </tr>
	<tr><td class="ui-widget-content ui-priority-secondary" colspan="2">Bemerkungen: <? 
	if (welcheEinstellung(SE_infoOeff_MI)!="")
	{
	echo utf8_encode(welcheEinstellung(SE_infoOeff_MI));
	}
	else
	{
	echo "-";
	}
	?><br><br></td></tr>

  <tr>
    <td width="350" class="ui-widget-content">Donnerstag</td>
    <td class="ui-widget-content"><?
	if ($_SESSION["SE_DoGeschlOderZeite"]=="0")
	{
	echo "geschlossen";
	}
	else
	{
	echo $_SESSION["SE_DoOffen11"]."-".$_SESSION["SE_DoOffen12"]. " Uhr";
		if ($_SESSION["SE_DoOffen21"]=="-" && $_SESSION["SE_DoOffen22"]=="-")
		{
		}
		else
		{
		echo " und ".$_SESSION["SE_DoOffen21"]."-".$_SESSION["SE_DoOffen22"]." Uhr";
		}
	}
	?></td>
  </tr>
  	<tr><td class="ui-widget-content ui-priority-secondary" colspan="2">Bemerkungen: <? 
	if (welcheEinstellung(SE_infoOeff_DO)!="")
	{
	echo utf8_encode(welcheEinstellung(SE_infoOeff_DO));
	}
	else
	{
	echo "-";
	}
	?><br><br></td></tr>
	
  <tr>
    <td width="350" class="ui-widget-content">Freitag</td>
    <td class="ui-widget-content"><?
	if ($_SESSION["SE_FrGeschlOderZeite"]=="0")
	{
	echo "geschlossen";
	}
	else
	{
	echo $_SESSION["SE_FrOffen11"]."-".$_SESSION["SE_FrOffen12"]. " Uhr";
		if ($_SESSION["SE_FrOffen21"]=="-" && $_SESSION["SE_FrOffen22"]=="-")
		{
		}
		else
		{
		echo " und ".$_SESSION["SE_FrOffen21"]."-".$_SESSION["SE_FrOffen22"]." Uhr";
		}
	}
	?></td>
  </tr>
  	<tr><td class="ui-widget-content ui-priority-secondary" colspan="2">Bemerkungen: <? 
	if (welcheEinstellung(SE_infoOeff_FR)!="")
	{
	echo utf8_encode(welcheEinstellung(SE_infoOeff_FR));
	}
	else
	{
	echo "-";
	}
	?><br><br></td></tr>
	
  <tr>
    <td width="350" class="ui-widget-content">Sonnabend</td>
    <td class="ui-widget-content"><?
	if ($_SESSION["SE_SaGeschlOderZeite"]=="0")
	{
	echo "geschlossen";
	}
	else
	{
	echo $_SESSION["SE_SaOffen11"]."-".$_SESSION["SE_SaOffen12"]. " Uhr";
		if ($_SESSION["SE_SaOffen21"]=="-" && $_SESSION["SE_SaOffen22"]=="-")
		{
		}
		else
		{
		echo " und ".$_SESSION["SE_SaOffen21"]."-".$_SESSION["SE_SaOffen22"]." Uhr";
		}
	}
	?></td>
  </tr>
	<tr><td class="ui-widget-content ui-priority-secondary" colspan="2">Bemerkungen: <? 
	if (welcheEinstellung(SE_infoOeff_SA)!="")
	{
	echo utf8_encode(welcheEinstellung(SE_infoOeff_SA));
	}
	else
	{
	echo "-";
	}
	?><br><br></td></tr>  
  
  <tr>
    <td width="350" class="ui-widget-content">Sonntag</td>
    <td class="ui-widget-content"><?
	if ($_SESSION["SE_SoGeschlOderZeite"]=="0")
	{
	echo "geschlossen";
	}
	else
	{
	echo $_SESSION["SE_SoOffen11"]."-".$_SESSION["SE_SoOffen12"]. " Uhr";
		if ($_SESSION["SE_SoOffen21"]=="-" && $_SESSION["SE_SoOffen22"]=="-")
		{
		}
		else
		{
		echo " und ".$_SESSION["SE_SoOffen21"]."-".$_SESSION["SE_SoOffen22"]." Uhr";
		}
	}
	?></td>
  </tr>
  	<tr><td class="ui-widget-content ui-priority-secondary" colspan="2">Bemerkungen: <? 
	if (welcheEinstellung(SE_infoOeff_SO)!="")
	{
	echo utf8_encode(welcheEinstellung(SE_infoOeff_SO));
	}
	else
	{
	echo "-";
	}
	?><br><br></td></tr>
  

</table>	
							
							
						  </div>

						</article>

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
$includeName="../../_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}

/////////////////////////////////////////////			
?>  
	        
       
		</section> <!-- Closing the #page section -->

		 

        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);

echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>
</body>
</html>