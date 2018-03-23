<!--
  relation: index.php
-->
<?php
require_once(__DIR__.'/common.php');
$host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$host .= $_SERVER['HTTP_HOST'];
?>
<footer class="footer">  <!-- フッター -->
  <div class="last-edit">
    <i class="fa fa-history"></i>最終更新: <?php echo escapeHtml($fetchData["author"]);?><i class="fa fa-angle-double-right fa-1x"></i>
  </div>

  <div class="relation-entry">  <!-- 関連記事 -->
    <h2>関連記事</h2>
    <div class="content">
      <a href="hoge">
        <div class="img-rapper"><div class="img" style="background-image: url('<?php echo $host; ?>/resource/img/xlr-600x300.jpg')"></div></div>  <!-- 関連記事のアイキャッチ画像 -->
        <div class="title">関連記事はこれだ</div>
      </a>
      <a href="hoge">
        <div class="img-rapper"><div class="img" style="background-image: url('<?php echo $host; ?>/resource/img/xlr-200x118.jpg')"></div></div>  <!-- 関連記事のアイキャッチ画像 -->
        <div class="title">関連記事はこれか？</div>
      </a>
      <a href="hoge">
        <div class="img-rapper"><div class="img" style="background-image: url('<?php echo $host; ?>/resource/img/xlr-600x300.jpg')"></div></div>  <!-- 関連記事のアイキャッチ画像 -->
        <div class="title">関連記事はこっちかも</div>
      </a>
    </div>
  </div>

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
