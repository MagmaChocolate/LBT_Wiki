/*
  relation : index.php
  auther : MagmaChocolate
  lang : javascript, ja-jp
*/


/**
 * 本文、セクション区切り<h2>をアコーディオン化するスクリプト
*/
function initSection(){
  $('div.main-text h2').on('click',function (){
    if($('i',this).hasClass('fa-angle-down')){
      $('i',this).removeClass('fa-angle-down');
      $('i',this).addClass('fa-angle-up');
    }else if ($('i',this).hasClass('fa-angle-up')) {
      $('i',this).removeClass('fa-angle-up');
      $('i',this).addClass('fa-angle-down');
    }
    $(this).next('div').toggle();
  });
}
initSection();
