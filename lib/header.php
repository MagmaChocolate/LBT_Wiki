<!--
 relaton: index.php
 @param $title <meta>のタイトルの文字列
 -->
<?php
$host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$host .= $_SERVER['HTTP_HOST'];
?>
<!DOCTYPE HTML>
<html>
<head>
  <!-- TwitterCards -->
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@LBT_LiSA" />
  <meta name="twitter:title" content="<?php echo ($fetchData["title"].' | LBT_wiki'); ?>" />
  <meta name="twitter:description" content="LBT部員のための知識共有サービス" />
  <meta name="twitter:image" content="<?php echo $host?>/resource/img/twitter-cards.png" />

  <!-- favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="/manifest.json">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#000000">
  <meta name="theme-color" content="#ffffff">

  <title><?php echo ($fetchData["title"].' | LBT_wiki'); ?></title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- include FontAwesome -->
  <link rel="stylesheet" href="<?php echo $host; ?>/resource/font-awesome/css/font-awesome.min.css">
  <!-- include Bootstrap -->
  <link href="<?php echo $host; ?>/resource/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="drawer drawer--left ">
  <?php require(__DIR__."/google-analytics.php");?>
<?php include(__DIR__.'/side-bar.php');  ?>


<!-- メインコンテンツ -->
<div class="main-area">
  <div class="container">
    <div class="row"> <!-- ヘッダー部分 -->
      <header class="col-xs-12">
        <div class="row times">
          <div class="col-xs-2 icon-button"><i class="fa fa-3x fa-times"></i></div>
        </div>
        <div class="row">
          <div class="col-xs-2 icon-button drawer-toggle"><i class="fa fa-bars fa-2x"></i></div>
          <div class="col-xs-9 search-area">
            <div class="row">
              <div class="col-xs-2"><i class="fa fa-search fa-lg" ></i></div>
                <form method="post" action="http://lbt.webcrow.jp/index.php?cmd=category">
                  <input class="search-text col-xs-10" type="text" name="search" placeholder="検索フィード" />
                </form>
            </div>
          </div>
        </div>
      </header>
    </div>

    <div class="search-overlay"></div>
    <div class="search-result-area">
      <div class="row">
        <div class="col-xs-12 search-result">
          <table class="search-result">
            <tr class="allSearchEntry"><td><i class="fa fa-file-text-o"></i>全文検索</td></tr>
          </table>
        </div>
      </div>
    </div>
