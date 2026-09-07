<?php
$c = mysqli_connect('localhost', 'root', '', 'website');
if (!$c) die("Connection failed");

$blogs = [
    [
        'title' => 'Honoring Our Heroes: A Year of Support and Gratitude',
        'slug' => 'honoring-our-heroes',
        'heading' => 'A Year of Gratitude',
        'description' => '<p>Throughout the past year, our organization has remained steadfast in its commitment to supporting the families of our brave martyrs. From financial assistance to emotional counseling, we have walked alongside these families, ensuring they never feel alone in their journey of sacrifice.</p><p>We have organized multiple memorial events and community gatherings to honor those who gave their lives for the nation. Your contributions have made it possible for us to reach more families and provide them with the dignity and support they truly deserve.</p>',
        'postedBy' => 'Admin',
        'postedDate' => date('Y-m-d'),
        'subject' => 'NGO News',
        'image' => 'assetsW/img/img-1.jpg',
        'status' => 'Active',
        'creationDate' => date('Y-m-d H:i:s')
    ],
    [
        'title' => 'Education: The True Light of Hope for Future Generations',
        'slug' => 'education-light-of-hope',
        'heading' => 'Empowering Through Knowledge',
        'description' => '<p>Education is the most powerful tool we can give to a child. This quarter, our focus has been on providing comprehensive educational support to the children of martyrs. We believe that by securing their academic future, we are honoring the legacy of their parents.</p><p>Multiple scholarship programs and school kit distribution drives were conducted across various districts. Witnessing the smiles and determination of these children is our greatest reward. Let us continue to invest in their dreams.</p>',
        'postedBy' => 'Education Cell',
        'postedDate' => date('Y-m-d', strtotime('-5 days')),
        'subject' => 'Education Support',
        'image' => 'assetsW/img/img-2.jpg',
        'status' => 'Active',
        'creationDate' => date('Y-m-d H:i:s')
    ],
    [
        'title' => 'Healthcare Outreach: Bringing Medical Support to Your Doorstep',
        'slug' => 'healthcare-outreach',
        'heading' => 'Health is Wealth',
        'description' => '<p>Access to quality healthcare is a fundamental right. Our recent medical camps in rural areas have provided free checkups, medicines, and specialized consultations to hundreds of families. Our team of volunteer doctors and healthcare workers worked tirelessly to ensure that every visitor received the care they needed.</p><p>We are expanding our healthcare reaches to include specialized wellness programs for the elderly and comprehensive health tracking for children. Your support ensures that health remains a priority for those who have sacrificed so much for us.</p>',
        'postedBy' => 'Medical Team',
        'postedDate' => date('Y-m-d', strtotime('-12 days')),
        'subject' => 'Health Camps',
        'image' => 'assetsW/img/img-3.jpg',
        'status' => 'Active',
        'creationDate' => date('Y-m-d H:i:s')
    ]
];

foreach ($blogs as $b) {
    $sql = "INSERT INTO blog (title, slug, heading, description, postedBy, postedDate, subject, image, status, creationDate) VALUES (
        '" . mysqli_real_escape_string($c, $b['title']) . "',
        '" . mysqli_real_escape_string($c, $b['slug']) . "',
        '" . mysqli_real_escape_string($c, $b['heading']) . "',
        '" . mysqli_real_escape_string($c, $b['description']) . "',
        '" . mysqli_real_escape_string($c, $b['postedBy']) . "',
        '" . mysqli_real_escape_string($c, $b['postedDate']) . "',
        '" . mysqli_real_escape_string($c, $b['subject']) . "',
        '" . mysqli_real_escape_string($c, $b['image']) . "',
        '" . mysqli_real_escape_string($c, $b['status']) . "',
        '" . mysqli_real_escape_string($c, $b['creationDate']) . "'
    )";
    
    if (mysqli_query($c, $sql)) {
        echo "Inserted blog: " . $b['slug'] . "\n";
    } else {
        echo "Error for " . $b['slug'] . ": " . mysqli_error($c) . "\n";
    }
}

mysqli_close($c);
?>
