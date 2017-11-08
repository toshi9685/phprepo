<?php
    //phpのバージョンは4,5に対応
    header('Content-Type: text/html; charset=utf-8');
    try {
        $dbh = new PDO('mysql:host=ホスト名;dbname=データベース名', 'ユーザ名', 'パスワード');
        foreach($dbh->query('SHOW TABLES FROM データベース名') as $row) {
            echo "Table: {$row[0]}<br>";
        }
        $dbh = null;
    } catch (PDOException $e) {
        print "エラー!: " . $e->getMessage() . "<br/>";
        die();
    }
?>
