<?php
include "header.php";
include "mysqli_connection.php";

if (!isset($_SESSION["username"])){
        echo "<script>window.location.href='index.php'</script>";
}
else{
        if (isset($_GET["id"]) && $_GET["id"] !== ""){
                $t_id = $mysqli->real_escape_string(trim($_GET["id"]));
                $query = "SELECT title, description, steps, e_result, af_id FROM testcases WHERE t_id = ".$t_id.";";//根据t_id查到实际的记录
				$result = mysqli_fetch_array($mysqli->query($query));//提出array的第一个元素
				if ($result){
?>

<form action="updatetc.php" method="post">
<input type="hidden" name = "t_id" value="<?php echo $t_id;?>" />
<input type="hidden" name = "af_id" value="<?php echo $result["af_id"];?>" />
Title:<br/><textarea name="title"><?php echo $result["title"];?></textarea><br/>
Description:  <br/><textarea name="description"><?php echo $result["description"];?></textarea><br/>
Steps: <br/><textarea name="steps"><?php echo $result["steps"];?></textarea><br/>
Expect Result:<br/><textarea name="e_result"><?php echo $result["e_result"];?></textarea><br/>
<input type = "submit" value = "Update" />
<input type = "button" value = "Cancel" onclick="window.location.href='testcases.php?id=<?php echo $result["af_id"];?>'" />
</form>
<?php
				}
				else{
					echo "No exist!<br />";
				}
        }
		else{
			echo "No exist!<br />";
		}
?>

<?php
}
//mysqli_close($mysqli);	
include "footer.php";
