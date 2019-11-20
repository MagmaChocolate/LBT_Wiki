<?php
require('./database.php');
header('Content-type: text/html');
if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
   // 保存ファイル名決定
   preg_match('/\.(.*)/',$_FILES["file"]["name"],$a);
   $fileType = $a[0];
   $SAVE_NAME = date('YmdHis',time()).rand(10,99).$fileType;
  if(isset($_GET['page'])){
    $dirPath = "../db/entry/img/".$_GET["page"]."/";
    if(!file_exists($dirPath)){mkdir($dirPath,0755);}
  }else {
    $dirPath = "../db/entry/img/other/";
  }
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $dirPath . $SAVE_NAME)) {
    chmod($dirPath . $SAVE_NAME, 0644);
    // $host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
    // $host .= $_SERVER['HTTP_HOST'];
    $host = "https://lbt-wiki.magcho.com";
    $data = array('messgae' => 'Succes',
                  'code' => 1);
    if(isset($_GET["page"])){
      $data['url'] = $host."/db/entry/img/".$_GET["page"]."/".$SAVE_NAME;
    }else {
      $data['url'] = $host."/db/entry/img/other/".$SAVE_NAME;
    }
    echo json_encode($data);
  } else {
    $data = array('messgae' => 'Failed. Can`t moved img data in server.',
                  'code' => 3);
    echo json_encode($data);
  }
} else {
  $data = array("message" => "Faild. Don`t receved image data in server.",
                "code" => "2");
  echo json_encode($data);
}
 ?>
