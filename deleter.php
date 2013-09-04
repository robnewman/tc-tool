<?php
include "header.php";
include "mysqli_connection.php";

if (!isset($_SESSION["username"])){
        echo "<script>window.location.href='index.php'</script>";
}
else{
?>

<script>
function jump(){
        window.location.href='result.php';
}
window.setTimeout("jump();",3000);
</script>
<div>
<?php
        if (isset($_POST["r_id"]) && $_POST["r_id"] !== ""){//isset 存在 而且不为空
                $t_id = $mysqli->real_escape_string(trim($_POST["r_id"]));//转译 trim减掉头尾空格
				echo $t_id;
				if ($t_id != 0){
                        $query = "DELETE FROM results WHERE r_id = ".$_POST["r_id"].";";
						if (mysqli_query($mysqli,$query)){
							echo "Item deleted!";
						}
						else {
							echo "Delete failed!"; 
						}
                }
                else{
					
                }
        }
        else{
       
        }
?>
Jumping out this page in 3 seconds...<br />
<img src="wait.gif"/>
<br />
<a href="result.php">Click here to jump immediately</a>
</div>
<?php
}
mysqli_close($mysqli);	
include "footer.php";
