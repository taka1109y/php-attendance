<?php
    try{
        require_once('./../config/dbini.php');

        $emp_id = intval($_GET['id']);

        echo $emp_id;

        // DBへの接続
        $dbh = new PDO($dsn,$user,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        // SQL文の発行及びレコードへの追加
        $sql = 'SELECT * FROM mst_emp WHERE id=?';
        $stmt = $dbh->prepare($sql);
        $data[] = $emp_id;
        $stmt->execute($data);
        // DB切断
        $dbh = null;
        //DBから一行ずつ取り出し
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        

        //DBから取り出した内容と比較
        if($rec==false){
            //一致しなかった場合
            header('Location:error.php');
            exit();
        }else{
            //一致した場合
            $emp_name = $rec['emp_name'];
        }

    }catch(Exception $e){
        $errMsg = 'ただいま障害によりご迷惑をお掛けしております。';
    }

?>


<!DOCTYPE html>
<html lang="jp">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>勤怠管理システム|エラー</title>
        
        <script src="./js/showDatetime.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./css/common.css">
        <link rel="stylesheet" href="./css/loading.css">
    </head>
    <body>
        <div class="loader">
            <img src="./img/loading.gif" alt="">
        </div>

        <header>
            <a href="att_top.php">
                <img src="./img/back.png" alt="戻る" style="width:20px; height: 20px;">
            </a>
            <p id="staffName"><?php echo $emp_name ?></p>
        </header>

        <div id="dateTimeContiner">
            <div id="dtView"></div>
        </div>

        <main>   
        </main>

        <script src="./js/loading.js"></script>
    </body>
</html>