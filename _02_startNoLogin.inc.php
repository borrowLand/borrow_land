
	<?
	//willkommensnachricht
	if ($startmeldung=="1")
	{
	echo '<article><p style="float:left;display:inline"><img style="margin-right:30px;" src="BL_BILDER/willkommen.png" border="1"> <h4>Herzlich Willkommen bei BORROW LAND!</h4>Mithilfe der beiden Symbole oben rechts können Sie sich registrieren oder anmelden.<br></p></article>';
	echo '<article id="article3" class="ui-helper-hidden">';
	}
	else
	{
	echo '<article id="article3">';
	}
	
	?>

<h2 class="clear">Vorschau Ausleih-Objekte</h2>

<div class="line"></div>
<div class="articleBody clear">

<link rel="stylesheet" type="text/css" href="BL_CSS/StartGal_Start.css" />


<div id="main">
<div id="gallery" >
 
<?

/* Configuration Start */

$thumb_directory = 'BL_MEDIA/PIC_OBJ';

$stage_width=700;	// How big is the area the images are scattered on
$stage_height=600;

/* Configuration end */

$allowed_types=array('jpg');
$file_parts=array();
$ext='';
$title='';
$i=0;

/* Opening the thumbnail directory and looping through all the thumbs: */

$dir_handle = @opendir($thumb_directory) or die("There is an error with your image directory!");

$i=1;
while ($file = readdir($dir_handle)) 
{
	/* Skipping the system files: */
	if($file=='.' || $file == '..') continue;
	
	$file_parts = explode('.',$file);
	$ext = strtolower(array_pop($file_parts));
	$title = implode('.',$file_parts);
	$title = htmlspecialchars($title);
	if(in_array($ext,$allowed_types))
	{
		$left=rand(0,$stage_width);
		$top=rand(0,400);
		$rot = rand(-40,40);
		
		if($top>$stage_height-130 && $left > $stage_width-230)
		{
			$top-=120+130;
			$left-=230;
		}
		
		$sql = "SELECT VorschauAnAus  FROM `04_obj_objekte` WHERE `specid_obj` = \"".unserialize(base64_decode($file_parts[0]))."\""; 
		$okayOrNot = mysql_query($sql);
		$DatenokayOrNot = mysql_fetch_row($okayOrNot);
		
		if ($DatenokayOrNot[0]=="1")
		{
		echo '
		<div id="pic-'.($i++).'" class="pic" style="top:'.$top.'px;left:'.$left.'px;background:url(galPrev.php?a='.$file_parts[0].') no-repeat 50% 50%; -moz-transform:rotate('.$rot.'deg); -webkit-transform:rotate('.$rot.'deg);">
		</div>';
		}
		
	}
}

/* Closing the directory */
closedir($dir_handle);

?>
  
 </div>

</div>




	</div>

</article>