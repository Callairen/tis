<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DummyUser;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Data user dummy untuk simulasi [cite: 106-119]
    private $users = [
    [
        'id' => 1,
        'name' => 'User Cakep',
        'email' => 'user@example.com',
        'password' => 'password123'
    ],
    [
        'id' => 2,
        'name' => 'Admin Hebat',
        'email' => 'admin@example.com',
        'password' => 'secret321'
    ],
    [
        'id' => 3,
        'name' => 'Devanida Ratna',
        'email' => 'nana@example.com',
        'password' => 'itulahpokoknya966'
    ],
];

    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email',
        'password' => 'required|string|min:6|confirmed'
    ]);

    // Logika Validasi Email Unik Manual (Pengerjaan Nomor 2)
    $isExist = collect($this->users)->firstWhere('email', $validated['email']);

    if ($isExist) {
        return response()->json([
            'message' => 'The email has already been taken.'
        ], 422); // 422 Unprocessable Entity
    }

    $user = [
        'id' => rand(3, 1000),
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'],
    ];

    return response()->json([
        'message' => 'User registered successfully (dummy)',
        'user' => $user
    ], 201);
}

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Mencari user di array dummy berdasarkan email [cite: 145-146]
        $userData = collect($this->users)->firstWhere('email', $credentials['email']);

        // Validasi password sederhana [cite: 147]
        if (!$userData || $userData['password'] !== $credentials['password']) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        // Buat objek DummyUser dan generate token [cite: 151-156]
        $user = new DummyUser($userData);
        $token = JWTAuth::claims([
            'email' => $user->email,
            'name' => $user->name
        ])->fromUser($user);

        return response()->json([
            'message' => 'Login successful (dummy)',
            'token' => $token
        ]);
    }

    public function logout()
    {
        try {
            // Melakukan invalidasi pada token yang sedang digunakan [cite: 164]
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'User logged out successfully']);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Failed to logout, token invalid'], 500);
        }
    }

    public function profile(Request $request)
    {
        // Mengambil payload yang sudah disisipkan oleh middleware dummy.jwt [cite: 177]
        $payload = $request->jwt_payload;

        return response()->json([
            'user' => [
                'email' => $payload->get('email'),
                'name' => $payload->get('name')
            ]
        ]);
    }

    public function tokenCheck(Request $request)
    {
    $payload = $request->jwt_payload;

    return response()->json([
        'message' => 'Token valid',
        'user' => [
            'email' => $payload->get('email'),
            'name' => $payload->get('name')
        ]
    ], 200);
}
}