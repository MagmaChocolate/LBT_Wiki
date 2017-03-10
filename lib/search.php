<?php
require(__DIR__.'/database.php');

/**
 * JSにjsonで結果を返却する関数
 * @param $data 返却する内容の連想配列
 * @return json
 */
function returnJson($returnData){
  header("Content-Type: application/json");
  echo json_encode($returnData,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT); //連想配列を変換して出力
}


switch ($_GET["mode"]) {
  case "title":
  // タイトル検索用のapi
    returnJson(fetchAllIndex());
    break;

  case "All":
  // 全文検索
    returnJson(allSearchEntry());
    break;
}
/*  ? > このファイル全てがphpなので敢えてつけない*/
