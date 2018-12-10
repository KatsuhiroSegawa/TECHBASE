<?php
session_start();

// ログイン状態でページに入ってきた時の処理
if(isset($_SESSION[NAME]))
{
	header("Location:top.php");
	exit();
}

// ログイン処理
$errorMessage = "";
if (isset($_POST["login"]))
{
	if (empty($_POST["name"]))
		$errorMessage = "ユーザー名が未入力です。";
	else if (empty($_POST["password"]))
		$errorMessage = "パスワードが未入力です。";
	else
	{
		try
		{
			// 接続
			$dsn='データベース';
			$user='ユーザー名';
			$password='パスワード';
			$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
			
			$name = $_POST["name"];
			$pppassword = $_POST["password"];
			$stmt = $pdo->prepare("SELECT * FROM UserTable WHERE name = ?");
			$stmt->execute(array($name));
			$userData = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($userData[name] === $name) 
			{
				if ($userData[password] === $pppassword) //パスワードの一致を確認
				{
					if((int)$userData[comfirm] === 1)
					{
						$_SESSION[NAME] = $userData[name];
						header("Location: top.php"); // メイン画面へ遷移
						exit();  // 処理終了
					}
					else if((int)$userData[comfirm] === 0)
						$errorMessage="認証してください。";
					else
						$errorMessage="認証エラー";
				}
				else
			    	$errorMessage = "パスワードに誤りがあります。";
			}
			else
				$errorMessage = "ユーザー名に誤りがあります。";
		}
		catch (PDOException $e)
		{
			$errorMessage = "データベースエラー";
			// $errorMessage = $sql;
			// echo $e->getMessage();
		}
	}
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログイン</title>
<link rel="stylesheet" href="stylesheet.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include ("header.php"); ?>
<main class="main">
	<div class="title"><h2>ログイン画面</h2></div>
	<form class="form" name="loginForm" action="" method="POST">
		<fieldset class="field">
			<div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
			<table>
				<tr>
					<td><label for="userid">ユーザー名</label></td>
					<td><input type="text" id="name" name="name" placeholder="ユーザー名を入力" 
					value="<?php if (!empty($_POST["name"])) echo htmlspecialchars($_POST["name"], ENT_QUOTES); ?>"></td>
				</tr>
				<tr>
					<td><label for="password">パスワード</label></td>
					<td><input type="password" id="password" name="password" value="" placeholder="パスワードを入力"></td>
				</tr>
				<tr>
					<td><input type="submit" id="login" name="login" value="ログイン"></td>
				</tr>
			</table>
		</fieldset>
	</form>
</main>
<?php include ("footer.php"); ?>
</body>
</html>