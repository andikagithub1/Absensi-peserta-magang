<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('success', 'Logout berhasil')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:peserta,pembina',
            // Pembina fields
            'nip' => 'nullable|required_if:role,pembina|string|unique:pembinas,nip',
            'jabatan' => 'nullable|required_if:role,pembina|string',
            'nomor_hp' => 'nullable|required_if:role,pembina|string',
            // Peserta fields
            'nisn' => 'nullable|required_if:role,peserta|string|unique:pesertas,nisn',
            'sekolah' => 'nullable|required_if:role,peserta|string',
            'jurusan' => 'nullable|required_if:role,peserta|string',
            'tanggal_mulai' => 'nullable|required_if:role,peserta|date',
            'tanggal_selesai' => 'nullable|required_if:role,peserta|date|after:tanggal_mulai',
        ]);

        // Create user
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        // Create related record based on role
        if ($validated['role'] === 'pembina') {
            \App\Models\Pembina::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'nama_lengkap' => $validated['name'],
                'jabatan' => $validated['jabatan'],
                'nomor_hp' => $validated['nomor_hp'],
            ]);
        } elseif ($validated['role'] === 'peserta') {
            \App\Models\Peserta::create([
                'user_id' => $user->id,
                'pembina_id' => null, // Admin akan assign pembina nanti
                'nisn' => $validated['nisn'],
                'nama_lengkap' => $validated['name'],
                'sekolah' => $validated['sekolah'],
                'jurusan' => $validated['jurusan'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'nomor_hp' => $validated['nomor_hp'] ?? null,
            ]);
        }

        auth()->login($user);
        return redirect('/dashboard')->with('success', 'Registrasi berhasil');
    }
}
