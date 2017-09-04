<?php
require_once(__DIR__.'/common.php');
$host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$host .= $_SERVER['HTTP_HOST'];

$fetchData["title"] = 'カテゴリー一覧';
require(__DIR__."/header.php");
?>
<style>
.category-area{
  border: solid 1px black;
  font-weight: bold;
  padding-top: 20px;
  text-align: center;
  background: #fbfbfb;
}
.main-contents > h1{
  border-bottom: solid 1px #eaecf0;
  padding-bottom: 0px;
}
li.category-list{
  font-size: 1.3em;
}
div.contents-count{
  text-align: right;
  /*float: right;*/
  display: block;
  margin-top: 5px;
  margin-bottom: 5px;
}
</style>

    <div class="main-contents">  <!-- 記事部分 -->
      <h1>カテゴリーごとの一覧</h1>
      <div class="category-area">
        <p>現在LBT_Wikiに存在する全記事の一覧です。</p>
        <p>そのうち５０音順に並ぶ様にアップデート予定です</p>
      </div>
    </div>

    <div class="main-text-area"> <!-- 記事本文 -->
      <?php
        require(__DIR__."/database.php");
        $allEntryInfo = fetchAllIndex();

        // カテゴリ指定なし
        foreach ($allEntryInfo as $value2) {
          if($value2["category"] == "none"){
            if(!$noneFlag){
              echo '<h2><i class="fa fa-angle-up fa-1x"></i>カテゴリー指定なし</h2><div class="main-text"><ul class="category-list">';
            }
            if($value2['state'] == 'public'){
              echo '<a href="'.$host.'/'.$value2["page"].'"><li class="category-list">'.escapeHtml($value2["title"]).'</li></a>';
            }
            $noneFlag = true;
          }
        }
        echo '</ul></div>';

        // カテゴリー指定あり
        $categoryList = ["音響","照明","袖","全体","その他"];
        foreach ($categoryList as $value1) {
          echo '<h2><i class="fa fa-angle-up fa-1x"></i>'.$value1.'</h2><div class="main-text"><ul class="category-list">';
          foreach ($allEntryInfo as $value2) {
            if($value2["category"][0] == $value1){
              if($value2['state'] == 'public'){
                echo '<a href="'.$host.'/'.$value2["page"].'"><li class="category-list">'.escapeHtml($value2[title]).'</li></a>';
              }
            }
          }
          echo '</ul></div>';
        }
      ?>
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

<script src="<?php echo $host; ?>/resource/js/category.js"></script>
<link href="<?php echo $host; ?>/resource/css/view.css" rel="stylesheet" />
</body>
</html>
