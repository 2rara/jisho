<!DOCTYPE html>
<html>
<head>
	<meta charset = “UTF-8”>
	<title>ノルウェー語・日本語辞書</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<h1>ノルウェー語・日本語辞書</h1>
<h2>検索結果</h2>
<div class="stitch">
<?
//データベースに接続 
if (!$con = mysql_connect("localhost", "jisho", "jisho.no")) {
echo "接続エラー" ;
exit ;
}

//データベースを選択
if (!mysql_select_db("norjapdic", $con)) {
echo "データベース選択エラー" ;
exit ;
}

mysql_query('SET NAMES utf8', $con);

$nm=$_GET['nm']; 

//フォームで送られてきた条件を元にSELECT文を作成
/*綴り、発音、活用抽出*/
$sql  = "
SELECT w.SPELLING AS 'spell' 
, w.PRONUNCIATION AS 'pro' 
, ic.CONJUGATION_PATTERN AS 'con' 
FROM word w 
, irregular_conjugation ic 
WHERE 1=1 
AND w.WORD_ID = ic.WORD_ID 
AND w.SPELLING LIKE '" . $nm . "%'";

// SELECT文を実行 
if (!$res = mysql_query($sql)) {
echo "SQLエラー<BR>" ;
exit ;
}


// 検索結果表示
echo "<table border=1>" ;
echo "<tr><td>綴り</td>
<td>発音</td>
<td>品詞</td>
<td>活用</td>
</tr>" ;
while($row = mysql_fetch_array($res)){
echo "<tr>" ;
echo "<td>" . $row["spell"] . "</td>" ;
echo "<td>" . $row["pro"] . "</td>" ;
echo "<td>" . "活用" . "</td>" ; 
echo "<td>" . $row["con"] . "</td>" ; 
echo "</tr>" ;
} 
echo "</table>" ;

// 結果セットの開放
mysql_free_result ($res) ; 

// データベースから切断
mysql_close($con) ;
?>
</div>
</body>
</html>