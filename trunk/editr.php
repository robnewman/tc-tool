<?php
include "header.php";
include "mysqli_connection.php";

if (!isset($_SESSION["username"])){
        echo "<script>window.location.href='index.php'</script>";
}
/*else{
        if (isset($_GET["id"]) && $_GET["id"] !== ""){
                $r_id = $mysqli->real_escape_string(trim($_GET["id"]));
                $query = "SELECT title, description, steps, e_result FROM testcases WHERE t_id = ".$t_id.";";//根据t_id查到实际的记录
				$result = mysqli_fetch_array($mysqli->query($query));//提出array的第一个元素
				if ($result){
*/
?>

<?php
//$sql = "SELECT title, description, steps, e_result FROM testcases WHERE t_id = ".$_GET["id"].";";
$sql = "SELECT results.t_id, t_status, t_result, a_result, repro_steps, assign_to, priority, comment, title, description, steps, e_result FROM results INNER JOIN testcases WHERE (results.t_id = testcases.t_id AND r_id = ".$_GET["id"].");";
$result = $mysqli->query($sql);
if ($result){
	$row = mysqli_fetch_array($result);
	if ($row){
?>
<div id="dest">
Testcase ID: <?php echo $row["t_id"]; ?><br/>
Title: <?php echo $row["title"]?><br/>
Description: <?php echo $row["description"]?><br/>
Steps: <?php echo $row["steps"]?><br/>
Expect Result: <?php echo $row["e_result"]?><br/>
</div>
<br/>
<br/>
<form action="updater.php" method="post">
	<input type="hidden" name = "t_id" value="<?php echo $row["t_id"];?>" />
	<input type="hidden" name = "r_id" value="<?php echo $_GET["id"];?>" />
	Test Status:
	<input type="radio" name="t_status" value="1" <?php if ($row["t_status"] == 1) echo "checked";?>>Tested
	<input type="radio" name="t_status" value="0" <?php if ($row["t_status"] == 0) echo "checked";?>>Not tested
	<br/>
	Test Result:
	<input type="radio" name="t_result" value="0" <?php if ($row["t_result"] == 0) echo "checked";?>>Pass
	<input type="radio" name="t_result" value="1" <?php if ($row["t_result"] == 1) echo "checked";?>>Fail
	<input type="radio" name="t_result" value="2" <?php if ($row["t_result"] == 2) echo "checked";?>>N\A
	<br/>
	Assign To: <select name="assign_to">
<?php
$sql_2 = "SELECT user_id, user_name from users;";
$result_2 = $mysqli->query($sql_2);
if ($result_2){
	while ($row_2 = mysqli_fetch_array($result_2)){
?>
<option value="<?php echo $row_2["user_name"];?>" <?php if ($row["assign_to"] == $row_2["user_name"]) echo "selected";?>><?php echo $row_2["user_name"];?></option>
<?php
	}
}
?>
	</select>
	<br />
	Priority: <select name="priority">
<?php
	for ($i =0; $i<5; $i++){
		echo "<option value='".$i."' ";
		if ($row["priority"] == $i)
			echo "selected";
		echo ">";
		if ($i>0)
			echo $i;
		else
			echo "NULL";
		echo "</option>";
	}
?>
	</select>
	<br />
	Actual Result: <br/><textarea name="a_result"><?php echo $row["a_result"];?></textarea><br/>
	Re-pro Steps: <br/><textarea name="repro_steps"><?php echo $row["repro_steps"];?></textarea><br/>
	Comment: <br/><textarea name="comment"><?php echo $row["comment"];?></textarea><br/>
	<br/>
	<input type="submit" value="Submit">
	<input type = "button" value = "Cancel" onclick="window.location.href='result.php?id=<?php echo $row["t_id"];?>'" />
</form>
<?php
	}
	else{
		echo "No found result.";
	}
}
mysqli_close($mysqli);	

include "footer.php";
