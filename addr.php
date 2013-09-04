<?php
include "header.php";

include "mysqli_connection.php";

if (!isset($_SESSION["username"])){
       echo "<script>window.location.href='index.php'</script>";
}

?>

<?php
$sql = "SELECT title, description, steps, e_result FROM testcases WHERE t_id = ".$_GET["id"].";";
//echo $sql;
$result = $mysqli->query($sql);
if ($result){
	$row = mysqli_fetch_array($result);
	if ($row){
?>
<div id="dest">
  Testcase ID: <?php echo $_GET["id"]; ?><br/>
  Title: <?php echo $row["title"]?><br/>
  Description: <?php echo $row["description"]?><br/>
  Steps: <?php echo $row["steps"]?><br/>
  Expect Result: <?php echo $row["e_result"]?><br/>
</div>
<?php	
	}
	else{
		echo "No found testcase.";
	}
}

?>
<br/>
<br/>
<br/>
<form method = "POST" action="addr_finish.php">
	<input type = "hidden" name = "t_id" value="<?php echo $_GET["id"];?>"/>
	Test Status:
	<input type="radio" name="t_status" value="1" checked>Tested
	<input type="radio" name="t_status" value="0">Not tested
	<br/>
	Test Result:
	<input type="radio" name="t_result" value="0" checked>Pass
	<input type="radio" name="t_result" value="1">Fail
	<input type="radio" name="t_result" value="2">N\A
	<br/>

	Assign To: <select name="assign_to">
<?php
$sql = "SELECT user_id, user_name from users;";
$result = $mysqli->query($sql);
if ($result){
	while ($row = mysqli_fetch_array($result)){
?>
<option value="<?php echo $row["user_name"];?>"><?php echo $row["user_name"];?></option>
<?php
	}
}
mysqli_close($mysqli);	
?>
	</select>
	<br />
	Priority: <select name="priority">
		<option value="0">NULL</option>	
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
	</select>

	<br />
	Actual Result: <br/><textarea name="a_result"></textarea><br/>
	Re-pro Steps: <br/><textarea name="repro_steps"></textarea><br/>
	Comment: <br/><textarea name="comment"></textarea><br/>
	<br/>
	<input type="submit" value="Submit">
	<input type = "button" value = "Cancel" onclick="window.location.href='result.php'" />
</form>

<?php
include "footer.php";