<?php
include "header.php";
include "mysqli_connection.php";

if (!isset($_SESSION["username"])){
        echo "<script>window.location.href='index.php'</script>";
}
else{


?>
<script>
$(document).ready(function() {
	$("#date").datepicker({ dateFormat: "yy-mm-dd" });
});
</script>
<div>
<h1>Test Cases Results</h1>
</div>

<div>
<form action = "#" method = "GET">
<input type = "hidden" name = "id" value="<?php echo $_GET['id'];?>"/>
<label for = "tester"> Tester: </label>
<select name ="tester">
<option value = "">&nbsp </option>
<?php
$sql_2 = "SELECT user_id, user_name from users;";
$result_2 = $mysqli->query($sql_2);
if ($result_2){
	while ($row_2 = mysqli_fetch_array($result_2)){
?>
<option value="<?php echo $row_2["user_name"];?>" <?php if ($_GET['tester'] == $row_2["user_name"]) echo "selected";?>><?php echo $row_2["user_name"];?></option>
<?php
	}
}
?>
</select>
<label for = "datetime">Datetime: </label><input type = "text" id="date" name = "datetime" value = "<?php echo $_GET['datetime'];?>" />

<input type = "submit" value = "Search" />
<input type = "button" value = "Clear" onclick = "window.location.href = 'result.php?id=<?php echo $_GET['id'];?>';" />
</form>
</div>
<div>
<a href="addr.php?id=<?php echo $_GET['id'];?>">Add new test result</a>
</div>
<hr />
<div>
<table>
<thead>
<td>Result ID</td><td>Test Status</td><td>Test Result</td><td>Datetime</td><td>Tester</td><td>Operation</td>
</thead>
<tbody>
<?php
$filter = "results.t_id = " . $_GET["id"];

if (isset($_GET["r_id"]) && $_GET["r_id"] !== ""){
        $param = "(r_id = " . $mysqli->real_escape_string(trim($_GET["r_id"])) . ")";
        $filter .= " AND " . $param;
}
if (isset($_GET["t_status"]) && $_GET["t_status"] !== ""){
        $param = "(t_status = " . $mysqli->real_escape_string(trim($_GET["t_status"])) . ")";
        $filter .= " AND " . $param;
}
if (isset($_GET["t_result"]) && $_GET["t_result"] !== ""){
        $param = "(t_result = " . $mysqli->real_escape_string(trim($_GET["t_result"])) . ")";
        $filter .= " AND " . $param;
}
if (isset($_GET["tester"]) && $_GET["tester"] !== ""){
        $param = "(tester LIKE '%" . $mysqli->real_escape_string(trim($_GET["tester"])) . "%')";
        $filter .= " AND " . $param;
}
if (isset($_GET["datetime"]) && $_GET["datetime"] !== ""){
		$param = "(datetime LIKE '" . $mysqli->real_escape_string(trim($_GET["datetime"])) . "%')";
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
$sql = "SELECT r_id, t_status, t_result, tester, datetime FROM results WHERE (".$filter.") LIMIT $startCount, $perNumber;";
//inner join tester? to get tester name?
//echo $sql."<br />";
$result = $mysqli->query($sql);

if ($result){
        while ($row = mysqli_fetch_array($result)){
?>
<tr>
<td><?php echo $row["r_id"];?></td>
<td><?php if ($row["t_status"] == 1) 
			{echo "Tested" ;} 
			else {echo "Not tested";}
	?></td>  
<td><?php if ($row["t_result"] == 0) 
			{echo "Pass" ;} 
		else if ($row["t_result"] == 1)
			{echo "Fail";}
		else {echo "N\A";}
	?></td>
<td><?php echo $row["datetime"];?></td>
<td><?php echo $row["tester"];?></td>

<td><a href="javascript:" onclick = "show_delete_yes(this,<?php echo $row['r_id'];?>);" >Delete</a>&nbsp&nbsp
<a href="editr.php?id=<?php echo $row['r_id'];?>">Edit</a>&nbsp&nbsp

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
                echo "<a href='testcases.php?r_id=" . $_GET["r_id"]. "&t_status=" . $_GET["t_status"] . "&t_result =". $_GET["t_result"]. "&tester =". $_GET["tester"]. "&datetime =". $_GET["datetime"]. "&page=" . ($page - 1) . "'>Back</a>&nbsp";
        }
        for ( $i = 1; $i <= $totalPage; $i++){
                if ($i == $page){
                        echo "&nbsp" . $i . "&nbsp";
                }
                else{
                        echo "&nbsp<a href='testcases.php?r_id=" . $_GET["r_id"]. "&t_status=". $_GET["t_status"] . "&t_result =". $_GET["t_result"]. "&tester =". $_GET["tester"]. "&datetime=" . $_GET["datetime"]. "&page=" . $i . "'>" . $i . "</a>&nbsp";
                }
        }
        if ($page < $totalPage) {
                echo "&nbsp<a href='testcases.php?r_id=" . $_GET["r_id"]. "&t_status=" . $_GET["t_status"] . "&t_result =". $_GET["t_result"]. "&tester =". $_GET["tester"]. "&datetime=" . $_GET["datetime"]. "&page=" . ($page + 1) . "'>Next</a>";
        }
}
?>
</div>
</div>
<script>
function show_delete_yes(link, id){
        var top = $(link).offset().top;
        $("#deleteyes").css("display","block");
        $("#deleteyes").css("top", top);
        $("#r_id").val(id);
}
function hide_delete_yes(){
        $("#deleteyes").css("display","none");
}
</script>
<div id = "deleteyes" style="display:none;">
<div class = "confirm_delete_text">Are you sure to delete it?</div>
<form action = "deleter.php" method = "POST">
<input type = "hidden" name = "r_id" id = "r_id" />
<input type = "submit" value = "Yes" />
<input type = "button" value = "No" onclick = "hide_delete_yes();false;" />
</form>
</div>
<?php
}
mysqli_close($mysqli);	
include "footer.php";