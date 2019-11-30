<!DOCTYPE html>
<html>
<head>
	<meta charset = “UTF-8”>
	<title>ノルウェー語・日本語辞書更新画面</title>
	<style>
	input {
		width: 50%;
	}
	</style>
</head>
<body>
	<h1>ノルウェー語・日本語辞書更新画面</h1>

	<?
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
	$searchword=$_GET['searchword'];
	if(is_alnum($searchword)){
		$searchword=escape($searchword);
		?>
		<h2>検索文字列：<? echo $searchword ?></h2><?

		require('../../app/init.php');

		//フォームで送られてきた条件を元にSELECT文を作成
		/*綴り、発音、活用抽出*/
		$sql = "
		SELECT w.WORD_ID AS 'id'
		, w.SPELLING AS 'spell'
		, w.PRONUNCIATION AS 'pro'
		, ic.CONJUGATION_PATTERN AS 'con'
		FROM word w
		, irregular_conjugation ic
		WHERE 1=1
		AND w.WORD_ID = ic.WORD_ID
		AND w.SPELLING LIKE (:searchword)";

		$stmt = $dbh->prepare($sql);

		echo "<form action=update.php method=post>";

		if($stmt){
			$like_searchword = "%". $searchword."%";
			//プレースホルダへ実際の値を設定する
			$stmt->bindValue(':searchword',$like_searchword,PDO::PARAM_STR);
			if($stmt->execute()){
				//レコード件数取得
				$row_count = $stmt->rowCount();
				echo "該当件数：<strong>". $row_count. "</strong>件 (空白の箇所は未登録)<br/><br/>
				<div class='stitch'>";

				while($row = $stmt->fetch()){
					// 検索結果表示
					echo "<input type=hidden name=id value=\"" . $row['id'] . "\">" ;
					echo "<p>スペル：<input type=text name=spell value=\"" . $row['spell']. "\"><br/>" ;
					echo "発音：<input type=text name=pro value=\"" . $row['pro'] . "\"><br/>";
					echo "活用：<input type=text name=con value=\"" . $row['con'] . "\"><br/>";

					for ($pos = 1; $pos <= 5; $pos++){
						/*品詞1抽出*/
						$posres = "0" . "$pos";
						$sql = "
						SELECT pos.PART_OF_SPEECH AS 'pos'
						FROM word w
						, part_of_speech pos
						WHERE 1=1
						AND w.PART_OF_SPEECH_".$posres."_ID = pos.PoS_ID
						AND w.WORD_ID = (:id)";

						$posres = $dbh->prepare($sql);
						//プレースホルダへ実際の値を設定する
						$posres->bindValue(':id',$row['id'],PDO::PARAM_STR);
						if(!$posres->execute()){
							echo "SQLエラー<BR>" ;
							exit ;
						}

						switch ($pos) {
							case 1:
							/*品詞1を格納*/
							$posres1 = $posres->fetchColumn(0);
							case 2:
							/*品詞2を格納*/
							$posres2 = $posres->fetchColumn(0);
							case 3:
							/*品詞3を格納*/
							$posres3 = $posres->fetchColumn(0);
							case 4:
							/*品詞4を格納*/
							$posres4 = $posres->fetchColumn(0);
							case 5:
							/*品詞5を格納*/
							$posres5 = $posres->fetchColumn(0);
						}
					}
					// 検索結果表示
					echo "品詞１：<input type=text name=posres1 value=\"" . $posres1. "\"><br/>
					品詞２：<input type=text name=posres2 value=\"" . $posres2. "\"><br/>
					品詞３：<input type=text name=posres3 value=\"" .  $posres3. "\"><br/>
					品詞４：<input type=text name=posres4 value=\"" . $posres4. "\"><br/>
					品詞５：<input type=text name=posres5 value=\"" . $posres5. "\"><br/>" ;

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
						echo "意味 $i ：<input type=text name=def value=\"" .  $defrow['def']. "\">&emsp;<br/>";

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
									echo "例文 $j ：<input type=text name=ex value=\"" . $exprow['ex'] . "\"> / <input type=text name=exj value=\"" . $exprow['exj'] . "\"><br/>";
								}
							}else{
								break;
							}
						}
						$i++;
					}
					/*一つの単語終了*/
					echo "</p><hr />";
				}


			}else{
				echo "SQLエラー<BR>" ;
				exit ;
			}
		}
		$dbh = null;
	}else{
		echo "半角英数字で検索して下さい。";
	}

	echo "<input type=submit value=更新>";
	echo "</form>";
	?>



</div>
</body>
</html>
