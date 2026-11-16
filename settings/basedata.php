<?php
//base data connection 
/* to test conection, please go to  
http://localhost/main-store/settings/basedata.php
*/

// local concection
$local_host = "localhost";
$local_port = 5432;
$local_dbname = "mainstore";
$local_user = "postgres";
$local_password = "postgres";


$local_conn= pg_connect("
        host=$local_host 
        port=$local_port  
        dbname=$local_dbname    
        user=$local_user  
        password=$local_password"
    );


// supa concection
$supa_host = "aws-1-us-west-2.pooler.supabase.com";
$supa_port = 6543;
$supa_dbname = "postgres";
$supa_user = "postgres.unqionzoeccefyghhjxr";
$supa_password = "main-store@@";


$supa_conn = pg_connect("
        host=$supa_host 
        port=$supa_port  
        dbname=$supa_dbname    
        user=$supa_user  
        password=$supa_password"
    );
    

    // local connection
if (!$local_conn) {
    die("Error conection");}
else {
    echo "success database local Connection!!! ";
}

if (!$supa_conn) {
    die("Error conection");}
else {
    echo "<br> success database supa Connection!!! ";
}
?>