<?php
$c = mysqli_connect('localhost', 'root', '', 'website');
if (!$c) die("Connection failed: " . mysqli_connect_error());

echo "TABLES:\n";
$q = mysqli_query($c, 'SHOW TABLES');
while($r = mysqli_fetch_row($q)) {
    echo "- " . $r[0] . "\n";
}

echo "\nSCHEMA ngom_gallery:\n";
$q = mysqli_query($c, 'DESCRIBE ngom_gallery');
if ($q) {
    while($r = mysqli_fetch_assoc($q)) {
        echo $r['Field'] . " (" . $r['Type'] . ")\n";
    }
} else {
    echo "ngom_gallery table not found!\n";
}

mysqli_close($c);
?>
