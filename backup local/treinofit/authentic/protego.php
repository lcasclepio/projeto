<?php
function protego($dado) {
    
    if ($dado === null) {
        return "";
    }
    return htmlspecialchars($dado, ENT_QUOTES, 'UTF-8');
}