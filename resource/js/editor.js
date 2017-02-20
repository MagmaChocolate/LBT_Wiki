/*
  relation : index.php
  auther : MagmaChocolate
  lang : javascript, ja-jp
*/

/**
 * <textarea>にフォーカスしている時にヘッダーを隠す
 * フォーカスオフした時のイベントが取れない（理解していない）ので実装見送り
 */
// var ckeditorForCss = CKEDITOR.instances['visualEditor'];
// ckeditorForCss.on('focus', function(e){
//   $('header').css('display','none');
// });

$(function(){
  $('.save').on('click',function(){
    var sendText = {
      'page': 4,
      'title': 'ajaxテスト',
      'html':CKEDITOR.instances.visualEditor.getData(),
      'author': 'MG',
    };
    $.ajax({
      type: 'POST',
      url: './lib/ajax.php',
      data: sendText,
      dataType: 'json',  //レスポンスとして受け取ったデータタイプの指定レスポンスは変数dataに格納される
      cache: false,
      timeout: 1000
    })
    .done(function(data){  // 通信成功時に呼び出される部分
      console.log(data);
    })
    .fail(function(data){  // 通信失敗時に呼び出される部分
      console.log(data);
    });
  });
});
