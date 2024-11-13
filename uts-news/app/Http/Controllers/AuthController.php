<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;  // Pastikan mengimpor Hash untuk hash password

class AuthController extends Controller
{
    // Fungsi untuk register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Membuat input user
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ];

        // Menyimpan user ke dalam database
        $user = User::create($input);

        // Mengirimkan response
        return response()->json([
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    // Fungsi untuk login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Mencari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Mengecek kecocokan email dan password
        if ($user && Hash::check($request->password, $user->password)) {

            // Membuat token untuk user yang berhasil login
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Login successful',
                'token' => $token
            ], 200);
        }

        // Jika login gagal
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
}
