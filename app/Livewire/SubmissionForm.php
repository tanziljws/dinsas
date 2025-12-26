<?php

namespace App\Livewire;

use App\Models\Guru;
use App\Models\PerjalananDinas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubmissionForm extends Component
{
    use WithFileUploads;

    public ?Guru $guru = null;
    public $pengajuanId = null;

    // Form fields
    public $pengikut = []; // Stores array of names
    public $nomor_surat = '';
    public $tanggal_surat = '';
    public $tanggal_berangkat = '';
    public $tanggal_kembali = '';
    public $jenis = '';
    public $lama = 1;
    public $nama_kegiatan = '';
    public $nama_instansi = '';
    public $alamat_instansi = '';
    public $file = null;

    protected function rules()
    {
        $rules = [
            'pengikut.*' => 'nullable|string|max:255',
            'nomor_surat' => 'required|string|max:100',
            'tanggal_surat' => 'required|date',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
            'jenis' => 'required|in:Dalam Kota,Luar Kota',
            'lama' => 'required|integer|min:1',
            'nama_kegiatan' => 'required|string|max:1000',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string|max:500',
            'file' => 'required|file|mimes:pdf|max:10240',
        ];

        // Make file optional if editing
        if ($this->pengajuanId) {
            $rules['file'] = 'nullable|file|mimes:pdf|max:10240';
        }

        return $rules;
    }

    protected $messages = [
        'nomor_surat.required' => 'Nomor surat wajib diisi.',
        'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
        'tanggal_berangkat.required' => 'Tanggal berangkat wajib diisi.',
        'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
        'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal berangkat.',
        'jenis.required' => 'Jenis perjalanan dinas wajib dipilih.',
        'lama.required' => 'Lama perjalanan wajib diisi.',
        'lama.integer' => 'Lama perjalanan harus berupa angka.',
        'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
        'nama_instansi.required' => 'Nama instansi wajib diisi.',
        'alamat_instansi.required' => 'Alamat instansi wajib diisi.',
        'file.required' => 'File dokumen wajib diunggah.',
        'file.mimes' => 'File harus berformat PDF.',
    ];

    public function mount($id = null)
    {
        // Get guru from authenticated user
        $user = Auth::user();
        if ($user) {
            $this->guru = Guru::where('user_id', $user->id)->first();
        }

        if (!$this->guru) {
            session()->flash('error', 'Akun Anda tidak terhubung dengan data Pegawai. Silakan login menggunakan NIP.');
            return redirect()->route('guru.dashboard');
        }

        if ($id) {
            $pengajuan = PerjalananDinas::where('id', $id)
                ->where('guru_id', $this->guru->id)
                ->firstOrFail();

            // Check if editable
            if (!in_array($pengajuan->status, ['Terkirim', 'Ditolak', 'Belum Dicek'])) {
                session()->flash('error', 'Pengajuan ini tidak dapat diedit karena sedang diproses atau sudah selesai.');
                return redirect()->route('guru.dashboard');
            }

            $this->pengajuanId = $pengajuan->id;
            $this->nomor_surat = $pengajuan->nomor_surat;
            $this->tanggal_surat = $pengajuan->tanggal_surat->format('Y-m-d');
            $this->tanggal_berangkat = $pengajuan->tanggal_berangkat->format('Y-m-d');
            if ($pengajuan->tanggal_kembali) {
                $this->tanggal_kembali = $pengajuan->tanggal_kembali->format('Y-m-d');
            }
            $this->jenis = $pengajuan->jenis;
            // Extract integer from lama string if necessary, or just assign
            $this->lama = (int) filter_var($pengajuan->lama, FILTER_SANITIZE_NUMBER_INT);

            $this->nama_kegiatan = $pengajuan->nama_kegiatan;
            $this->nama_instansi = $pengajuan->nama_instansi;
            $this->alamat_instansi = $pengajuan->alamat_instansi;

            $this->pengikut = array_values(array_filter([
                $pengajuan->nama_pengikut1,
                $pengajuan->nama_pengikut2,
                $pengajuan->nama_pengikut3
            ]));
        }
    }

    public function updatedLama($value)
    {
        // Auto-fill tanggal_kembali if duration is 1 day and travel date is set
        if ((int) $value === 1 && $this->tanggal_berangkat) {
            $this->tanggal_kembali = $this->tanggal_berangkat;
        }
    }

    public function updatedTanggalBerangkat($value)
    {
        // Update tanggal_kembali if duration is 1 day
        if ((int) $this->lama === 1) {
            $this->tanggal_kembali = $value;
        }
    }

    public function addPengikut()
    {
        if (count($this->pengikut) < 3) {
            $this->pengikut[] = '';
        }
    }

    public function removePengikut($index)
    {
        unset($this->pengikut[$index]);
        $this->pengikut = array_values($this->pengikut);
    }

    public function submit()
    {
        $this->validate();

        $data = [
            'guru_id' => $this->guru->id,
            'nama_pengikut1' => $this->pengikut[0] ?? null,
            'nama_pengikut2' => $this->pengikut[1] ?? null,
            'nama_pengikut3' => $this->pengikut[2] ?? null,
            'nomor_surat' => $this->nomor_surat,
            'tanggal_surat' => $this->tanggal_surat,
            'tanggal_berangkat' => $this->tanggal_berangkat,
            'tanggal_kembali' => $this->tanggal_kembali,
            'jenis' => $this->jenis,
            'lama' => (string) $this->lama . ' Hari',
            'nama_kegiatan' => $this->nama_kegiatan,
            'nama_instansi' => $this->nama_instansi,
            'alamat_instansi' => $this->alamat_instansi,
            'status' => 'Terkirim',
        ];

        // Handle file upload
        if ($this->file) {
            $data['file_path'] = $this->file->store('uploads', 'public');
        }

        if ($this->pengajuanId) {
            // Update
            PerjalananDinas::where('id', $this->pengajuanId)->update($data);
            $message = 'Pengajuan berhasil diperbarui!';
        } else {
            // Create
            PerjalananDinas::create($data);
            $message = 'Pengajuan berhasil dikirim!';
        }

        return redirect()->route('guru.dashboard')->with('success', $message);
    }

    public function render()
    {
        return view('livewire.submission-form', [
            'gurus' => Guru::orderBy('nama')->get(),
        ])->layout('layouts.guru');
    }
}
