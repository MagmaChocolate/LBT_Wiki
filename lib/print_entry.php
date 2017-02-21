<!--
  relation: index.php
-->
<?php
$host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$host .= $_SERVER['HTTP_HOST'];
?>
<div class="main-contents">  <!-- 記事部分 -->
  <h1><?php echo $fetchData["title"];?></h1>
  <div class="tools"><i class="fa fa-pencil fa-2x"></i></div>
</div>
<ul class="breadcrumb-list">  <!-- パンくずリスト -->
  <?php
  if($fetchData["category"] != "none"){
    foreach ($category as $value) {
      echo '<li class="breadcrumb-contents">'.$value.'</li>';
    }
  }
  ?>
</ul>
<div class="eyecatch" style="background-image:url('<?php echo $host; ?>/resource/img/xlr-600x300.jpg')"></div> <!-- アイキャッチ画像 -->
<!-- <div class="description">
  簡単な説明文、検索結果にはここの文章が表示されるようになっている。自動生成でもいいしユーザが書き込んでもいいが、書き込みユーザがこの簡易説明と本文の違いを意識する必要がある
</div> -->
<div class="main-text-area"> <!-- 記事本文 -->
  <?php echo $fetchData["html"];?>


  <h2><i class="fa fa-angle-down fa-1x"></i>セクション区切り</h2>
  <div class="main-text">
    <p>段落で落とすサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル</p>
    <img src="<?php echo $host; ?>/resource/img/S4-300x354.jpg" />
    <p>段落で落とすサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル</p>
  </div>
  <h2><i class="fa fa-angle-down fa-1x"></i>セクション区切り</h2>
  <div class="main-text">
    <p>段落で落とすサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル</p>
    <img src="<?php echo $host; ?>/resource/img/S4-306x179.jpg" />
    <img src="<?php echo $host; ?>/resource/img/ios-750x1334.png" />
    <p>段落で落とすサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル</p>
  </div>
  <h2><i class="fa fa-angle-down fa-1x"></i>セクション区切り</h2>
  <div class="main-text">
    <p>段落で落とすサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル</p>
    <img src="<?php echo $host; ?>/resource/img/M4-1920x1080.jpg" />
  </div>


</div>
</div> <!-- class="container" -->
