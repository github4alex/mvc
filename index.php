<?php

require_once("cfg/cfg.php");
require_once("model/WADB.cls.php");

include_once("view/header.php");

$db = new WADB(db_server,db_name,db_username, db_password);

if ( !empty($_GET["action"]) ) {
	switch($_GET["action"]) {
		case "add":
			if( !empty($_POST)){
				$sql = "INSERT INTO guestbook (name,email,sex,content,create_time,ip) VALUES (";
				$sql .= "'" .$_POST["name"] . "','" . $_POST["email"] . "'," . $_POST["sex"] . ",'" . $_POST["content"] ;
				$sql .= "','" . time() . "','" . $_SERVER["REMOTE_ADDR"] . "')";
				$id = $db->insertRecords($sql);
			}
			include_once("view/add.php");
			break;
		default:
			show();
	}
} else {
	show();
}

include_once("view/footer.php");

function show() {
	$sql = "SELECT * FROM guestbook ORDER BY id DESC";
	$dataSet = $GLOBALS['db']->selectRecords($sql);

/*	for ($i =0; $i < $dataSet["record"]; $i++) {
		$msg = "[" . $i . "] <br />";
		$msg .= $dataSet["data"][$i]["id"] .		" | " . $dataSet["data"][$i]["name"] . " | ";
		$msg .= $dataSet["data"][$i]["sex"] .		" | " . $dataSet["data"][$i]["email"] . " | ";
		$msg .= $dataSet["data"][$i]["content"]	.	" | " . $dataSet["data"][$i]["create_time"] . " | ";
		$msg .= $dataSet["data"][$i]["ip"] . " <hr />";
		echo $msg;
	}
*/

	if ( $dataSet["record"] > 0) {
?>
	<table><th>
				<tr>流水號</td>
				<tr>姓名</td>
				<tr>Email</td>
				<tr>性別</td>
				<tr>留言內容</td>
				<tr>留言時間</td>
				<tr>留言的IP位置</td></th>
<?php
		foreach($dataSet["data"] as $key => $value) {
?>
		<td><tr><?$value ?>
<?php			
		}
	}
	include_once("view/show.php");

}
?>