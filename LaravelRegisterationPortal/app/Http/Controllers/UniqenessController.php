<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UniquenessController extends Controller
{
  public function checkUnique(Request $request)
{
    $field = $request->input('field');
    $value = $request->input('value');

    $allowedFields = [
        'username' => 'username',
        'email' => 'email',
        'phone_number' => 'phone_number'
    ];

    if (!array_key_exists($field, $allowedFields)) {
        return response()->json(['available' => false, 'message' => 'Invalid field'], 400);
    }

    $column = $allowedFields[$field];

    $exists = \DB::table('form_users')->where($column, $value)->exists();

    return response()->json([
        'available' => !$exists
    ]);
}

}
