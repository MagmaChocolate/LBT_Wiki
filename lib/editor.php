<?php
$host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$host .= $_SERVER['HTTP_HOST'];
?>
<!doctype html>
<html>
<head>
  <!-- TwitterCards -->
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@LBT_LiSA" />
  <meta name="twitter:title" content="<?php echo isset($info)?$info["title"]."を編集中":"新規記事の作成"?> | LBT_Wiki" />
  <meta name="twitter:image" content="<?php echo $host?>/resource/img/twitter-cards.png" />

  <title><?php echo isset($info)?$info["title"]."を編集中":"新規記事の作成"?> | LBT_Wiki</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- include FontAwesome -->
  <link rel="stylesheet" href="./resource/font-awesome/css/font-awesome.min.css">
</head>
<body>
  <?php require(__DIR__."/google-analytics.php");?>
  <script>
    var newFlag = <?php echo !isset($info)?"true":"false"?>;
  </script>
  <div class="entry-config before">
    <div class="text"><?php echo isset($info)?$info["title"]."を編集中":"新規記事の作成"?></div>
    <div class="title area" >
      <span class="title">記事タイトル</span>
      <span class="essential">※必須です</span>
      <input class="form" id="title-form" type="text" <?php if(isset($info))echo 'value="'.$info["title"].'"'?>/>
    </div>
    <div class="category area" >
      <span class="title">カテゴリー</span>
      <span class="option">※任意です</span>
      <form>
        <select class="first">
          <option value="">▼カテゴリーを選択してください▼</option>
          <option value="音響">音響</option>
          <option value="照明">照明</option>
          <option value="袖">袖</option>
          <option value="全体">全体</option>
          <option value="その他">その他</option>
        </select>
      </form>
      <div class="submit-button">
        OK
      </div>
      <div class="attention"></div>
    </div>
  </div>

  <div class="entry-config after" style="display:none">
    <div class="text">今回の編集の概要</div>
    <div class="descpretion area">
      <span class="title">今回の編集の概要</span>
      <span class="option">※任意です</span>
      <textarea class="form" id="description" placeholder="（例） 誤字脱字の修正"></textarea>
    </div>
    <div class="author area">
      <span class="title">ニックネーム</span>
      <span class="option">※任意です</span>
      <input class="form" type="text"/>
    </div>
    <div class="submit-button">
      送信
    </div>
  </div>
  <div class="loading-animation">
    <i class="fa fa-2x fa-check" style="display:none"></i>
    <i class="fa fa-2x fa-exclamation-triangle" style="display:none"></i>
    <i class="fa fa-2x fa-spinner fa-pulse"></i>
    <span class="text"></span>
  </div>
  <div class="eidtor-overlay"></div>
  <div class="upper-mask"></div>

  <header>
    <div class="icon">
      <i class="fa fa-arrow-left fa-2x"></i>
    </div>
    <div class="title">
      <?php if(isset($info))echo $info["title"] ?>
    </div>
    <div class="save">
      保存
    </div>
    <div class="show-before-config">
      <i class="fa fa-cog fa-2x"></i>
    </div>
  </header>

  <div class="main-contents">
    <div class="editor-rapper">
      <textarea name="visual-editor" id="visualEditor"></textarea>
      <?php
  if(isset($_GET["page"])){
        $page = $_GET["page"];
        if( isset($_GET["ver"]) ){
          $ver = $_GET["ver"];
          $data = read_db($page,$ver);
        }else{
          $data = read_db($page);
        }
        $html = [];
        $html = htmlspecialchars($data['html']);
        // $html = json_encode($html,JSON_UNESCAPED_UNICODE);
  }
       ?>
      <div id="pre-text" style="display:none" phtml="<?php echo isset($html)?$html:""; ?>" pcategory="<?php echo isset($data['category'][0])?$data['category'][0]:"";?>"</div>
    </div>
  </div>


<!-- Include JQery -->
<script src="./resource/jquery/jquery-3.1.1.min.js"></script>
<!-- CKEditorの呼び出し -->
<script src="./resource/ckeditor/ckeditor.js"></script>
  <script>
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace( 'visualEditor' );
  </script>
  <script src="./resource/js/editor.js"></script>
  <link href="./resource/css/editor.css" rel="stylesheet" />
</body>
</html>
