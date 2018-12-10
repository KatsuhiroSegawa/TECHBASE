<?php

// 接続
$dsn='データベース';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);

// 変数宣言
$exeption1 = "companyAdd.php";
$exeption2 = "companyAll.php";
$exeption3 = "companyFormat.php";
$exeption4 = "companyTableControll.php";

// 企業テーブルを一括作成
$id = "id int PRIMARY KEY NOT NULL AUTO_INCREMENT";
$name = "name char(32) NOT NULL";
$comment = "comment char(200) NOT NULL";
$date = "date char(32) NOT NULL";
$url = glob("*");
for($i=0; $i<count($url); $i++)
{
	if(($url[$i] !== $exeption1 && $url[$i] !== $exeption2) && ($url[$i] !== $exeption3 && $url[$i]!== $exeption4))
	{
		// テーブル一括作成の機構
		include_once("$url[$i]");
		$tableName = $companyTable;
		$sql="CREATE TABLE $tableName($id, $name, $comment, $date)";
		$check = $pdo->query($sql);
		
		// listの一括変更のための機構
		if($i===0) $companyList = "'{$companyListName}'";
		else $companyList = "{$companyList},'{$companyListName}'";
	}
}
var_dump($check);
echo "テーブルを一括作成しました。<hr>";

// UserTableのlistを一括変更
$sql = "ALTER TABLE UserTable CHANGE list list SET($companyList)";
$reslutA = $pdo->query($sql);
echo "UserTableのlistを一括変更しました。<hr>";

// テーブル一覧
$sql="SHOW TABLES";
$result=$pdo->query($sql);
foreach($result as $row)
{
	echo $row[0];
	echo "<br>";
}
echo "<hr>";

// UserTableの構成を表示
$sql='SHOW CREATE TABLE UserTable';
$result=$pdo->query($sql);
echo "<p>テーブル構成</p>";
foreach($result as $row)
	{
	echo ($row[1]);
	echo "<br>";
	}
echo "<hr>";

?>