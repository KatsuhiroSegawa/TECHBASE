<?php
session_start();

// ログイン状態でページに入ってきた時の処理
if(isset($_SESSION[NAME]))
{
	header("Location:top.php");
	exit();
}

$now=time();
if($now<$expiry)  // 有効期限の確認
{
	$message="認証しました。";
	// 接続
	$dsn='データベース';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO($dsn,$user,$password);

	// comfirmを1に変更
	$sql="UPDATE UserTable SET comfirm=1 WHERE id=$id";
	$result=$pdo->query($sql);
}
else
{
	$message = "<h3>URLが無効になりました。もう一度新規登録をしてください。</h3>\n";
	$message .= "<h3>同じメールアドレスで新規登録ができます（ユーザー名は重複不可）。</h3>\n";
}
?>

<body class="top">
<?php include ("../header.php"); ?>
<main class="main">
	<div class="comfirm">
		<div class="message">
			<?php echo $message; ?>
		</div>
		<p>
			<?php if($now<$expiry): ?><a href='../login.php'>ログイン画面へ</a>
			<?php else: ?> <a href='../signup.php'>新規登録画面へ</a>
			<?php endif; ?>
		</p>
	</div>
</main>
<?php include ("../footer.php"); ?>
</body>
</html>