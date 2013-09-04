<?php
include "header.php";

include "mysqli_connection.php";

if (isset($_SESSION["username"])){
//        echo "<script>window.location.href='af.php'</script>";
}

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<form name="form" method="post" action="register_finish.php">
	Username:<input type="text" name="user_name" /> <br>
	Password:<input type="password" name="pw" /> <br>
	Re-enter password:<input type="password" name="pw2" /> <br>
	Input your authority:<select name='authority'>
		<option value='4'>Developer</option>
		<option value='3'>Tester </option>
		<option value='2'>Test cases Creator </option>
		<option value='1'>Creator&Tester </option>
		<option value='0'>Adminstrator </option>
		</select>
	<br/>
	<input type="submit" name="button" value="Submit" />
</form>


<?php
include "footer.php";