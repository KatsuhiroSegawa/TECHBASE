<?php
session_start();
// ログイン状態か否かを確認
if(isset($_SESSION[NAME]))  $isLogin = 1;
else    $isLogin = 0;

// 接続
$dsn='データベース';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);

// 投稿の書き込み
if(isset($_POST[submit]))
{
	if( $_POST[name]!=NULL && $_POST[comment]!=NULL )
	{
		$sql = $pdo -> prepare("INSERT INTO $companyTable VALUES(:id,:name,:comment,:date)");
		
		$name = $_POST[name];
		$comment = $_POST[comment];
		$date = date("Y/n/j G:i:s");
		$sql -> bindValue(':id', NULL, PDO::PARAM_NULL);
		$sql -> bindValue(':name', $name, PDO::PARAM_STR);
		$sql -> bindValue(':comment', $comment, PDO::PARAM_STR);
		$sql -> bindValue(':date', $date, PDO::PARAM_STR);
		
		$sql -> execute();
	}
	else
		$errorMessage="コメントを入力してください。<br>";
}

if($isLogin===1)
{
	// 企業リストを取得
	$name = $_SESSION[NAME];
	$stmt1 = $pdo->prepare("SELECT * FROM UserTable WHERE name = ?");
	$stmt1->execute(array($name));
	$userCompanyList = $stmt1->fetchColumn(5);

	// 正規表現でリストを検索
	$matching = preg_match("/$companyListName/", "$userCompanyList");

	// リストに書き込み
	if(isset($_POST[listIn]))
	{
		if($matching)
		{
			$newUserCompanyList=preg_replace("/$companyListName/", " ", $userCompanyList);
			$sql="UPDATE UserTable SET list = '{$newUserCompanyList}' WHERE name = '{$name}'";
			$result=$pdo->query($sql);
		}
		else
		{
			$newUserCompanyList=$userCompanyList.",$companyListName";
			$sql="UPDATE UserTable SET list = '{$newUserCompanyList}' WHERE name = '{$name}'";
			$result=$pdo->query($sql);
		}
		// 企業リストを更新
		$stmtNo2 = $pdo->prepare("SELECT * FROM UserTable WHERE name = ?");
		$stmtNo2->execute(array($name));
		$userCompanyList = $stmtNo2->fetchColumn(5);	// 企業リスト取得
		$matching = preg_match("/$companyListName/", "$userCompanyList");
	}

	// メッセージを代入
	if($matching) $inList="リストから削除";
	else $inList="リストに追加";
}

// 投稿の表示のための変数
function h($str)
{ 
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); 
}
$display = "SELECT*FROM $companyTable ORDER BY id DESC";
$stmt = $pdo->query($display);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
(string)$allComment = "";
foreach($result as $row)
{
	// エスケープ処理
	$name = h($row[name]);
	$comment = h($row[comment]);
	// 改行文字を処理
	$comment = nl2br($comment);
	// 全投稿を変数に代入
	$allComment .= "<div class='commentTable'>
		<ul><li class='id'>$row[id]</li><li class='username'>$name</li><li class='date'>$row[date]</li></ul>";
	$allComment .= "<div class='comment'>$comment</div></div>";
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?php echo $companyName; ?></title>
<link rel="stylesheet" href="../stylesheet.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include ("../header.php"); ?>
<main>
<div class="companyPage">
	<div class="name">
		<h2><?php echo $companyName; ?></h2>
	</div>
	<div class="companyLink">
		<a href="<?php echo $companyUrl; ?>" target="_blank">企業のウェブサイトを開く</a>
	</div>
	<div class="companyInfo">
		<p>企業情報</p>
		<table>
		<tr><td>業種</td><td><?php echo $business; ?></td></tr>
		<tr><td>売上高</td><td><?php echo $sales; ?>百万円</td></tr>
		<?php if($ordinary === 0) : ?>
		<tr><td>営業利益</td><td><?php echo $profit; ?>百万円</td></tr>
		<tr><td>営業利益率</td><td><?php echo $profitRatio; ?>％</td></tr>
		<?php elseif($ordinary ===1) : ?>
		<tr><td>経常利益</td><td><?php echo $profit; ?>百万円</td></tr>
		<tr><td>経常利益率</td><td><?php echo $profitRatio; ?>％</td></tr>
		<?php endif; ?>
		<?php if($foreignSalesRatio !== "nodata"): ?>
		<tr><td>海外売上高比率</td><td><?php echo $foreignSalesRatio; ?>％</td></tr>
		<?php endif; ?>
		<tr><td>平均年収</td><td><?php echo $aveIncome; ?>千円</td></tr>
		<tr><td>平均年齢</td><td><?php echo $aveAge; ?>歳</td></tr>
		</table>
	</div>
	<div class="listButton">
		<?php if($isLogin===1) : ?>
		<form name='isInList' action='' method='post'>
		<button name='listIn'><?php echo $inList; ?></button>
		</form>
		<?php endif; ?>
	</div>
	<div class="commentArea">
		<p>コメント欄</p>
		<div class="commentAll">
			<?php if($result) : ?>
			<?php echo $allComment; ?>
			<?php else : ?>
			<p>コメントがありません</p>
			<?php endif; ?>
		</div>
	</div>
	<div class="commentForm">
		<?php if($isLogin===1) : ?>
		<form action="" method="post">
		<?php echo $errorMessage; ?>
		<input type="hidden" name="name" value="<?php echo $_SESSION[NAME]; ?>">
		<p>コメント(200字以下で入力してください)</p>
		<p><textarea name="comment" rows="5" cols="40"></textarea></p>
		<p><input type="submit" name="submit" value="送信"></p>
		</form>
		<?php elseif($isLogin===0) : ?>
		<p><a href="../login.php">コメントするにはログインしてください</a></p>
		<?php endif; ?>
	</div>
</div>
</main>
<?php include ("../footer.php"); ?>
</body>
</html>