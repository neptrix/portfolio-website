<?php
session_start();

$random_number = substr(md5(mt_rand()), 0, 7);
$_SESSION['captcha'] = $random_number;

$im = imagecreatetruecolor(80, 30);
$bg_color = imagecolorallocate($im, 255, 255, 255);
$text_color = imagecolorallocate($im, 0, 0, 0);

imagefill($im, 0, 0, $bg_color);
imagestring($im, 5, 10, 5, $random_number, $text_color);

header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
?>