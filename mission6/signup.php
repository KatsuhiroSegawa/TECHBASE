<?php
session_start();

// ログイン状態でページに入ってきた時の処理
if(isset($_SESSION[NAME]))
{ header("Location:top.php"); exit(); }

// フォームにユーザー名を再表示するための変数
if (!empty($_POST["name"])) $escText = htmlspecialchars($_POST["name"], ENT_QUOTES);

// フォームから受け取った情報を確認
if (isset($_POST["signup"]))
{
	if (empty($_POST["name"]))
		$errorMessage = "ユーザー名が未入力です。";
	else if (empty($_POST["mailaddress"]))
		$errorMessage = "メールアドレスが未入力です。";
	else if (empty($_POST["password"]))
		$errorMessage = "パスワードが未入力です。";
	else if (!preg_match('/\A[a-z\d]{8,100}+\z/i', $_POST["password"]))
		$errorMessage = "パスワードは英数字８文字以上に設定してください。";
	else
	{
		try
		{
			// 接続
			$dsn='データベース';
			$user='ユーザー名';
			$password='パスワード';
			$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

			//ユーザーネームの重複を確認
			$username = $_POST[name];
			$checkSql = "SELECT count(*) FROM UserTable WHERE name = '{$username}'";
			$count = (int)$pdo->query($checkSql)->fetchColumn();
			if ($count > 0)
				$errorMessage = 'そのユーザー名は既に使用されています';
			else
			{
				// レコード挿入
				$sql = $pdo -> prepare("INSERT INTO UserTable VALUES(:id,:name,:mailaddress,:password,:comfirm,:list)");
				$sql -> bindValue(":id", null, PDO::PARAM_NULL);
				$sql -> bindValue(":name", $_POST[name], PDO::PARAM_STR);
				$sql -> bindValue(":mailaddress", $_POST[mailaddress], PDO::PARAM_STR);
				$sql -> bindValue(":password", $_POST[password], PDO::PARAM_STR);
				$sql -> bindValue(":comfirm", 1, PDO::PARAM_INT);
				$sql -> bindValue(":list", null, PDO::PARAM_NULL);
				$sql -> execute();
				
				// 新規登録したユーザーのidを取得
				$stmt = $pdo -> prepare("SELECT * FROM UserTable ORDER BY id DESC");
				$stmt -> execute();
				$row = $stmt -> fetch(PDO::FETCH_ASSOC);
				
				// セッション変数に入れてメール送信phpに移動
				$_SESSION[id]=$row[id];
				$_SESSION[name]=$_POST[name];
				$_SESSION[mailaddress]=$_POST[mailaddress];
				header("Location: comfirm.php");
				exit();  // 処理終了
			}
		}
		catch (PDOException $e)
		{
			$errorMessage = 'データベースエラー';
			//$e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
			// echo $e->getMessage();
		}
	}
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>新規登録</title>
<link rel="stylesheet" href="stylesheet.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include ("header.php"); ?>
<main>
	<div class="title"><h2>新規登録</h2></div>
	<form class="form" name="signupForm" action="" method="POST">
		<fieldset class="field">
			<div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
			<table>
				<tr>
					<td><label for="name">ユーザー名</label></td>
					<td><input type="text" name="name" placeholder="ユーザー名を入力" value="<?php echo $escText; ?>"></td>
				</tr>
				<tr>
					<td><label for="mailaddress">メールアドレス</label></td>
					<td><input type="text" name="mailaddress" placeholder="メールアドレスを入力"></td>
				</tr>
				<tr>
					<td><label for="password">パスワード</label></td>
					<td><input type="password" name="password" value="" placeholder="パスワードを入力"></td>
				</tr>
				<tr>
					<td><input type="submit" name="signup" value=" 登録 "></td>
				</tr>
			</table>
		</fieldset>
	</form>
</main>
<?php include ("footer.php"); ?>
</body>
</html>