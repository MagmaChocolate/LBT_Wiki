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
 * slackへ通知を送信する
 * @param  {string} $text 送信する文章
 */
function sendSlack($text) {
  $webhook_url = 'https://hooks.slack.com/services/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';
  $message = [
    'username' => 'WikiBot',
    // 'text' => $text,
    'attachments' => [
      [
        'title' => 'タイトル',
        // 'title_link' => 'http:/lbt.webcrow.jp',
        'text' => $text
      ]
    ],
    "channel" => "#develop-notification"
  ];
  $contents = json_encode($message,JSON_UNESCAPED_UNICODE);
  $options = array(
    'http' => array(
      'method' => 'POST',
      'header' => 'Content-Type: application/json',
      'content' => $contents
    )
  );



$msg = 'payload=' . urlencode($contents);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $webhook_url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
curl_exec($ch);
curl_close($ch);
  //file_get_contents($webhook_url, false, stream_context_create($options));
}


/**
 * 処理ログをテキストファイルとして吐く関数
 * @param  string $text 出力する文字列
 * @param  string $type [err(default) | info infoアイコンが付きます |
 *                       dir (ver_dumpする）]
 * @return bool         正常にログを履いたらtrue ダメならfalse
 */
function putLog($text,$type = err){

  date_default_timezone_set('Asia/Tokyo'); //タイムゾーン設定
  $out = date("m/d_H:i").",";
  $text = ($text === false) ? "falseが返却されました" : $text;
  $text = ($text === true) ? "trueが返却されました" : $text;

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
  sendSlack($text);
  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../log");  //ワークディレクトリを../logに変更
  if (file_put_contents("log.log",$out,FILE_APPEND) === false){
    return false;
  }
  return true;
}

/**
 * pageが既存かall_entry_listから判断
 * @param  string  $page 記事タイトル
 * @return boolean        既存ならtrue、新規はfalse
 */
function thisPageExisting($page){
  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db");  //ワークディレクトリを../dbに変更
  $json = file_get_contents("all_entry_list.json");
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryList = json_decode($json,true); //連想配列に変換

  foreach ($entryList as $value) {
    if($value['id'] == $page){
      return true;
    }
  }
  return false;
}


/**
 * 記事IDからその記事の最新バージョンを取得
 * 全記事インデックス(all_entry_list.json)から検索する
 * @param  int    $page 記事ID
 * @return int|false     最新の記事verを返す、失敗時はfalse
 */
