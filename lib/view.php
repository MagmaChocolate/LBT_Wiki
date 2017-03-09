<?php
/*
  auther : MagmaChocolate
  lang : php, ja-jp
*/


/**
 * pageに指定した記事が存在しなかった時にnotfoundを返す
 * @return [type] [description]
 */
function notFound(){
  require (__DIR__."/notfound.php");
  return true;
}



/*
* ## URL option
* get   int   記事id
*/
function view(){
  //処理部の読み込み
  require(__DIR__.'/database.php');

  $page = $_GET["page"];
  if(isset($$_GET["ver"])){
    $ver = $_GET["ver"];
    $fetchData = read_db($page,$ver);
  }else{
    $fetchData = read_db($page);
  }
  if($fetchData === false){
    notFound();
    return false;
  }


  // 出力部の読み込みと実行
  require(__DIR__.'/header.php');
  require(__DIR__.'/print_entry.php');
  require(__DIR__.'/footer-area.php');
  require(__DIR__.'/footer.php');

}
view();
