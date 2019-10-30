<?php

//----------------------------------------
// Connection
//----------------------------------------

$foxproConnection = odbc_connect("Driver={Devart ODBC Driver for xBase};Database=/srv/www/sbtdev/root/db;IdentifierCase=icLower;DBF Format=VisualFoxPro;IndexOnReading=Native;", '', '');
$file = '/srv/www/sbtdev/root/results.txt';

if (!$foxproConnection) {
    echo odbc_error($foxproConnection);
    die("Connection to foxpro could not be made.");
}

//----------------------------------------
// SELECT query
//----------------------------------------

$query = "SELECT custno, entered FROM ARCUST01;";

$results = odbc_exec($foxproConnection, $query) or die ("<h2>Error message</h2><pre>".odbc_errormsg($foxproConnection)."</pre>"."<h2>Query that attempted to run</h2><pre>".$query."</pre>");

while($row=odbc_fetch_array($results)) {
    $output1 .= $row['custno'].' was created on "'.$row['entered'].'"'.PHP_EOL;
    $output1 .= PHP_EOL;
}

//----------------------------------------
// OUTPUT
//----------------------------------------

echo '<h2>Query that returns all records from database:</h2>';

echo "<pre>".$query."</pre>";

echo '<h2>Results:</h2>';

echo "<pre>".$output1."</pre>";

//----------------------------------------
// SELECT query 2
//----------------------------------------

$query = "SELECT custno, entered FROM ARCUST01 WHERE entered BETWEEN '2000-01-01' AND '2015-01-01';";
//$query = "SELECT custno, entered FROM ARCUST01 WHERE entered BETWEEN 01/01/2000 AND 01/01/2015;";

$results = odbc_exec($foxproConnection, $query) or die ("<h2>Error message</h2><pre>".odbc_errormsg($foxproConnection)."</pre>"."<h2>Query that attempted to run</h2><pre>".$query."</pre>");

while($row=odbc_fetch_array($results)) {
    $output2 .= $row['custno'].' was created on "'.$row['entered'].'"'.PHP_EOL;
    $output2 .= PHP_EOL;
}

//----------------------------------------
// OUTPUT
//----------------------------------------

echo '<h2>Query that returns records filtered between 2000 and 2015:</h2>';

echo "<pre>".$query."</pre>";

echo '<h2>Results:</h2>';

echo "<pre>".$output2."</pre>";

file_put_contents($file, $output1.$output2);

echo 'foxpro finished!<br>';
?>