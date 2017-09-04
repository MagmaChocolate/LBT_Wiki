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

  <title>LBT_Wiki</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- include FontAwesome -->
  <link rel="stylesheet" href="<?php echo $host;?>/resource/font-awesome/css/font-awesome.min.css">
  <!-- include Bootstrap -->
  <link href="<?php echo $host;?>/resource/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- include slick -->
  <link rel="stylesheet" type="text/css" href="<?php echo $host;?>/resource/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo $host;?>/resource/slick/slick-theme.css"/>
  <style>
  .slide-show-area{
    margin-top: 20px;
    height: 200px;
  }
  .slide-show-area > div{
    height: 100%;
    border: solid 1px black;
  }
  .slide-show-area > div > div{
    height: 100%;
  }
  .first{
    background: white;
  }
  .first > .text{
    float: left;
    /*width: 193px;*/
    width: 50%;
  }
  div.first > img{
    width: 50%;
    max-height: 200px;
    float: left;
  }
  div.second img{
    max-height:200px;
  }
  div.second{
    background-color: #40c842;
  }
  footer{
    height:200px;
  }
  </style>
</head>
<body class="drawer drawer--left ">
  <?php require(__DIR__."/google-analytics.php");?>
  <?php require(__DIR__.'/side-bar.php'); ?>


<!-- メインコンテンツ -->
<div class="main-area">
  <div class="container">
    <div class="row"> <!-- ヘッダー部分 -->
      <header class="col-xs-12">
        <div class="row times">
          <div class="col-xs-2 icon-button"><i class="fa fa-3x fa-times"></i></div>
        </div>
        <div class="row">
          <div class="col-xs-2"><i class="fa fa-bars fa-2x drawer-toggle"></i></div>
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


    <div class="main-contents">  <!-- 記事部分 -->
      <div class="slide-show-area">
        <div class="first col-xs-12">
          <div class="text">
            <h2>LBT_wiki</h2>
            <p>
              LBTのための知識共有サービス
            </p>
            <p>
              ベータ版なのでバグを見つけたら教えてください。
            </p>
          </div>
          <img src="<?php echo $host;?>/resource/img/lbt-logo.png">
          <div class="ver">
            <h3>Ver 4.2</h3>
          </div>
        </div>
        <div class="second col-xs-12">
          <div>
            <img src="<?php echo $host?>/resource/img/home1.png" />
          </div>
        </div>
        <div class="third col-xs-12">
          <div>
            <h2>アップデートについて</h2>
            <p>
              随時アップデートを実施しています、詳細は記事にてまとめています。
            </p>
            <p>
              機能要望など言ってくれれば実装します。
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="main-text-area-"> <!-- 記事本文 -->
      <div>
        <p>LBT_wikiはLBT部員が知識やノウハウなど好きなことを今後のLBT部のために形に残る知識を共有するためのアンオフィシャルなサービスです。</p>
        <p>検索するには上の検索バーで検索できます</p>
        <p>知識を書くには左上の「三」みたいなボタンを押してみてください</p>
        <p><u>画像アップロード機能実装しました！！</u></p>
        <p><b>βテスト版で書いた記事は全て残るので、みなさん書いて！！</b></p>
      </div>
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
<script src="./resource/jquery/jquery-3.1.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="./resource/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>


<!-- drawer.css -->
<link rel="stylesheet" href="./resource/drawer/css/drawer.min.css">
<!-- jquery & iScroll -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<script src="./resource/iscroll/iscroll.js"></script>
<!-- drawer.js -->
<script src="./resource/drawer/js/drawer.min.js"></script>
<script>$(document).ready(function(){$('.drawer').drawer();});</script>
<!-- slick -->
<script type="text/javascript" src="<?php echo $host;?>/resource/slick/slick.min.js"></script>
<script>
$(document).ready(function(){
  $('.slide-show-area').slick({
    autoplay: true,
    autoplaySpead: 5000,
  });
});
</script>

<script src="./resource/js/view.js"></script>
<link href="./resource/css/view.css" rel="stylesheet" />
<style>
div.search-overlay{
  z-index: 1;
}
div.search-result-area{
  z-index: 1;
}
</style>
</body>
</html>
