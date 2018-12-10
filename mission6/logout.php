<?php
session_start();

//ログインしているかどうか
if (isset($_SESSION["NAME"])) {
	$errorMessage = "ログアウトしました";
} else {
	$errorMessage = "タイムアウトしました";
}
echo $errorMessage;
//セッション変数のクリア
$_SESSION = array();
//セッションクリア
session_destroy();

header("Location: top.php");
exit();

?>