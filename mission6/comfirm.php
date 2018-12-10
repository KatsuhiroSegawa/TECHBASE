<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>メール認証</title>
<link rel="stylesheet" href="stylesheet.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php include ("header.php"); ?>


<?php
session_start();

// リンク要phpファイル作成
$id=$_SESSION[id];
$filename="comfirm/comfirmUrlId{$id}.php";
$expiry=time()+24*60*60;  // 有効期限を設定
$fp=fopen($filename, "w");
$text="<?php include('htmlInfo.html'); \$id=$id; \$expiry=$expiry; include('changeComfirm.php');  ?>";
fwrite($fp,$text);
fclose($fp);


mb_language("Japanese");
mb_internal_encoding("UTF-8");
$to = $_SESSION[mailaddress];
$title = "メール認証";
$message = "$_SESSION[name]さん(id:$_SESSION[id])、以下のリンクをクリックして認証してください\n";
$url="http://tt-573.99sv-coco.com/".$filename;
$message2 = "\n上記のリンクは24時間有効です。";
$content=$message.$url.$message2;


if($_SESSION[mailaddress])
{
	if(mb_send_mail($to, $title, $content))
	{
		echo "以下のメールアドレスに認証用URLを送信しました";
		echo "<br>";
		echo $_SESSION[mailaddress];
	}
	else
		echo "メールの送信に失敗しました";
}
else
	echo "SESSION[mailaddress]が未定義";

?>

<?php include ("footer.php"); ?>

</body>
</html>