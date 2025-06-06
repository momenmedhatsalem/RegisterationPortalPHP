<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UploadImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'user_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::where('id', $request->user_id)->firstOrFail();
        $file = $request->file('user_image');
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $originalFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalFileName);
        $uniqueKey = uniqid();
        $fileExt = $file->getClientOriginalExtension();
        $newFileName = "{$originalFileName}_{$user->id}_{$uniqueKey}.{$fileExt}";
        $uploadDir = 'uploads/users/';
        $file->move(public_path($uploadDir), $newFileName);
        $user->user_image = $newFileName;
        $user->save();
        return response()->json(['message' => 'File uploaded successfully!', 'file' => $newFileName]);
    }
}
