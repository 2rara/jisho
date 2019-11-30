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

	<h1>ノルウェー語・日本語辞書更新完了画面</h1>

  <?

		require('../../app/init.php');

*phpmyadminでSELECTのSQL投げてテストできる*


    // UPDATE文を実行

    // wordテーブルのスペル、春音を更新
    $sql = "update word set spelling='$spell' , pronunciation=$pro where id = $id";

    // wordテーブルの品詞を更新


    // definitionテーブルの意味を更新


    // exampleテーブルの英文・日本語文を更新


    // irregular_conjugationテーブルのconjugation_patternを更新

    


    if(!$res=mysql_query($sql)){
    echo "SQL実行時エラー";
    exit;
    }

    // データベースから切断
    mysql_close($con);

    // 登録完了メッセージの表示
    echo "更新完了";
    ?>

</body>
</html>
