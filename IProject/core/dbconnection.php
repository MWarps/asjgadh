<?php
$hostname = 'localhost';
$dbname = 'iproject';
$username = 'testgebruiker';
$password = 'test123';
// dit zijn nep gegevens!

$hostname = 'mssql2.iproject.icasites.nl';
$dbname = 'iproject34';
$username = 'iproject34';
$password = '263MsBEvp8vS';

try {
    global $dbh;

    $dbh = new PDO("sqlsrv:server=$hostname; database=$dbname;
                connectionpooling=0;", "$username", "$password");

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo 'verbonden';
} catch (PDOexception $e) {
    echo "something went wrong {$e->getMessage()}";
}
?>