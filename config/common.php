<?php
    date_default_timezone_set('Asia/Tokyo');
    
    function sanitize($before){
        foreach($before as $key => $value){
            $after[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
        }
        return $after;
    }

    $wk = array( "日", "月", "火", "水", "木", "金", "土" );
?>