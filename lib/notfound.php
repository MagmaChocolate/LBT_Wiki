<!--
  auther : MagmaChocolate
  lang : php, ja-jp
  relation: view.php
-->
<!--
not found時に表示するページ
-->
<?php
$host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$host .= $_SERVER['HTTP_HOST'];
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>アクセスしたURLはありませんでした | LBT_Wiki</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- include FontAwesome -->
  <link rel="stylesheet" href="<?php echo $host; ?>/resource/font-awesome/css/font-awesome.min.css">
  <!-- include Bootstrap -->
  <link href="<?php echo $host; ?>/resource/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="drawer drawer--left ">
<!-- サイドメニュー -->
<nav class="side-menu-area drawer-nav">
  <ul class="list-area drawer-menu">
    <li class="list-contents menu-home"><i class="fa fa-home fa-lg"></i><div class="list-text">ホーム</div></li>
    <li class="list-contents menu-category"><i class="fa fa-list-ul fa-lg"></i><div class="list-text">カテゴリ</div></li>
    <li class="list-contents menu-random"><i class="fa fa-random fa-lg"></i><div class="list-text">おまかせ</div></li>
    <li class="list-blank"></li>
    <li class="list-contents menu-newpage"><i class="fa fa-file-o fa-lg"></i><div class="list-text">新規ページ</div></li>
    <li class="list-contents menu-admin"><i class="fa fa-cog fa-lg"></i><div class="list-text">管理メニュー</div></div></li>
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
      <h1>アクセスしたURLのページはありませんでした。</h1>
    </div>
    <div class="eyecatch" style="background-image:url('<?php echo $host; ?>/resource/img/notfound.jpg')"></div> <!-- アイキャッチ画像 -->
    <div class="description">
      アクセスしたページはありませんでした、このページが表示されてしまった原因は
      <ul>
        <li>サーバーのエラー</li>
        <li>この記事が現在非公開になっている</li>
        <li>URLが変更になった</li>
        <li>管理人のミス</li>
      </ul>
      などが考えられます。なのでまずは<b>画面上方の検索を使ってみることをオススメします。</b><br />
      それでも解決しない場合は<a href="<?php echo $host;?>/contact/index.html">ここから</a>管理している人に連絡すればどうにかしてくれるかも。
    </div>
  </div> <!-- class="container" -->


    <footer class="footer" style="padding-top: 20px;">  <!-- フッター -->
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
<script src="<?php echo $host; ?>/resource/jquery/jquery-3.1.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo $host; ?>/resource/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>


<!-- drawer.css -->
<link rel="stylesheet" href="<?php echo $host; ?>/resource/drawer/css/drawer.min.css">
<!-- jquery & iScroll -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<script src="<?php echo $host; ?>/resource/iscroll/iscroll.js"></script>
<!-- drawer.js -->
<script src="<?php echo $host; ?>/resource/drawer/js/drawer.min.js"></script>
<script>$(document).ready(function(){$('.drawer').drawer();});</script>

<script src="<?php echo $host; ?>/resource/js/view.js"></script>
<link href="<?php echo $host; ?>/resource/css/view.css" rel="stylesheet" />
</body>
</html>
