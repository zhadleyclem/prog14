<?php
// check_numbers.php - Process the numbers from the form

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

// Function to check if a number is prime
function isPrime($num) {
    if ($num <= 1) return false;
    if ($num <= 3) return true;
    if ($num % 2 == 0 || $num % 3 == 0) return false;
    
    for ($i = 5; $i * $i <= $num; $i += 6) {
        if ($num % $i == 0 || $num % ($i + 2) == 0) {
            return false;
        }
    }
    return true;
}

// Function to check if a number is Armstrong
function isArmstrong($num) {
    $original = $num;
    $digits = strlen($num);
    $sum = 0;
    $temp = $num;
    
    while ($temp > 0) {
        $digit = $temp % 10;
        $sum += pow($digit, $digits);
        $temp = intval($temp / 10);
    }
    
    return $sum == $original;
}

// Function to check if a number is Fibonacci
function isFibonacci($num) {
    if ($num < 0) return false;
    if ($num == 0 || $num == 1) return true;
    
    $a = 0;
    $b = 1;
    
    while ($b < $num) {
        $temp = $a + $b;
        $a = $b;
        $b = $temp;
    }
    
    return $b == $num;
}

// Process the form data
if (isset($_POST['action']) && $_POST['action'] == 'check') {
    $numbers_input = $_POST['numbers'];
    
    // Split the input by commas and clean up
    $numbers = explode(',', $numbers_input);
    $processed = 0;
    
    foreach ($numbers as $num) {
        $num = trim($num); // Remove spaces
        
        if (is_numeric($num)) {
            $num = intval($num);
            $processed++;
            
            // Check what type of number it is
            if (isPrime($num)) {
                // Add to prime.txt
                file_put_contents('prime.txt', $num . "\n", FILE_APPEND);
            } elseif (isArmstrong($num)) {
                // Add to armstrong.txt
                file_put_contents('armstrong.txt', $num . "\n", FILE_APPEND);
            } elseif (isFibonacci($num)) {
                // Add to fibonacci.txt
                file_put_contents('fibonacci.txt', $num . "\n", FILE_APPEND);
            } else {
                // Add to none.txt
                file_put_contents('none.txt', $num . "\n", FILE_APPEND);
            }
        }
    }
    
    // Redirect back to main page with success message
    header("Location: index.html?processed=" . $processed);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Processing...</title>
</head>
<body>
    <h1>Processing numbers...</h1>
    <p>Please wait while we process your numbers.</p>
    <p><a href="index.html">Go back to main page</a></p>
</body>
</html>
