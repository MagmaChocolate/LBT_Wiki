/*
  relation : index.php
  auther : MagmaChocolate
  lang : javascript, ja-jp
*/

/**
 * <textarea>にフォーカスしている時にヘッダーを隠す
 */
 var ckeditorForCss = CKEDITOR.instances['visual-editor'];
 ckeditorForCss.on('focus', function(e){
    $('header').css('display','none');
 });
