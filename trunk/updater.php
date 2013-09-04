<?php
include "header.php";
include "mysqli_connection.php";

if (!isset($_SESSION["username"])){
        echo "<script>window.location.href='index.php'</script>";
}
else{
//echo $_POST["r_id"];
	if (isset($_POST["r_id"]) && $_POST["r_id"] !== ""){
		//echo " asdfsadf";
		$sql = "UPDATE results SET t_status = '".$_POST["t_status"]."', t_result = '".$_POST["t_result"]."', a_result = '".$_POST["a_result"]."',repro_steps = '".$_POST["repro_steps"]."',assign_to = '".$_POST["assign_to"]."', priority = '".$_POST["priority"]."' WHERE r_id = ".$_POST["r_id"].";";
		//echo $sql;
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
        window.location.href='result.php?id=<?php echo $_POST["t_id"];?>';
}
window.setTimeout("jump();",3000);
</script>
<div>
<?php
 //完成edit之后跳转回testcases页面显示test cases 有问题
?>
Jumping back to results page in 3 seconds...<br />
<img src="wait.gif"/>
<br />
<a href="result.php?id=<?php echo $_POST["t_id"];?>">Click here to jump immediately</a>
</div>

<?php
}
mysqli_close($mysqli);	
include "footer.php";
