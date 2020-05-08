<!-- データベース以外の関数 -->
<?php

// 出力時エスケープ
function html_escape($word) {
    return htmlspecialchars($word, ENT_QUOTES, 'UTF-8');
}

// POSTしてきた値の前後の空白をトリム
function get_post($key){
    if(isset($_POST[$key])){
        $var = trim($_POST[$key]);
        return $var;
    }
}

// 入力された項目が0文字、指定された長さより大きければ、falseを返す
function check_words($word, $length){
    if(mb_strlen($word) === 0){
        return false;
    }elseif(mb_strlen($word) > $length){
        return false;
    }else{
        return true;
    }
}
