<?php
session_start();

// Create an image
$image = imagecreatetruecolor(200, 50);

// Set the background color
$bgColor = imagecolorallocate($image, 255, 255, 255);
imagefilledrectangle($image, 0, 0, 200, 50, $bgColor);

// Set the text color
$textColor = imagecolorallocate($image, 0, 0, 0);

// Generate a random string
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$captchaText = '';
for ($i = 0; $i < 6; $i++) {
    $captchaText .= $characters[rand(0, strlen($characters) - 1)];
}

// Store the CAPTCHA text in the session
$_SESSION['captcha'] = $captchaText;

// Add the text to the image
$fontPath = __DIR__ . '/arial.ttf'; // Path to the font file
imagettftext($image, 20, 0, 30, 35, $textColor, $fontPath, $captchaText);

// Output the image as a PNG
header('Content-Type: image/png');
imagepng($image);

// Free up memory
imagedestroy($image);
?>
