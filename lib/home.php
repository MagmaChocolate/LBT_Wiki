<?php
$host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$host .= $_SERVER['HTTP_HOST'];
?>
<!DOCTYPE HTML>
<html>
<head>
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
  }
  .slide-show-area > div{
    height: 200px;
    border: solid 1px black;
  }

  .first{
    background: white;
    padding-left: 10px;
  }
  .first > .text{
    float: left;
    /*width: 193px;*/
    width: 50%;
  }
  div.first > img{
    width: 50%;
    max-height: 200px;
    max-width: 200px;
    float: left;
  }
  </style>
</head>
<body class="drawer drawer--left ">
<!-- サイドメニュー -->
<nav class="side-menu-area drawer-nav">
  <ul class="list-area drawer-menu">
    <a href="<?php echo $host?>"><li class="list-contents menu-home"><i class="fa fa-home fa-lg"></i><div class="list-text">ホーム</div></li></a>
    <a href="<?php echo $host."/index.php?cmd=category"?>"><li class="list-contents menu-category"><i class="fa fa-list-ul fa-lg"></i><div class="list-text">カテゴリ</div></li></a>
    <a href="<?php echo $host."/index.php?cmd=random"?>"><li class="list-contents menu-random"><i class="fa fa-random fa-lg"></i><div class="list-text">おまかせ</div></li></a>
    <li class="list-blank"></li>
    <a href="<?php echo $host."/index.php?cmd=edit"?>"><li class="list-contents menu-newpage"><i class="fa fa-file-o fa-lg"></i><div class="list-text">新規ページ</div></li></a>
    <a href="<?php echo $host."/index.php?cmd=admin"?>"><li class="list-contents menu-admin"><i class="fa fa-cog fa-lg"></i><div class="list-text">管理メニュー</div></div></li></a>
  </ul>
</nav>


<!-- メインコンテンツ -->
<div class="main-area">
  <div class="container">
    <div class="row"> <!-- ヘッダー部分 -->
      <header class="col-xs-12">
        <div class="row">
          <div class="col-xs-2"><i class="fa fa-bars fa-2x drawer-toggle"></i></div>
          <div class="col-xs-9 search-area">
            <div class="row">
              <div class="col-xs-2"><i class="fa fa-search fa-lg" ></i></div>
                <form method="GET" action="search.php">
                  <input class="search-text col-xs-10" type="text" name="search" value="検索フィード" />
                </form>
            </div>
          </div>
        </div>
      </header>
    </div>


    <div class="main-contents">  <!-- 記事部分 -->
      <div class="slide-show-area">
        <div class="first">
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
            <h3>Ver 0.1β</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="main-text-area-"> <!-- 記事本文 -->
      <div>
        <p>LBT_wikiはLBT部員が知識やノウハウなど好きなことを今後のLBT部のために形に残る知識を共有するためのサービスです。</p>
        <p>検索するには上の検索バーで検索できます</p>
        <p>知識を書くには左上の「三」みたいなボタンを押してみてください</p>
        <p><b>βテスト版で書いた知識は全て残るので、みなさん書いて！！</b></p>
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
        <a href="hoge">ヘルプ</a>
        <a href="hoge">コンタクト</a>
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
    autoplaySpead: 3000,
  });
});
</script>

<script src="./resource/js/view.js"></script>
<link href="./resource/css/view.css" rel="stylesheet" />
</body>
</html>
