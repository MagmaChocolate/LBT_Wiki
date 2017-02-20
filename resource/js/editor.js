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
      'text':CKEDITOR.instances.visualEditor.getData(),
      'author': 'MG'
    };
    console.log(sendText);
  });
});
$(function(){
  $('.save').on('click',function(){
    var sendText = {
      'html':CKEDITOR.instances.visualEditor.getData(),
      'author': 'MG'
    };
    $.ajax({
      type: 'POST',
      url: './ajax.php',
      data: sendText,
      dataType: 'text',  //レスポンスとして受け取ったデータタイプの指定レスポンスは変数dataに格納される
      cache: false,
      timeout: 1000
    })
    .done(function(data){  // 通信成功時に呼び出される部分
      console.log(data);
    })
    .fail(function(data){  // 通信失敗時に呼び出される部分
      console.log(data);
    })
    .allways(function(){  // ajaxの通信の結果に関わらず通信処理を終えたらよびだされる部分
      console.log('Ajax job end');
    });
  });
});
