<?php
    if(isset($_POST['login'])){
        header('Location:top');
    }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理システム｜ログイン画面</title>
</head>
<body>
    打刻画面ログイン

    <div class="main">
        <form action="index.php" method="post">
            <input type="text" name="login_id" placeholder="IDを入力してください">
            <input type="password" name="login_id" placeholder="パスワードを入力してください">
            <button type="submit" name="login">ログイン</button>
        </form>
    </div>

    
</body>
</html>