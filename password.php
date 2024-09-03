<?php
function generateRandomPassword($length = 12) {
    // Define the characters to be used in the password
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    
    // Get the total number of characters
    $charactersLength = strlen($characters);
    
    // Initialize the password variable
    $randomPassword = '';
    
    // Loop through and append random characters to the password
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return $randomPassword;
}

// Generate a random password with the default length of 12 characters
$password = generateRandomPassword();

// Display the generated password
echo "Generated Password: " . $password;
?>
