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
 * 既存記事のデータをiframeに入力
 */
$(function(){
  $('iframe').contents().find('head').html('<link rel="stylesheet" href="'+location.href.replace(/(^.*)\/index.*/,function(){return arguments[1]})+'/resource/css/editor-iframe.css">');
  $('iframe').contents().find('body').html(preData.html);
});
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
    'html': $('#editorframe').contents().find('body').html(),
    'description': $('textarea#description').val(),
    'author': $('div.author input').val(),
    'category': category
  };
  var pageNum = location.href.replace(/.*page=([0-9]+)/gi,function(){return arguments[1]})
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
    timeout: 10000,
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
    console.log(data);
    showLoading('err','もう一度送信してください');
  });
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

// $(function(){
//   if($('#pre-text').attr('phtml') != ''){
//     var pretxt = $('#pre-text').attr('phtml');
//     editor.execCommand('inserthtml',false,pretxt);
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
$('.submit-button').on('click',function(){
  editor = document.getElementsByTagName("iframe")[0].contentDocument;
  editor.designMode = "On";
  $('#editorframe').focus();
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

/**
 * ブラウザバック
 */
$(function(){
  $('.fa-arrow-left').on('click',function(){
    window.history.back(-1);
    return false;
  });
});




$(function(){
  $('#entry-info-ber').css('display','none');
});


$('#undo').on('click',function(){
  editor.execCommand('undo',false,null);
});
$('#redo').on('click',function(){
  editor.execCommand('redo',false,null);
});

$('#insert_image').on('click',function(){
  $('input#file').click();
});

/**
 * 画像を投稿するロジック
 * フォームにファイルが定まったら発火
 * @return {json} 画像のURLが帰ってくる
 */
$(function() {
  $('#foo').on('change', function() {
    let getParam = purseQuery();
    const fd = new FormData($('#foo').get(0));
    if (getParam.page !== undefined) {
      var getURL = "./lib/imgupload.php?page=" + getParam.page * 1;
    } else {
      var getURL = "./lib/imgupload.php";
    }
    $.ajax({
        // url: "./lib/imgupload.php",
        url: getURL,
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json'
      })
      .done(function(data) {
        console.log(data);
        if(data.code === 1){
          editor.execCommand('insertimage',false,data.url);
          $('#editorframe').focus();
        }
      }).fail(function(data){
        console.log('Faild:'+data);
      });
    return false;
  });
});

//http://qiita.com/thelarch/items/5e2a82a77c796788e848?utm_source=Qiita%E3%83%8B%E3%83%A5%E3%83%BC%E3%82%B9&utm_campaign=565bb223ff-Qiita_newsletter_255_12_04_2017&utm_medium=email&utm_term=0_e44feaa081-565bb223ff-33170173#get%E5%80%A4%E3%82%92%E5%8F%96%E5%BE%97%E3%81%99%E3%82%8B
/**
 * URLをパースしてGET値のオブジェクトにする
 * @returns {{}} GET値のオブジェクトです。
 */
function purseQuery() {
  const result = {};
  const query = decodeURIComponent(location.search);
  const query_ary = query.substring(1).split("&");
  for (let item of query_ary) {
    let match_index = item.search(/=/);
    let key = "";
    if (match_index !== -1) {
      key = item.slice(0, match_index);
    }
    let value = item.slice(item.indexOf("=", 0) + 1);
    if (key !== "") {
      result[key] = value;
    }
  }
  return result;
}

/**
 * 書式設定のメニューを表示するロジック
 * @return {[type]} [description]
 */
$('.text_style_show').on('click',function(){
  if(this.flag === false || this.flag === undefined){
    this.flag = true;
    $('.text_style_show').css('background','rgb(237, 237, 237)');
  }else{
    this.flag = false;
    $('.text_style_show').css('background','white');
    $('#indent_popup').css('display','none');
  }
  $('.font-style').toggle();
});
/**
 * ふとじ
 */
function text_bold(){
  editor.execCommand("bold",false,null);
  $('#editorframe').focus();
  if(this.flag === undefined || this.flag === false){
    this.flag = true; // 有効
    $('#tr_bold').css('background','rgb(237, 237, 237)');
  }else{
    this.flag = false; // 無効
    $('#tr_bold').css('background','white');
  }
  $('.font-style').toggle();
}
/**
 * アンダーライン
 */
function text_underline(){
  editor.execCommand('underline',false,null);
  $('#editorframe').focus();
  if(this.flag === undefined || this.flag === false){
    this.flag = true; // 有効
    $('#tr_underline').css('background','rgb(237, 237, 237)');
  }else{
    this.flag = false; // 無効
    $('#tr_underline').css('background','white');
  }
  $('.font-style').toggle();
}
/**
 * 取り消し文字
 */
function text_cancel(){
  editor.execCommand('strikethrough',false,null);
  $('#editorframe').focus();
  if(this.flag === undefined || this.flag === false){
    this.flag = true; // 有効
    $('#tr_cancel').css('background','rgb(237, 237, 237)');
  }else{
    this.flag = false; // 無効
    $('#tr_cancel').css('background','white');
  }
  $('.font-style').toggle();
}
/**
 * 箇条書き（点）
 */
function text_list(){
  editor.execCommand('insertunorderedlist',false,null);
  $('#editorframe').focus();
  if(this.flag === undefined || this.flag === false){
    this.flag = true; // 有効
    $('#tr_list').css('background','rgb(237, 237, 237)');
  }else{
    this.flag = false; // 無効
    $('#tr_list').css('background','white');
  }
  $('.font-style').toggle();
}
/**
 * セクション区切りの小見出し
 */
function format_headline(){
  editor.execCommand('formatblock',false,'<h2>');
  $('#editorframe').focus();
  $('.font-style').toggle();
}
/**
 * インデントを調整するメニューを表示させる
 */
function text_indent_show(){
  $('#tr_indent').css('background','rgb(237, 237, 237)');
  $('#editorframe').focus();
  $('#indent_popup').toggle();
}
/**
 * インデントを変化させる
 * @param  {text} mode インデントを下げる(indent)、上げる(outdent)
 */
function text_indent(mode){
  if(mode === 'down'){
    editor.execCommand('indent',false,null);
  }else if(mode === 'up'){
    editor.execCommand('outdent',false,null);
  }
  $('#tr_indent').css('background','white');
  $('#editorframe').focus();
  $('#indent_popup').toggle();
  $('.font-style').toggle();
}

/**
 * iframe height change
 */
$('#minus').on('click',function(){
  var height = $('#editorframe').height() / 30 - 1;
  $('#editor-height').html(height);
  $('#editorframe').css('height',height * 30);
});
$('#plus').on('click',function(){
  var height = $('#editorframe').height() / 30 + 1;
  $('#editor-height').html(height);
  $('#editorframe').css('height',height * 30);
});


// /**
//  * iframe CSS
//  */
// $(function(){
//   let url = purseQuery();
//   if(url == undefined){
//     $('iframe').contents().find('head').append('<link href="./resource/css/editor-iframe.css" rel="stylesheet" type="text/css" media="all" />');
//   }
// });

setTimeout(function(){
  $('div[style*=z-index][style*=overflow]').css('display','none');
},50);
