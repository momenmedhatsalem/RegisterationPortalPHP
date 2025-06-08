<?php

namespace App\Http\Controllers;

use App\Services\FormUserService;

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
        FormUserService::formatAndStoreFormData($request);

        return redirect('/')->with('success', 'You are successfully registered!');
    }
}
