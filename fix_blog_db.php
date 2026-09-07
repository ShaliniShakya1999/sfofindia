<?php
$c = mysqli_connect('localhost', 'root', '', 'website');
if (!$c) die("Connection failed: " . mysqli_connect_error());

$sql = "CREATE TABLE IF NOT EXISTS blog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255),
    metaTitle VARCHAR(255),
    metaDescription TEXT,
    metaKeyword VARCHAR(255),
    title VARCHAR(255),
    heading VARCHAR(255),
    description TEXT,
    postedBy VARCHAR(255),
    postedDate DATE,
    subject VARCHAR(255),
    image TEXT,
    status VARCHAR(50) DEFAULT 'Active',
    creationDate DATETIME,
    updationDate DATETIME
) ENGINE=InnoDB;";

if (mysqli_query($c, $sql)) {
    echo "Success: 'blog' table created.\n";
} else {
    echo "Error: " . mysqli_error($c) . "\n";
}

mysqli_close($c);
?>
