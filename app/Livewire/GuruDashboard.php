<?php

namespace App\Livewire;

use App\Models\Guru;
use App\Models\PerjalananDinas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GuruDashboard extends Component
{
    public function mount()
    {
        $user = Auth::user();

        // Redirect admin users to admin panel
        if ($user->role === 'admin') {
            return redirect('/admin');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    public function delete($id)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if ($guru) {
            $pengajuan = PerjalananDinas::where('id', $id)
                ->where('guru_id', $guru->id)
                ->first();

            if ($pengajuan) {
                // Check status restriction
                if (!in_array($pengajuan->status, ['Terkirim', 'Ditolak', 'Belum Dicek'])) {
                    session()->flash('error', 'Pengajuan ini tidak dapat dihapus karena sedang diproses atau sudah selesai.');
                    return;
                }

                // Delete file if exists
                if ($pengajuan->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($pengajuan->file_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($pengajuan->file_path);
                }

                $pengajuan->delete();
                session()->flash('success', 'Pengajuan berhasil dihapus.');
            }
        }
    }

    public function render()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        // If no guru record, show error
        if (!$guru) {
            session()->flash('error', 'Akun Anda tidak terhubung dengan data Pegawai. Hubungi Admin.');
            return view('livewire.guru-dashboard', [
                'guru' => null,
                'history' => collect([]),
            ])->layout('layouts.guru');
        }

        $history = PerjalananDinas::where('guru_id', $guru->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.guru-dashboard', [
            'guru' => $guru,
            'history' => $history,
        ])->layout('layouts.guru');
    }
}
