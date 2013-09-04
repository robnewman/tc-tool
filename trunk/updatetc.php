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
	if (isset($_POST["t_id"]) && $_POST["t_id"] !== ""){
		$sql = "UPDATE testcases SET title = '".$_POST["title"]."', description = '".$_POST["description"]."', steps = '".$_POST["steps"]."', e_result = '".$_POST["e_result"]."' WHERE t_id = ".$_POST["t_id"].";";
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
        window.location.href='testcases.php?id=<?php echo $_POST["af_id"];?>';
}
window.setTimeout("jump();",3000);
</script>
<div>
<?php
 //完成edit之后跳转回testcases页面显示test cases 有问题
?>
Jumping back to test cases page in 3 seconds...<br />
<img src="wait.gif"/>
<br />
<a href="testcases.php?id=<?php echo $_POST["af_id"];?>">Click here to jump immediately</a>
</div>

<?php
}
mysqli_close($mysqli);	
include "footer.php";
