<?php
session_start();

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
        <h1>メイン画面</h1>
        <!-- ユーザーIDにHTMLタグが含まれても良いようにエスケープする -->
        <p>ようこそ<u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん</p>  <!-- ユーザー名をechoで表示 -->

        <p>メニュー</p>
        <ol>
        <li><a href="add_word.php">単語追加</a></li>
        <li><a href="edit_word.php">単語修正</a></li>
        <li><a href="delete_word.php">単語削除</a></li>
        <li><a href="add_example.php">例文追加</a></li>
        <li><a href="edit_example.php">例文修正</a></li>
        <li><a href="delete_example.php">例文削除</a></li>
        </ol>
       
        
        <ul>
            <li><a href="Logout.php">ログアウト</a></li>
        </ul>
    </body>
</html>