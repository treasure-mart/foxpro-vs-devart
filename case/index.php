<?php
/*
Notes:
- The path to the database files must exist on a FAT32 disk otherwise you will get an error saying the file does not exist.
*/

//CODE

$mode = $_GET['mode'];

if($mode == 'devart') {
    $foxproConnection = odbc_connect("Driver={Devart ODBC Driver for xBase};Database=/srv/www/sbt64/root/devart/db;DBF Format=FoxPro2;IndexOnReading=Local;Code Page=UnitedStatesOEM;IdentifierCase=icLower;", '', '');
    $file = '/srv/www/sbt64/root/fptest/results/devart.txt';
} else {
    $foxproConnection = odbc_connect("Driver={Microsoft FoxPro VFP Driver (*.DBF)};SourceType=DBF;SourceDB=F:\TEMP\DBTEST;Exclusive=No; Collate=Machine;NULL=NO;DELETED=NO;BACKGROUNDFETCH=NO;", '', '');
    $file = 'C:\www\foxy\fptest\results\legacy.txt';
}

if (!$foxproConnection) {
    echo odbc_error($foxproConnection);
    die("Connection to foxpro could not be made.");
} else {
    echo 'foxpro Connection okay...<br>';
}


$query = "  SELECT item, descrip
            FROM ARINVT01 
            WHERE cat3 = 'Y'
            ORDER BY item;
        ";

echo 'foxpro query to be called...<br>';

$results = odbc_exec($foxproConnection, $query) or die ("<h2>Error message</h2><pre>".odbc_errormsg($foxproConnection)."</pre>"."<h2>Query that attempted to run</h2><pre>".$query."</pre>");

echo 'foxpro executed successfully...<br>';

echo "<pre>".var_dump($results)."</pre>";

echo 'foxpro while loop...<br>';

$i=0;
$output='';
while($row=odbc_fetch_array($results)) {
    $output .= 'Row #'.$i.' $row[\'descrip\'] returns "'.$row['descrip'].'"'.PHP_EOL;
    $output .= 'Row #'.$i.' $row[\'DESCRIP\'] returns "'.$row['DESCRIP'].'"'.PHP_EOL;
    $output .= PHP_EOL;
    $i++;
}

echo "<pre>".$output."</pre>";

//file_put_contents($file, $output);

echo 'foxpro finished!<br>';
?>