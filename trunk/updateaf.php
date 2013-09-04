<?php
include "header.php";
include "mysqli_connection.php";
if ($_SESSION["authority"]==4){
       echo "You do not allowed to edit this page!";
	   echo "<script>window.location.href='dev.php'</script>";
}else

if (!isset($_SESSION["username"])){
        echo "<script>window.location.href='index.php'</script>";
}
else{
	if (isset($_POST["af_id"]) && $_POST["af_id"] !== ""){
		$sql = "UPDATE af SET app = '".$_POST["app"]."', product = '".$_POST["product"]."', feature = '".$_POST["feature"]."' WHERE af_id = ".$_POST["af_id"].";";
		$result = $mysqli->query($sql);
		if ($result){
			echo "Succeed!";
		}
		else
			echo "Failed!";
	}
	else{
	}
?>

<script>
function jump(){
        window.location.href='af.php';
}
window.setTimeout("jump();",3000);
</script>
<div>
<?php
 
?>
Jumping back to af page in 3 seconds...<br />
<img src="wait.gif"/>
<br />
<a href="af.php">Click here to jump immediately</a>
</div>

<?php
}
mysqli_close($mysqli);	
include "footer.php";
