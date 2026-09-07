<?php
$databases = ['website', 'web', 'project', 'Shaheed Foundation ', 'bappi'];
foreach ($databases as $db) {
    $c = mysqli_connect('localhost', 'root', '', $db);
    if ($c) {
        $q = mysqli_query($c, "SHOW TABLES LIKE 'admin_users'");
        if ($q && mysqli_num_rows($q) > 0) {
            echo "Database: $db HAS admin_users\n";
            $q2 = mysqli_query($c, "SHOW TABLES LIKE 'ngom_gallery'");
            if ($q2 && mysqli_num_rows($q2) > 0) {
                echo "  - HAS ngom_gallery\n";
            } else {
                echo "  - MISSING ngom_gallery\n";
            }
        }
        mysqli_close($c);
    }
}
?>
