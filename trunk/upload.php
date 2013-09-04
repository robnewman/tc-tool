<?php
include "header.php";

include "mysqli_connection.php";

if (!isset($_SESSION["username"])){
        echo "<script>window.location.href='index.php'</script>";
}

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<form action="upload_file.php" method="post" enctype="multipart/form-data">
<input type="hidden" name = "af_id" value = "<?php echo $_GET["af_id"];?>" />
<label for="file">Upload:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form>

<?php
include "footer.php";