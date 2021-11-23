<?php
define('PAGINATION_COUMT', 30);

 function getFolder(){
    return app()->getLocale()==='ar'?'css-rtl':'css';
}
