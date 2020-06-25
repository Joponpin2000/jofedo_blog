<?php
function slug($text)
{
    // replace non-letter or digits by -
    $text = strtolower(preg_replace("/[^A-Za-z0-9]/", "-", $text));

    // trim
    $text = trim($text, '-');

    // tranliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('[^A-Za-z0-9-]', '', $text);

    return $text;
}
?>