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
//$af_id = $_GET["af_id"];
?>

<form name="form" action="upread_excel.php" method="post" enctype="multipart/form-data">
<input type="hidden" name = "af_id" value = "<?php echo $_GET["af_id"];?>" />

<?php
  
$allowedExts = array("xls", "xlsx", "csv");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if (/* (($_FILES["file"]["type"] == "excel/xls")
|| ($_FILES["file"]["type"] == "excel/xlsx"))
&&  */($_FILES["file"]["size"] < 2000000000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1048576) . " kMB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  } 
?> 
<input type ="hidden" name="file" value="upload\<?php echo $_FILES["file"]["name"];?>" />
<input type="submit" name="submit" value="Submit" />
</form>

<?php
include "footer.php";