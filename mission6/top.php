<?php
session_start();
// 企業ページ一覧から除外するファイル
$exeption1 = "company/companyAdd.php";
$exeption2 = "company/companyAll.php";
$exeption3 = "company/companyFormat.php";
$exeption4 = "company/companyTableControll.php";
// 業界ごとに変数を用意し初期化
(string)$kinyuu = "";
(string)$shosha = "";
(string)$koukoku = "";
(string)$jidosha = "";
(string)$kikiki = "";
(string)$kagaku = "";
(string)$iyakuhin = "";
(string)$shokuhin = "";
(string)$kouri = "";
(string)$koukuu = "";
(string)$tetudo = "";
(string)$it = "";
(string)$service = "";
(string)$others = "";
$url = glob("company/*");
for($i=0; $i<count($url); $i++)
{
	if(($url[$i] !== $exeption1 && $url[$i] !== $exeption2) && ($url[$i] !== $exeption3 && $url[$i] !== $exeption4))
	{
		// 企業ページから変数を取得
		include_once("$url[$i]");
		$businessList[$i] = $business;
		$linkList[$i] = "<li><a href='{$url[$i]}'>$companyName</a></li>";
	}
	// 業種別に表示するための変数を用意
	if ($businessList[$i]=="金融") $kinyuu .= $linkList[$i];
	else if($businessList[$i]=="総合商社") $shosha .= $linkList[$i];
	else if($businessList[$i]=="広告") $koukoku .= $linkList[$i];
	else if($businessList[$i]=="自動車") $jidosha .= $linkList[$i];
	else if($businessList[$i]=="電気機器") $kikiki .= $linkList[$i];
	else if($businessList[$i]=="化学") $kagaku .= $linkList[$i];
	else if($businessList[$i]=="医薬品") $iyakuhin .= $linkList[$i];	
	else if($businessList[$i]=="食料品") $shokuhin .= $linkList[$i];
	else if($businessList[$i]=="小売業") $kouri .= $linkList[$i];
	else if($businessList[$i]=="航空") $koukuu .= $linkList[$i];
	else if($businessList[$i]=="鉄道") $tetudo .= $linkList[$i];
	else if($businessList[$i]=="情報・通信業") $it .= $linkList[$i];
	else if($businessList[$i]=="サービス業") $service .= $linkList[$i];
	else $others .= $linkList[$i];

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>企業研究掲示板</title>
<link rel="stylesheet" href="stylesheet.css">
</head>
<body class="top">
<?php include_once("header.php"); ?>
<main class="main">
	<div class="title">
		<h2>企業一覧（業種別）</h2>
	</div>
	<div class="companyList-business">
		<div class="business"><p>金融</p><ul><?php echo $kinyuu; ?></ul></div>
		<div class="business"><p>商社</p><ul><?php echo $shosha; ?></ul></div>
		<div class="business"><p>広告</p><ul><?php echo $koukoku; ?></ul></div>
		<div class="business"><p>自動車</p><ul><?php echo $jidosha; ?></ul></div>
		<div class="business"><p>電気機器</p><ul><?php echo $kikiki; ?></ul></div>
		<div class="business"><p>化学</p><ul><?php echo $kagaku; ?></ul></div>
		<div class="business"><p>医薬品</p><ul><?php echo $iyakuhin; ?></ul></div>
		<div class="business"><p>食品</p><ul><?php echo $shokuhin; ?></ul></div>
		<div class="business"><p>小売</p><ul><?php echo $kouri; ?></ul></div>
		<div class="business"><p>航空</p><ul><?php echo $koukuu; ?></ul></div>
		<div class="business"><p>鉄道</p><ul><?php echo $tetudo; ?></ul></div>
		<div class="business"><p>情報・通信</p><ul><?php echo $it; ?></ul></div>
		<div class="business"><p>サービス業</p><ul><?php echo $service; ?></ul></div>
		<div class="business"><p>未分類</p><ul><?php echo $others; ?></ul></div>
		<div class="blank"> </div>
	</div>
</main>
<?php include_once("footer.php"); ?>
</body>
</html>