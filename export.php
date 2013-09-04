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



require_once 'excel_reader.php';
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');
$data->read('exceltestsheet.xls');
 
$conn = mysql_connect("title","description","steps","e_result");
mysql_select_db("tctool",$conn);
 
for ($x = 2; $x < = count($data->sheets[0]["cells"]); $x++) {
    $name = $data->sheets[0]["cells"][$x][1];
    $extension = $data->sheets[0]["cells"][$x][2];
    $email = $data->sheets[0]["cells"][$x][3];
    $sql = "INSERT INTO mytable (name,extension,email) 
        VALUES ('$name',$extension,'$email')";
    echo $sql."\n";
    mysql_query($sql);
}

?>


<?php
include "footer.php";