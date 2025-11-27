<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        if ($user->role === 'admin') {
            $stats = [
                'total_pembina' => \App\Models\Pembina::count(),
                'total_peserta' => \App\Models\Peserta::count(),
                'total_absensi' => \App\Models\Attendance::count(),
            ];
            return view('dashboard.admin', compact('stats'));
        } else if ($user->role === 'pembina') {
            $pembina = $user->pembina;
            
            if (!$pembina) {
                return redirect('/')->with('error', 'Data pembina tidak ditemukan');
            }
            
            $stats = [
                'total_peserta' => $pembina->pesertas()->count(),
                'hadir_hari_ini' => \App\Models\Attendance::whereHas('peserta', function ($query) use ($pembina) {
                    $query->where('pembina_id', $pembina->id);
                })->where('tanggal', today())
                    ->where('status', 'hadir')
                    ->count(),
            ];
            return view('dashboard.pembina', compact('stats', 'pembina'));
        } else {
            $peserta = $user->peserta;
            
            if (!$peserta) {
                return redirect('/')->with('error', 'Data peserta tidak ditemukan');
            }
            
            $today_attendance = \App\Models\Attendance::where('peserta_id', $peserta->id)
                ->where('tanggal', today())
                ->first();
            $stats = [
                'total_hadir' => $peserta->attendances()->where('status', 'hadir')->count(),
                'total_izin' => $peserta->attendances()->where('status', 'izin')->count(),
                'total_sakit' => $peserta->attendances()->where('status', 'sakit')->count(),
                'total_alfa' => $peserta->attendances()->where('status', 'alfa')->count(),
            ];
            return view('dashboard.peserta', compact('stats', 'peserta', 'today_attendance'));
        }
    }
}
