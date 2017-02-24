<?php
require('./database.php');

/**
 * ajaxで受け取りwrite_db()に投げる関数
 * {
 *  "id": (int), // 省略可、省略時は新規記事扱い
 *  "title": (string),
 *  "html": (sring) // 基本的に<body></body>の中身だけ送られる(<body></body>は来ない)
 *  "description": (string), // 省略可
 *  "author": (string), // 省略可
 *  "eyecatch": (string) // 省略可
 * }
 * @return json jQueryへjsonを返す
 */
function sendContents(){


  /**
   * JSにjsonで結果を返却する関数
   * @param $data 返却する内容の連想配列
   * @return json
   */
  function returnJson($returnData){
    header("Content-Type: application/json");
    echo json_encode($returnData,true); //連想配列を変換して出力
  }

  if(!isset($_POST["title"])){
    $returnData = ["message" => "ERR_no_title"];
    returnJson($returnData);
    return false;
  }
  if(!isset($_POST["html"])){
    $returnData = ["message" => "ERR_no_html"];
    returnJson($returnData);
    return false;
  }

  $saveData = $_POST;
  $return = write_db($saveData);
  if($return !== false){
    // 保存成功
    putLog('asdfasdf');
    $returnData = ["message" => "success","page" => $return];
  }else{
    // 保存失敗
    $returnData = ["message" => "ERR_save_database()"];
  }
  returnJson($returnData);
  return true;
}
sendContents();

/*  ? > このファイル全てがphpなので敢えてつけない*/
