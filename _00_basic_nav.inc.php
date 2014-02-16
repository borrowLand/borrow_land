<?
//wenn logout bereich, dann keine nav symbole
$logOutBer = strstr($_SERVER["SCRIPT_FILENAME"], 'logout');

if (isset($_SESSION["User_ID"]) && $logOutBer=="")
{
	?>
	<nav class="clear" id="RechtsOben" >
	<ul>
	<?
	if (isset($_SESSION["User_WK"]) && wkCountOhneLeer()!=0)
		{
		echo '<div style="display:inline;" id="wk"><li><a href="'.$_SESSION["SE_festUrl"].'account/basket" title="Warenkorb">'.wkCountOhneLeer().'<div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-cart"></span></div></a></li></div>';
		}
	else
		{
		echo '<div style="display:inline;" id="wk"></div>'; 
		}

	if ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1")
		{
		echo '<li><a href="'.$_SESSION["SE_festUrl"].'admini/" title="Verwaltung"><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-gear"></span></div></a></li>';
		}
	$nutzerInfos=benutzerDaten($_SESSION["User_ID"]);
	?>	
	<li><a href="<? echo $_SESSION["SE_festUrl"]; ?>account/" title="Benutzer <? echo utf8_encode(htmlspecialchars($nutzerInfos[0]));?>" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-person"></span></div></a></li>
	<li><a href="<? echo $_SESSION["SE_festUrl"]; ?>logout/" title="Ausloggen" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-power"></span></div></a></li>
	</ul>
	</nav>
	<?
}
	else
	{
	?>
	<nav class="clear" id="RechtsOben" >
	<ul>
	<li><a href="<? echo $_SESSION["SE_festUrl"]; ?>reg/" title="Registrieren"><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span></div></a></li>
	<li><a href="<? echo $_SESSION["SE_festUrl"]; ?>login/" title="Login"><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-key"></span></div></a></li>
	</ul>
	</nav>
	<?
	}

?>