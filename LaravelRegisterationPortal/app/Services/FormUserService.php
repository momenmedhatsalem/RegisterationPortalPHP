<?php

namespace App\Services;


use App\Models\FormUser;
use App\Helpers\DataFormatter;


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
            $request[$key] = DataFormatter::clean($value);
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
        $request->validate([
            'full_name'                 =>  ['required', 'regex:/^([a-zA-Z]+[-.]?[ ]*){1,6}$/'],
            'user_name'                 =>  ['required', 'regex:/^[^\s]+$/', 'unique:form_users'],
            'password'                  =>  ['required', 'regex:/^\S*$/', Password::min(8)
                                                                            ->letters()
                                                                            ->numbers()
                                                                            ->symbols()
                                                                            ->uncompromised()
                                            ],
            'confirm_password'          =>  ['required', 'same:password'],
            'email'                     =>  ['required', 'email', 'unique:form_users'],
            'phone'                     =>  ['required', 'regex:/^\+?[0-9]{7,15}$/', 'unique:form_users'],
            'whatsapp'                  =>  ['required', 'regex:/^\+?[0-9]{7,15}$/'],
            'address'                   =>  ['required'],
            'user_image'                =>  ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048', 'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000']
        
        
        ], [


            'required'                  => 'The :attribute field is required. Please fill it',
            'unique'                    => 'This :attribute is already in use. Please enter another :attribute',

            'full_name.regex'           => 'Your name must contain at least one alphabetical letter and no special characters other than - . (which can\'t be consecutive) and spaces. Maximum till the name of the 4th grandparent',

            'user_name.regex'           => 'usernames cannot contain any whitespaces or backslashes',

            'password.regex'            => 'passwords can\'t contain any whitespace characters',
            'password.min'              => 'password must be at least 8 characters long',
            'password.letters'          => 'password must contain at least one letter',
            'password.numbers'          => 'password must contain at least one number',
            'password.symbols'          => 'password must contain at least one special character',
            
            'confirm_password.same'     => 'confirm password doesn\'t match password',

            'email.email'               => 'please enter a valid email address',

            'phone.regex'               => 'Phone number must contain only digits, and may start with a +. It must be between 7 to 15 digits',

            'whatsapp.regex'            => 'Phone number must contain only digits, and may start with a +. It must be between 7 to 15 digits',

            'user_image.image'          => 'The uploaded file is not an image',
            'user_image.mimes'          => 'please choose an image with one of those extensions: jpg, png, jpeg, gif, svg',
            'user_image.max'            => 'maximum image size is 2048. Please choose a smaller image',
            'user_image.dimensions'     => 'The allowed image dimensions are between 100 and 1000 whether in width or height. Please choose another image with suitable dimensions'
        ], [


            'confirm_password'          => 'confirm password',
            'phone'                     => 'phone number',
            'whatsapp'                  => 'whatsapp phone number',
            'user_image'                => 'image'
        ]);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public static function formatAndStoreFormData(Request $request) {
        $user = new FormUser;
        $tempImagePath = 'to-be-assigned-properly-after-storing.png';

        $user->name = DataFormatter::removeRedundantWS($request->full_name);
        $user->username = $request->user_name;
        $user->password = Hash::make($request->password);;
        $user->email = $request->email;
        $user->phone_number = DataFormatter::formatPhoneNumber($request->phone);
        $user->whatsapp_phone_number = DataFormatter::formatPhoneNumber($request->whatsapp);
        $user->address = DataFormatter::removeRedundantWS($request->address);
        $user->image_path = $tempImagePath;

        $user->save();
        FormUserService::handleUploadedImage($request, $user);
    }


    /**
     * @param \Illuminate\Http\Request  $request
     * @param \App\Models\FormUser      $user
     */
    protected static function handleUploadedImage (Request $request, FormUser $user) {
        $image = $request->file('user_image');

        //make a proper naming for the image
        $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        //clean the name from any extra-special chars
        $originalFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalFileName);
        $fileExtension = $image->getClientOriginalExtension();
        $newFileName = "user_{$user->id}_{$originalFileName}.{$fileExtension}";

        $uploadDir = 'images/users/';
        $image->move(public_path($uploadDir), $newFileName);

        $user->image_path = $newFileName;
        $user->save();
    }
}