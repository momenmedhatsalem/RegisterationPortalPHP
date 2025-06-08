<?php

namespace App\Helpers;

class DataFormatter {

    public static function clean($input) {
        if (is_null($input))
        {
            return $input;
        }

        return htmlspecialchars(trim(stripslashes($input)));
    }


    public static function removeRedundantWS ($text) {
        if (is_null($text))
        {
            return $text;
        }

        $found_WS = false;
        for ($i = 0; $i < strlen($text); $i++)
        {
            if (($text[$i] === ' ' || $text[$i] === '\n') && !$found_WS)
            {
                $found_WS = true;
            }
            else if (($text[$i] === ' ' || $text[$i] === '\n') && $found_WS)
            {
                //remove the extra consecutive ws
                $text = substr($text, 0,$i) . substr($text, $i + 1);
            }
            else if (!($text[$i] === ' ' || $text[$i] === '\n') && $found_WS)
            {
                $found_WS = false;
            }
        }
        return $text;
    }


    public static function formatPhoneNumber ($phoneNumber) {
        if (is_null($phoneNumber))
        {
            return $phoneNumber;
        }

        if ($phoneNumber[0] !== '+')
        {
            $char = '+';
            $phoneNumber = $char . $phoneNumber; 
        }
        return $phoneNumber;
    }
};