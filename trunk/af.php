<?php
include "header.php";
include "mysqli_connection.php";

if (!isset($_SESSION["username"])){
        echo "<script>window.location.href='index.php'</script>";
}
else{
?>

<div>
<h1>Product-Application-Feature</h1>
</div>

<div>
<form action = "#" method = "GET">
<label for = "product">Product: </label><input type = "text" name = "product" value = "<?php echo $_GET['product'];?>" />
<label for = "app">Application: </label><input type = "text" name = "app" value = "<?php echo $_GET['app'];?>" />
<label for = "feature">Feature: </label><input type = "text" name = "feature" value = "<?php echo $_GET['feature'];?>" />

<input type = "submit" value = "Search" />
<input type = "button" value = "Clear" onclick = "window.location.href = 'af.php';" />
</form>
</div>
<div>
<a href="addaf.php">Add new Product/Application/Feature</a>
</div>
<hr />
<div>
<table>
<thead>
<td>ID</td><td>Product</td><td>Application</td><td>Feature</td><td>Operation</td>
</thead>
<tbody>
<?php
$filter = "true";
if (isset($_GET["af_id"]) && $_GET["af_id"] !== ""){
        $param = "(af_id = " . $mysqli->real_escape_string(trim($_GET["af_id"])) . ")";
        $filter .= " AND " . $param;
}
if (isset($_GET["product"]) && $_GET["product"] !== ""){
        $param = "(product LIKE '%" . $mysqli->real_escape_string(trim($_GET["product"])) . "%')";
        $filter .= " AND " . $param;
}
if (isset($_GET["app"]) && $_GET["app"] !== ""){
        $param = "(app LIKE '%" . $mysqli->real_escape_string(trim($_GET["app"])) . "%')";
        $filter .= " AND " . $param;
}
if (isset($_GET["feature"]) && $_GET["feature"] !== ""){
        $param = "(feature LIKE '%" . $mysqli->real_escape_string(trim($_GET["feature"])) . "%')";
        $filter .= " AND " . $param;
}

$perNumber = 25;
$page = $_GET['page'];
$count = $mysqli->query("select count(*) from af WHERE " . $filter . ";");
if ($count){
	$rs = mysqli_fetch_array($count);
	$totalNumber = $rs[0];
}
else
	$totalNumber = 0;
if ($totalNumber == 0){
        echo "<div><font color='red'>There is no results found!</font></div>";
}
else{
        echo "<div>Found " . $totalNumber. " items.</div>";
}
$totalPage = ceil($totalNumber / $perNumber);
if ($page < 1) {
        $page = 1;
}
else if ($page > $totalPage){
        $page = $totalPage;
}
$startCount = ($page - 1) * $perNumber;
$result = $mysqli->query("select * from af WHERE (" . $filter .") LIMIT $startCount, $perNumber");
if ($result){
        while ($row = mysqli_fetch_array($result)){
?>
<tr>
<td><?php echo $row["af_id"];?></td>
<td><?php echo $row["product"];?></td>
<td><?php echo $row["app"];?></td>
<td><?php echo $row["feature"];?></td>

<td><a href="javascript:" onclick = "show_delete_yes(this,<?php echo $row['af_id'];?>);" >Delete</a>&nbsp&nbsp
<a href="editaf.php?id=<?php echo $row['af_id'];?>">Edit</a>&nbsp&nbsp <!--？id=。。是给$_GET[“id”]传值-->
<a href="testcases.php?id=<?php echo $row['af_id'];?>">Test Cases</a>&nbsp&nbsp 
<a href="upload.php?id=<?php echo $row['af_id'];?>">Upload Test Case File</a>
</td>
</tr>
<?php
		}
}
?>
</tbody>
</table>
<div>
<?php
if ($totalPage > 1){
        if ($page != 1) {
                echo "<a href='af.php?product=" . $_GET["product"]. "&app=" . $_GET["app"] . "&afeature=" . $_GET["feature"] . "&page=" . ($page - 1) . "'>Back</a>&nbsp";
        }
        for ( $i = 1; $i <= $totalPage; $i++){
                if ($i == $page){
                        echo "&nbsp" . $i . "&nbsp";
                }
                else{
                        echo "&nbsp<a href='af.php?product=" . $_GET["product"]. "&app=" . $_GET["app"] . "&feature=" . $_GET["feature"] . "&page=" . $i . "'>" . $i . "</a>&nbsp";
                }
        }
        if ($page < $totalPage) {
                echo "&nbsp<a href='af.php?product=" . $_GET["product"]. "&app=" . $_GET["app"] . "&feature=" . $_GET["feature"] . "&page=" . ($page + 1) . "'>Next</a>";
        }
}
mysqli_close($mysqli);	
?>
</div>
</div>
<script>
function show_delete_yes(link, id){
        var top = $(link).offset().top;
        $("#deleteyes").css("display","block");
        $("#deleteyes").css("top", top);
        $("#af_id").val(id);
}
function hide_delete_yes(){
        $("#deleteyes").css("display","none");
}
</script>
<div id = "deleteyes" style="display:none;">
<div class = "confirm_delete_text">Are you sure to delete it?</div>
<form action = "deleteaf.php" method = "POST">
<input type = "hidden" name = "af_id" id = "af_id" />
<input type = "submit" value = "Yes" />
<input type = "button" value = "No" onclick = "hide_delete_yes();false;" />
</form>
</div>
<?php
}
include "footer.php";