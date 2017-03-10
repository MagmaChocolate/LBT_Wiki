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
  if($('.category select').eq(0).val() !== "" && $('.category select').eq(0).val() !== undefined){
    var category = [];
    for (var i = 0;i <= 2;i++){
      if($('.category select').eq(i).val() !== "" && $('.category select').eq(i).val() !== undefined){
        category.push($('.category select').eq(i).val());
      }
    }
  }else{
    var category = 'none';
  }

  // var category = [];
  // category[0] = $('.category select').eq(0).val();
  console.log(category);
  var sendText = {
    'title': sessionStorage.getItem('title'),
    'html': CKEDITOR.instances.visualEditor.getData(),
    'description': $('textarea#description').val(),
    'author': $('div.author input').val(),
    'category': category
  };
  var pageNum = location.href.replace(/.*page=([0-9])/,function(){return arguments[1]})
  if(pageNum != location.href){
    sendText.page = pageNum;
  }
  console.log(sendText);
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
    switch (data.message) {
      case 'success':
        showLoading('rm','送信しました');
        var host = location.href.replace(/(^.*)\/index.*/,function(){return arguments[1]});
        location.href = host+'/index.php?cmd=view&page='+data.page;
        break;

      case 'ERR_no_title':
        showLoading('err','タイトルエラー');
        setTimeout(function(){
          showLoading('rm','もう一度送信してください');
        },1000);
        break

      case 'ERR_no_html':
        showLoading('err','本文エラー');
        setTimeout(function(){
          showLoading('rm','もう一度送信してください');
        },1000);
        break

      case 'ERR_save_database()':
        showLoading('err','サーバーエラーです');
        setTimeout(function(){
          showLoading('rm','管理人に報告してください');
        },1000);
        break
    }
  })
  .fail(function(data){  // 通信失敗時に呼び出される部分
    showLoading('err','もう一度送信してください');
  });
}
/**
 * 既存の記事の時に最新の記事を取得
 */
$(function(){
  if(location.href.indexOf('page')){
    var sendText = {
      'page': location.href.replace(/.*page=([0-9]*)/,function(){return arguments[1]})
    };
    console.log(sendText);
    $.ajax({
      type: 'POST',
      url: './lib/fetchhtml.php',
      data: sendText,
      dataType: 'json',  //レスポンスとして受け取ったデータタイプの指定レスポンスは変数dataに格納される
      cache: false,
      timeout: 1000,
    })
    .done(function(data){  // 通信成功時に呼び出される部分
      CKEDITOR.instances.visualEditor.setData(data.html);
      for(var i = $('select.first > option').length,j = 0;j<=i;j++){
        if($('select.first > option').eq(j).val() == data.category[0]){
          $('select.first > option').eq(j).prop('selected',true);
        }
      }
      console.log(data);
    });
  }
});


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
    $('.loading-animation > i.fa-spinner,.loading-animation > i.fa-exclamation-triangle').css('display','none');
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
    },2000);
  }
}

// $(function (){
//   if(newFlag===false){
//     // 既存の編集
//     $('div.entry-config,div.eidtor-overlay').css('display','none');
//   }
// });

/**
 * イベントの設置
 */

/**
 * 記事タイトルの入力チェック、未入力ならば促す
 */
$(function(){
  $('.before .submit-button').on('click',function(){
    var titleText = $('.title input').val();
    sessionStorage.setItem('title',$('.title input').val());
    if(titleText === ''){
      $('.title > span.essential').text('※必ず入力してね！！');
      $('.title input').css({'border-color':'red','box-shadow':'0px 0px 15px red'});
      $('.title input').focus();
      return false;
    }
    $('div.title').text(titleText+'を編集中です');
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

/**
 * ヘッダの歯車押した時のイベント
 */
$(function(){
  $('header > div.show-before-config').on('click',function(){
    $('div.before').css('display','block');
  });
});
