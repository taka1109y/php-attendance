<!DOCTYPE html>
<html lang="jp">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>勤怠管理システム|トップページ</title>

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
            <p>ログアウト</p>
            <p id="showDatetime">0000年00月00日(月)　00:00:00</p>
        </header>

        <div id="dateTimeContiner">
            <div id="dtView"></div>
        </div>

        <main>
            <div id="mainWrapp">

            <?php
                try{
                    require_once('./../config/common.php');
                    require_once('./../config/dbini.php');

                    // DBへの接続
                    $dbh = new PDO($dsn,$user,$password);
                    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                    // SQL文の発行及びレコードへの追加
                    $sql = 'SELECT id,emp_name FROM mst_emp WHERE 1';
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();

                    // DB切断
                    $dbh = null;

                    while(true){
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);// $stmtから１レコード取り出し
                        if($rec == false){
                            break;
                        }
                        print '<a href="./att_eng.php?id='.$rec['id'].'">';
                        print '<div id="staffWrapp">';
                        print '<img src="./img/door_line.png" alt="">';
                        print '<p>'.$rec['emp_name'].'</p>';
                        print '</div></a>';
                    }

                    $count = $stmt -> rowCount();
                    if($count%3 == 2){
                        print '<a id="nolink"></a>';
                    }

                }catch(Exception $e){
                    print'ただいま障害によりご迷惑をお掛けしております。';
                }
            ?>

            </div>    
        </main>

        <!-- デバック用　デプロイ時削除 -->
        <p><a href="index.php">戻る</a></p>

        <script src="./js/loading.js"></script>
    </body>
</html>