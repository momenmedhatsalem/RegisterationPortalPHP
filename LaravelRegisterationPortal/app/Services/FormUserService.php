<?php

namespace App\Services;


use App\Models\FormUser;
use App\Helpers\FormDataFormatter;


use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;


class FormUserService {
    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public static function cleanFormData(Request &$request) {
        foreach ($request as $key => $value)
        {
            $request[$key] = FormDataFormatter::clean($value);
        }

        //use this if the above code fails
        //TODO: To be deleted if not used

        // $input = $request->all();

        // foreach ($input as $key => $value) {
        //     $input[$key] = FormDataFormatter::clean($value);
        // }

        // $request->merge($input);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public static function validateFormData(Request &$request) {
        //TODO: Ensure the names of the request object match what's used in the code
        $request->validate([
            'name'                      =>  ['required', 'regex:/^([a-zA-Z]+[-.]?[ ]*){1,6}$/'],
            'username'                  =>  ['required', 'regex:/^[^\s]+$/', 'unique:form_users'],
            'password'                  =>  ['required', 'regex:/^\S*$/', Password::min(8)
                                                                            ->letters()
                                                                            ->numbers()
                                                                            ->symbols()
                                                                            ->uncompromised()
                                            ],
            'confirm_password'          =>  ['required', 'same:password'],
            'email'                     =>  ['required', 'email', 'unique:form_users'],
            'phone_number'              =>  ['required', 'regex:/^\+?[0-9]{7,15}$/', 'unique:form_users'],
            'whatsapp_phone_number'     =>  ['required', 'regex:/^\+?[0-9]{7,15}$/'],
            'address'                   =>  ['required'],
            'image_path'                =>  ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048', 'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000']
        
        
        ], [


            'required'                  => 'The :attribute field is required. Please fill it',
            'unique'                    => 'This :attribute is already in use. Please enter another :attribute',

            'name.regex'                => 'Your name must contain at least one alphabetical letter and no special characters other than - . (which can\'t be consecutive) and spaces. Maximum till the name of the 4th grandparent',

            'username.regex'            => 'usernames cannot contain any whitespaces or backslashes',

            'password.regex'            => 'passwords can\'t contain any whitespace characters',
            'password.min'              => 'password must be at least 8 characters long',
            'password.letters'          => 'password must contain at least one letter',
            'password.numbers'          => 'password must contain at least one number',
            'password.symbols'          => 'password must contain at least one special character',
            
            'confirm_password.same'     => 'confirm password doesn\'t match password',

            'email.email'               => 'please enter a valid email address',

            'phone_number.regex'        => 'Phone number must contain only digits, and may start with a +. It must be between 7 to 15 digits',

            'whatsapp_phone_number.regex'   => 'Phone number must contain only digits, and may start with a +. It must be between 7 to 15 digits',


        ], [


            'confirm_password'          => 'confirm password',
            'phone_number'              => 'phone number',
            'whatsapp_phone_number'     => 'whatsapp phone number'
        ]);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public static function formatAndStoreFormData(Request $request) {
        //TODO: refactor image-related logic
        $file_name = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $file_name);

        //format and store
        //TODO: Ensure the names of the request object match what's used in the code
        $user = new FormUser;

        $user->name = FormDataFormatter::removeRedundantWS($request->name);
        $user->username = $request->username;
        $user->password = Hash::make($request->password);;
        $user->email = $request->email;
        $user->phone_number = FormDataFormatter::formatPhoneNumber($request->phone_number);
        $user->whatsapp_phone_number = FormDataFormatter::formatPhoneNumber($request->whatsapp_phone_number);
        $user->address = FormDataFormatter::removeRedundantWS($request->address);
        $user->image_path = $file_name;

        $user->save();
    }
}