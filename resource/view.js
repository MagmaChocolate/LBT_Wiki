/*
  relation : index.php
  auther : MagmaChocolate
  lang : javascript, ja-jp
*/


/**
 * 本文、セクション区切り<h2>をアコーディオン化するスクリプト
*/
function initSection(){
  $(this).next('div').toggle();
  $('div.main-text h2').on('click',function (){
    if($('i',this).hasClass('fa-caret-down')){
      $('i',this).removeClass('fa-caret-down');
      $('i',this).addClass('fa-caret-up');
    }else if ($('i',this).hasClass('fa-caret-up')) {
      $('i',this).removeClass('fa-caret-up');
      $('i',this).addClass('fa-caret-down');
    }
  });
}
initSection();
