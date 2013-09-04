<?php
include "header.php";
include "mysqli_connection.php";

if (!isset($_SESSION["username"])){
        echo "<script>window.location.href='index.php'</script>";
}
else{


?>

<div>
<h1>Hello! <?php echo $_SESSION["username"];?></h1>
</div>

<div>
<form action = "#" method = "GET">
<label for = "priority">Priority: </label><input type = "text" name = "priority" value = "<?php echo $_GET['priority'];?>" />
<label for = "datetime">Datetime: </label><input type = "text" name = "datetime" value = "<?php echo $_GET['datetime'];?>" />

<input type = "submit" value = "Search" />
<input type = "button" value = "Clear" onclick = "window.location.href = 'dev.php';" />
</form>
</div>

<hr />
<div>
<table>
<thead>
<td>Test case ID</td><td>Result ID</td><td>Test Status</td><td>Test Result</td><td>Datetime</td><td>Tester</td><td>Operation</td>
</thead>
<tbody>
<?php
$filter = "results.assign_to = '" . $_SESSION["username"] . "'";

/* if (isset($_GET["t_id"]) && $_GET["t_id"] !== ""){
        $param = "(t_id = " . $mysqli->real_escape_string(trim($_GET["t_id"])) . ")";
        $filter .= " AND " . $param;
} */
if (isset($_GET["r_id"]) && $_GET["r_id"] !== ""){
        $param = "(r_id = " . $mysqli->real_escape_string(trim($_GET["r_id"])) . ")";
        $filter .= " AND " . $param;
}
if (isset($_GET["priority"]) && $_GET["priority"] !== ""){
        $param = "(priority = " . $mysqli->real_escape_string(trim($_GET["priority"])) . ")";
        $filter .= " AND " . $param;
}
/* if (isset($_GET["t_result"]) && $_GET["t_result"] !== ""){
        $param = "(t_result = " . $mysqli->real_escape_string(trim($_GET["t_result"])) . ")";
        $filter .= " AND " . $param;
}
if (isset($_GET["tester"]) && $_GET["tester"] !== ""){
        $param = "(tester = " . $mysqli->real_escape_string(trim($_GET["tester"])) . ")";
        $filter .= " AND " . $param;
} */
if (isset($_GET["datetime"]) && $_GET["datetime"] !== ""){
		$param = "(datetime = " . $mysqli->real_escape_string(trim($_GET["datetime"])) . ")";
        $filter .= " AND " . $param;
}


$perNumber = 25;
$page = $_GET['page'];
$count = $mysqli->query("select count(*) from results WHERE " . $filter . ";");
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
        echo "<div>Found " . $totalNumber. " results.</div>";
}
$totalPage = ceil($totalNumber / $perNumber);
if ($page < 1) {
        $page = 1;
}
else if ($page > $totalPage){
        $page = $totalPage;
}
$startCount = ($page - 1) * $perNumber;
$sql = "SELECT t_id, r_id, priority, t_result, tester, datetime FROM results WHERE (".$filter.") LIMIT $startCount, $perNumber;";
//inner join tester? to get tester name?
//echo $sql."<br />";
$result = $mysqli->query($sql);

if ($result){
        while ($row = mysqli_fetch_array($result)){
?>
<tr>
<td><?php echo $row["r_id"]."-".$row["app"]."-".$row["feature"]."-".$row["t_id"];?></td>
<td><?php echo $row["priority"];?></td>
<td><?php echo $row["priority"];?></td>
<td><?php echo $row["t_result"];?></td>
<td><?php echo $row["datetime"];?></td>
<td><?php echo $row["tester"];?></td>
<td>

<a href="editr.php?id=<?php echo $row['r_id'];?>">See details</a>&nbsp&nbsp

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
                echo "<a href='testcases.php?t_id=" . $_GET["t_id"]. "&r_id=" . $_GET["r_id"]. "&priority=" . $_GET["priority"] . "&t_result =". $_GET["t_result"]. "&tester =". $_GET["tester"]. "&datetime =". $_GET["datetime"]. "&page=" . ($page - 1) . "'>Back</a>&nbsp";
        }
        for ( $i = 1; $i <= $totalPage; $i++){
                if ($i == $page){
                        echo "&nbsp" . $i . "&nbsp";
                }
                else{
                        echo "&nbsp<a href='testcases.php?t_id=" . $_GET["t_id"]. "&r_id=" . $_GET["r_id"]. "&priority=" . $_GET["priority"]. "&t_result =". $_GET["t_result"]. "&tester =". $_GET["tester"]. "&datetime=" . $_GET["datetime"]. "&page=" . $i . "'>" . $i . "</a>&nbsp";
                }
        }
        if ($page < $totalPage) {
                echo "&nbsp<a href='testcases.php?t_id=" . $_GET["t_id"]. "&r_id=" . $_GET["r_id"]. "&priority=" . $_GET["priority"] . "&t_result =". $_GET["t_result"]. "&tester =". $_GET["tester"]. "&datetime=" . $_GET["datetime"]. "&page=" . ($page + 1) . "'>Next</a>";
        }
}
mysqli_close($mysqli);	
?>
</div>
</div>


<?php
}
include "footer.php";