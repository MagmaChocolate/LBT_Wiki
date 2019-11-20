<!--
  auther : MagmaChocolate
  lang : php, ja-jp
  relation: view.php
-->
<!--
not found時に表示するページ
-->
<?php
// $host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
// $host .= $_SERVER['HTTP_HOST'];
    $host = "https://lbt-wiki.magcho.com";
$fetchData["title"] = "アクセスしたURLのページはありませんでした";
require("header.php");
?>


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
      それでも解決しない場合は<a href="https://twitter.com/LiSA_sue0527">ここから</a>管理している人に連絡すればどうにかしてくれるかも。
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
        <a href="<?=$host?>/help/">ヘルプ</a>
        <a href="https://github.com/magcho/">github</a>
      </div>
    </footer>
  <!-- </div> -->
</div>


<?php require("footer.php");
