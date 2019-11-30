<!DOCTYPE html>
<html>
<head>
	<meta charset = “UTF-8”>
	<title>ノルウェー語・日本語辞書</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<h1>ノルウェー語・日本語辞書</h1>

<?
// エスケープ処理
function escape($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}
	$searchword=escape($_GET['searchword']); 
?>
	<h2>検索文字列：<? echo $searchword ?></h2><h4>(空白の場合は未登録)</h4>
<div class="stitch">
<?
require('app/init.php'); 

// 検索結果の件数を表示
$count  = "
SELECT count(WORD_ID)
FROM word
WHERE 1=1 
AND SPELLING LIKE (:searchword)";

$stmt = $dbh->prepare($count);
	
	if($statement){
		$like_searchword = $searchword."%";
		//プレースホルダへ実際の値を設定する
		$stmt->bindValue(':searchword',$like_searchword,PDO::PARAM_STR);
		if($stmt->execute()){
			//レコード件数取得
		echo $stmt;
		}

 
//フォームで送られてきた条件を元にSELECT文を作成
/*綴り、発音、活用抽出*/
$sql  = "
SELECT w.WORD_ID AS 'id' 
, w.SPELLING AS 'spell' 
, w.PRONUNCIATION AS 'pro' 
, ic.CONJUGATION_PATTERN AS 'con' 
FROM word w 
, irregular_conjugation ic 
WHERE 1=1 
AND w.WORD_ID = ic.WORD_ID 
AND w.SPELLING LIKE ?";

$stmt = $dbh->prepare($sql);

	$stmt->bindValue(1,$searchword,PDO::PARAM_STR);
    $res=$stmt->execute();

// SELECT文を実行 
// if (!$res = mysql_query($sql)) {
if (!$res) {
echo "SQLエラー<BR>" ;
exit ;
}
echo $res;
// 検索結果表示
echo "<table border=1>" ;
echo "<tr><td>綴り</td>
<td>発音</td>
<td>品詞</td>
<td>活用</td>
<td>意味・例文</td>
</tr>" ;
while($row = mysql_fetch_array($res)){
/*品詞1抽出*/
$sql  = "
SELECT pos.PART_OF_SPEECH AS 'pos1'
FROM word w
, part_of_speech pos
WHERE 1=1
AND w.PART_OF_SPEECH_A_ID = pos.PoS_ID
AND w.WORD_ID = '" . $row["id"] . "'";

// SELECT文を実行 
if (!$posres1 = mysql_query($sql)) {
echo "SQLエラー<BR>" ;
exit ;
}

$posres1 = mysql_fetch_array($posres1);

/*品詞2抽出*/
$sql  = "
SELECT pos.PART_OF_SPEECH AS 'pos2'
FROM word w
, part_of_speech pos
WHERE 1=1
AND w.PART_OF_SPEECH_B_ID = pos.PoS_ID
AND w.WORD_ID = '" . $row["id"] . "'";

// SELECT文を実行 
if (!$posres2 = mysql_query($sql)) {
echo "SQLエラー<BR>" ;
exit ;
}

$posres2 = mysql_fetch_array($posres2);

/*品詞3抽出*/
$sql  = "
SELECT pos.PART_OF_SPEECH AS 'pos3'
FROM word w
, part_of_speech pos
WHERE 1=1
AND w.PART_OF_SPEECH_C_ID = pos.PoS_ID
AND w.WORD_ID = '" . $row["id"] . "'";

// SELECT文を実行 
if (!$posres3 = mysql_query($sql)) {
echo "SQLエラー<BR>" ;
exit ;
}

$posres3 = mysql_fetch_array($posres3);

/*品詞4抽出*/
$sql  = "
SELECT pos.PART_OF_SPEECH AS 'pos4'
FROM word w
, part_of_speech pos
WHERE 1=1
AND w.PART_OF_SPEECH_D_ID = pos.PoS_ID
AND w.WORD_ID = '" . $row["id"] . "'";

// SELECT文を実行 
if (!$posres4 = mysql_query($sql)) {
echo "SQLエラー<BR>" ;
exit ;
}

$posres4 = mysql_fetch_array($posres4);

/*品詞5抽出*/
$sql  = "
SELECT pos.PART_OF_SPEECH AS 'pos5'
FROM word w
, part_of_speech pos
WHERE 1=1
AND w.PART_OF_SPEECH_E_ID = pos.PoS_ID
AND w.WORD_ID = '" . $row["id"] . "'";

// SELECT文を実行 
if (!$posres5 = mysql_query($sql)) {
echo "SQLエラー<BR>" ;
exit ;
}

$posres5 = mysql_fetch_array($posres5);


/*意味抽出*/
$sql  = "
SELECT d.DEFINITION AS 'def'
, d.EXAMPLE_SENTENCE_01_ID AS 'eid1'
, d.EXAMPLE_SENTENCE_02_ID AS 'eid2'
, d.EXAMPLE_SENTENCE_03_ID AS 'eid3'
, d.EXAMPLE_SENTENCE_04_ID AS 'eid4'
, d.EXAMPLE_SENTENCE_05_ID AS 'eid5'
, d.EXAMPLE_SENTENCE_06_ID AS 'eid6'
, d.EXAMPLE_SENTENCE_07_ID AS 'eid7'
, d.EXAMPLE_SENTENCE_08_ID AS 'eid8'
, d.EXAMPLE_SENTENCE_09_ID AS 'eid9'
, d.EXAMPLE_SENTENCE_10_ID AS 'eid10'
, d.EXAMPLE_SENTENCE_11_ID AS 'eid11'
, d.EXAMPLE_SENTENCE_12_ID AS 'eid12'
, d.EXAMPLE_SENTENCE_13_ID AS 'eid13'
, d.EXAMPLE_SENTENCE_14_ID AS 'eid14'
, d.EXAMPLE_SENTENCE_15_ID AS 'eid15'
, d.EXAMPLE_SENTENCE_16_ID AS 'eid16'
, d.EXAMPLE_SENTENCE_17_ID AS 'eid17'
, d.EXAMPLE_SENTENCE_18_ID AS 'eid18'
, d.EXAMPLE_SENTENCE_19_ID AS 'eid19'
, d.EXAMPLE_SENTENCE_20_ID AS 'eid20'
, d.EXAMPLE_SENTENCE_21_ID AS 'eid21'
, d.EXAMPLE_SENTENCE_22_ID AS 'eid22'
, d.EXAMPLE_SENTENCE_23_ID AS 'eid23'
, d.EXAMPLE_SENTENCE_24_ID AS 'eid24'
, d.EXAMPLE_SENTENCE_25_ID AS 'eid25'
, d.EXAMPLE_SENTENCE_26_ID AS 'eid26'
, d.EXAMPLE_SENTENCE_27_ID AS 'eid27'
, d.EXAMPLE_SENTENCE_28_ID AS 'eid28'
, d.EXAMPLE_SENTENCE_29_ID AS 'eid29'
, d.EXAMPLE_SENTENCE_30_ID AS 'eid30'
FROM definition d
WHERE 1=1
AND d.WORD_ID LIKE '" . $row["id"] . "%'";


// SELECT文を実行 
if (!$def = mysql_query($sql)) {
echo "SQLエラー<BR>" ;
exit ;
}


echo "<tr>" ;
echo "<td>" . $row["spell"] . "</td>" ;
echo "<td>" . $row["pro"] . "</td>" ;
echo "<td>" . $posres1["pos1"] . " " . $posres2["pos2"] . " " . $posres3["pos3"] . " " . $posres4["pos4"] . " " . $posres5["pos5"] . "</td>" ; 
echo "<td>" . $row["con"] . "</td>" ; 
echo "<td>
		<table border=1>";
			while($defrow = mysql_fetch_row($def)){
			echo "<tr>" ;
				echo "<td>" . $defrow[0] . "</td>" ;

				for($i = 1; $i < 31; $i++){
				
				if($defrow[$i]!=""){
				/*例抽出*/
				$sql  = "
				SELECT e.EXAMPLE_SENTENCE AS 'ex'
				, e.EXAMPLE_SENTENCE_JPN AS 'exj'
				FROM example e
				WHERE 1=1
				AND e.EXAMPLE_ID = '" . $defrow[$i] . "'";
				
				// SELECT文を実行 
				if (!$ex = mysql_query($sql)) {
				echo "SQLエラー<BR>" ;
				exit ;
				}
				$ex = mysql_fetch_array($ex);

				echo "<td>" . $ex["ex"] . " / " . $ex["exj"] . "</td>" ;
				}
			}
			echo "</tr>" ;
		}
		echo "</table>" ;
echo "</td>";
} 
echo "</table>" ;


/*
// 結果セットの開放
mysql_free_result ($res) ; 

// データベースから切断
mysql_close($con) ;
*/
$dbh = null;
?>
</div>
</body>
</html>