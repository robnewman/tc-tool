<?php
include "header.php";

include "mysqli_connection.php";
if ($_SESSION["authority"]==4){
       echo "You do not allowed to edit this page!";
	   echo "<script>window.location.href='dev.php'</script>";
}else
if (isset($_SESSION["username"])){
   echo "<script>window.location.href='af.php'</script>";
}

/* $af_id = $_POST["af_id"];
$title = $_POST["title"];
$description = $_POST["description"];
$steps = $_POST["steps"];
$e_result = $_POST["e_result"];
//判斷帳號密碼是否為空值
//確認密碼輸入的正確性
if($title != null && $description != null && $steps != null && $e_result != null)
{ */
        //新增資料進資料庫語法
        $sql = "LOAD DATA LOCAL INFILE D:\\testing.csv INTO TABLE testcases FIELDS TERMINATED BY ';' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' (title, description, steps, e_result, af_id);"; 
        //echo $sql."<br />";
		if(mysqli_query($mysqli,$sql))
        {
                echo 'Create successfully!';
                echo '<meta http-equiv=REFRESH CONTENT=2;url=testcases.php?id='.$af_id.'>';
        }
        else
        {
                echo 'Fail to create!';
				echo '<meta http-equiv=REFRESH CONTENT=2;url=testcases.php?id='.$af_id.'>';
				echo mysqli_error($mysqli);
                //echo '<meta http-equiv=REFRESH CONTENT=2;url=testcases.php>';
        }
}
/* else
{
        echo "<div style = 'color:red;'>Please fullfill your info!</div>" ;
        echo '<meta http-equiv=REFRESH CONTENT=2;url=testcases.php?id='.$af_id.'>';
} */

mysqli_close($mysqli);	
?>
<img src="wait.gif"/>
<br />

<?php
include "footer.php";