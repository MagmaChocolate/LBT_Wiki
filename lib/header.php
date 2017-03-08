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
