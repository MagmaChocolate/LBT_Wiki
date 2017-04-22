<?php
require('./database.php');
header('Content-type: text/html');
if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
  if(isset($_GET['page'])){
    $dirPath = "../db/entry/img/".$_GET["page"]."/";
    if(!file_exists($dirPath)){mkdir($dirPath,0777);}
  }else {
    $dirPath = "../db/entry/img/other/";
  }
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $dirPath . $_FILES["file"]["name"])) {
    chmod($dirPath . $_FILES["file"]["name"], 0644);
    $host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
    $host .= $_SERVER['HTTP_HOST'];
    $data = array('messgae' => 'Succes',
                  'code' => 1,
                  'url' => $host."/db/entry/img/".$_GET["page"]."/".$_FILES["file"]["name"]);
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
