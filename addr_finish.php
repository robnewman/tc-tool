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

$t_id = $_POST["t_id"];
$t_status = $_POST["t_status"];
$t_result = $_POST["t_result"];
$assign_to = $_POST["assign_to"];
$priority = $_POST["priority"];
$a_result = $_POST["a_result"];
$repro_steps = $_POST["repro_steps"];
$comment = $_POST["comment"];
//判斷帳號密碼是否為空值
//確認密碼輸入的正確性
if($t_status != null && $t_result != null)
{
	//新增資料進資料庫語法
	$sql = "INSERT INTO results (t_id, datetime, tester, t_status, t_result, a_result, repro_steps, assign_to, priority, comment) values ('".$t_id."', now(), '".$_SESSION["username"]."', '".$t_status."','".$t_result."','".$a_result."','".$repro_steps."','".$assign_to."','".$priority."','".$comment."');";
	//echo $sql;
	if(mysqli_query($mysqli,$sql))
	{
		echo 'Create successfully!';
		echo '<meta http-equiv=REFRESH CONTENT=2;url=result.php?id='.$t_id.'>';
	}
	else
	{
		echo 'Fail to create!';
		echo mysqli_error($mysqli);
		echo '<meta http-equiv=REFRESH CONTENT=2;url=result.php?id='.$t_id.'>';	
	}
}
else
{
	echo "<div style = 'color:red;'>Please fullfill your info!</div>" ;
	echo '<meta http-equiv=REFRESH CONTENT=2;url=result.php?id='.$t_id.'>';
}

mysqli_close($mysqli);	
?>
<img src="wait.gif"/>
<br />

<?php
include "footer.php";