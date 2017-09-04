<?php
/**
 * XSS対策でエスケープする
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function escapeHtml($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
