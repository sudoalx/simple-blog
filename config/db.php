<?php

    // Hostname
    $hostname = "localhost";

    // Database Name
    $dbname = "cleanblog";

    // Database Credentials
    $username = "root";
    $password = "";

    // Connection
    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