function getEntryVer($page){
  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db");  //ワークディレクトリを../dbに変更
  $json = file_get_contents("all_entry_list.json");
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryList = json_decode($json,true); //連想配列に変換

  foreach ($entryList as $value) {
    if($value['id'] == $page){
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
  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db");  //ワークディレクトリを../dbに変更
  $json = file_get_contents("all_entry_list.json");
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryList = json_decode($json,true); //連想配列に変換

  $NextEntryId = count($entryList);  // 配列の個数をカウントするので配列の添字と１差が出るの
  return $NextEntryId;
}


/**
 * 記事追加時に記事を管理するindexに追記する、新規ならば新しくファイルを作成する
 * @param int    $page        記事ID
 * @param string $title       記事タイトル
 * @param string $author      書き込んだユーザ名
 * @param int    $ip          書き込んだIP
 * @param string $description 編集内容の概要説明
 * @return boolean            成功ならtrue、失敗ならfalse
 */
function addEntryIndex($page,$title,$author,$ip,$description){
  $fileName = $page.".json";

  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db/entry/index");  //ワークディレクトリを../dbに変更
  if(!file_exists($fileName)){
    putLog("addEntryIndex() 書き込み先のファイルが存在しませんでした");
    return false;
  }
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
    "description" => $description,
    "day" => array(
      "year" => (int)$nowJpTime['year'],
      "month" => (int)$nowJpTime['month'],
      "_day" => (int)$nowJpTime['day'],
      "hour" => (int)$nowJpTime['hour'],
      "minute" => (int)$nowJpTime['minute'],
      "second" => (int)$nowJpTime['second'],
    ),
    "author" => $author,
    "ip" => $ip
  );

  $entryIndex [] = $array;  // 既存の配列と今回作ったデータを結合

  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db/entry/index");  //ワークディレクトリを../dbに変更
  file_put_contents($fileName,sprintf(json_encode($entryIndex,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)));
  return true;
}


/**
 * 記事追加時に記事を管理するindexを新規作成
 * @param string $title       記事タイトル
 * @param string $author      書き込んだユーザ名
 * @param int    $ip          書き込んだIP
 * @param string $description 編集の簡易説明
 * @return boolean       成功なら記事ID+1、失敗ならfalse
 */
function newEntryIndex($page,$title,$author,$ip,$description){

  $fileName = $page.".json";



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
    "description" => $description,
    "day" => array(
      "year" => (int)$nowJpTime['year'],
      "month" => (int)$nowJpTime['month'],
      "_day" => (int)$nowJpTime['day'],
      "hour" => (int)$nowJpTime['hour'],
      "minute" => (int)$nowJpTime['minute'],
      "second" => (int)$nowJpTime['second'],
    ),
    "author" => $author,
    "ip" => $ip
  );

  $entryIndex [] = $array;


  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db/entry/index");  //ワークディレクトリを../dbに変更
  if(file_exists($fileName)){
    putLog("databace.php newEntryIndex() 作成しようとしたファイル名がすでに存在しているため処理を中断しました。");
    return false;
  }

  file_put_contents($fileName,sprintf(json_encode($entryIndex,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)));
  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db/entry/index");  //ワークディレクトリを../dbに変更
  if(!file_exists ($fileName)){
    putLog("database.php wilEntryIndex() インデックスファイルが作成できませんでした。","err");
    return false;
  }

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
  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db/entry/body");
  $tmpFileName = $page."_1.json";
  if(file_exists($tmpFileName)){
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
  // $json = json_encode($arr,JSON_UNESCAPED_SLASES);  // http://qiita.com/shogo807/items/f68dde0d1fe7c07b8939
  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db/entry/body");
  file_put_contents($fileName,sprintf(json_encode($arr,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)));
  if(!file_exists($fileName)){
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
 * @param array  $category [省略可]カテゴリを一次配列で渡す
 * @param string $eyecatch [省略可]アイキャッチ画像へのリンク
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
      "year" => (int)$nowJpTime['year'],
      "month" => (int)$nowJpTime['month'],
      "_day" => (int)$nowJpTime['day'],
      "hour" => (int)$nowJpTime['hour'],
      "minute" => (int)$nowJpTime['minute'],
      "second" => (int)$nowJpTime['second'],
    ),
  );
  if ($eyecatch !== null){  // アイキャッチが指定されているならばindexに記録
    $i = array("eyecatch" => $eyecatch);
    $arr = array_merge($arr,$i);
  }else{
    $arr = array_merge($arr,array("eyecatch" => "none"));
  }
  if ($category !== null){  // カテゴリが指定されているならばindexに記録
    $j = array("category" => $category);
    $arr = array_merge($arr,$j);
  }else{
    $arr = array_merge($arr,array("category" => "none"));
  }

  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db");  //ワークディレクトリを../dbに変更
  $json = file_get_contents("all_entry_list.json");
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryList = json_decode($json,true); //連想配列に変換

  foreach ($entryList as $key => $value) {
    if($value["id"] == $page){
      $entryKey = $key;
      break;
    }
  }
  if (isset($entryKey)){
    $entryList[$entryKey] = $arr; // indexの更新
  }else{
    $entryList [] = $arr;  // indexの追記
  }
  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db/");
  file_put_contents("all_entry_list.json",sprintf(json_encode($entryList,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)));
  return true;
}

/**
 * データベースから情報を出す
 * @param  int    page    ページ番号
 * @param  int    [ver] 過去バージョンのデータを引き出したいときに指定するオプション
 *                        バージョンの詳細は別途info関数で取得する
 * @return array          連想配列を返す、失敗はfalseを返す
 *         ["title","author","(array)category","eyecatch","html"];
 */
