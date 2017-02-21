<?php
/**
 * getのcmd属性に従っって処理を分ける
 * @return [type] [description]
 */
function init(){
  if($_GET["cmd"] == "view"){
    require("./lib/view.php");
  }
}
init();
?>
