<?php
require(__DIR__.'/database.php');

function returnJson($returnData){
  header("Content-Type: application/json");
  echo json_encode($returnData,true); //連想配列を変換して出力
}

$arr = read_db($_POST["page"]);
$out = ["html" => $arr["html"],"category" => $arr["category"]];
returnJson($out);
