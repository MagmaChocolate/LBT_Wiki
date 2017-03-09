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

/**
 * 検索バー
 */
$(function(){
  $('.search-overlay').css('height',$('body').height()-54); // overlayの縦サイズを設定
  $('input.search-text').focus(function(){
    /**
     * 閉じイベント作成
     */
    $('div.times,div.search-overlay').on('click',function(){
      $('div.search-overlay,div.times,div.search-result-area').css('display','none');
      $('header').css('position','static');
      $('div.main-contents').css('margin-top','20px');
    });
    $('div.search-overlay,div.search-result-area,div.times').css('display','block');
    $('header').css('position','fixed'); // ヘッダーをスクロールしても固定される様に
    $('div.main-contents').css('margin-top','74px');
  });


  /**
   * 記事タイトルとページ番号のリストを取得
   */
  $.ajax({
    type: 'POST',
    url: './lib/search.php?mode=title',
    dataType: 'json',  //レスポンスとして受け取ったデータタイプの指定レスポンスは変数dataに格納される
    cache: false,
    timeout: 1000,
  })
  .done(function(data){  // 通信成功時に呼び出される部分
    G_entryListst = data; // グローバルスコープ
    // webstrageが使えるかどうかチェック
    if (typeof sessionStorage === 'undefined') {var canUse = false;}else{var canUse = true};
      localStorage.setItem("entryList", JSON.stringify(data)); // fetchしたjsonを文字列に変換して格納
  });
});



/**
 * 検索部分の実装
 *
 */
$(function(){
  /**
   * 検索実装部
   * @param  {String} searchWord 検索文字列
   * @return {object}            検索にヒットしたもののみをまとめたオブジェクトを返す
   */
  function event_search(searchWord){
    var Result = [];
    for (var i in G_entryListst){
      if ( G_entryListst[i].title.indexOf(searchWord) != -1) {
        Result.push(G_entryListst[i]);
      }
    }
    return Result;
  }

  /**
   * 検索結果から、画面上に結果を描画する
   * @param  {object} Result event_search()の返り値
   */
  function showSearchResult(Result){
    var host = location.href
    host = host.replace(/(^.*)\/index.*/,function(){return arguments[1]}); // http://rfs.jp/sb/javascript/js-lab/javascript_replace_regexp.html
    var text = '<tr class="allSearchEntry"><td class="col-xs-12"><i class="fa fa-file-text-o"></i>全文検索</td></tr>';
    Object.keys(Result).forEach(function (key) {  // http://qiita.com/nantekkotai/items/6c603b40ac2264e9f6f6
      text = text + '<tr class="search-result-content"><td><a href="'+host+'/index.php?cmd=view&page='+Result[key].page+'"><img src="./resource/img/lbt-logo.png" class="search-result-img" />';
      text = text + Result[key].title +'</a></td></tr>';
    });
    $('.search-result').html(text);
  }

  //http://qiita.com/maruyam-a/items/cf0168f91d934b449a07
  $('input.search-text').keyup(checkChange(this));
  function checkChange(e){
    var old = v = $(e).find('input.search-text').val();
    return function(){
      v = $(e).find('input.search-text').val();
      if(old != v){
        old = v;
        if($('input.search-text').val() !== ""){
          var Result = event_search($('input.search-text').val());
          showSearchResult(Result);
        }
      }
    }
  };
});
