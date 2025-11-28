<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Pembina;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Admin bisa lihat semua peserta
        if ($user->role === 'admin') {
            $pesertas = Peserta::with(['user', 'pembina'])->paginate(10);
        }
        // Pembina hanya bisa lihat peserta mereka
        elseif ($user->role === 'pembina') {
            $pembina = $user->pembina;
            if (! $pembina) {
                return redirect()->back()->with('error', 'Data pembina tidak ditemukan');
            }
            $pesertas = $pembina->pesertas()->with('pembina')->paginate(10);
        }
        // Peserta tidak boleh akses halaman ini
        else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        return view('peserta.index', compact('pesertas'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang bisa membuat peserta baru');
        }

        $pembinas = Pembina::all();

        return view('peserta.create', compact('pembinas'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang bisa membuat peserta baru');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'pembina_id' => 'required|exists:pembinas,id',
            'nisn' => 'required|unique:pesertas',
            'nama_lengkap' => 'required|string',
            'sekolah' => 'required|string',
            'jurusan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'nomor_hp' => 'required|string',
        ]);

        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'plain_password' => $validated['password'],
            'role' => 'peserta',
        ]);

        Peserta::create([
            'user_id' => $newUser->id,
            'pembina_id' => $validated['pembina_id'],
            'nisn' => $validated['nisn'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'sekolah' => $validated['sekolah'],
            'jurusan' => $validated['jurusan'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'nomor_hp' => $validated['nomor_hp'],
        ]);

        return redirect('/peserta')->with('success', 'Data peserta berhasil ditambahkan');
    }

    public function edit($id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = auth()->user();

        // Pembina hanya bisa edit peserta mereka
        if ($user->role === 'pembina') {
            $pembina = $user->pembina;
            if (! $pembina || $peserta->pembina_id !== $pembina->id) {
                return redirect()->back()->with('error', 'Anda tidak bisa mengedit peserta ini');
            }
        }
        // Hanya admin dan pembina yang punya peserta ini
        elseif ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $pembinas = Pembina::all();

        return view('peserta.edit', compact('peserta', 'pembinas'));
    }

    public function update(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = auth()->user();

        // Pembina hanya bisa update peserta mereka
        if ($user->role === 'pembina') {
            $pembina = $user->pembina;
            if (! $pembina || $peserta->pembina_id !== $pembina->id) {
                return redirect()->back()->with('error', 'Anda tidak bisa mengupdate peserta ini');
            }
        }
        // Hanya admin yang bisa update dengan full access
        elseif ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $validated = $request->validate([
            'pembina_id' => 'required|exists:pembinas,id',
            'nama_lengkap' => 'required|string',
            'sekolah' => 'required|string',
            'jurusan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'nomor_hp' => 'required|string',
        ]);

        $peserta->update($validated);

        return redirect('/peserta')->with('success', 'Data peserta berhasil diperbarui');
    }

    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = auth()->user();

        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang bisa menghapus peserta');
        }

        $peserta->user()->delete();
        $peserta->delete();

        return redirect('/peserta')->with('success', 'Data peserta berhasil dihapus');
    }

    public function show($id)
    {
        $peserta = Peserta::findOrFail($id);
        $attendances = $peserta->attendances()->orderBy('tanggal', 'desc')->paginate(10);

        return view('peserta.show', compact('peserta', 'attendances'));
    }

    public function editPassword($id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = auth()->user();

        // Only admin can edit peserta password
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        return view('peserta.edit-password', compact('peserta'));
    }

    public function updatePassword(UpdatePasswordRequest $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = auth()->user();

        // Only admin can update peserta password
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $peserta->user->update([
            'password' => bcrypt($request->password),
            'plain_password' => $request->password,
        ]);

        return redirect('/peserta')->with('success', 'Password peserta berhasil diperbarui');
    }
}
