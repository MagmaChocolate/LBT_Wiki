<!DOCTYPE HTML>
<html>
<head>
  <!-- favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
  <link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="../manifest.json">
  <link rel="mask-icon" href="../safari-pinned-tab.svg" color="#000000">
  <meta name="theme-color" content="#ffffff">

  <title>LBT_Wiki</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- include FontAwesome -->
  <link rel="stylesheet" href="<?=$host?>/resource/font-awesome/css/font-awesome.min.css">
  <!-- include Bootstrap -->
  <link href="<?=$host?>/resource/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="drawer drawer--left ">
<?php include('../lib/side-bar.php');  ?>


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
                <form method="GET" action="search.php">
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

    <div class="main-contents">  <!-- 記事部分 -->
      <h1>ヘルプ</h1>
      <div class="tools"><i class="fa fa-pencil fa-2x"></i></div>
    </div>
    <ul class="breadcrumb-list">  <!-- パンくずリスト -->
      <li class="breadcrumb-contents">LBT_Wiki</li>
      <li class="breadcrumb-contents">ヘルプ</li>
    </ul>
    <div class="main-text-area"> <!-- 記事本文 -->
      <script src="https://gist.github.com/magcho/72e648c007564bb71a538ad844397e94.js"></script>
      <p>
        こちらはヘルプページですが作り途中のため内容完全ではありません。お手数ですがお困りの際は開発者へTwitterやLINEなどから連絡ください。
      </p>
      <p>
        開発者Twitter <a href="https://twitter.com/LiSA_sue0527">@LiSA_sue0527</a><br />
        開発者Github <a href="https://github.com/MagCho/">MagmaChocolate</a>
      </p>
    </div>
  </div> <!-- class="container" -->


    <footer class="footer">  <!-- フッター -->


      <div class="copy-write">
        <h3>LBT_Wiki</h3>
        <div class="text">
          このサイトの全てに対し無断転載を禁じます。
          Copywrite 2017 LBT部のみなさん.
        </div>
      </div>
      <div class="links">
        <a href="<?=$host?>/help/">ヘルプ</a>
        <a href="https://twitter.com/LiSA_sue0527">コンタクト</a>
      </div>
    </footer>
  <!-- </div> -->
</div>


<!-- Include JQery -->
<script src="<?=$host?>/resource/jquery/jquery-3.1.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?=$host?>/resource/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>


<!-- drawer.css -->
<link rel="stylesheet" href="<?=$host?>/resource/drawer/css/drawer.min.css">
<!-- jquery & iScroll -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<script src="<?=$host?>/resource/iscroll/iscroll.js"></script>
<!-- drawer.js -->
<script src="<?=$host?>/resource/drawer/js/drawer.min.js"></script>
<script>$(document).ready(function(){$('.drawer').drawer();});</script>

<script src="<?=$host?>/resource/js/view.js"></script>
<link href="<?=$host?>/resource/css/view.css" rel="stylesheet" />
</body>
</html>
