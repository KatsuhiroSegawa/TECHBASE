<?php
session_start();

// ログアウト状態でページに入ってきた時の処理
if(!isset($_SESSION[NAME]))
{
	header("Location:top.php");
	exit();
}

// 接続
$dsn='データベース';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);

// 企業リストを取得
$stmt = $pdo->prepare("SELECT * FROM UserTable WHERE name = ?");
$stmt->execute(array($_SESSION[NAME]));
$userCompanyList = $stmt->fetchColumn(5);
$companies=explode(",",$userCompanyList);

// 企業ページ内includeを回避するための変数
$url = "url";
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>マイページ</title>
<link rel="stylesheet" href="stylesheet.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php include ("header.php"); ?>


<main>
    <div class="title"><h2>マイページ</h2></div>
    <div class="userCompanyList">
        <fieldset>
            <legend>企業リスト</legend>
            <ul class="companyList">
                <?php
                if($userCompanyList==NULL)
                {
                    echo "<p>リストに企業がありません。気になる企業をリストに追加しましょう！<p>";
                    echo "<p><a href='company/companyAll.php'>企業ページ一覧</a></p>";
                }
                else
                {
                    // リスト表示
                    for($i=0; $i<count($companies); $i++)
                    {
                        $link[$i] = "company/$companies[$i].php";
                        include_once($link[$i]);
                        $htmlList = "<li><a href='{$link[$i]}'>$companyName</a></li>";
                        echo $htmlList;
                    }
                }
                ?>
            </ul>
        </fieldset>
    </div>
</main>


<?php include ("footer.php"); ?>
</body>
</html>