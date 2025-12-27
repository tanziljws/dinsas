<?php

namespace App\Livewire;

use App\Models\Guru;
use App\Models\LoginActivity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GuruLogin extends Component
{
    public $nip = '';
    public $password = '';
    public $error = '';

    protected $rules = [
        'nip' => 'required|string',
        'password' => 'required|string',
    ];

    protected $messages = [
        'nip.required' => 'NIP wajib diisi.',
        'password.required' => 'Password wajib diisi.',
    ];

    /**
     * Log login activity
     */
    private function logActivity(?User $user, string $email, string $status, ?string $reason = null): void
    {
        LoginActivity::create([
            'user_id' => $user?->id,
            'email' => $email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => $status,
            'reason' => $reason,
        ]);
    }

    public function login()
    {
        $this->validate();
        $this->error = '';

        // Find guru by NIP
        $guru = Guru::where('nomor', $this->nip)->first();

        if (!$guru) {
            $this->logActivity(null, $this->nip, 'failed', 'NIP tidak ditemukan');
            $this->error = 'NIP tidak ditemukan dalam sistem.';
            return;
        }

        if (!$guru->user_id) {
            $this->logActivity(null, $this->nip, 'failed', 'Akun belum terdaftar');
            $this->error = 'Akun belum terdaftar. Hubungi administrator.';
            return;
        }

        // Get user
        $user = User::find($guru->user_id);
        $email = $this->nip . '@smkn4bogor.local';

        // Check if account is locked
        if ($user && $user->isLocked()) {
            $minutes = $user->getLockoutMinutesRemaining();
            $this->logActivity($user, $email, 'locked', 'Akun terkunci');
            $this->error = "Akun terkunci karena terlalu banyak percobaan gagal. Coba lagi dalam {$minutes} menit.";
            return;
        }

        // Attempt login
        if (Auth::attempt(['email' => $email, 'password' => $this->password])) {
            // Success - reset failed attempts and log
            $user->resetFailedAttempts();
            $this->logActivity($user, $email, 'success');

            session()->regenerate();
            return redirect()->route('guru.dashboard');
        }

        // Failed login
        if ($user) {
            $user->incrementFailedAttempts();
            $remainingAttempts = User::MAX_LOGIN_ATTEMPTS - $user->fresh()->failed_login_attempts;

            if ($remainingAttempts <= 0) {
                $this->logActivity($user, $email, 'locked', 'Akun dikunci setelah 5 kali gagal');
                $this->error = "Akun terkunci karena terlalu banyak percobaan gagal. Coba lagi dalam " . User::LOCKOUT_DURATION . " menit.";
            } else {
                $this->logActivity($user, $email, 'failed', 'Password salah');
                $this->error = "Password salah. Sisa percobaan: {$remainingAttempts}";
            }
        } else {
            $this->logActivity(null, $email, 'failed', 'User tidak ditemukan');
            $this->error = 'Password salah. Password default adalah NIP Anda.';
        }
    }

    public function render()
    {
        return view('livewire.guru-login')
            ->layout('layouts.public');
    }
}
