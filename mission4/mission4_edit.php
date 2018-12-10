<html>
<meta charset="UTF-8">
<title>Sample BBS edit</title>

<body>


<?php

// フォーム切り替えのための変数
$number=0;
if($_POST[number]!=NULL)
	$number=$_POST[number];
$enumber=0;
if($_POST[enumber]!=NULL)
	$enumber=$_POST[enumber];
$epass;
if($_POST[pass]!=NULL)
	$epass=$_POST[pass];


// 編集番号入力フォーム表示
if($number==0 && $enumber==0)
{
	echo "<form action='mission4_edit.php' method='post'>";
	echo "編集対象番号<br>";
	echo "<input type='text' name='number'>";
	echo "<br>パスワード<br>";
	echo "<input type='text' name='pass'><br>";
	echo "<input type='submit' value='送信'></form>";
	echo "編集対象番号を入力してください。";
}


// パスワード未入力
else if($number!=0 && $epass==NULL)
{
	echo "<form action='mission4_edit.php' method='post'>";
	echo "編集対象番号<br>";
	echo "<input type='text' name='number'>";
	echo "<br>パスワード<br>";
	echo "<input type='text' name='pass'><br>";
	echo "<input type='submit' value='送信'></form>";
	echo "パスワードを入力してください。<br>";
}


else if($number!=0 && $epass!=NULL)
{
	// 接続
	$dsn='データベース';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO($dsn,$user,$password);
	
	
	// 投稿取得
	$sql = "SELECT*FROM SampleBBS WHERE number = $number";
	$result = $pdo->query($sql);
	foreach($result as $row)
	{
		$name = $row[name];
		$comment = $row[comment];
		$date = $row[date];
		$pass = $row[pass];
	}
	
	if($name==NULL)
	{
		echo "<form action='mission4_edit.php' method='post'>";
		echo "編集対象番号<br>";
		echo "<input type='text' name='number'>";
		echo "<br>パスワード<br>";
		echo "<input type='text' name='pass'><br>";
		echo "<input type='submit' value='送信'></form>";
		echo "存在しない投稿です。";
	}
	else if($pass!=$epass)
	{
		echo "<form action='mission4_edit.php' method='post'>";
		echo "編集対象番号<br>";
		echo "<input type='text' name='number'>";
		echo "<br>パスワード<br>";
		echo "<input type='text' name='pass'><br>";
		echo "<input type='submit' value='送信'></form>";
		echo "パスワードが違います。";
	}
	else
	{
		echo "<form action='mission4_edit.php' method='post'>";
		echo "<input type='hidden' name='enumber' value=$number>";
		echo "名前<br>";
		echo "<input type='text' name ='ename' value='$name'>";
		echo "<br>コメント<br>";
		echo "<input type='text' name='ecomment' value='$comment'>";
		echo "<br><input type='submit' value='送信'>";
		echo "<br></form>";
	}
}

if($number==0 && $enumber!=0)
{
	// 接続
	$dsn='データベース';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO($dsn,$user,$password);
	
	// 投稿の編集
	$number=$_POST[enumber];
	$name=$_POST[ename];
	$comment=$_POST[ecomment];
	$sql="UPDATE SampleBBS SET name = '$name',comment = '$comment' WHERE number=$number";
	$result=$pdo->query($sql);
	
	echo "編集しました<br><br>";
	
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
}


?>


<br><br>
<a href="mission4.php">新規投稿フォーム</a>|
<a href="mission4_delete.php">投稿削除フォーム</a>|
<a href="mission4_edit.php">投稿編集フォーム</a>

</body>
</html>