<?php
include "header.php";

include "mysqli_connection.php";

if (isset($_SESSION["username"])){
        //echo "<script>window.location.href='af.php'</script>";
}

?>
<script type="text/javascript" src="js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="js/jMask.js" ></script>
<script type="text/javascript" src="js/cufon-yui.js" ></script>
<script type="text/javascript" src="js/GeosansLight_500.font.js"  ></script>
<script type="text/javascript" src="js/raphael-min.js"  ></script>
<script type="text/javascript" src="js/custom.js"  ></script>

<link rel="stylesheet" href="css/style.css" type="text/css"  />
<link rel="stylesheet" href="css/jMask.css" type="text/css"  />

<div id="container">
<table style="border: 0px;">
<tr style="border: 0px;"><td style="border: 0px;">
<div id="outerblock">
<div id="innerblock">
<div id="slideshow">
<div>
<ul>
<li><img src="img/im4.jpg" />
</li>
<li><img src="img/im3.jpg" />
</li>
<li><img src="img/im2.jpg" />
</li>
<li><img src="img/im1.jpg" />
</li>
</ul>
</div>
</div>
<span id="ribbon-left"></span>
</div>
<div id="frame">
</div>
</div>
</td><td style="border: 0px;">
<div id="loginblock">
<?php
if (isset($_POST["username"]) && isset($_POST["password"])){
	$query = "SELECT user_name, authority FROM users WHERE (user_name='".$_POST["username"]."') AND (password='".$_POST["password"]."');";
	$result = mysqli_query($mysqli,$query);
	$row = mysqli_fetch_array($result);
	if($row){
		$_SESSION["username"] = $_POST["username"];
		$_SESSION["authority"] = $row["authority"];
		echo "<script>window.location.href='dev.php'</script>";	
		//else{echo "<script>window.location.href='af.php'</script>";	}
	}
	else {
		echo "<div style = 'color:red;'>Invalid username or password!</div>";
	}
	
        //$stmt = $mysqli->stmt_init();
        //if ($stmt = $mysqli->prepare($query)){
        //        $stmt->bind_param("ss", $_POST["username"], $_POST["password"]);
        //        $stmt->execute();
        //        $stmt->bind_result($username);
        //        if ($stmt->fetch()){
        //                $_SESSION["username"] = $username;
        //                echo "<script>window.location.href='managehome.php'</script>";
        //        }
        //        else{
        //                echo "<div style = 'color:red;'>Invalid username or password!</div>";
        //        }
        //        $stmt->close();
        //}

mysqli_close($mysqli);		
}
?>

<form action = "#" method = "post">
<label for = "username">Username: </label><input type = "text" name = "username" /><br />
<label for = "password">Password: </label><input type = "password" name = "password" /><br />
<input type = "submit" value = "Log in" />
<input type = "button"value = "Create new account" onclick = "window.location.href = 'register.php';"/>
</form>
</div>
</td></tr></table>
<img src="css/i/shadow.png" class="grid_10" id="shadow" />
</div>






<?php
include "footer.php";