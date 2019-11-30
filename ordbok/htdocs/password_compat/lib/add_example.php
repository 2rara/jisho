<?php
    if(!isset($_SESSION)) { 
		require('../../app/init.php');
    }

	// ログイン状態チェック
	if (!isset($_SESSION["NAME"])) {
		header("Location: Logout.php");
		exit;
	}
?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>メイン</title>
  </head>
  <body>
    <h1>例文追加</h1>
    <u>
      <?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>
    </u>さんとしてログイン中
    </p>
    <!-- ユーザー名をechoで表示 -->
    <p>例文を追加する単語
    </p>
    <form action = "" method = "GET">
      <input id="text" type="text" name="searchword" pattern="^[0-9A-ZÆÅØa-zæåø]+$" title="半角英数字で入力して下さい。" value="" autocomplete="off" required>
      <div id="suggest" style="display:none;" tabindex="-1"></div>
      <input type = "submit" value = "検索">
    </form>
    <!-- 検索候補表示方法の参考元：http://www.enjoyxstudy.com/javascript/suggest/ -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://www.enjoyxstudy.com/js/bootstrap.min.js"></script>
    <script src="http://www.enjoyxstudy.com/js/scripts.js"></script>
    <script src="http://www.enjoyxstudy.com/javascript/suggest/suggest.js"></script>
    <script src="../../wordlist"></script>
    <script>
      <!--
      // wondowのonloadイベントでSuggestを生成
      // (listは、list.js内で定義している)
      var start = function(){new Suggest.Local("text", "suggest", list, {dispMax: 0, dispAllKey: true, prefix: false, highlight: true});};
      window.addEventListener ?
        window.addEventListener('load', start, false) :
        window.attachEvent('onload', start);
        //-->
    </script>
    <p>追加する例文（ノルウェー語）
    </p>
    <form>
      <input id="text" type="text" required>
      <input type = "submit" value = "追加">
    </form>
    <p>追加する例文（日本語）
    </p>
    <form>
      <input id="text" type="text" required>
      <input type = "submit" value = "追加">
    </form>
    <p>見つかった文
    </p><?
// 半角英数チェック
function is_alnum($text) {
    if (preg_match("/^[0-9A-ZÆÅØa-zæåø]+$/",$text)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// エスケープ処理
function escape($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

 if(!empty($_GET['searchword'])){
	$searchword=$_GET['searchword'];
	if(is_alnum($searchword)){
		$searchword=escape($searchword);

//フォームで送られてきた条件を元にSELECT文を作成
/*綴り、発音、活用抽出*/
$sql = "
SELECT WORD_ID AS 'id'
, SPELLING AS 'spell'
FROM word 
WHERE 1=1
AND SPELLING LIKE (:searchword)";

$stmt = $dbh->prepare($sql);


	if($stmt){
			$like_searchword = "%". $searchword."%";
		//プレースホルダへ実際の値を設定する
		$stmt->bindValue(':searchword',$like_searchword,PDO::PARAM_STR);
		
		if($stmt->execute()){
			//レコード件数取得
			$row_count = $stmt->rowCount();
			
			//レコード件数にって表示を分ける
			if($row_count==0){
				echo "例文は未登録です。";
			}else {
				echo "登録済例文：<strong>". $row_count. "</strong> 件<br/>";
			}
				while($row = $stmt->fetch()){
					// 検索結果表示
					echo "<p>" . $row['spell'] . "<br/>" ;

					/*意味を抽出*/
					$sql = "
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
					AND d.WORD_ID LIKE (:id)";

					$like_id = $row['id']."%";

					$def = $dbh->prepare($sql);
					//プレースホルダへ実際の値を設定する
					$def->bindValue(':id',$like_id,PDO::PARAM_STR);
					if(!$def->execute()){
						echo "SQLエラー<BR>" ;
						exit ;
					}

					/* 意味が複数あるかい否かを知るためのインディケータ */
					$i = 1;

					while($defrow = $def->fetch()){
						// 意味表示
						if($i==1){
							echo "意味：" . $defrow['def']."&emsp;";
						}else{
							echo $defrow['def']."&emsp;";
						}

						$def_count = $def->rowCount();

						// 意味につき、例文を検索
						for ($j = 1; $j <= $def_count; $j++){
						/*例が登録されている場合、例を抽出*/
							$eid = 'eid'.$j;

							if($defrow[$eid]!=""){
								$sql = "
								SELECT e.EXAMPLE_SENTENCE AS 'ex'
								, e.EXAMPLE_SENTENCE_JPN AS 'exj'
								FROM example e
								WHERE 1=1
								AND e.EXAMPLE_ID = (:exp)";

								$exp = $dbh->prepare($sql);
								//プレースホルダへ実際の値を設定する
								$exp->bindValue(':exp',$defrow[$eid],PDO::PARAM_STR);
								if(!$exp->execute()){
									echo "SQLエラー<BR>" ;
									exit ;
								}

								while($exprow = $exp->fetch()){
									$row_count = $exp->rowCount();
									if($row_count!=0){
										echo "<br/>例文：" . $exprow['ex'] . " / " . $exprow['exj'] . "<br/>";
									}else{
										echo "<br/>例文：" . $exprow['ex'] . " / " . $exprow['exj'] ;
									}
								}

							}else{
								break;
							}
						}
						$i++;
					}
					/*一つの単語終了*/
					echo "</p>";
				}
			}else{
				echo "SQLエラー<BR>" ;
				exit ;
			}
		}
		 $dbh = null;
	 }else{
		 if(isset($_GET['submit'])){
		 echo empty($searchword);
			 if(empty($searchword)){
				 echo "Enter a search term";
			 }else{
				 echo "半角英数字で検索して下さい。";
			 }
		 }
	 }
 }
?> 
    <ul>
      <li>
        <a href="Logout.php">ログアウト</a>
      </li>
    </ul>
  </body>
</html>