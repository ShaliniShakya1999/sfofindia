<?php
$c = mysqli_connect('localhost', 'root', '', 'website');
if (!$c) die("Connection failed: " . mysqli_connect_error());

$queries = [
    "CREATE TABLE IF NOT EXISTS ngom_gallery (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        image_path TEXT,
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;",

    "CREATE TABLE IF NOT EXISTS ngom_events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        slug VARCHAR(255),
        body TEXT,
        event_date DATE,
        image TEXT,
        status VARCHAR(50) DEFAULT 'published',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;",

    "CREATE TABLE IF NOT EXISTS ngom_projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        summary TEXT,
        body TEXT,
        image TEXT,
        status VARCHAR(50) DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;",

    "CREATE TABLE IF NOT EXISTS ngom_campaigns (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        goal_amount DECIMAL(15,2) DEFAULT 0,
        raised_display VARCHAR(100),
        description TEXT,
        image TEXT,
        status VARCHAR(50) DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;",

    "CREATE TABLE IF NOT EXISTS ngom_audit_reports (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        file_path TEXT,
        admin_user_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;"
];

foreach ($queries as $sql) {
    if (mysqli_query($c, $sql)) {
        echo "Success: " . substr($sql, 13, 15) . "...\n";
    } else {
        echo "Error: " . mysqli_error($c) . "\n";
    }
}

mysqli_close($c);
?>
