<?php
include "header.php";

include "mysqli_connection.php";

if (isset($_SESSION["username"])){
    //echo "<script>window.location.href='af.php'</script>";
}



$user_name = $_POST["user_name"];
$pw = $_POST["pw"];
$pw2 = $_POST["pw2"];
$authority = $_POST["authority"];

//判斷帳號密碼是否為空值
//確認密碼輸入的正確性
if($user_name != null && $pw != null && $pw2 != null && $pw === $pw2)
{
        //新增資料進資料庫語法
        $sql = "INSERT INTO users (user_name, password, authority) values ('".$user_name."', '".$pw."', '".$authority."');";
        //echo $sql;
		if(mysqli_query($mysqli,$sql))
        {
                echo 'Create New account successfully!';
                echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
        }
        else
        {
                echo 'Fail to create new account!';
				//echo mysqli_error($mysqli);
                echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
        }
}
else
{
        echo "<div style = 'color:red;'>Please fullfill your info!</div>" ;
        echo '<meta http-equiv=REFRESH CONTENT=2;url=register.php>';
}

mysqli_close($mysqli);	
?>
<img src="wait.gif"/>
<br />

<?php
include "footer.php";