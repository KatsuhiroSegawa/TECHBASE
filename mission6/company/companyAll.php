<?php
session_start();
$exeption1 = "companyAdd.php";
$exeption2 = "companyAll.php";
$exeption3 = "companyFormat.php";
$exeption4 = "companyTableControll.php";
$url = glob("*");
(string)$list = ""."\n";
// 全企業のリストを取得
for($i=0; $i<count($url); $i++)
{
    if(($url[$i] !== $exeption1 && $url[$i] !== $exeption2) && ($url[$i] !== $exeption3 && $url[$i]!== $exeption4))
    {
        include_once("$url[$i]");
        $list = $list."<li><a href='{$url[$i]}'>$companyName</a></li>"."\n";
    }
}
// 企業数
$count = count($url)-4;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>企業ページ一覧</title>
<link rel="stylesheet" href="../stylesheet.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include ("../header.php"); ?>
<main>
<div class="title"><h2>企業ページ一覧</h2></div>
<div class="companyAllList">
<p>全<?php echo $count; ?>社</p>
<ul><?php echo $list; ?>
</ul>
</div>
</main>
<?php include ("../footer.php"); ?>
</body>
</html>