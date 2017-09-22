<?php
/**
 * ランダムに記事にリダイレクトさせる
 */
require(__DIR__."/database.php");
$range_max = willNextEntryId() - 1;
while (true) {
  $random_page = rand(0,$range_max);
  $pageState = fetchInfo($random_page);
  if($pageState['state'] === "public"){
    break;
  }
}
header("location:$random_page");
exit();
