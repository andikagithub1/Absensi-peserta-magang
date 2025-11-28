<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'peserta') {
            $peserta = $user->peserta;
            $attendances = $peserta->attendances()->orderBy('tanggal', 'desc')->paginate(10);
        } elseif ($user->role === 'pembina') {
            $pembina = $user->pembina;
            $attendances = Attendance::whereHas('peserta', function ($query) use ($pembina) {
                $query->where('pembina_id', $pembina->id);
            })->orderBy('tanggal', 'desc')->paginate(10);
        } else {
            $attendances = Attendance::orderBy('tanggal', 'desc')->paginate(10);
        }

        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $user = auth()->user();
        if ($user->role !== 'peserta') {
            return redirect('/attendance')->with('error', 'Hanya peserta yang dapat membuat absensi');
        }

        $peserta = $user->peserta;

        return view('attendance.create', compact('peserta'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'peserta') {
            return redirect('/attendance')->with('error', 'Hanya peserta yang dapat membuat absensi');
        }

        $peserta = $user->peserta;
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'foto_masuk' => 'required|image|max:2048',
            'foto_keluar' => 'nullable|image|max:2048',
            'status' => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|string',
            'tanda_tangan' => 'required|string',
        ]);

        // Handle foto masuk
        if ($request->hasFile('foto_masuk')) {
            $validated['foto_masuk'] = $request->file('foto_masuk')->store('attendance', 'public');
        }

        // Handle foto keluar
        if ($request->hasFile('foto_keluar')) {
            $validated['foto_keluar'] = $request->file('foto_keluar')->store('attendance', 'public');
        }

        $validated['peserta_id'] = $peserta->id;

        Attendance::create($validated);

        return redirect('/attendance')->with('success', 'Data absensi berhasil disimpan');
    }

    public function edit(Attendance $attendance)
    {
        $user = auth()->user();
        if ($user->role === 'peserta') {
            if ($attendance->peserta->user_id !== $user->id) {
                return redirect('/attendance')->with('error', 'Anda tidak memiliki akses');
            }
        } elseif ($user->role !== 'admin' && $user->role !== 'pembina') {
            return redirect('/attendance')->with('error', 'Anda tidak memiliki akses');
        }

        return view('attendance.edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $user = auth()->user();
        if ($user->role === 'peserta') {
            if ($attendance->peserta->user_id !== $user->id) {
                return redirect('/attendance')->with('error', 'Anda tidak memiliki akses');
            }
        } elseif ($user->role !== 'admin' && $user->role !== 'pembina') {
            return redirect('/attendance')->with('error', 'Anda tidak memiliki akses');
        }

        $validated = $request->validate([
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'foto_masuk' => 'nullable|image|max:2048',
            'foto_keluar' => 'nullable|image|max:2048',
            'status' => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|string',
            'tanda_tangan' => 'nullable|string',
        ]);

        // Handle foto masuk
        if ($request->hasFile('foto_masuk')) {
            if ($attendance->foto_masuk) {
                @unlink(storage_path('app/public/'.$attendance->foto_masuk));
            }
            $validated['foto_masuk'] = $request->file('foto_masuk')->store('attendance', 'public');
        }

        // Handle foto keluar
        if ($request->hasFile('foto_keluar')) {
            if ($attendance->foto_keluar) {
                @unlink(storage_path('app/public/'.$attendance->foto_keluar));
            }
            $validated['foto_keluar'] = $request->file('foto_keluar')->store('attendance', 'public');
        }

        $attendance->update($validated);

        return redirect('/attendance')->with('success', 'Data absensi berhasil diperbarui');
    }

    public function destroy(Attendance $attendance)
    {
        $user = auth()->user();
        if ($user->role === 'peserta') {
            if ($attendance->peserta->user_id !== $user->id) {
                return redirect('/attendance')->with('error', 'Anda tidak memiliki akses');
            }
        } elseif ($user->role !== 'admin') {
            return redirect('/attendance')->with('error', 'Anda tidak memiliki akses');
        }

        if ($attendance->foto_masuk) {
            @unlink(storage_path('app/public/'.$attendance->foto_masuk));
        }
        if ($attendance->foto_keluar) {
            @unlink(storage_path('app/public/'.$attendance->foto_keluar));
        }

        $attendance->delete();

        return redirect('/attendance')->with('success', 'Data absensi berhasil dihapus');
    }

    public function show(Attendance $attendance)
    {
        return view('attendance.show', compact('attendance'));
    }
}
