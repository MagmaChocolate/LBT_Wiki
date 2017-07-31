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
  <link rel="stylesheet" href="<?=$host?>/resource/font-awesome/css/font-awesome.min.css">
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
    <div class="header-ber" id="entry-info-ber">
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
    </div>
    <div class="header-ber" id="editor-info-ber">
      <div class="icon" id="undo">
        <i class="fa fa-undo fa-2x"></i>
      </div>
      <div class="icon" id="redo">
        <i class="fa fa-repeat fa-2x"></i>
      </div>
      <div class="icon" id="insert_image">
        <i class="fa fa-picture-o fa-2x"></i>
      </div>
      <div class="icon-drop text_style_show">
        <i class="fa fa-font fa-2x"></i>
        <i class="fa fa-angle-down"></i>
      </div>
      <div class="save">
        保存
      </div>
      <div class="show-before-config">
        <i class="fa fa-cog fa-2x"></i>
      </div>
    </div>
    <div class="tool-box-popup font-style">
      <table>
        <tr  onclick="format_headline()" id="tr_format_headline">
          <td>
            <div onclick="format_headline" class="font-style-table" id="headline">
              <u><i class="fa  fa-angle-down fa-1x"></i>
              <i class="text">見出し</i></u>
            </div>
          </td>
        </tr>
        <tr id="tr_bold">
          <td>
            <div onclick="text_bold()" class="font-style-table bold">
              <i class="text">太字</i>
            </div>
          </td>
        </tr>
        <tr id="tr_underline">
          <td>
            <div onclick="text_underline()" class="font-style-table underline">
              <i class="text">下線</i>
            </div>
          </td>
        </tr>
        <tr id="tr_cancel">
          <td>
            <div onclick="text_cancel()" class="font-style-table cancel">
              <i class="text">取り消し線</i>
            </div>
          </td>
        </tr>
        <tr id="tr_list">
          <td>
            <div onclick="text_list()" class="font-style-table list">
              <i class="text">・箇条書き</i>
            </div>
          </td>
        </tr>
        <tr id="tr_indent">
          <td>
            <div onclick="text_indent_show()" class="font-style-table indent">
              <i class="text">インデント</i></i>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div id="indent_popup">
      <table>
        <tr>
          <td>
            <div onclick="text_indent('down')" class="font-style-table indent">
              <i class="fa fa-indent fa-1x"></i>
              <i class="text">字下げ</i>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div onclick="text_indent('up')" class="font-style-table indent">
              <i class="fa fa-outdent fa-1x"></i>
              <i class="text">字上げ</i>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </header>
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
  <div class="main-contents">
    <iframe id="editorframe" frameborder="0" src="<?=$host?>/lib/editor-iframe.php<?php echo isset($_GET['page'])?'?page='.$_GET['page']:''?><?php echo isset($_GET['var'])?'&var='.$_GET['var']:''?>"></iframe>
    <div class="setting" id="editor-setting">
      <div>
        エディタ領域のサイズ調整
      </div>
      <div class="setting" id="height-setting-area">
        <div class="button" id="minus">
          <i class="fa fa-minus fa-1x"></i>
        </div>
        <div class="num" id="editor-height">
          5
        </div>
        <div class="button" id="plus">
          <i class="fa fa-plus fa-1x"></i>
        </div>
      </div>
    </div>
    <form id="foo" style="display:none">
      <input id="file" name="file" type="file" />
    </form>
    <input id="hoge" type="hidden" value="hoge">

    <div class="editor-rapper">
      <div id="pre-text" style="display:none" phtml="<?php echo isset($html)?$html:""; ?>" pcategory="<?php echo isset($data['category'][0])?$data['category'][0]:"";?>"</div>
    </div>
  </div>


  <!-- Include JQery -->
  <script src="<?=$host?>/resource/jquery/jquery-3.1.1.min.js"></script>
  <!-- Setup designMode -->
  <script>
    editor = document.getElementsByTagName("iframe")[0].contentDocument;
    // editor.designMode = "On";
  </script>
  <script src="<?=$host?>/resource/js/editor.js"></script>
  <link href="<?=$host?>/resource/css/editor.css" rel="stylesheet" />
</body>
</html>
