
## putLog($text,$type = err)
```
/**
 * 処理ログをテキストファイルとして吐く関数
 * @param  string $text 出力する文字列
 * @param  string $type [err(default) | info infoアイコンが付きます |
 *                       dir (ver_dumpする）]
 * @return bool         正常にログを履いたらtrue ダメならfalse
 */
```


## thisPageExisting($title)
```
/**
 * pageが既存かall_entry_listから判断
 * @param  string  $title 記事ID
 * @return boolean        既存ならtrue、新規はfalse
 */
```


## getEntryVer($page)
```
/**
 * 記事IDからその記事の最新バージョンを取得
 * 全記事インデックス(all_entry_list.json)から検索する
 * @param  int    $page 記事ID
 * @return int|false     最新の記事verを返す、失敗時はfalse
 */
```

## willNextEntryId()
```
/**
 * 新規記事IDに割り当てられる予定のIDを取得
 * @return int           新規記事IDになる予定の数値を返す
 */
```

## addEntryIndex($page,$title,$author,$ip,$description)
```
/**
 * 記事追加時に記事を管理するindexに追記する、新規ならば新しくファイルを作成する
 * @param int    $page        記事ID
 * @param string $title       記事タイトル
 * @param string $author      書き込んだユーザ名
 * @param int    $ip          書き込んだIP
 * @param string $description 編集内容の概要説明
 * @return boolean            成功ならtrue、失敗ならfalse
 */
```

## newEntryIndex($id,$title,$author,$ip,$description)
```
/**
 * 記事追加時に記事を管理するindexを新規作成
 * @param string $title       記事タイトル
 * @param string $author      書き込んだユーザ名
 * @param int    $ip          書き込んだIP
 * @param string $description 編集の簡易説明
 * @return boolean       成功なら記事ID+1、失敗ならfalse
 */
```

## saveEntryBody($page,$title,$description,$html)
```
/**
 * 記事本文を保存する関数
 * @param  int    $page        記事ID
 * @param  string $title       記事タイトル
 * @param  string $description 編集の要約
 * @param  string $html        記事本文
 * @return boolean             正常終了はtrue、失敗はfalse
 */
```

## addAllEntryList($page,$title,$author,$category = null,eyecatch = null)
```
/**
 * all_entry_listの記事データを更新、追記する
 * @param int    $page     記事id
 * @param string $title    記事タイトル
 * @param string $author   作者名
 * @param array  $category [省略可]カテゴリを一次配列で渡す
 * @param string $eyecatch [省略可]アイキャッチ画像へのリンク
 * @return boolean         正常終了はtrue、失敗はfalse
 */
```
## read_db($page,$ver = null)
```
/**
 * データベースから情報を出す
 * @param  int    page    ページ番号
 * @param  int    [ver] 過去バージョンのデータを引き出したいときに指定するオプション
 *                        バージョンの詳細は別途info関数で取得する
 * @return array          連想配列を返す、失敗はfalseを返す
 *         ["title","author","(array)category","eyecatch","html"];
 */

## write_db()
```
/**
 * 記事データ本文やインデックスを一括で保存する関数
 * 受け取りはpostでjson形式で送られてくるのでこの関数で受け取る
 */
```
