<?php
/**
 * getのcmd属性に従っって処理を分ける
 * @return [type] [description]
 */
function init(){
  if(!isset($_GET["cmd"])){
    require(__DIR__."/lib/home.php");
    return true;
  }
  switch ($_GET["cmd"]){
    case "view":
      require(__DIR__."/lib/view.php");
      break;

    case "edit":
      if(isset($_GET["page"])){
        // 既存記事
        require(__DIR__."/lib/database.php");
        $info = fetchInfo($_GET["page"]);
        if($info === false){
          require(__DIR__."/lib/notfound.php");
          return true;
        }
        require(__DIR__."/lib/editor.php");
      }else{
        // 新規記事
        require(__DIR__."/lib/editor.php");
      }
      break;

    case "category":
      require(__DIR__."/lib/category.php");
      break;

    case "random":
      require(__DIR__."/lib/random.php");
      break;

    case "admin":
      require(__DIR__."/lib/admin.php");
      break;

    default:
      require(__DIR__."/lib/notfound.php");
      break;
  }
}
init();
?>
