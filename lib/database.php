<?php
/*
  author : MagmaChocolate
  lang : php, ja-jp
*/
/*
 * データを格納、引き出し、バージョン管理をする
 * ログイン認証を通さないとデータベース内にアクセスし放題なので対策する
*/

/**
 * 処理ログをテキストファイルとして吐く関数
 * @param  string $text 出力する文字列
 * @param  string $type [err(default) | info infoアイコンが付きます |
 *                       dir (ver_dumpする）]
 * @return bool         正常にログを履いたらtrue ダメならfalse
 */
function putLog($text,$type = err){

  date_default_timezone_set('Asia/Tokyo'); //タイムゾーン設定
  $out = date("H:i");

  switch ($type) {
    case "err":
      $out .= "ERR,".$text."'";
      break;

    case "info":
      $out .= "info,".$text."'";
      break;

    case "dir":
      $out .= ver_dump($text);
      break;
  }
  chdir("../log");  //ワークディレクトリを../logに変更
  file_put_contents(log.log,$out);
}

/**
 * pageが既存かどうか判断、既存なら最新のバージョン番号+1を返却
 * @param  string  $title 記事ID
 * @return boolean        新規はfalse、既存は最新バージョン+1
 */
function thisPageExisting($title){
  chdir("../db");  //ワークディレクトリを../dbに変更
  $json = file_get_contents("all_entry_list.json");
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryList = json_decode($json,true); //連想配列に変換

  foreach ($entryList as $value) {
    if($value['title'] == $title){
      return $value['last-ver'];
    }
  }
  return false;
}


/**
 * 新規記事IDに割り当てられる予定のIDを取得
 * @return int           新規記事IDになる予定の数値を返す
 */
function willNextEntryId(){
  chdir("../db");  //ワークディレクトリを../dbに変更
  $json = file_get_contents("all_entry_list.json");
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryList = json_decode($json,true); //連想配列に変換

  $NextEntryId = count($entryList) - 1;
  return $NextEntryId;
}


/**
 * 記事追加時に記事を管理するindexに追記する
 * @param int    $page   記事ID
 * @param string $title  記事タイトル
 * @param string $author 書き込んだユーザ名
 * @param int    $ip     書き込んだIP
 * @return boolean       成功ならtrue、失敗ならfalse
 */
function addEntryIndex($page,$title,$author,$ip){
  chdir("../db/index");  //ワークディレクトリを../dbに変更
  $fileName = $page.".json";
  $json = file_get_contents($fileName);
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryIndex = json_decode($json,true); //連想配列に変換



  date_default_timezone_set('Asia/Tokyo'); //タイムゾーン設定
  $nowJpTime = array(
    "year" => date(Y),
    "month" => date(n),
    "day" => date(j),
    "hour" => date(G),
    "minute" => date(i),
    "second" => date(s)
  );

  $array = array(
    "title" => $title,
    "ver" => thisPageExisting($page)-1,
    "day" => array(
      "year" => $nowJpTime['year'],
      "month" => $nowJpTime['month'],
      "day" => $nowJpTime['day'],
      "hour" => $nowJpTime['hour'],
      "minute" => $nowJpTime['minute'],
      "second" => $nowJpTime['second'],
    ),
    "author" => $author,
    "ip" => $ip
  );

  $entryIndex = array_merge($entryIndex,$array);

  $fp = fopen($fileName,"w");  //上書き
  fwrite($fp, sprintf(json_encode($entryIndex)));
  fclose($fp);

  return true;
}


/**
 * 記事追加時に記事を管理するindexを新規作成
 * @param string $title  記事タイトル
 * @param string $author 書き込んだユーザ名
 * @param int    $ip     書き込んだIP
 * @return boolean       成功なら記事ID+1、失敗ならfalse
 */
function newEmtryIndex($title,$author,$ip){

  $page = willNextEntryId();

  chdir("../db/index");  //ワークディレクトリを../dbに変更
  $fileName = $page.".json";
  $json = file_get_contents($fileName);
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryIndex = json_decode($json,true); //連想配列に変換



  date_default_timezone_set('Asia/Tokyo'); //タイムゾーン設定
  $nowJpTime = array(
    "year" => date(Y),
    "month" => date(n),
    "day" => date(j),
    "hour" => date(G),
    "minute" => date(i),
    "second" => date(s)
  );

  $array = array(
    "title" => $title,
    "ver" => thisPageExisting($page)-1,
    "day" => array(
      "year" => $nowJpTime['year'],
      "month" => $nowJpTime['month'],
      "day" => $nowJpTime['day'],
      "hour" => $nowJpTime['hour'],
      "minute" => $nowJpTime['minute'],
      "second" => $nowJpTime['second'],
    ),
    "author" => $author,
    "ip" => $ip
  );

  $entryIndex = array_merge($entryIndex,$array);

  touch($fileName);  // ファイル作成
  chmod($fileName,0777);  // ファイルのパーミッション変更
  if(!file_exitst($fileName)){
    putLog("database.php wilEntryIndex() インデックスファイルが作成できませんでした。","err");
    return false;
  }
  $fp = fopen($fileName,"w");  //上書き
  fwrite($fp, sprintf(json_encode($entryIndex)));
  fclose($fp);
}

/**
 * データベースから情報を出す
 * @param  int    page    ページ番号
 * @param  int    backlog 過去バージョンのデータを引き出したいときに指定、バージョンの詳細は別途info関数で取得する、readのみ有効
 * @return [type]         [description]
 */
function read_db($page,$backlog){

}



/**
 * データを保存する
 * 受け取りはpostでjson形式で送られてくる
 * @param  string title
 * @param  int    page  ページ番号、省略すると新規作成モードになる
 * @param  json
 * @return [type]       [description]
 */
function write_db($title,$json,$page = null){
  /*
    保存するときにはバージョン管理できるように各バージョンごとに１ファイルの
    テキストファイルを作り、そのファイル名と作成日時を管理ようテキストファイル
    で管理する

    送られてくるjsonの形式
    json{
      "html" : "<h1>サンプル</h1>\n<p>ほげほげ</p>\n・・・",    // 改行はJavascript側で事前に\nにエスケープしておく
      "description" : "誤字脱字の修正"         // 概要説明
      "author" : "magcho",        // ユーザ名
    }
   */


  if($page>=0){
    saveEntryBody($page,$json);
    addEnteyIndex($page,$title,$author,$ip);

  }else if($page==null){
    $page = willNextEntryId();
    saveEntryBody($page,$json);
    newEntryIndex($title,$author,$ip);
    addAllEntryList($page);
  }
}

ini_set( 'display_errors', 1 ); // エラーログ表示設定
chdir("../db");  //ワークディレクトリを../dbに変更
addEntryIndex(,'')
?>
