<?

if(isset($_POST['b']))
{
$matrID = trim($_POST['b']);



if(is_numeric($matrID) && strlen($matrID)==8)
{
		if (substr($matrID, -8, 2)=="20")
		{
		echo "0";
		}
		else
		{
		$msg = "invalid";
		}
}
else
{
$msg = "invalid";
}




echo $msg;

}

?>
