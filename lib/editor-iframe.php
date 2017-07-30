<?php
/**
 * エディター内でインラインフレームとして既存の生地のデータを読み込む
 * @GET['page'] {int} 記事番号
 * @GET['var'] {int} 記事バージョン（省略時は最新を取得）
 * @return {string} 記事本文を返す
 */
$host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$host .= $_SERVER['HTTP_HOST'];
require(__DIR__.'/database.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?=$host?>/resource/css/editor-iframe.css" />
  </head>
  <body>
    <?php
    if(isset($_GET['page'])){
      if(isset($_GET['var'])){
        $data = read_db($_GET['page'],$_GET['var']);
      }else{
        $data = read_db($_GET['page']);
      }
      if($data !== false){
        echo $data['html'];
      }
    }
    ?>
    <!-- Include JQery -->
    <script src="<?=$host?>/resource/jquery/jquery-3.1.1.min.js"></script>
    <script>
$(function(){$('div[style]:not([class]):not([id])').css('display','none');});</script>
  </body>
</html>
