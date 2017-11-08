
  <?php
  // chmodで書き込み権限を付与
  //if(file_exists('sample.txt')){
    //$file = chmod('sample.txt', 0666);
  //}else{
    //$file = 'sample.txt';
  //}
  // ファイルをオープン
  $fp = fopen("sample.txt",'a');
  $current = "Hello World!!\n";
  //ファイルに書き出します
  fwrite($fp, $current);
  //ファイルを閉じる
  fclose($fp);
  ?>
