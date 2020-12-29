<?php

try {
    
    $dbconn = pg_connect("host=localhost port=5432 dbname=raspored_tbp user=postgres password=0000");
    session_start();
    return $dbconn;

} catch (Exception $e) {
    echo $e->getMessage();
}


?>