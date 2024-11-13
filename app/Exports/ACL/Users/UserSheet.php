<?php

namespace App\Exports\ACL\Users;

use App\Components\Filters\ACL\UserFilter;
use App\Models\ACL\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserSheet implements WithTitle, WithHeadings, ShouldAutoSize, WithStyles, WithStrictNullComparison, FromQuery, WithMapping
{
    protected $params, $title;

    public function __construct($params = [], $title = 'Data')
    {
        $this->params = $params;
        $this->title = $title;
    }

    public function query()
    {
        $filters = new UserFilter(new Request($this->params));

        return User::with(['jabatan', 'role', 'outlet', 'kota_link', 'unitBisnis', 'direktorat'])->filter($filters)
                ->join('roles', 'roles.id', 'users.role_id')
                ->where('roles.is_master', '!=', 1)
                ->select('users.*');
    }

    public function map($user): array
    {
        $classifiers = [];

        foreach (@$user->jabatan->classifiers ?? [] as $jc) {
            $classifiers[] = @$jc->name;
        }

        return [
            @$user->name,
            @$user->jenis_kelamin,
            @$user->status,
            @$user->npp,
            @$user->id_his,
            @$user->jabatan->level_jabatan,
            @$user->plt_penugasan,
            @$user->tmb_plt,
            @$user->masa_kerja_plt,
            @$user->jabatan->jenis_jabatan,
            @$user->jabatan->name,
            implode(', ', $classifiers),
            @$user->role->name,
            @$user->cost_center,
            @$user->outlet->name,
            @$user->kota_link->name,
            @$user->unitBisnis->name,
            @$user->outlet_inhouse,
            @$user->direktorat->name,
            @$user->strata_unit_bisnis,
            @$user->kelas_outlet,
            @$user->pendidikan,
            @$user->jurusan,
            @$user->alumni_pendidikan,
            @$user->tanggal_lulus,
            @$user->gelar_profesi,
            @$user->alumni_pendidikan_profesi,
            @$user->tahun_lulus_profesi,
            @$user->tempat_lahir,
            @$user->tanggal_lahir,
            @$user->tmb,
            @$user->masa_kerja,
            @$user->tmb_jabatan_saat_ini,
            @$user->masa_kerja_jabatan_saat_ini,
            @$user->tmb_kenaikan_level,
            @$user->tanggal_pj_penuh,
            @$user->tmb_pt,
            @$user->masa_kerja_pt,
            @$user->grading,
            @$user->eselon,
            @$user->spk_i,
            @$user->spk_ii,
            @$user->spk_iii,
            @$user->spk_iv,
            @$user->spk_v,
            @$user->habis_kontrak,
            @$user->domisili_asal,
            @$user->alamat_ktp,
            @$user->kelurahan,
            @$user->kecamatan,
            @$user->kota,
            @$user->provinsi,
            @$user->kode_pos,
            @$user->agama,
            @$user->ktp,
            @$user->no_tlp,
            @$user->alamat_email,
            @$user->no_tlp_keluarga,
            @$user->alamat_sesuai_npwp,
            @$user->npwp,
            @$user->nama_ibu,
            @$user->nama_ayah,
            @$user->bpjs_kes,
            @$user->no_rek,
            @$user->status_kawin_npwp,
            @$user->golongan_darah,
            @$user->status_kawin,
            @$user->jml_anak,
            @$user->jml_anggota_keluarga,
            @$user->nama_pasangan,
            @$user->anak_1,
            @$user->anak_2,
            @$user->anak_3,
            @$user->anak_4,
            @$user->anak_5,
        ];
    }
    
    public function headings(): array
    {
        $headings = [
            'NAMA',
            'JK',
            'STATUS',
            'NPP',
            'ID HIS',
            'LEVEL JABATAN',
            'PLT. PENUGASAN',
            'TMB PLT',
            'MASA KERJA PLT',
            'JENIS JABATAN',
            'JABATAN',
            'CLASSIFIER',
            'ROLES',
            'COST CENTER 2021',
            'OUTLET',
            'KOTA',
            'UNIT BISNIS',
            'OUTLET INHOUSE',
            'DIREKTORAT',
            'STRATA UNIT BISNIS (2023)',
            'KELAS OUTLET (2023)',
            'PENDIDIKAN ',
            'JURUSAN',
            'ALUMNI PENDIDIKAN',
            'TANGGAL LULUS',
            'GELAR PROFESI',
            'ALUMNI PENDIDIKAN PROFESI',
            'TAHUN LULUS PROFESI',
            'TEMPAT LAHIR',
            'TGL LAHIR',
            'USIA',
            'TMB',
            'MASA KERJA ',
            'TMB JABATAN SAAT INI',
            'MASA KERJA JABATAN SAAT INI',
            'TMB KENAIKAN LEVEL (SPV S.D. MANAJER)',
            'TANGGAL PJ PENUH',
            'TMB PT',
            'MASA KERJA PT',
            'GRADING',
            'ESELON ',
            'SPK I',
            'SPK II',
            'SPK III',
            'SPK IV',
            'SPK V',
            'HABIS KONTRAK',
            'HABIS KONTRAK (RUMUS)',
            'DOMISILI ASAL (KOTA)',
            'ALAMAT KTP',
            'KELURAHAN',
            'KECAMATAN',
            'KOTA',
            'PROVINSI',
            'KODE POS',
            'AGAMA',
            'KTP ',
            'NO.TLP',
            'ALAMAT EMAIL',
            'NO.TLP KELUARGA',
            'ALAMAT SESUAI NPWP',
            'NPWP',
            'NAMA IBU',
            'NAMA AYAH',
            'BPJS KES',
            'NO REK',
            'STATUS KAWIN NPWP',
            'GOLONGAN DARAH',
            'STATUS KAWIN_(K)',
            'JML ANAK',
            'JML ANGGOTA KELUARGA (TIDAK TERMASUK PEGAWAI)',
            'NAMA ISTRI/SUAMI',
            'ANAK 1',
            'ANAK 2',
            'ANAK 3',
            'ANAK 4',
            'ANAK 5'
        ];

        return $headings;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true,'color' => ['rgb' => 'ffffff']], 
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['rgb' => '0a8f76']]
            ],
        ];
    }

}
