<?php

try {
    
    $dbconn = pg_connect("host=localhost port=5432 dbname=raspored user=postgres password=0000");
    //echo "Connection successfull";

    return $dbconn;

    /*  
    $result = pg_query($dbconn, 'SELECT * FROM "Dvorana"');
    $arr = pg_fetch_all($result);
    print_r($arr); 
    */

} catch (PDOException $e) {
    echo $e->getMessage();
}


?>