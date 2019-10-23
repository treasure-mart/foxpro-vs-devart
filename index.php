<?php

//----------------------------------------
// Connection
//----------------------------------------

//$foxproConnection = odbc_connect("Driver={Devart ODBC Driver for xBase};Database=/srv/www/sbtdev/root/db;DBF Format=FoxPro2;IndexOnReading=Local;Code Page=UnitedStatesOEM;IdentifierCase=icLower;", '', '');
$foxproConnection = odbc_connect("Driver={Devart ODBC Driver for xBase};Database=/srv/www/sbtdev/root/db;IdentifierCase=icLower;DBF Format=VisualFoxPro;IndexOnReading=Native;", '', '');
$file = '/srv/www/sbtdev/root/results.txt';

if (!$foxproConnection) {
    echo odbc_error($foxproConnection);
    die("Connection to foxpro could not be made.");
} else {
    echo 'foxpro Connection okay...<br>';
}

//----------------------------------------
// SELECT query
//----------------------------------------

$query = "SELECT custno, pnet FROM ARCUST01;";

echo 'foxpro query to be called...<br>';

$results = odbc_exec($foxproConnection, $query) or die ("<h2>Error message</h2><pre>".odbc_errormsg($foxproConnection)."</pre>"."<h2>Query that attempted to run</h2><pre>".$query."</pre>");

echo 'foxpro executed successfully...<br>';

echo "<pre>".var_dump($results)."</pre>";

echo 'foxpro while loop...<br>';

$i=0;
$output='';
while($row=odbc_fetch_array($results)) {
    $output .= $row['custno'].' is "'.$row['pnet'].'"'.PHP_EOL;
    $output .= PHP_EOL;
    $i++;
}

//----------------------------------------
// UPDATE query
//----------------------------------------

$query = "UPDATE ARCUST01 SET pnet = 0;";

$results = odbc_exec($foxproConnection, $query) or die ($output .= PHP_EOL.odbc_errormsg($foxproConnection).$query);

echo "<pre>".$output."</pre>";

file_put_contents($file, $output);

echo 'foxpro finished!<br>';
?>