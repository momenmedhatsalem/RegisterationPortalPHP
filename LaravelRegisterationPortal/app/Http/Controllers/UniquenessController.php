<?php

namespace App\Http\Controllers;
use App\Helpers\DataFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UniquenessController extends Controller
{
  public function checkUnique(Request $request)
{

    $field = $request->input('field');
    $value = $request->input('value');

    //normalize the data as it exists in the DB
    $value = DataFormatter::clean($value);
    if (preg_match('/phone_number$/', $field))
    {
        $value = DataFormatter::formatPhoneNumber($value);
    }

    $allowedFields = [
        'username' => 'username',
        'email' => 'email',
        'phone_number' => 'phone_number'
    ];

    if (!array_key_exists($field, $allowedFields)) {
        return response()->json(['available' => false, 'message' => 'Invalid field'], 400);
    }

    $column = $allowedFields[$field];

    $exists = DB::table('form_users')->where($column, $value)->exists();

    return response()->json([
        'available' => !$exists
    ]);
}

}
