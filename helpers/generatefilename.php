<?php
function generateFileName($originalName) {
     $timestamp = time();
     $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
     return 'avatar_' . $timestamp . '.' . $fileExtension;
}
?>