<?phpinclude "header.php";include "mysqli_connection.php";if ($_SESSION["authority"]==4){       echo "You do not allowed to edit this page!";	   echo "<script>window.location.href='dev.php'</script>";}elseif (isset($_SESSION["username"])){   echo "<script>window.location.href='af.php'</script>";}$af_id = $_POST["af_id"];$excel_file = $_POST["file"];$sheet_data = '';         // to store html tables with excel data, added in page$table_output = array();  // store tables with worksheets data$max_rows = 0;        // USE 0 for no max$max_cols = 8;        // USE 0 for no max$force_nobr = 0;      // USE 1 to Force the info in cells Not to wrap unless stated explicitly (newline)require_once 'excel_reader.php';       // include the class$excel = new PhpExcelReader();$excel->setOutputEncoding('UTF-8');     // sets encoding UTF-8 for output data$excel->read($excel_file);       // read excel file data$nr_sheets = count($excel->sheets);       // gets the number of worksheetsmysql_select_db ( 'tctool' ); // 选择数据库// 调用ImportExcelData方法ImportExcelData ( $excel, 'tctool', array ('title', 'description', 'steps', 'e_result', 'af_id'), true );/** * 将读取到的Excel数据导入到数据库中 * * @access public * @param hasColumnHeader    是否包含列头 * @param columnArray        要插入的列 * @param tableName         要插入的表 * @param batchSize            每次执行插入语句的条数 * @return bool */function ImportExcelData($excel, $testcases, $title, $description, $steps, $e_result, $af_id, $hasColumnHeader = false, $batchSize = 5){        // 默认不包含列头，起始行就为1    $start = 1;        if($hasColumnHeader){        // 如果包含列头，跳过列头，起始行为2        $start = 2;    }    // 记录循环次数    $loop = 0;    $sql = "";    // 生成insert语句的前半部分    // 形式如这种：insert into table_name('field1','field2'...) values    $insert_statement = CreateInsertStatement($testcases, $title, $description, $steps, $e_result, $af_id);    for($i = $start; $i <= $excel->sheets[0]['numRows']; $i++){ // 遍历行        $sql .= $insert_statement;        $sql .= "(";        for ($j = 1; $j <= $excel->sheets[0]['numCols']; $j++){ // 遍历列            $sql .= "'".$excel->sheets[0]['cells'][$i][$j]."',";        }        $sql = trimEnd($sql,",");        $sql .= ");";                $loop ++;        // 当loop值等于batchSize时，执行插入操作        if($loop == $batchSize){            $res = mysql_query ( $sql );            $loop = 0;            $sql = "";        }        echo $sql;    }        // 如果有950条记录，执行了前9个batch，剩余50条也应当执行    if($loop != 0){        $res = mysql_query ( $sql );    }}/** * 创建插入sql的语句 * * @access public * @param *            tableName * @param *            columnArray * @return string */function CreateInsertStatement($testcases, $title, $description, $steps, $e_result, $af_id) {    $sql = "insert into ".$testcases."(";    foreach ( $title, $description, $steps, $e_result, $af_id as $c ) {        $sql .= "" . $c . ",";    }    $sql = trimEnd ( $sql, "," );    $sql .= ") values";    return $sql;}/** * 移除字符串中指定的尾部字符 * * @access public * @param *            str * @param *            strEnd * @return string */function trimEnd($str, $strEnd) {    return substr ( $str, - (strlen ( $strEnd )) ) == $strEnd ? substr ( $str, 0, strlen ( $str ) - strlen ( $strEnd ) ) : $str;}?><img src="wait.gif"/><br /><?phpmysqli_close($mysqli);	include "footer.php";