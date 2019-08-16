<?php
require_once dirname(__FILE__) . '/capcha/securimage/securimage.php';

$img = new Securimage();

//Change some settings
$img->image_width     = 120;
$img->image_height    = 50;
$img->perturbation    = 0.3;      // high level of distortion
$img->code_length     = rand(5,6); // random code length
$img->image_bg_color  = new Securimage_Color("#ffffff");
$img->num_lines       = 1;
$img->noise_level     = 1;
$img->text_color      = new Securimage_Color("#000000");
$img->noise_color     = $img->text_color;
$img->line_color      = new Securimage_Color("#cccccc");
$img->show();
?>