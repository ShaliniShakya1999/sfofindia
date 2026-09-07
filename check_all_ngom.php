<?php
$db_name = 'website';
$c = mysqli_connect('localhost', 'root', '', $db_name);
if (!$c) die("Connection failed");

$check = ['ngom_gallery', 'ngom_events', 'ngom_projects', 'ngom_campaigns', 'ngom_audit_reports'];
foreach($check as $t) {
    $q = mysqli_query($c, "SHOW TABLES LIKE '$t'");
    echo "$t: " . (mysqli_num_rows($q) > 0 ? "EXISTS" : "MISSING") . "\n";
}
mysqli_close($c);
?>
