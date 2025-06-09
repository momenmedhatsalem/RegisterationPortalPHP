<?php

namespace App\Services;

use App\Helpers\DataFormatter;
use Illuminate\Support\Facades\Http;

class WhatsAppService 
{
  
 
    /**
     * Validate with WhatsApp API
     * 
     * @param string $number
     * @throws \Exception
     */
   public static function validateWhatsAppNumber($number)
    {
        $url = 'https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItBulkWithToken';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-RapidAPI-Key' => env('RAPIDAPI_KEY'),
            'X-RapidAPI-Host' => env('RAPIDAPI_HOST'),
        ])->post($url, [
            'phone_numbers' => [$number]
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to reach WhatsApp API. Please try again.');
        }

        $responseData = $response->json();

        if (!empty($responseData) && isset($responseData[0]['status'])) {
            if ($responseData[0]['status'] !== 'valid') {
                throw new \Exception('Invalid WhatsApp number.');
            }
        } else {
            throw new \Exception('Unexpected response from WhatsApp API.');
        }
    }
}

