<!--
  relation: index.php
-->
<?php
$host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$host .= $_SERVER['HTTP_HOST'];

/**
 * データベースの記事データをhtmlで表示した時にセクションで折り畳めるようにする
 * クロージャー関数、いわゆる即時関数
 * @param {string} $fetchData["html"]を与える
 * @return {string} $fetchData["html"]に返して
 */
function replace_entry($fetchData){
  $html_txt = preg_replace('/<\/h2>/','</h2><div class="main-text-area">',$fetchData["html"]);
  $html_txt = preg_replace('/(<h2 class="section">)/','$1<i class="fa fa-angle-down fa-1x"></i>',$html_txt,1);
  $html_txt = preg_replace('/(\n.*)(<h2 class="section">)/','</div>$2<i class="fa fa-angle-down fa-1x"></i>',$html_txt);
  $html_txt = $html_txt.'</div>';
  return $html_txt;
};
/**
 * 記事中のURLをアンカータグに置換する関数
 * @param  {string} $value 本文テキスト(html形式)
 * @return {string}        アンカータグに置換した本文テキスト(html形式)
 */
function makeLink($value){  // http://www.webcyou.com/?p=964
  //画像タグ置換よけ
  $value = mb_ereg_replace('(<img src=")(http|https|ftp)://([[a-zA-Z0-9]\+\$\;\?\.%,!#~*/:@&=_-]+)">','[image](\\3)',$value);
  //URLアンカー化
  $value = mb_ereg_replace("(http|https|ftp)(://[[a-zA-Z0-9]\+\$\;\?\.%,!#~*/:@&=_-]+)", '<a href="\\1\\2">\\1\\2</a>' , $value);
  // 画像タグ置換よけ、戻し
  $value = mb_ereg_replace('\[image\]\(([[a-zA-Z0-9]\+\$\;\?\.%,!#~*/:@&=_-]+)\)','<img src="http://\\1" />',$value);
return $value;
}
// $fetchData["html"] = escape_and_linkify($fetchData["html"]);
// $fetchData["html"] = url_henkan($fetchData["html"]);
 // $fetchData["html"] = replace_entry($fetchData);
$fetchData["html"] = makeLink($fetchData["html"]);
?>
<div class="main-contents">  <!-- 記事部分 -->
  <h1><?php echo escapeHtml($fetchData["title"]);?></h1>
  <div class="tools"><a href="<?php echo $host?>/index.php?cmd=edit&page=<?php echo $_GET["page"]?>"><i class="fa fa-pencil fa-2x"></i></a></div>
</div>
<ul class="breadcrumb-list">  <!-- パンくずリスト -->
  <?php
  if($fetchData["category"] != "none"){
    echo '<li class="breadcrumb-contents">LBT_Wiki</li>';
    foreach ($fetchData["category"] as $value) {
      echo '<li class="breadcrumb-contents">'.$value.'</li>';
    }
  }
  ?>
</ul>
<?php
  if($fetchData["eyecatch"] === "none"){
    $fetchData["eyecatch"] = "/resource/img/eyecatch-none.png";
  }
?>
<div class="eyecatch" style="background-image:url('<?php echo $host.$fetchData["eyecatch"]; ?>')"></div>
<!-- <div class="description">
  簡単な説明文、検索結果にはここの文章が表示されるようになっている。自動生成でもいいしユーザが書き込んでもいいが、書き込みユーザがこの簡易説明と本文の違いを意識する必要がある
</div> -->
<div class="main-text-area"> <!-- 記事本文 -->
  <?php echo $fetchData["html"];?>
</div>
</div> <!-- class="container" -->
