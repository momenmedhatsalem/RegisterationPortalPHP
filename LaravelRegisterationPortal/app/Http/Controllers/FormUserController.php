<?php

namespace App\Http\Controllers;

use App\Services\FormUserService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use App\Mail\NewUserRegistered; 
use Illuminate\Support\Facades\Mail;
class FormUserController extends Controller
{
    protected $whatsAppService;

    // Inject WhatsAppService via constructor
    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function store(Request $request)
    {
        FormUserService::cleanFormData($request);
        FormUserService::validateFormData($request);

        $this->validateWhatsAppNumberAPI($request->whatsapp_phone_number);

        FormUserService::formatAndStoreFormData($request);
       $user = [  
            'name' => $request->name,
            'username'=> $request->username , 
            'email'=> $request->email,
            'phone_number'=> $request->phone_number,
            'whatsapp_number'=> $request->whatsapp_phone_number

            ];

Mail::to('marimesm2@gmail.com')->send(new NewUserRegistered($user));

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
       
        $this->whatsAppService->validateWhatsAppNumber($whatsappNumber);
    }
}