function read_db($page,$ver = null){
  if($backlog === null){ //最新バージョンを取得
   // 最新の情報をall_entry_indexから取得
    chdir(__DIR__);  // ワークディレクトリを戻す
    chdir("../db");  //ワークディレクトリを../dbに変更
    $json1 = file_get_contents("all_entry_list.json");
    $json1 = mb_convert_encoding($json1, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    $entryList = json_decode($json1,true); //連想配列に変換
    foreach ($entryList as $value) {
      if($value["id"] == $page){
        $arr = array(
          "title" => $value["title"],
          "author" => $value["author"],
          "category" => $value["category"],
          "eyecatch" => $value["eyecatch"]
        );
        $ver = $value["last-ver"];
        break;
      }
    }
    if(!isset($arr)){  // 検索で見つからなかっったエラー処理
      putLog("database.php read_db() 指定された記事id(".$page.")が見つかりませんでした。");
      return false;
    }


   // 記事本文を取得
    $fileName = $page."_".$ver.".json";
    chdir(__DIR__);
    chdir("../db/entry/body");
    if(!file_exists($fileName)){
      putLog("database.php read_db() ".$fileName."が見つかりませんでした");
      return false;
    }
    $json2 = file_get_contents($fileName);
    $json2 = mb_convert_encoding($json2, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    $entryBody = json_decode($json2,true); //連想配列に変換

    $arr = array_merge($arr,array("html" => $entryBody["html"]));

  }else{  // 過去バージョンを取得
    $indexFileName = $page.".json";
    chdir(__DIR__);  // ワークディレクトリを戻す
    chdir("../db/index");  //ワークディレクトリを../dbに変更
    if(!file_exists($indexFileName)){
      putLog("database.php read_db() ".$indexFileName."が見つかりませんでした");
      return false;
    }
    $json1 = file_get_contents($indexFileName);
    $json1 = mb_convert_encoding($json1, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    $entryIndex = json_decode($json1,true); //連想配列に変換

    foreach ($entryIndex as $value) {
      if($value["ver"] == $ver){
        $arr = array(
          "title" => $value["title"],
          "author" => $value["author"]
        );
        break;
      }
    }
    if(!isset($arr)){
      putLog("detabase.php read_db() 指定されたver(".$ver.")が見つかりませんでした");
      return false;
    }

   // 記事本文を取得
    $bodyFileName = $page."_".$ver.".json";
    chdir(__DIR__);
    chdir("../db/entry/");
    if(!file_exists($bodyFileName)){
      putLog("database.php read_db() ".$bodyFileName."が見つかりませんでした");
      return false;
    }
    $json2 = file_get_contents($bodyFileName);
    $json2 = mb_convert_encoding($json2, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    $entryBody = json_decode($json2,true); //連想配列に変換
    $arr = array_merge($arr,array("html" => $entryBody["html"]));

   // アイキャッチとカテゴリーを取得
    chdir(__DIR__);  // ワークディレクトリを戻す
    chdir("../db");  //ワークディレクトリを../dbに変更
    $json3 = file_get_contents("all_entry_list.json");
    $json3 = mb_convert_encoding($json3, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    $entryList = json_decode($json3,true); //連想配列に変換

    foreach ($entryList as $value) {
      if($value["id"] == $page){
        $arr = array_merge(array("eyecatch" => $value["eyecatch"],"category" => $value["category"]));
        break;
      }
    }
    if(!isset($arr["id"])){
      putLog("database.php read_db() 指定された記事id(".$page.")が見つかりませんでした。");
      return false;
    }
  }

  return $arr;
}

/**
 * 記事idから既存の記事の情報を返す
 * @param  {int} $page 記事id
 * @return {array}     {"title"=>"記事タイトル","category"=>["音響","マイク"]}
 *                     エラーはfalseを返す
 */
function fetchInfo($page){
  if(!thisPageExisting($page)){
    // 新規記事はfalse
    return false;
  }else{
    // 既存記事は処理続行
    chdir(__DIR__);  // ワークディレクトリを戻す
    chdir("../db");  //ワークディレクトリを../dbに変更
    $json = file_get_contents("all_entry_list.json");
    $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    $entryList = json_decode($json,true); //連想配列に変換

    foreach ($entryList as $value) {
      if($value['id'] == $page){
        $title = $value["title"];
        $category = $value["category"];
        $out = ["title" => $title,"category" => $category];
        return $out;
      }
    }

  }
}

/**
 * 記事タイトルとのそページ番号を取得し連想はいれつで返す
 * leration: search.php
 * @return [type] [description]
 */
function fetchAllIndex(){
  chdir(__DIR__);  // ワークディレクトリを戻す
  chdir("../db");  //ワークディレクトリを../dbに変更
  $json = file_get_contents("all_entry_list.json");
  $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $entryList = json_decode($json,true); //連想配列に変換

  $out = [];
  foreach ($entryList as $value) {
    $out[] = ["title" => $value["title"],"page" => $value["id"],"category" => $value["category"]];
  }
  return $out;
}


/**
 * 記事データ本文やインデックスを一括で保存する関数
 * 受け取りはpostで連想配列形式で送られてくるのでこの関数で受け取る
 * 投げるデータ形式は
 * {
 *  "id": (int), // 省略可、省略時は新規記事扱い
 *  "title": (string),
 *  "html": (sring) // 基本的に<body></body>の中身だけ送られる(<body></body>は来ない)
 *  "description": (string), // 省略可
 *  "author": (string), // 省略可
 *  "eyecatch": (string) // 省略可
 * }
 * @return {int} 作成した記事idを返す
 */
function write_db($data){
// function write_db($title,$page = null){
  /*
    保存するときにはバージョン管理できるように各バージョンごとに１ファイルの
    テキストファイルを作り、そのファイル名と作成日時を管理ようテキストファイル
    で管理する
  */
  $newFlag = !isset($data["page"]); //新規記事ならばtrue、既存はfalse


  // $json = file_get_contents('php://input');  // http://php-archive.net/php/ajax-json/
  // $data = json_decode($json, true);  // POSTで受け取ったjsonを$dataへ代入

  $page = isset($data["page"]) ? $data["page"] : willNextEntryId();
  $title = $data["title"];
  $html = $data["html"];
  $description = isset($data["description"]) ? $data["description"] : "none";
  $author = isset($data["author"]) ? $data["author"] : "名無しさん";
  $eyecatch = isset($data["eyecatch"]) ? $data["eyecatch"] : null;
  $category = isset($data["category"]) ? $data["category"] : null;

  $ip = ip2long($_SERVER["REMOTE_ADDR"]); // アクセス元のipアドレスを取得し整数値に変換して代入

/*デバッグ用のダミーコンテンツ、要らなきゃ消してくれ
// $page = isset($data["page"]) ? $data["page"] : willNextEntryId();
$page = 1;
$title = "S＿タイトル";
$html = "<html><body><h1>ふが</h1></body></html>";
$description = "S_誤字脱字の修正";
$author = isset($data["author"]) ? $data["author"] : "名無しさん";
$eyecatch = isset($data["eyecatch"]) ? $data["eyecatch"] : null;
$ip = 1234567890;

$newFlag = false;
*/
  if($newFlag){
    // 新規記事の保存
    if(!saveEntryBody($page,$title,$description,$html)){return 'err1';}
    if(!newEntryIndex($page,$title,$author,$ip,$description)){return 'err2';}
    if(!addAllEntryList($page,$title,$author,$category,$eyecatch)){return 'err3';}
  }else{
    // 既存記事の保存
    if(!saveEntryBody($page,$title,$description,$html)){return 'err4';}
    if(!addEntryIndex($page,$title,$author,$ip,$description)){return 'err5';}
    if(!addAllEntryList($page,$title,$author,$category,$eyecatch)){return 'err6';}
  }
  return $page;
}

ini_set( 'display_errors', 1 ); // エラーログ表示設定

?>
