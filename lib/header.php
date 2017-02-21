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
  <title><?php echo $fetchData["title"] | LBT_wiki; ?></title>
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
