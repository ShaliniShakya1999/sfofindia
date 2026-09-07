<?php
$db_name = 'website';
$c = mysqli_connect('localhost', 'root', '', $db_name);
if (!$c) die("Connection to $db_name failed: " . mysqli_connect_error());

echo "Connected to: $db_name\n";

$tables = [];
$q = mysqli_query($c, 'SHOW TABLES');
while($r = mysqli_fetch_row($q)) {
    $tables[] = $r[0];
}

foreach(['ngom_gallery', 'ngom_events', 'gallery', 'events'] as $t) {
    if (in_array($t, $tables)) {
        echo "Table: $t EXISTS\n";
        $q2 = mysqli_query($c, "DESCRIBE $t");
        while($r2 = mysqli_fetch_assoc($q2)) {
            echo "  - " . $r2['Field'] . " (" . $r2['Type'] . ")\n";
        }
    } else {
        echo "Table: $t DOES NOT exist\n";
    }
}

mysqli_close($c);
?>
