<?php

namespace App\Http\Controllers;

use App\Services\FormUserService;
use App\Services\WhatsAppService;


use Illuminate\Http\Request;


class FormUserController extends Controller
{
    /**
     * Store the form's data which represents a FormUser instance in the DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
            FormUserService::cleanFormData($request);
            FormUserService::validateFormData($request);
       
            $this->validateWhatsAppNumberAPI($request->whatsapp_phone_number);
            FormUserService::formatAndStoreFormData($request);


            return redirect('/')->with('success', 'You are successfully registered!');
            
        
    }

     public function ajaxCheckWhatsApp(Request $request)
    {
    
        try {
            $this->validateWhatsAppNumberAPI($request->whatsapp_phone_number);

            return response()->json([
                'valid' => true,
                'message' => 'Valid WhatsApp number!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    private function validateWhatsAppNumberAPI($whatsappNumber)
    {
          WhatsAppService::validateWhatsAppNumber($whatsappNumber);

    }
        
        

    
}
