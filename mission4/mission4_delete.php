<html>
<meta charset="UTF-8">
<title>Sample BBS delete</title>
<body>

<form method="post" action="mission4_delete.php">

削除対象番号<br>
<input type="text" name="dnumber">
<br>パスワード<br>
<input type="text" name="dpass"><br>
<input type="submit" value="送信">

</form>


<?php

$dnumber=$_POST[dnumber];
$dpass=$_POST[dpass];

if($dnumber==NULL)
	echo "削除対象番号を入力してください。";
else if($dpass==NULL)
	echo "パスワードを入力してください。";

else
{
	// 接続
	$dsn='データベース';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO($dsn,$user,$password);
	
	
	// 投稿を取得
	$sql="SELECT*FROM SampleBBS WHERE number = $dnumber";
	$result=$pdo->query($sql);
	foreach($result as $row)
	{
		$number=$row[number];
		$pass=$row[pass];
	}
	
	if($number==NULL)
		echo "存在しない投稿です。";
	else if($pass!=$dpass)
		echo "パスワードが違います。";
	else
	{
		// 投稿の削除
		$dnumber=$_POST[dnumber];
		$sql="DELETE FROM SampleBBS WHERE number=$dnumber";
		$result=$pdo->query($sql);
		
		echo "削除しました。<br>";
		
		// 投稿の表示
		$display = 'SELECT*FROM SampleBBS ORDER BY number ASC';
		$result = $pdo->query($display);
		foreach($result as $row)
		{
			echo $row[number]." ";
			echo $row[name]." ";
			echo $row[comment]." ";
			echo $row[date]."<br>";
		}
	}
}

?>


<br><br>
<a href="mission4.php">新規投稿フォーム</a>|
<a href="mission4_delete.php">投稿削除フォーム</a>|
<a href="mission4_edit.php">投稿編集フォーム</a>

</body>
</html>