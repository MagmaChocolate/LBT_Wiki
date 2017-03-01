/*
  relation : index.php
  auther : MagmaChocolate
  lang : javascript, ja-jp
*/


/**
 * 本文、セクション区切り<h2>をアコーディオン化するスクリプト
*/
function initSection(){
  // 折りたたみの実装

  $('div.main-text-area > h2').on('click',function (e){
    if($('i',this).hasClass('fa-angle-down')){
      // 開ける
      $('i',this).removeClass('fa-angle-down');
      $('i',this).addClass('fa-angle-up');
    }else if ($('i',this).hasClass('fa-angle-up')) {
      // 閉める
      $('i',this).removeClass('fa-angle-up');
      $('i',this).addClass('fa-angle-down');
    }
    $(this).next('div').toggle();
  });
}

/**
 * 本文の画像をセンタリングするbootstrapのclass名を付加する
 */
function initImgCenter(){
  $('div.main-text img').addClass('center-block');
}
initImgCenter();
initSection();
