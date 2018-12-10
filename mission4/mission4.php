<html>
<meta charset="UTF-8">
<title>Sample BBS</title>
<body>

<form action="mission4.php" method="post">

名前<br>
<input type="text" name="name">
<br>コメント<br>
<input type="text" name="comment">
<br>パスワード<br>
<input type="text" name="pass">
<br>
<input type="submit" value="送信">
<br>

</form>


<?php

// MySQLに接続
$dsn='データベース';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);


// テーブル作成
$sql="CREATE TABLE SampleBBS(number int PRIMARY KEY NOT NULL AUTO_INCREMENT, name char(32), comment text, date text, pass text)";
$result=$pdo->query($sql);


// 投稿の書き込み
if( (($_POST[name] != NULL) && ($_POST[comment] != NULL)) && $_POST[pass] != NULL )
{
	$sql = $pdo -> prepare("INSERT INTO SampleBBS VALUES(:number,:name,:comment,:date,:pass)");
	
	$sql -> bindValue(':number', null, PDO::PARAM_NULL);
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':date', $date, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	
	$name = $_POST[name];
	$comment = $_POST[comment];
	$date = date("Y/n/j G:i:s");
	$pass = $_POST[pass];
	
	$sql -> execute();
}


// 投稿の表示
$display = "SELECT*FROM SampleBBS ORDER BY number ASC";
$result = $pdo->query($display);
foreach($result as $row)
{
	echo $row[number]." ";
	echo $row[name]." ";
	echo $row[comment]." ";
	echo $row[date]."<br>";
}


?>


<br><br>
<a href="mission4.php">新規投稿フォーム</a>|
<a href="mission4_delete.php">投稿削除フォーム</a>|
<a href="mission4_edit.php">投稿編集フォーム</a>

</body>
</html>