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
  $out = date("H:i").",";

  switch ($type) {
    case "err":
      $out .= "ERR,\"".$text."\"\n";
      break;

    case "info":
      $out .= "info,\"".$text."\"\n";
      break;

    case "dir":
      $out .= "dir,\n".print_r($text,true)."-----------\n";
      break;
  }
  chdir("../log");  //ワークディレクトリを../logに変更
  file_put_contents("log.log",$out,FILE_APPEND);
}

/**
 * pageが既存かどうか判断
 * @param  string  $title 記事ID
 * @return boolean        既存ならtrue、新規はfalse
 */
function thisPageExisting($title){
  chdir("../db");  //ワークディレクトリを../dbに変更
  $json = file_get_contents("all_entry_list.json");
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryList = json_decode($json,true); //連想配列に変換

  foreach ($entryList as $value) {
    if($value['title'] == $title){
      return true;
    }
  }
  return false;
}


/**
 * 記事IDからその記事の最新バージョンを取得
 * 全記事インデックス(all_entry_list.json)から検索する
 * @param  int    $page 記事ID
 * @return int|fals     最新の記事verを返す、失敗時はfalse
 */
function getEntryVer($page){
  chdir("../db");  //ワークディレクトリを../dbに変更
  $json = file_get_contents("all_entry_list.json");
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryList = json_decode($json,true); //連想配列に変換

  foreach ($entryList as $value) {
    if($value['id'] == $id){
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

  $NextEntryId = count($entryList);  // 配列の個数をカウントするので配列の添字と１差が出るの
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
    "ver" => getEntryVer($page)+1,
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
    "ver" => 1,
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
  return true;
}


/**
 * 記事本文を保存する関数
 * @param  int    $page        記事ID
 * @param  string $title       記事タイトル
 * @param  string $description 編集の要約
 * @param  string $html        記事本文
 * @return boolean             正常終了はtrue、失敗はfalse
 */
function saveEntryBody($page,$title,$description,$html){
  if (thisPageExisting($page)){
    // 既存記事
    $ver = getEntryVer($page) + 1;
  }else{
    // 新規記事
    $ver = 1;
  }
  $fileName = $page."_"."$ver".".json";

  $arr = array(
    "title" => $title,
    "description" => $description,
    "html" => $html
  );
  $json = json_encode($arr,JSON_UNESCAPED_SLASES);  // http://qiita.com/shogo807/items/f68dde0d1fe7c07b8939
  chdir("../db/body");
  file_put_contents($fileName, $json);
  chmod($fileName,0777);  // ファイルのパーミッション変更
  if(!file_exitst($fileName)){
    putLog("database.php saveEntryBody() 記事bodyが作成できませんでした。","err");
    return false;
  }
  return true;
}


/**
 * all_entry_listの記事データを更新、追記する
 * @param int    $page     記事id
 * @param string $title    記事タイトル
 * @param string $author   作者名
 * @param array  $category カテゴリを一次配列で渡す
 * @param string $eyecatch アイキャッチ画像へのリンク
 * @return boolean         正常終了はtrue、失敗はfalse
 */
function addAllEntryList($page,$title,$author,$category = null,$eyecatch = null){

  date_default_timezone_set('Asia/Tokyo'); //タイムゾーン設定
  $nowJpTime = array(
    "year" => date(Y),
    "month" => date(n),
    "day" => date(j),
    "hour" => date(G),
    "minute" => date(i),
    "second" => date(s)
  );

  $arr = array(
    "id" => $page,
    "last-ver" => getEntryVer($page) + 1,
    "title" => $title,
    "author" => $author,
    "day" => array(
      "year" => $nowJpTime['year'],
      "month" => $nowJpTime['month'],
      "day" => $nowJpTime['day'],
      "hour" => $nowJpTime['hour'],
      "minute" => $nowJpTime['minute'],
      "second" => $nowJpTime['second'],
    ),
  );
  if ($eyecatch !== null){  // アイキャッチが指定されているならばindexに記録
    $i = array("eyecatch" => $eyecatch);
    $arr = array_merge($arr,$i);
  }
  if ($category !== null){  // カテゴリが指定されているならばindexに記録
    $j = array("category" => $category);
    $arr = array_merge($arr,$j);
  }

  chdir("../db");  //ワークディレクトリを../dbに変更
  $json = file_get_contents("all_entry_list.json");
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryList = json_decode($json,true); //連想配列に変換

  foreach ($entryList as $key => $value) {
    if($value["id"] == $page){
      $entryKey = $key;
    }
  }
  if (is_set($entryKey)){
    $entryList[$entryKey] = $arr; // indexの更新
  }else{
    $entryList = array_merge($entryList,$arr);  // indexの新規追記
  }
  file_put_contents("all_entry_list.json",$arr) // 上書きモード
  return true;
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
 * 記事データ本文やインデックスを一括で保存する関数
 * 受け取りはpostでjson形式で送られてくるのでこの関数で受け取る
 * @param  string title
 * @param  int    page  ページ番号、省略すると新規作成モードになる
 * @return [type]       [description]
 */
function write_db(){
// function write_db($title,$page = null){
  /*
    保存するときにはバージョン管理できるように各バージョンごとに１ファイルの
    テキストファイルを作り、そのファイル名と作成日時を管理ようテキストファイル
    で管理する
  */

  $json = file_get_contents('php://input');  // http://php-archive.net/php/ajax-json/
  $data = json_decode($json, true);

  $page = is_set($data["page"]) ? $data["page"] : willNextEntryId();
  $title = $data["title"];
  $html = $data["html"];
  $description = $data["description"];
  $author = is_set($data["author"]) ? $data["author"] : "名無しさん";
  $eyecatch = is_set($data["eyecatch"]) ? $data["eyecatch"] : null;

  $ip = ip2long($_SERVER["REMOTE_ADDR"]); // アクセス元のipアドレスを取得し整数値に変換して代入


  if($page>=0){  // 既存記事の保存
    saveEntryBody($page,$title,$description,$html);
    addEnteyIndex($page,$title,$author,$ip);

  }else if($page==null){  // 新規記事の保存
    saveEntryBody($page,$title,$description,$html);
    addEntryIndex($page,$title,$author,$ip);
    addAllEntryList($page,$title,$author,$category,$eyecatch);
  }
}

ini_set( 'display_errors', 1 ); // エラーログ表示設定
// chdir("../db");  //ワークディレクトリを../dbに変更
// addEntryIndex(0,"タイトル","ななしさん","192.168.0.100");
?>
