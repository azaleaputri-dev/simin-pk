<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPDB extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_INVITED_TO_TEST = 'diajak_tes';
    public const STATUS_PASSED_TEST = 'lulus_tes';
    public const STATUS_WAITLIST = 'waitlist';
    public const STATUS_ACCEPTED = 'diterima';
    public const STATUS_REJECTED = 'ditolak';
    public const STATUS_CANCELLED = 'batal';

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_INVITED_TO_TEST,
        self::STATUS_PASSED_TEST,
        self::STATUS_WAITLIST,
        self::STATUS_ACCEPTED,
        self::STATUS_REJECTED,
        self::STATUS_CANCELLED,
    ];

    public const REVIEW_STATUSES = [
        self::STATUS_INVITED_TO_TEST,
        self::STATUS_PASSED_TEST,
        self::STATUS_WAITLIST,
    ];

    public const FINAL_STATUSES = [
        self::STATUS_ACCEPTED,
        self::STATUS_REJECTED,
        self::STATUS_CANCELLED,
    ];

    protected $table = 'p_p_d_b_s';

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'tempat_lahir',
        'agama',
        'alamat',
        'rt',
        'rw',
        'dusun',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'no_telp',
        'email',
        'nama_orang_tua',
        'email_orang_tua',
        'no_hp_orang_tua',
        'asal_sekolah',
        'nisn_asal',
        'jalur_pendaftaran',
        'pilihan_jurusan',
        'status_pendaftaran',
        'tanggal_daftar',
        'tanggal_tes',
        'tanggal_pengumuman',
        'berkas',
        'catatan',
        'user_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'date',
        'tanggal_tes' => 'date',
        'tanggal_pengumuman' => 'date',
        'berkas' => 'array',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'ppdb_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portalProgress(): array
    {
        $steps = self::portalSteps();

        $status = $this->status_pendaftaran;
        $currentStep = match ($status) {
            self::STATUS_ACCEPTED, self::STATUS_REJECTED, self::STATUS_CANCELLED => 'hasil',
            self::STATUS_INVITED_TO_TEST, self::STATUS_PASSED_TEST, self::STATUS_WAITLIST => 'review',
            default => 'formulir',
        };

        $completed = ['akun', 'formulir'];

        if (in_array($status, array_merge(self::REVIEW_STATUSES, self::FINAL_STATUSES), true)) {
            $completed[] = 'review';
        }

        if (in_array($status, array_merge([self::STATUS_WAITLIST], self::FINAL_STATUSES), true)) {
            $completed[] = 'waitlist';
        }

        if (in_array($status, self::FINAL_STATUSES, true)) {
            $completed[] = 'hasil';
        }

        return [
            'current' => $currentStep,
            'completed' => array_values(array_unique($completed)),
            'steps' => $steps,
            'status_label' => ucfirst(str_replace('_', ' ', $status)),
        ];
    }

    public static function emptyPortalJourney(): array
    {
        return [
            'current' => 'akun',
            'completed' => ['akun'],
            'steps' => self::portalSteps(),
            'status_label' => 'Menunggu pengisian formulir',
        ];
    }

    public function statusAppearance(): array
    {
        return match ($this->status_pendaftaran) {
            self::STATUS_ACCEPTED => ['label' => 'Diterima', 'class' => 'text-bg-success'],
            self::STATUS_REJECTED, self::STATUS_CANCELLED => ['label' => ucfirst(str_replace('_', ' ', $this->status_pendaftaran)), 'class' => 'text-bg-danger'],
            self::STATUS_INVITED_TO_TEST, self::STATUS_PASSED_TEST, self::STATUS_WAITLIST => ['label' => ucfirst(str_replace('_', ' ', $this->status_pendaftaran)), 'class' => 'text-bg-warning'],
            default => ['label' => ucfirst(str_replace('_', ' ', $this->status_pendaftaran)), 'class' => 'text-bg-secondary'],
        };
    }

    public function isFinalStatus(): bool
    {
        return in_array($this->status_pendaftaran, self::FINAL_STATUSES, true);
    }

    public function canManagePortalDocuments(): bool
    {
        return ! $this->isFinalStatus();
    }

    public function requiredPortalDocuments(): array
    {
        return [
            'kk' => 'Kartu Keluarga',
            'akte' => 'Akte Kelahiran',
            'foto' => 'Foto Siswa',
        ];
    }

    public function portalDocumentSummary(): array
    {
        $required = $this->requiredPortalDocuments();
        $uploaded = $this->berkas ?? [];
        $items = [];
        $completed = 0;

        foreach ($required as $key => $label) {
            $isUploaded = isset($uploaded[$key]['path']) && $uploaded[$key]['path'];

            if ($isUploaded) {
                $completed++;
            }

            $items[] = [
                'key' => $key,
                'label' => $label,
                'uploaded' => $isUploaded,
            ];
        }

        return [
            'completed' => $completed,
            'total' => count($required),
            'items' => $items,
            'is_complete' => $completed === count($required),
            'percentage' => count($required) > 0 ? (int) round(($completed / count($required)) * 100) : 0,
            'missing_labels' => collect($items)->where('uploaded', false)->pluck('label')->values()->all(),
            'missing_items' => collect($items)->where('uploaded', false)->values()->all(),
        ];
    }

    protected static function portalSteps(): array
    {
        return [
            ['key' => 'akun', 'label' => 'Akun Aktif', 'description' => 'Akun portal orang tua sudah berhasil dibuat.'],
            ['key' => 'formulir', 'label' => 'Form Diisi', 'description' => 'Formulir PPDB calon siswa sudah dikirim ke sistem.'],
            ['key' => 'review', 'label' => 'Ditinjau Admin', 'description' => 'Admin sekolah sedang memeriksa data pendaftaran.'],
            ['key' => 'waitlist', 'label' => 'Menunggu Kuota', 'description' => 'Pendaftaran telah lulus seleksi tetapi menunggu kuota yang tersedia.'],
            ['key' => 'hasil', 'label' => 'Hasil Akhir', 'description' => 'Pendaftaran sudah mendapatkan keputusan akhir dari sekolah.'],
        ];
    }
}
