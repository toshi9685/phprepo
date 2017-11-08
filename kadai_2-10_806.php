<?php
    //phpのバージョンは4,5に対応
    header('Content-Type: text/html; charset=utf-8');
    $link = mysql_connect('ホスト名','ユーザ名','パスワード');
    if(!$link){
        echo "接続できません:".mysql_error()."\n";
    }else{
        echo "接続できました.\n";
    }
    $db_selected = mysql_select_db('データベース名',$link);
    if(!$db_selected){
        echo "can't use";
    }else{
        echo "can use";
    }
    $result = mysql_query('SHOW COLUMNS FROM Board',$link);
    if (!$result) {
        echo 'Could not run query: ' . mysql_error();
        exit;
    }
    if (mysql_num_rows($result) > 0) {
        echo "<br>";
        while ($row = mysql_fetch_assoc($result)) {
            print_r($row);
            echo "<br>";
        }
    }
?>
