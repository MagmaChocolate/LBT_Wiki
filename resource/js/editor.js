/*
  relation : index.php
  auther : MagmaChocolate
  lang : javascript, ja-jp
*/

/**
 * ページのURLから正規表現でパラメータを取得する
 * @param  {string} param 取得したいパラメータ
 * @return {string}       パラメータの内容
 */
// function getPostParam(param){
//   var url   = location.href;
//   parameters    = url.split("?");
//   params   = parameters[1].split("&");
//   var paramsArray = [];
//   for ( i = 0; i < params.length; i++ ) {
//       neet = params[i].split("=");
//       paramsArray.push(neet[0]);
//       paramsArray[neet[0]] = neet[1];
//   }
//   var categoryKey = paramsArray[param];
//   return categoryKey;
// }

/**
 * <textarea>にフォーカスしている時にヘッダーを隠す
 * フォーカスオフした時のイベントが取れない（理解していない）ので実装見送り
 */
// var ckeditorForCss = CKEDITOR.instances['visualEditor'];
// ckeditorForCss.on('focus', function(e){
//   $('header').css('display','none');
// });
function postData(){
  for (var i = 0,category = [];i <= 2;i++){
    if(category[i] !== undefined){
      category[i] = $('.category select').eq(i).val();
    }
  }
  var sendText = {
    'title': $('.title > input').val(),
    'html': CKEDITOR.instances.visualEditor.getData(),
    'description': $('div.description textarea').val(),
    'author': $('div.author input').val(),
    'category': category
  };
  // if(getPostParam('page') !== undefined){
  //   sendText.page = getPostParam('page');
  // }
  $.ajax({
    type: 'POST',
    url: './lib/ajax.php',
    data: sendText,
    dataType: 'json',  //レスポンスとして受け取ったデータタイプの指定レスポンスは変数dataに格納される
    cache: false,
    timeout: 1000,
    beforeSend: function(){
      showLoading('show','送信中です');
    }
  })
  .done(function(data){  // 通信成功時に呼び出される部分
    console.log(data);
    showLoading('rm','送信しました');
    location.href = 'http://lbt_wiki.dev/index.php?cmd=view&page='+data.page;
  })
  .fail(function(data){  // 通信失敗時に呼び出される部分
    showLoading('err','もう一度送信してください');
  });
  // .always(function(data){
  //   console.log(data);
  // });
}

/**
 * ローディングアニメーションを表示する関数
 * @param  {string} mode 表示したいならshow、消すときは[rm | err]
 * @param  {string} text ロード中に表示するメッセージ
 */
function showLoading(mode,text){
  if(mode === 'show'){
    $('.loading-animation > span.text').text(text);
    $('.loading-animation').animate({'marginTop':'10px'},200);
  }else if(mode === 'rm'){
    $('.loading-animation > span.text').text(text);
    $('.loading-animation > i.fa-spinner').css('display','none');
    $('.loading-animation > i.fa-check').css('display','inline-block');
    setTimeout(function(){
      $('.loading-animation').stop().animate({'marginTop':'-50px'},200,function(){
        $('.loading-animation i').css('display','none');
        $('.loading-animation > i.fa-spinner').css('display','inline-block');
      });
    },1000);
  }else if(mode === 'err'){
    $('.loading-animation > span.text').text(text);
    $('.loading-animation > i.fa-spinner').css('display','none');
    $('.loading-animation > i.fa-exclamation-triangle').css('display','inline-block');
    setTimeout(function(){
      $('.loading-animation').stop().animate({'marginTop':'-50px'},200,function(){
        $('.loading-animation  i').css('display','none');
        $('.loading-animation > i.fa-spinner').css('display','inline-block');
      });
    },1000);
  }
}

/**
 * イベントの設置
 */

/**
 * 記事タイトルの入力チェック、未入力ならば促す
 */
$(function(){
  $('.before .submit-button').on('click',function(){
    if($('.title > input').val() === ''){
      $('.title > span.essential').text('※必ず入力してね！！');
      $('.title > input').css({'border-color':'red','box-shadow':'0px 0px 15px red'});
      $('.title > input').focus();
      return false;
    }
    $('.entry-config').css('display','none');
    $('.before,.eidtor-overlay').css('display','none');
  });
});

/**
 * 編集の概要の入力フォームの表示
 */
$(function(){
  $('.save').on('click',function(){
    $('.after,.eidtor-overlay').css('display','block');
  });
});
/**
 * ajax送信ボタン
 */
$(function(){
  $('.after .submit-button').on('click',function(){
    postData();
  });
});
