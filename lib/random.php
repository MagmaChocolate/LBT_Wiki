<?php
/**
 * ランダムに記事にリダイレクトさせる
 */
require(__DIR__."/database.php");
$range_max = willNextEntryId() - 1;
$random_page = rand(0,$range_max);
header("location:index.php?cmd=view&page=$random_page");
exit();
