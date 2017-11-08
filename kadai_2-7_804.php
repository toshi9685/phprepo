<?php
    //phpのバージョンは4,5に対応
    header('Content-Type: text/html; charset=utf-8');
    $link = mysql_connect('ホスト名','データベース名','パスワード');
    if(!$link){
        echo '接続できません:'.mysql_error();
    }else{
        echo '接続できました';
    }
    //データベース名をカレントのdbに指定する
    $db_selected = mysql_select_db('データベース名',$link);
    if(!$db_selected){
      echo "can't use";
    }else{
      echo "can use";
    }
    $table= 'CREATE TABLE keijiban (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30),
    comment VARCHAR(300),
    create_datetime DATETIME,
    password VARCHAR(30)
    ) engine=innodb default charset=utf8';
    if(mysql_query($table,$link)){
        echo "テーブルの作成に成功しました\n";
    }else{
        echo "テーブルは存在しています";
    }
?>
