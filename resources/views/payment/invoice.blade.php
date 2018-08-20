<?php
$font = "Z:\\BEKA\\SOLARNET\\WEB\\demo\\public\\fonts\\arial.ttf";
$fontb = "Z:\\BEKA\\SOLARNET\\WEB\\demo\\public\\fonts\\arialbd.ttf";

$image_width = 300;
$image_height =300;

$image = imagecreate($image_width, $image_height);
imagecolorallocate($image,225,190,231);
$text_color = imagecolorallocate($image,0,0,0);

//for($x=1;$x<=30;$x++){
//    $x1 = rand(1, 100);
//    $y1 = rand(1, 100);
//    $x2 = rand(1, 100);
//    $y2 = rand(1, 100);
//
//    imageline($image, $x1, $y1 ,$x2 ,$y2, $text_color);
//}
$text_color_primary = imagecolorallocate($image,63,81,181);
$text_color_accent = imagecolorallocate($image,255,64,129);
$text_color_grey = imagecolorallocate($image,70,70,70);

imagettftext($image, 12, 0, 120, 30, $text_color, $font, "Tagihan");
imageline($image, 10, 37 ,290 ,37, $text_color_accent);
imagettftext($image, 8, 0, 15, 50, $text_color, $font, "Silakan transfer:");
imagettftext($image, 12, 0, 15, 68, $text_color_primary, $fontb, $amount);
imagettftext($image, 8, 0, 15, 82, $text_color, $font, "Sebelum: ".$expired);
imagettftext($image, 8, 0, 15, 100, $text_color_accent, $font, "- Mohon transfer sesuai jumlah yang tertera");
imagettftext($image, 8, 0, 15, 113, $text_color, $font, "- Transfer melalui bank berbeda dapat dikenakan biaya");

imageline($image, 10, 120 ,290 ,120, $text_color_accent);
imagettftext($image, 8, 0, 15, 133, $text_color_grey, $font, "Bank");
imagettftext($image, 8, 0, 150, 133, $text_color_grey, $font, "No Rekening");
imagettftext($image, 8, 0, 15, 145, $text_color, $font, $bankName);
imagettftext($image, 8, 0, 150, 145, $text_color, $font, "1234567890");

imageline($image, 10, 157,290 ,157, $text_color_accent);
imagettftext($image, 8, 0, 15, 170, $text_color_grey, $font, "Kepada");
imagettftext($image, 8, 0, 150, 170, $text_color_grey, $font, "Dari");
imagettftext($image, 8, 0, 15, 185, $text_color, $font, $bankAccount);
imagettftext($image, 8, 0, 150, 185, $text_color, $font, "User Demo");

imageline($image, 10, 195,290 ,195, $text_color_accent);
imagettftext($image, 8, 0, 15, 208, $text_color_grey, $font, "Catatan");
imagettftext($image, 8, 0, 15, 220, $text_color, $font, $message);
imagejpeg($image);

?>
