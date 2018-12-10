<?php
$companyTable = $_POST[companyTable];
$companyTable = "\$companyTable = \"{$companyTable}\";"."\n";
$companyListName = $_POST[companyListName];
$companyListName = "\$companyListName = \"{$companyListName}\";"."\n";
$companyName = $_POST[companyName];
$companyName = "\$companyName = \"{$companyName}\";"."\n";
$business = $_POST[business];
$business = "\$business = \"{$business}\";"."\n";
$ordinary = $_POST[ordinary];
if(isset($ordinary)) $ordinary = "\$ordinary = {$ordinary};"."\n";
else $ordinary = "\$ordinary = 0;"."\n";
(string)$sales = $_POST[sales];
$sales = "\$sales = \"{$sales}\";"."\n";
(string)$profit = $_POST[profit];
$profit = "\$profit = \"{$profit}\";"."\n";
(string)$profitRatio = $_POST[profitRatio];
$profitRatio = "\$profitRatio = \"{$profitRatio}\";"."\n";
(string)$foreignSalesRatio = $_POST[foreignSalesRatio];
$foreignSalesRatio = "\$foreignSalesRatio = \"{$foreignSalesRatio}\";"."\n";
(string)$aveIncome = $_POST[aveIncome];
$aveIncome = "\$aveIncome = \"{$aveIncome}\";"."\n";
(string)$aveAge = $_POST[aveAge];
$aveAge = "\$aveAge = \"{$aveAge}\";"."\n";
(string)$companyUrl = $_POST[companyUrl];
$companyUrl = "\$companyUrl = \"{$companyUrl}\";"."\n";
$include = 'if(empty($url)) include_once("companyFormat.php");';

$string = $companyTable.$companyListName.$companyName.$business.$ordinary;
$text = '<?php'."\n".$string.$sales.$profit.$profitRatio.$foreignSalesRatio.$aveIncome.$aveAge.$companyUrl.$include."\n".'?>';

if(isset($_POST[submit]))
{
    $filename = $_POST[companyListName].".php";
    $fp = fopen($filename, "w");
    fwrite($fp,$text);
    fclose($fp);

    $message = "ページを作成しました<br>";
    $link = "<a href='{$filename}'>リンク</a>";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>企業ページ追加</title>
</head>
<body>
<?php echo $message.$link; ?>
<form name="addCompany" action="" method="POST">
    <fieldset>
        <legend>企業追加</legend>
        <input type="text" name="companyTable" required placeholder="companyTable"><br>
        <input type="text" name="companyListName" required placeholder="companyListName"><br>
        <input type="text" name="companyName" required placeholder="companyName"><br>
        <input type="text" name="business" required placeholder="business"><br>
        <input type="checkbox" name="ordinary" value="1">ordinaryProfit<br>
        <input type="text" name="sales" required placeholder ="sales"><br>
        <input type="text" name="profit" required placeholder ="profit"><br>
        <input type="text" name="profitRatio" required placeholder ="profitRatio"><br>
        <input type="text" name="foreignSalesRatio" required placeholder="foreignSalesRatio"><br>
        <input type="text" name="aveIncome" required placeholder ="aveIncome"><br>
        <input type="text" name="aveAge" required placeholder ="aveAge"><br>
        <input type="text" name="companyUrl" required placeholder="companyUrl"><br>
        <input type="submit" name="submit" value="企業ページを作成">
    </fieldset>
</form>
</body>
</html>