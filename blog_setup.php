<?php

function ensureBlogTables($conn)
{
    if (!$conn) {
        return false;
    }

    mysqli_query(
        $conn,
        "
        CREATE TABLE IF NOT EXISTS blog_categories (
            id int(11) NOT NULL AUTO_INCREMENT,
            category_name varchar(100) DEFAULT NULL,
            status tinyint(1) DEFAULT 1,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        "
    );

    mysqli_query(
        $conn,
        "
        CREATE TABLE IF NOT EXISTS blogs (
            id int(11) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            slug varchar(255) NOT NULL,
            category_id int(11) NOT NULL,
            featured_image varchar(255) DEFAULT NULL,
            excerpt text DEFAULT NULL,
            content longtext DEFAULT NULL,
            author varchar(100) DEFAULT 'Caring Squad',
            read_time varchar(30) DEFAULT NULL,
            status enum('Published','Draft') DEFAULT 'Published',
            featured tinyint(1) DEFAULT 0,
            views int(11) DEFAULT 0,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        "
    );

    $categoryCount = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM blog_categories"
    );

    if ($categoryCount) {
        $row = mysqli_fetch_assoc($categoryCount);

        if ((int)$row['total'] === 0) {
            mysqli_query(
                $conn,
                "
                INSERT INTO blog_categories (category_name, status) VALUES
                ('Health & Wellness', 1),
                ('Elder Care', 1),
                ('Companionship', 1),
                ('News & Updates', 1)
                "
            );
        }
    }

    return true;
}

?>
