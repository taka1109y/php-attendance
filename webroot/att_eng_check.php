<?php
    $msg = '　';
    $emp_id = $_GET['id'];

    require_once('./../config/common.php');
    require_once('./../config/dbini.php');

    //スタッフ名参照処理
    try{
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
        $msg = '※ただいま障害が発生により、ご迷惑をおかけしております。<br>　至急管理者にご連絡ください。';
    }

    //出退勤打刻処理
    try{
        $emp_id = $_GET['id'];
        if($_GET['code'] == 'on'){
            $AL = 'att';
            $M = '（出勤）';
        }elseif($_GET['code'] == 'off'){
            $AL = 'lea';
            $M = '（退勤）';
        }

        $timestamp = date("Y-m-d H:i:s", time());

        $h = date("G",strtotime($timestamp));

        if($h < 16){
            $daynight = 'day';
        }else{
            $daynight = 'night';
        }

        // DBへの接続
        $dbh = new PDO($dsn,$user,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        // SQL文の発行及びレコードへの追加
        $sql = 'INSERT INTO dat_work(emp_id,daynight,AL,timestamp) VALUES (?,?,?,?)';
        $stmt = $dbh->prepare($sql);
        $data = array();
        $data[] = $emp_id;
        $data[] = $daynight;
        $data[] = $AL;
        $data[] = $timestamp;
        $stmt->execute($data);
        // DB切断
        $dbh = null;


        $msg = '・打刻'.$M.'が完了しました。';

    }catch(Exception $e){
        // $msg = $e->getMessage();
        $msg = '※ただいま障害発生により、打刻が未完了です。<br>　至急管理者にご連絡ください。';
    }

?>


<!DOCTYPE html>
<html lang="jp">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>勤怠管理システム|勤務状況</title>
        
        <script src="./js/showDatetime.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./css/att_eng_check.css">
        <link rel="stylesheet" href="./css/loading.css">
    </head>
    <body>
        <div class="loader">
            <img src="./img/loading.gif" alt="">
        </div>

        <header>
            <a href="att_top.php">
                <img src="./img/back.png" alt="戻る" style="width:20px; height: 20px; margin-right:223px;">
            </a>
            <p id="staffName"><?php echo $emp_name ?></p>
            <p id="showDatetime"></p>
        </header>

        <div id="dateTimeContiner" style="display: none;">
            <div id="dtView"></div>
        </div>

        <main>
            <p id="msg"><?php print $msg?></p>
            <table border="1">
                <tr>
                    <th rowspan="2" style="width: 120px;">日付</th>
                    <th colspan="2">出退勤(昼)</th>
                    <th colspan="2">出退勤(夜)</th>
                </tr>
                <tr>
                    <th>出</th>
                    <th>退</th>
                    <th>出</th>
                    <th>退</th>
                </tr>

                <?php
                    //勤務表表示処理
                    try{
                        // DBへの接続
                        $dbh = new PDO($dsn,$user,$password);
                        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                        // SQL文の発行及びレコードへの追加
                        $sql = '(SELECT * FROM dat_work WHERE emp_id=? ORDER BY timestamp DESC Limit 10) ORDER BY timestamp ASC';
                        $stmt = $dbh->prepare($sql);
                        $data = array();
                        $data[] = $emp_id;
                        $stmt->execute($data);
                        // DB切断
                        $dbh = null;

                        $ary = [];

                        while(true){
                            $rec = $stmt->fetch(PDO::FETCH_ASSOC);// $stmtから１レコード取り出し
                            if($rec == false){
                                break;
                            }
                            $ary[] = [
                                $rec['daynight'],
                                $rec['AL'],
                                date("n/j",strtotime($rec['timestamp'])),
                                date("H:i",strtotime($rec['timestamp']))
                            ];

                        }


                        for($i=-9; $i<=0; $i++){
                            $d = date("n/j",strtotime("$i day",time()));//日付
                            $w = '('.$wk[date("w",strtotime("$i day",time()))].')';//曜日


                            print '<tr>';
                            print '<td class="date">'.$d.$w.'</td>';

                            $flag = 2;
                            $flag2 = 2;

                            foreach($ary as $row){
                                if($row[2] == $d && $row[0] == 'day'){
                                    if($row[1] == 'att'){
                                        print '<td>'.$row[3].'</td>';
                                        $flag--;
                                    }elseif($row[1] == 'lea'){
                                        print '<td>'.$row[3].'</td>';
                                        $flag--;
                                    }
                                }
                            }

                            for($a=0; $a<$flag; $a++){
                                print '<td></td>';
                            }

                            foreach($ary as $row){
                                if($row[2] == $d && $row[0] == 'night'){
                                    if($row[1] == 'att'){
                                        print '<td>'.$row[3].'</td>';
                                        $flag2--;
                                    }elseif($row[1] == 'lea'){
                                        print '<td>'.$row[3].'</td>';
                                        $flag2--;
                                    }
                                }
                            }

                            for($a=0; $a<$flag2; $a++){
                                print '<td></td>';
                            }

                            print '</tr>';
                        }
                    }catch(Exception $e){
                        $msg = '※ただいま障害が発生により、ご迷惑をおかけしております。<br>　至急管理者にご連絡ください。';
                    }
                ?>

                <tr id="sum">
                    <td style="text-align: center;">合計</td>
                    <td style="text-align: right;">00:00</td>
                    <td style="text-align: right;">00:00</td>
                    <td style="text-align: right;">00:00</td>
                    <td style="text-align: right;">00:00</td>
                </tr>
                
            </table>
        </main>

        <footer>
            <p>確認完了（5秒後に自動的に戻ります。）<?php header("refresh:6;url=att_top.php"); ?></p>
        </footer>

        <script src="./js/loading.js"></script>
    </body>
</html>