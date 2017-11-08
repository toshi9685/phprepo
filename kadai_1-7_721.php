<?php
header('Content-Type: text/html; charset=utf-8');
$arry_file = file('kadai1-6.txt');
$i = 0;
while($arry_file[$i] != null){
  //$arry_file[$i] = mb_convert_encoding($arry_file[$i],"utf-8","euc-jp");
  echo $arry_file[$i]."<br>";
  $i++;
}
?>
