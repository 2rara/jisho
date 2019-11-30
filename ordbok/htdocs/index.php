<!DOCTYPE html>
<html>
<head>
	<meta charset = “UTF-8”>
	<title>ノルウェー語・日本語辞書</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<h1>ノルウェー語・日本語辞書</h1>
<div class="stitch">
<p>検索ワード</p>
		<form action = "search.php" method = "GET">
			<input id="text" type="text" name="searchword" pattern="^[0-9A-ZÆÅØa-zæåø]+$" title="半角英数字で入力して下さい。" value="" autocomplete="off" required>
			<div id="suggest" style="display:none;" tabindex="-1"></div>
			<input type = "submit" value = "検索">
		</form>
</div>


    <!-- 検索候補表示方法の参考元：http://www.enjoyxstudy.com/javascript/suggest/ -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://www.enjoyxstudy.com/js/bootstrap.min.js"></script>
    <script src="http://www.enjoyxstudy.com/js/scripts.js"></script>

    <script src="http://www.enjoyxstudy.com/javascript/suggest/suggest.js"></script>
    <script src="./wordlist"></script>
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

</body>
</html>
