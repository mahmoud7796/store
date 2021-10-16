<?php
define('PAGINATION_COUMT', 15);

 function getFolder(){
    return app()->getLocale()==='ar'?'css-rtl':'css';
}
