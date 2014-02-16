<br><br><br><br><br><br><br><br>
<footer>

<a href="#page"><div class="ui-state-default ui-corner-all" title="nach oben scrollen" style="float:right"><span class="ui-icon ui-icon-arrowthickstop-1-n"></span></div></a>
<br><br><br>
<div id="toolbar">
<br><hr><br>
<a href="<? echo $_SESSION["SE_festUrl"]; ?>">Start</a> &sdot;
<a href="<? echo $_SESSION["SE_festUrl"]; ?>toolbar/open">Öffnungszeiten</a> &sdot;
<?
if (welcheEinstellung("SE_twitterModuleActi")=="1" && welcheEinstellung("SE_twitterName")!="")
{
echo '<a href="http://www.twitter.com/'.welcheEinstellung("SE_twitterName").'" target="_blank">Aktuelle Informationen (twitter)</a> &sdot;';
}
?> 
<a href="<? echo $_SESSION["SE_festUrl"]; ?>toolbar/imprint">Impressum</a> &sdot;
<a href="http://www.ausleihsoftware.de" target="_blank"> Info</a>

</div>   
</footer><br>