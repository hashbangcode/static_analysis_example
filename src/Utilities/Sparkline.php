<?php

namespace Hashbangcode\Composerexample\Utilities;

class Sparkline
{

    public static function getData() {
        $data = [];
        if (isset($_GET['data']) && str_contains($_GET['data'], ',')) {
            foreach (explode(',', $_GET['data']) as $datum) {
                if (is_numeric($datum)) {
                    // Ignore anything that that isn't a number.
                    $data[] = $datum;
                }
            }
        }
        return $data;
    }

    public static function getWidth() {
        // Define the width.
        $width = 50;
        if (isset($_GET['w']) && is_numeric($_GET['w']) && $_GET['w'] < 300) {
            // Set the passed width, cast to an integer.
            $width = (int) $_GET['w'];
        }
        return $width;
    }
    public static function getHeight() {
        // Define the height.
        $height = 30;
        if (isset($_GET['h']) && is_numeric($_GET['h']) && $_GET['h'] < 300) {
            // Set the passed height, cast to an integer.
            $height = (int) $_GET['h'];
        }
        return $height;
    }

    public static function sparkLine($data) {

        $data = self::getData();
    $width = self::getWidth();
    $height = self::getHeight();


// Create the image.
        $image = imagecreatetruecolor($width, $height);

// Set the background colour.
        $backgroundColour = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColour);

        if (empty($data)) {
            // If the $data is empty then output a blank image.
            header('Content-Type: image/png');
            imagepng($image);
            exit();
        }

// Set the line colours.
        $lineColour = imagecolorallocate($image, 0, 0, 255);
        $baseLineColour = imagecolorallocate($image, 128, 128, 128);

// Now that we have defined the height of the image ensure 0 on the chart is
// actually 1.
        $height--;

// Get the maximum value from the data.
        $maxValue = max($data);
        $minValue = min($data);

        if ($minValue < 0 && $maxValue > 0) {
            // This line crosses the 0 point, so draw the base line of the chart at 0.
            $x1 = 0;
            $x2 = $width;
            $y1 = $height - round($height * ((0 - $minValue) / ($maxValue - $minValue)));
            $y2 = $height - round($height * ((0 - $minValue) / ($maxValue - $minValue)));
            imageline($image, $x1, $y1, $x2, $y2, $baseLineColour);
        }

// Calculate the corrected distance between each point in the chart.
        $barWidth = ($width) / (count($data) -1);

// Draw the line of the chart.
        for ($i = 0; $i < count($data) -1; $i++) {
            $value = $data[$i] ?? 0;
            $nextValue = $data[$i + 1] ?? 0;
            $x1 = floor($i * $barWidth);
            $x2 = floor($x1 + $barWidth - 1);
            $y1 = $height - round($height * (($value - $minValue) / ($maxValue - $minValue)));
            $y2 = $height - round($height * (($nextValue - $minValue) / ($maxValue - $minValue)));

            imageline($image, $x1, $y1, $x2, $y2, $lineColour);
        }

// Output image.
        header('Content-Type: image/png');
        imagepng($image);

        unset($data);
    }
}