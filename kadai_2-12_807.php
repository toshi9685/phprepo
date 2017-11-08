<?php
    //phpのバージョンは4,5に対応
    header('Content-Type: text/html; charset=utf-8');
    //mysqlデータベース接続
    try {

    $dbh = new PDO('mysql:host=ホスト名;dbname=データベース名', 'ユーザ名', 'パスワード');
    if(!$dbh){
        echo "接続できません:".mysql_error()."\n";
    }else{
        echo "接続できました.\n";
    }
    $data = 'SELECT * FROM Board';
    $res = $dbh->query($data);
    if($res){
        echo "成功!<br>";
        // 連想配列を取得
        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
            echo $row["id"] . $row["name"] . $row["comment"] . $row["create_datetime"] . $row["password"] . "<br>";
        }
    }else{
        echo "失敗<br>".mysql_error();
    }
    } catch (PDOException $e) {
        print "エラー!: " . $e->getMessage() . "<br/>";
        die();
    }
?>
