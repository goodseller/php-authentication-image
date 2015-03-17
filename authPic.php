<?php

/**
 * Draw authication key.
 *
 * Use:
 *   <img src="path/authPic.php">
 * 
 * Remarks:
 *   No class needed for this file for performance reason.
 * 
 * @author Eric
 */


/**
 * Generate authication key
 * @param int $m Number of key length.
 * @param int $type Key types. 0: [0-9]; 1:[0-9[a-z]]; 2:[0-9[a-z][A-Z]]
 * @return string
 */
function getKey($m, $type){
    // string to be used
    $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    // type define
    $t = array (9,35,strlen($str)-1);
    
    
    $key="";
    for($i=0; $i<$m;$i++){
        $key.=$str[rand(0, $t[$type])];
    }
    return $key;
};

function randColor($image){
    return imagecolorallocate($image,
                                     rand(0,200), rand(0,200), rand(0,200));
}

/*********
 * config
 *********
 */

$keyLen = 4; // auth. key len.
$fontWidth = 28;
$paddingLeft = 6;
$paddingBottom = 15;
$charBlockWidth = 30;
$charBlockHeight = $charBlockWidth * 1.618; // times golden rate
$type = 2;
$cavSize = array($charBlockWidth * $keyLen, $charBlockHeight); // width, height
$bgColor = array(200,200,200); // background color in rgb
$fontfile = "Anonymous_Pro_0.ttf";
$randAngle  = 40;   // angle of rotation of the char
$randDotRate = 0.1; // rate of dot int the canvas. ie.
                    //number of dot = total pixel of image * rate.
$randLineRate = 0.08;

// get Key
$key = getKey($keyLen, $type);

// create canvas
$image = imagecreatetruecolor($cavSize[0], $cavSize[1]);


// define color
$color = imagecolorallocate($image, 111, 0, 55);
$bg  = imagecolorallocate($image, $bgColor[0], $bgColor[1], $bgColor[2]);

// draw
imagefill($image, 0, 0, $bg);

//draw char
for($i=0; $i<$keyLen;$i++){
    $x = $paddingLeft + $i * $fontWidth; // x position of char
    $y = $cavSize[1] - $paddingBottom;   // y position of char
    $angle = rand($randAngle * -1, $randAngle);
    $color = randColor($image);
    imagettftext($image, $fontWidth, $angle, $x, $y, $color, $fontfile, $key[$i]);
};

// draw line
for($i=0; $i < $cavSize[1] * $randLineRate; $i++){
    // left dot
    $x1 = rand(0, $fontWidth);
    $y1 = rand(0, $fontWidth);
    // right dot
    $x2 = rand($cavSize[0] - $fontWidth, $cavSize[0]);
    $y2 = rand($cavSize[1] - $fontWidth, $cavSize[1]);
    imageline($image, $x1, $y1, $x2, $y2, randColor($image));
}

// draw dot
for($i=0;$i<$cavSize[0] * $cavSize[1] * $randDotRate;$i++){
    $angle = rand($randAngle * -1, $randAngle);
    $color = randColor($image);
    imagesetpixel($image, rand(0,$cavSize[0]), rand(0,$cavSize[1]), $color);
}

// output img
header("Content-Type:image/png"); // set header as png
imagepng($image);

// release cache.
imagedestroy($image);

session_start();
$_SESSION["authKey"] = $key;
?>