<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Pembina;
use App\Models\User;
use Illuminate\Http\Request;

class PembinaController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()?->role !== 'admin') {
                abort(403, 'Unauthorized');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $pembinas = Pembina::with('user')->paginate(10);

        return view('pembina.index', compact('pembinas'));
    }

    public function create()
    {
        return view('pembina.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'nip' => 'required|unique:pembinas',
            'nama_lengkap' => 'required|string',
            'jabatan' => 'required|string',
            'nomor_hp' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'plain_password' => $validated['password'],
            'role' => 'pembina',
        ]);

        Pembina::create([
            'user_id' => $user->id,
            'nip' => $validated['nip'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'jabatan' => $validated['jabatan'],
            'nomor_hp' => $validated['nomor_hp'],
        ]);

        return redirect('/pembina')->with('success', 'Data pembina berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pembina = Pembina::findOrFail($id);

        return view('pembina.edit', compact('pembina'));
    }

    public function update(Request $request, $id)
    {
        $pembina = Pembina::findOrFail($id);
        $validated = $request->validate([
            'nama_lengkap' => 'required|string',
            'jabatan' => 'required|string',
            'nomor_hp' => 'required|string',
        ]);

        $pembina->update($validated);

        return redirect('/pembina')->with('success', 'Data pembina berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pembina = Pembina::findOrFail($id);
        $pembina->user()->delete();
        $pembina->delete();

        return redirect('/pembina')->with('success', 'Data pembina berhasil dihapus');
    }

    public function show($id)
    {
        $pembina = Pembina::findOrFail($id);
        $pesertas = $pembina->pesertas()->paginate(10);

        return view('pembina.show', compact('pembina', 'pesertas'));
    }

    public function editPassword($id)
    {
        $pembina = Pembina::findOrFail($id);

        return view('pembina.edit-password', compact('pembina'));
    }

    public function updatePassword(UpdatePasswordRequest $request, $id)
    {
        $pembina = Pembina::findOrFail($id);
        $user = $pembina->user;

        $user->update([
            'password' => bcrypt($request->password),
            'plain_password' => $request->password,
        ]);

        return redirect('/pembina')->with('success', 'Password pembina berhasil diperbarui');
    }
}
