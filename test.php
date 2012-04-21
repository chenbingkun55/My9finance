		<HTML>
		<BODY>
		<?PHP 
				require_once("head.php"); 
$num="1234.65";

$x=explode(".",$num);

echo $x[0]/1000%10;

echo "<BR>";
echo $x[0]/100%10;
echo "<BR>";
echo $x[0]/10%10;
echo "<BR>";
echo $x[0]/1%10;
echo "<BR>";

echo $x[1]/10%10;
echo "<BR>";
echo $x[1]/1%10;
		?>
		<?PHP require_once("tail.php");?>
		</BODY>
		</HTML>
