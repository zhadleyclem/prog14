<?php
// display.php - Display numbers from files or reset

// Check if this is first time user (no cookie exists)
if (!isset($_COOKIE['number_app_user'])) {
    // Create 4 empty text files
    file_put_contents('prime.txt', '');
    file_put_contents('armstrong.txt', '');
    file_put_contents('fibonacci.txt', '');
    file_put_contents('none.txt', '');
    
    // Set cookie to remember user
    setcookie('number_app_user', 'true', time() + (86400 * 30), "/"); // 30 days
}

$display_type = '';
$title = '';
$filename = '';

if (isset($_POST['display'])) {
    $display_type = $_POST['display'];
    
    // Handle reset action
    if ($display_type == 'reset') {
        // Delete all 4 files
        if (file_exists('prime.txt')) unlink('prime.txt');
        if (file_exists('armstrong.txt')) unlink('armstrong.txt');
        if (file_exists('fibonacci.txt')) unlink('fibonacci.txt');
        if (file_exists('none.txt')) unlink('none.txt');
        
        // Clear cookie
        setcookie('number_app_user', '', time() - 3600, "/");
        
        // Redirect back to main page
        header("Location: index.html?reset=true");
        exit();
    }
    
    // Set file information based on display type
    switch ($display_type) {
        case 'prime':
            $title = 'Prime Numbers';
            $filename = 'prime.txt';
            break;
        case 'armstrong':
            $title = 'Armstrong Numbers';
            $filename = 'armstrong.txt';
            break;
        case 'fibonacci':
            $title = 'Fibonacci Numbers';
            $filename = 'fibonacci.txt';
            break;
        case 'none':
            $title = 'Numbers with No Special Properties';
            $filename = 'none.txt';
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 700px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .display-area {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 3px;
        }
        .number-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }
        .number-item {
            background-color: #007cba;
            color: white;
            padding: 8px 12px;
            border-radius: 3px;
            font-size: 14px;
            font-weight: bold;
        }
        .back-button {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
        .empty-message {
            color: #6c757d;
            font-style: italic;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $title; ?></h1>
        
        <div class="display-area">
            <?php
            if ($filename && file_exists($filename)) {
                $content = file_get_contents($filename);
                $numbers = array_filter(explode("\n", trim($content)));
                
                if (!empty($numbers)) {
                    echo "<h3>Found " . count($numbers) . " numbers:</h3>";
                    echo "<div class='number-list'>";
                    foreach ($numbers as $number) {
                        if (trim($number) != '') {
                            echo "<div class='number-item'>" . trim($number) . "</div>";
                        }
                    }
                    echo "</div>";
                } else {
                    echo "<div class='empty-message'>No " . strtolower($title) . " found yet.</div>";
                }
            } else {
                echo "<div class='empty-message'>No " . strtolower($title) . " found yet.</div>";
            }
            ?>
        </div>
        
        <a href="index.html" class="back-button">← Back to Main Page</a>
    </div>
</body>
</html>
