<?php
$c = mysqli_connect('localhost', 'root', '');
if (!$c) die("Connection failed: " . mysqli_connect_error());

echo "DATABASES:\n";
$q = mysqli_query($c, 'SHOW DATABASES');
while($r = mysqli_fetch_row($q)) {
    echo "- " . $r[0] . "\n";
}
mysqli_close($c);
?>
