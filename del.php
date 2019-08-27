<?php

//original
$editorConnection = odbc_connect("Driver={Microsoft FoxPro VFP Driver (*.DBF)};SourceType=DBF;SourceDB=F:\TEMP\DBTEST;Exclusive=No; Collate=Machine;NULL=NO;DELETED=NO;BACKGROUNDFETCH=NO;", '', '');

#DRIVER={Devart ODBC Driver for xBase};Database=C:\MyDatabase\;DBF Format=VisualFoxPro;Code Page=UnitedStatesOEM;Connect Mode=Exlusive

//$editorConnection = odbc_connect("Driver={Devart ODBC Driver for xBase};Database=/srv/www/sbt64/sbt/SBT7/DATA;DBF Format=FoxPro2;IndexOnReading=Local;Code Page=UnitedStatesOEM;", '', '');

if (!$editorConnection) {
    die("Connection to SBT could not be made.");
}

echo 'SBT Connection okay...<br>';

$query = "  DELETE FROM ARINVT01
            WHERE NOT supplier = 'ABN';
        ";

echo 'SBT query to be called...<br>';

$results = odbc_exec($editorConnection, $query) or die ("<h2>Error message</h2><pre>".odbc_errormsg($editorConnection)."</pre>"."<h2>Query that attempted to run</h2><pre>".$query."</pre>");

echo 'SBT executed successfully...<br>';

echo "<pre>".var_dump($results)."</pre>";

echo 'SBT while loop...<br>';

$i=0;
while($row=odbc_fetch_array($results)) {
    echo '#'.$i.' - '.$row['DESCRIP'].'<br>';
    $i++;
}

echo 'SBT finished!<br>';
?>