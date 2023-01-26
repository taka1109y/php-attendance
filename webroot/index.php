<?php
    $errMsg = '';

    if(isset($_POST['login'])){
        try{
            require_once('./../config/common.php');
            require_once('./../config/dbini.php');

            $post = sanitize($_POST);
            $pass = $_POST['login_pass'];

            // 文字列のエスケープ処理
            $pass = htmlspecialchars($pass, ENT_QUOTES,'utf-8');

            // 暗号化処理(DB連携実装時　有効)
            // $pass =  md5($pass);

            // DBへの接続
            $dbh = new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            // SQL文の発行及びレコードへの追加
            $sql = 'SELECT * FROM mst_adm WHERE adm_pass=?';
            $stmt = $dbh->prepare($sql);
            $data[] = $pass;
            $stmt->execute($data);
            // DB切断
            $dbh = null;
            //DBから一行ずつ取り出し
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            //DBから取り出した内容と比較
            if($rec==false){
                //一致しなかった場合
                $errMsg = 'パスワードが間違っています。';
            }else{
                //一致した場合
                // session_start();
                // $_SESSION['adm_id'] = $rec['id'];
                header('Location:att_top.php');
                exit();
            }

        }catch(Exception $e){
            $errMsg = 'ただいま障害によりご迷惑をお掛けしております。';
        }
    }
?>

<!DOCTYPE html>
<html lang="jp">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>勤怠管理システム｜ログイン画面</title>

        <script src="./js/showDatetime.js"></script>
        <link rel="stylesheet" href="./css/common.css">
        <link rel="stylesheet" href="./css/index.css">
    </head>

    <body>
        <header>
            <p id="showDatetime">0000年00月00日(月)　00:00:00</p>
        </header>
        
        <div id="dateTimeContiner" style="display: none;">
            <div id="dtView"></div>
        </div>
        
        <div class="login">
            <h2 class="login-header">勤怠管理システム｜打刻</h2>
            <form action="#" method="post" class="login-container">
                <p>
                    <label for="login_pass">管理者パスワードを入力してください。</label>
                    <input type="password" name="login_pass" placeholder="パスワード">
                </p>
                <span class="errMsg">
                    <?php echo $errMsg ?>
                </span>
                <p><input type="submit" name="login" value="ログイン"></p>
            </form>
        </div>
    </body>
</html>