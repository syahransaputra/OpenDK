<?php

/*
 * File ini bagian dari:
 *
 * OpenDK
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2017 - 2023 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package    OpenDK
 * @author     Tim Pengembang OpenDesa
 * @copyright  Hak Cipta 2017 - 2023 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license    http://www.gnu.org/licenses/gpl.html    GPL V3
 * @link       https://github.com/OpenSID/opendk
 */

namespace App\Imports;

use App\Models\Pembangunan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SinkronPembangunan implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    use Importable;

    /**
     * {@inheritdoc}
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $value) {
            $insert = [
                "desa_id"                 => $value['desa_id'],
                "id"                      => $value['id'],
                "sumber_dana"             => $value['sumber_dana'],
                "lokasi"                  => $value['lokasi'],
                "keterangan"              => $value['keterangan'],
                "judul"                   => $value['judul'],
                "volume"                  => $value['volume'],
                "tahun_anggaran"          => $value['tahun_anggaran'],
                "pelaksana_kegiatan"      => $value['pelaksana_kegiatan'],
                "status"                  => $value['status'],
                "anggaran"                => $value['anggaran'],
                "perubahan_anggaran"      => $value['perubahan_anggaran'],
                "sumber_biaya_pemerintah" => $value['sumber_biaya_pemerintah'],
                "sumber_biaya_provinsi"   => $value['sumber_biaya_provinsi'],
                "sumber_biaya_kab_kota"   => $value['sumber_biaya_kab_kota'],
                "sumber_biaya_swadaya"    => $value['sumber_biaya_swadaya'],
                "sumber_biaya_jumlah"     => $value['sumber_biaya_jumlah'],
                "manfaat"                 => $value['manfaat'],
                "waktu"                   => $value['waktu'],
                "foto"                    => $value['foto'],
            ];

            Pembangunan::updateOrCreate([
                'desa_id' => $insert['desa_id'],
                'id'      => $insert['id']
            ], $insert);
        }
    }
}
