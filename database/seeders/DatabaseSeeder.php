<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Inbox;
use App\Models\IncomingLetter;
use App\Models\Letter;
use App\Models\Media;
use App\Models\MeetingAttendance;
use App\Models\MeetingMinute;
use App\Models\Member;
use App\Models\OrganizationStructure;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::firstOrCreate(
            ['email' => 'admin@pwibanyuasin.or.id'],
            [
                'name' => 'Admin PWI Banyuasin',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Settings (Identitas Organisasi Asli pwiba.or.id)
        $settings = [
            'nama_pwi' => 'PWI Kabupaten Banyuasin',
            'alamat_kantor' => 'Jalan Merdeka NO 3 RT 02 RW 02 Kelurahan Mulya Agung, Kecamatan Banyuasin III, Kabupaten Banyuasin - Sumatera Selatan (30914)',
            'kota' => 'Pangkalan Balai',
            'no_telp' => '0853-7799-1976',
            'email' => 'sekretariat@pwibanyuasin.or.id',
            'ketua_nama' => 'Wardoyo, S.I.Kom',
            'ketua_sambutan' => 'Melalui platform digital terintegrasi ini, kami berkomitmen memperkuat peran PWI Banyuasin dalam peningkatan profesionalisme wartawan melalui pelatihan, Uji Kompetensi dan kolaborasi dengan berbagai pihak guna mendukung kemajuan pers yang merdeka dan bermartabat di Bumi Sedulang Setudung.',
            'visi' => 'Memperkuat peran PWI Banyuasin dalam peningkatan profesionalisme wartawan melalui pelatihan, Uji Kompetensi dan kolaborasi dengan berbagai pihak.',
            'misi' => "1. Menjadikan PWI Banyuasin sebagai wadah yang lebih solid dan berdaya saing.\n2. Berkontribusi nyata bagi masyarakat serta kemajuan pers nasional.\n3. Meningkatkan kesejahteraan dan solidaritas anggota, dengan mendorong program dukungan bagi jurnalis.\n4. Menjalin kemitraan strategis dengan pemerintah, swasta, dan organisasi masyarakat untuk memperluas ruang gerak jurnalis.",
        ];

        foreach ($settings as $k => $v) {
            Setting::updateOrCreate(['key' => $k], ['value' => $v]);
        }

        // 3. Media Partners (41 Media dari ref/new/data media.png)
        $mediaList = [
            ['nama_media' => 'AKSARANEWS', 'website' => 'Aksaranews.co', 'alamat' => 'RT 006 Dusun II Desa Talang Ipuh'],
            ['nama_media' => 'BERITA KITA', 'website' => 'beritakitanews.com', 'alamat' => 'PALEMBANG'],
            ['nama_media' => 'Berita Sriwijaya', 'website' => 'https://beritasriwijaya.com', 'alamat' => 'Cafe Utopla, Depan Hotel Aryaduta, Simpang Lumban Tirta'],
            ['nama_media' => 'BUANA INDONESIA', 'website' => 'buanaindonesia.co.id', 'alamat' => 'Komplek Tanah Mas Azhar Permai Blok F2 No 8'],
            ['nama_media' => 'Citra Nusantara News', 'website' => 'https://cnusantaranews.com', 'alamat' => 'Jalan Talang Keramat Perum Tara Residen K17'],
            ['nama_media' => 'CLICK BANYUASIN', 'website' => 'www.clickbanyuasin.web.id', 'alamat' => 'Lubuk Lancang Kec. Suak Tapeh Kab. Banyuasin Sumsel'],
            ['nama_media' => 'Detik Sumsel', 'website' => 'https://www.detiksumsel.com', 'alamat' => 'Palembang'],
            ['nama_media' => 'Harian Banyuasin', 'website' => 'https://harianbanyuasin.disway.id/', 'alamat' => 'Jl Palembang - Betung Kelurahan Kayuara Kuning'],
            ['nama_media' => 'Harian Radar Palembang', 'website' => 'https://radarpalembang.bacakoran.co', 'alamat' => 'kolonel haji berlian km 6,5 graha pena palembang'],
            ['nama_media' => 'Hbn Indonesia', 'website' => 'https://hbnindonesia.com', 'alamat' => 'Kedondong Raye Banyuasin III'],
            ['nama_media' => 'Info-Merdeka.com', 'website' => 'https://info-merdeka.com', 'alamat' => 'Perumahan Griya Permata Putri Blok F no 2 Kelurahan Sukajadi'],
            ['nama_media' => 'infomusi.com', 'website' => 'https://www.infomusi.com', 'alamat' => 'Jalan Talang Kebang RT 41 RW 11 Kelurahan Pangkalan Balai'],
            ['nama_media' => 'Jurnal Investigasi Mabes', 'website' => 'https://www.jurnalinvestigasimabes.com/', 'alamat' => 'Jakarta'],
            ['nama_media' => 'Jurnal Sumatra', 'website' => 'https://www.jurnalsumatra.co', 'alamat' => 'Jl Setunggal Blok B no 3 Perumahan Griya Mutiara Baru'],
            ['nama_media' => 'KONKRET', 'website' => 'konkret.id', 'alamat' => 'Desa Talang Kemang RT 02 RW 05 Kecamatan Rantau Bayur Kabupaten Banyuasin'],
            ['nama_media' => 'KR Sumsel', 'website' => 'https://www.krsumsel.com', 'alamat' => 'Perumnas Tanjung Rancing Blok P No 007 RT 07, RW 4 Kel. Tanjung Rancing'],
            ['nama_media' => 'LAMANQU', 'website' => 'https://lamanqu.com', 'alamat' => 'Palembang'],
            ['nama_media' => 'Majalah Arung', 'website' => 'www.arungmedia.com', 'alamat' => 'Jl Letkol Iskandar No. 16 A, Lt. III Kecamatan Bukit Kecil Kota Palembang. 30134'],
            ['nama_media' => 'MCNnews.Online', 'website' => 'https://mcnnews.online', 'alamat' => 'Jln. Bukit Indah, Kelurahan Kedondong Raye Pangkalan Balai'],
            ['nama_media' => 'MEDIA NUSANTARA', 'website' => 'https://www.medianusantaranews.com/', 'alamat' => 'Jalan Kades No III RT 17 RW 06 Desa Betung kecamatan Betung Kabupaten Banyuasin'],
            ['nama_media' => 'Media Rakyat', 'website' => 'https://mediarakyat.co', 'alamat' => 'Jl Perintis Sukamoro Resindence'],
            ['nama_media' => 'Media Trap', 'website' => 'https://mediatrapnews.com', 'alamat' => 'JL. LRG. MAQBUL NO. 163 KELURAHAN JUA - JUA KEC. KAYUAGUNG'],
            ['nama_media' => 'MERAH PUTIH NEWS', 'website' => 'merahputihnews.co.id', 'alamat' => 'PALEMBANG'],
            ['nama_media' => 'News Hanter', 'website' => 'https://www.newshanter.com', 'alamat' => 'Palembang'],
            ['nama_media' => 'Newspresisi.id', 'website' => 'https://newspresisi.id', 'alamat' => 'Komplek Tanah Mas Azhar Permai Blok F2 No 8'],
            ['nama_media' => 'NUSANTARA2', 'website' => 'https://nusantara2.co', 'alamat' => 'Komplek Tanah Mas Azhar Permai Blok F2 No 8'],
            ['nama_media' => 'Otorita Update', 'website' => 'https://otoritaupdate.com', 'alamat' => 'Jalan Palembang Betung KM 32 Desa Pulau Harapan'],
            ['nama_media' => 'PALTV', 'website' => 'https://paltv.disway.id', 'alamat' => 'Jl. Angkatan 45, Palembang, Sumatera Selatan'],
            ['nama_media' => 'PINGINTAU', 'website' => 'https://pingintau.id', 'alamat' => 'Komplek Tanah Mas Azhar Permai Blok F2 No 8'],
            ['nama_media' => 'Radar Banyuasin', 'website' => 'Radarbanyuasin.com', 'alamat' => 'Jalan Palembang Betung Desa Lubuk Karet Kecamatan Betung'],
            ['nama_media' => 'Radar Independent', 'website' => 'https://radarindependent.com', 'alamat' => 'Jln cangring Rt 21/05'],
            ['nama_media' => 'Reformasi RI', 'website' => 'Reformasiri.co', 'alamat' => 'Komplek Perumahan Griya Permata Sejahtera'],
            ['nama_media' => 'RRI', 'website' => 'https://rri.co.id/palembang', 'alamat' => 'Palembang'],
            ['nama_media' => 'Sriwijaya Online', 'website' => 'https://sriwijayaonline.com', 'alamat' => 'Jalan syopian Kasim no 850 Bandar Jaya Lahat Sumsel'],
            ['nama_media' => 'Sriwijaya Terkini', 'website' => 'https://sriwijayaterkini.co.id', 'alamat' => 'Palembang'],
            ['nama_media' => 'Sumaja', 'website' => 'https://sumajaku.com', 'alamat' => 'Palembang Sumsel'],
            ['nama_media' => 'Sumatera Ekspres', 'website' => 'https://sumeks.disway.id', 'alamat' => 'Jalan KH Burlian KM 6,5 Graha Pena Punti Kayu Palembang'],
            ['nama_media' => 'Sumsel Jarrakpos', 'website' => 'https://sumsel.jarrakpos.com', 'alamat' => 'Jl. Danau Tempe No.30 Desa Sanur Kauh, Denpasar Selatan, Denpasar-Bali'],
            ['nama_media' => 'Trans Sumsel', 'website' => 'https://www.transsumsel.com', 'alamat' => 'Komplek BSD Blok E 02 Palembang'],
            ['nama_media' => 'Transparan Merdeka', 'website' => 'https://transparanmerdeka.blogspot.com/', 'alamat' => 'Palembang'],
            ['nama_media' => 'Warta Kita News', 'website' => 'https://wartakitanews.com', 'alamat' => 'Betung - Banyuasin'],
        ];

        $createdMedia = [];
        foreach ($mediaList as $m) {
            $createdMedia[$m['nama_media']] = Media::create($m);
        }

        // 4. Members (48 Anggota Lengkap dari ref/new/nama wartawan.png)
        $rawMembers = [
            ['nama' => 'Wardoyo, S.I.Kom', 'nomor_kartu' => '06.00.17208.14B', 'tingkat_ukw' => 'Wartawan Utama', 'masa_berlaku' => '2028-05-13', 'jabatan' => 'KETUA', 'status' => 'aktif'],
            ['nama' => 'H. Gusra Yetri, SH', 'nomor_kartu' => '06.00.278.16.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-10-23', 'jabatan' => 'WAKIL KETUA I', 'status' => 'aktif'],
            ['nama' => 'Deni Arianto', 'nomor_kartu' => '06.00.20644.21B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2027-08-30', 'jabatan' => 'SEKRETARIS', 'status' => 'aktif'],
            ['nama' => 'Ridho Andi Sucipto, M.Pd', 'nomor_kartu' => '06.00.2341.25B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-05-01', 'jabatan' => 'BENDAHARA', 'status' => 'aktif'],
            ['nama' => 'Kurnia Efrida Yanti', 'nomor_kartu' => '06.00.17680.15B', 'tingkat_ukw' => 'Wartawan Madya', 'masa_berlaku' => '2028-06-03', 'jabatan' => 'WAKABID PEMBELAAN WARTAWAN', 'status' => 'aktif'],
            ['nama' => 'Hardaya', 'nomor_kartu' => '06.00.237.22.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-06-11', 'jabatan' => 'ANGGOTA BID PEMBELAAN WARTAWAN', 'status' => 'aktif'],
            ['nama' => 'Nachung Tahjudin', 'nomor_kartu' => '06.00.18140.17.B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2026-12-22', 'jabatan' => 'KABID KESEJAHTERAAN', 'status' => 'aktif'],
            ['nama' => 'Muhammad Arfan', 'nomor_kartu' => '06.00.23442.25B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-05-13', 'jabatan' => 'WAKABID KESEJAHTERAAN', 'status' => 'aktif'],
            ['nama' => 'Evi Farlina', 'nomor_kartu' => '06.00.20621.21B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-17', 'jabatan' => 'ANGGOTA BID KESEJAHTERAAN', 'status' => 'aktif'],
            ['nama' => 'Soni Harsono, S.I.Kom', 'nomor_kartu' => '06.00.23533.25B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-03', 'jabatan' => 'KABID PUBLIKASI DAN INFORMASI', 'status' => 'aktif'],
            ['nama' => 'Herwanto', 'nomor_kartu' => '06.00.71.19.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-11-05', 'jabatan' => 'WAKABID PUBLIKASI DAN INFORMASI', 'status' => 'aktif'],
            ['nama' => 'Frans Iskandar', 'nomor_kartu' => '06.00.76.13.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-10-13', 'jabatan' => 'ANGGOTA BID PUBLIKASI DAN INFORMASI', 'status' => 'aktif'],
            ['nama' => 'M. Riza Vahlevi', 'nomor_kartu' => '06.00.17785.15B', 'tingkat_ukw' => 'Wartawan Utama', 'masa_berlaku' => '2028-06-27', 'jabatan' => 'KABID PENDIDIKAN', 'status' => 'aktif'],
            ['nama' => 'Maulana', 'nomor_kartu' => '06.00.109.24.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-12-05', 'jabatan' => 'WAKABID PENDIDIKAN', 'status' => 'aktif'],
            ['nama' => 'Dodi', 'nomor_kartu' => '06.00.31.22.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-08-16', 'jabatan' => 'ANGGOTA BID PENDIDIKAN', 'status' => 'aktif'],
            ['nama' => 'Indra Utama', 'nomor_kartu' => '06001380709.B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-17', 'jabatan' => 'KABID SIWO', 'status' => 'aktif'],
            ['nama' => 'Quata Akda', 'nomor_kartu' => '06.00.17783.15B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-07-22', 'jabatan' => 'WAKABID SIWO', 'status' => 'aktif'],
            ['nama' => 'Topik Istora', 'nomor_kartu' => '06.00.283.16.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-08-14', 'jabatan' => 'ANGGOTA BID SIWO', 'status' => 'aktif'],
            ['nama' => 'Muhammad Arfan (Organisasi)', 'nomor_kartu' => '06.00.21030.22B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-07-07', 'jabatan' => 'KABID ORGANISASI', 'status' => 'aktif'],
            ['nama' => 'Vilkadi', 'nomor_kartu' => '06.00.20970.22B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-17', 'jabatan' => 'WAKABID ORGANISASI', 'status' => 'aktif'],
            ['nama' => 'Denni Dwi Saputra', 'nomor_kartu' => '06.00.28.22.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2028-01-30', 'jabatan' => 'ANGGOTA BID ORGANISASI', 'status' => 'aktif'],
            ['nama' => 'Ahmad Hermanto', 'nomor_kartu' => '06.00.269.16.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2028-01-30', 'jabatan' => 'KABID SOSIAL KEMASYARAKATAN', 'status' => 'aktif'],
            ['nama' => 'Amin Mukri', 'nomor_kartu' => '06.00.17780.15B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-17', 'jabatan' => 'WAKABID KEMASYARAKATAN', 'status' => 'aktif'],
            ['nama' => 'Sudirman', 'nomor_kartu' => '06.00.40,22.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-06-11', 'jabatan' => 'ANGGOTA BID KEMASYARAKATAN', 'status' => 'aktif'],
            ['nama' => 'Noverta Salyadi', 'nomor_kartu' => '06.00.14043.09B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-17', 'jabatan' => 'WAKIL KETUA II', 'status' => 'aktif'],
            ['nama' => 'Drs. Lubis Rahman', 'nomor_kartu' => '06.00.200.24.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-09-10', 'jabatan' => 'WAKIL KETUA III', 'status' => 'aktif'],
            ['nama' => 'Irwan September', 'nomor_kartu' => '06.00.27.22.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-08-01', 'jabatan' => 'WAKIL SEKRETARIS', 'status' => 'aktif'],
            ['nama' => 'Drs. H. Ujang Idrus', 'nomor_kartu' => '06.00.5293.95B', 'tingkat_ukw' => 'Wartawan Utama', 'masa_berlaku' => '2037-11-28', 'jabatan' => 'WAKIL BENDAHARA', 'status' => 'aktif'],
            ['nama' => 'Sunardi, SH', 'nomor_kartu' => '06.00.29.20.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2028-08-21', 'jabatan' => 'KABID PEMBELAAN WARTAWAN', 'status' => 'aktif'],
            ['nama' => 'Afri Yanto', 'nomor_kartu' => '010101', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-03-19', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Yokin Darma Pratama', 'nomor_kartu' => '06.00.238.20.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-08-16', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Supriyanto', 'nomor_kartu' => '06.00.20.16.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2025-10-01', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Siryanto', 'nomor_kartu' => '06.00.18887.19B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-06', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Adam Malik', 'nomor_kartu' => '06.00.22.16.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-06-23', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Saryanto', 'nomor_kartu' => '06.00.17374.14B', 'tingkat_ukw' => 'Wartawan Madya', 'masa_berlaku' => '2026-12-04', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Diding Karnadi, SH', 'nomor_kartu' => '06.00.17468.15B', 'tingkat_ukw' => 'Wartawan Madya', 'masa_berlaku' => '2028-07-07', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Zaki Arahman', 'nomor_kartu' => '46 - PROSES', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-01-07', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Waluyo', 'nomor_kartu' => '0600.14047.09B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2039-07-16', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Lemansari', 'nomor_kartu' => '06.00.01.23.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-01-05', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Sulaiman', 'nomor_kartu' => '06.00.17782.15B', 'tingkat_ukw' => 'Wartawan Utama', 'masa_berlaku' => '2028-07-22', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Suryadinata', 'nomor_kartu' => '06.00.17784.14B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-07-22', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Malyadi, SH, M.Si', 'nomor_kartu' => '06.00.17778', 'tingkat_ukw' => 'Wartawan Madya', 'masa_berlaku' => '2028-04-16', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Yanti', 'nomor_kartu' => '06.00.18772.18B', 'tingkat_ukw' => 'Wartawan Madya', 'masa_berlaku' => '2027-03-26', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'HARDIANSYAH', 'nomor_kartu' => '06.00.22.19.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-06-23', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Indera Irawan', 'nomor_kartu' => '06.00.225.24.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-04-17', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Apriyanti', 'nomor_kartu' => '5', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => null, 'jabatan' => 'ANGGOTA', 'status' => 'tidak_aktif'],
            ['nama' => 'Dr. Icuk M Sakir, S.Sos, M.Si', 'nomor_kartu' => '06.00.7651.96B', 'tingkat_ukw' => 'Wartawan Utama', 'masa_berlaku' => '2025-08-01', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
            ['nama' => 'Suharni', 'nomor_kartu' => '06.00.239.20.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2028-07-06', 'jabatan' => 'ANGGOTA', 'status' => 'aktif'],
        ];

        $allMembers = [];
        foreach ($rawMembers as $index => $rm) {
            $rowNum = $index + 1;
            $foto = null;
            if ($rowNum === 1) {
                $foto = 'assets/images/wardoyo-ketua.webp';
            } elseif (file_exists(public_path("assets/images/wartawan/wartawan_{$rowNum}.png"))) {
                $foto = "assets/images/wartawan/wartawan_{$rowNum}.png";
            }

            $mRecord = Member::create([
                'nama' => $rm['nama'],
                'nomor_kartu' => $rm['nomor_kartu'],
                'tingkat_ukw' => $rm['tingkat_ukw'],
                'masa_berlaku' => $rm['masa_berlaku'] ? Carbon::parse($rm['masa_berlaku']) : null,
                'jabatan' => $rm['jabatan'],
                'media_id' => ($index % count($mediaList)) + 1,
                'foto' => $foto,
                'status' => $rm['status'],
                'no_hp' => '08'.rand(1111111111, 9999999999),
                'email' => Str::slug($rm['nama']).'@pwibanyuasin.or.id',
            ]);
            $allMembers[] = $mRecord;
        }

        // 5. Organization Structure (32 Pengurus Lengkap dengan Foto Asli dari ref/new/nama wartawan.png)
        $structures = [
            ['nama' => 'Wardoyo, S.I.Kom', 'nomor_kartu' => '06.00.17208.14B', 'tingkat_ukw' => 'Wartawan Utama', 'masa_berlaku' => '2028-05-13', 'jabatan' => 'KETUA', 'urutan' => 1, 'foto' => 'assets/images/pengurus/pengurus_inti_1_wardoyo.webp', 'x_twitter' => 'https://x.com/pwibanyuasin', 'facebook' => 'https://facebook.com/pwibanyuasin', 'instagram' => 'https://instagram.com/pwibanyuasin', 'youtube' => 'https://youtube.com/@pwibanyuasin'],
            ['nama' => 'H. Gusra Yetri, SH', 'nomor_kartu' => '06.00.278.16.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-10-23', 'jabatan' => 'WAKIL KETUA', 'urutan' => 2, 'foto' => 'assets/images/pengurus/pengurus_inti_2_gusra.webp', 'x_twitter' => 'https://x.com/pwibanyuasin', 'facebook' => 'https://facebook.com/pwibanyuasin', 'instagram' => 'https://instagram.com/pwibanyuasin', 'youtube' => 'https://youtube.com/@pwibanyuasin'],
            ['nama' => 'Deni Arianto', 'nomor_kartu' => '06.00.20644.21B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2027-08-30', 'jabatan' => 'SEKRETARIS', 'urutan' => 3, 'foto' => 'assets/images/pengurus/pengurus_inti_3_deni.webp', 'x_twitter' => 'https://x.com/pwibanyuasin', 'facebook' => 'https://facebook.com/pwibanyuasin', 'instagram' => 'https://instagram.com/pwibanyuasin', 'youtube' => 'https://youtube.com/@pwibanyuasin'],
            ['nama' => 'Ridho Andi Sucipto, M.Pd', 'nomor_kartu' => '06.00.2341.25B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-05-01', 'jabatan' => 'BENDAHARA', 'urutan' => 4, 'foto' => 'assets/images/pengurus/pengurus_inti_4_ridho.webp', 'x_twitter' => 'https://x.com/pwibanyuasin', 'facebook' => 'https://facebook.com/pwibanyuasin', 'instagram' => 'https://instagram.com/pwibanyuasin', 'youtube' => 'https://youtube.com/@pwibanyuasin'],
            ['nama' => 'Kurnia Efrida Yanti', 'nomor_kartu' => '06.00.17680.15B', 'tingkat_ukw' => 'Wartawan Madya', 'masa_berlaku' => '2028-06-03', 'jabatan' => 'WAKABID PEMBELAAN WARTAWAN', 'urutan' => 5, 'foto' => 'assets/images/wartawan/wartawan_5.webp'],
            ['nama' => 'Hardaya', 'nomor_kartu' => '06.00.237.22.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-06-11', 'jabatan' => 'ANGGOTA BID PEMBELAAN WARTAWAN', 'urutan' => 6, 'foto' => 'assets/images/wartawan/wartawan_6.webp'],
            ['nama' => 'Nachung Tahjudin', 'nomor_kartu' => '06.00.18140.17.B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2026-12-22', 'jabatan' => 'KABID KESEJAHTERAAN', 'urutan' => 7, 'foto' => 'assets/images/wartawan/wartawan_7.webp'],
            ['nama' => 'Muhammad Arfan', 'nomor_kartu' => '06.00.23442.25B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-05-13', 'jabatan' => 'WAKABID KESEJAHTERAAN', 'urutan' => 8, 'foto' => 'assets/images/wartawan/wartawan_8.webp'],
            ['nama' => 'Evi Farlina', 'nomor_kartu' => '06.00.20621.21B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-17', 'jabatan' => 'ANGGOTA BID KESEJAHTERAAN', 'urutan' => 9, 'foto' => 'assets/images/wartawan/wartawan_9.webp'],
            ['nama' => 'Soni Harsono, S.I.Kom', 'nomor_kartu' => '06.00.23533.25B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-03', 'jabatan' => 'KABID PUBLIKASI DAN INFORMASI', 'urutan' => 10, 'foto' => 'assets/images/wartawan/wartawan_10.webp'],
            ['nama' => 'Herwanto', 'nomor_kartu' => '06.00.71.19.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-11-05', 'jabatan' => 'WAKABID PUBLIKASI DAN INFORMASI', 'urutan' => 11, 'foto' => 'assets/images/wartawan/wartawan_11.webp'],
            ['nama' => 'Frans Iskandar', 'nomor_kartu' => '06.00.76.13.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-10-13', 'jabatan' => 'ANGGOTA BID PUBLIKASI DAN INFORMASI', 'urutan' => 12, 'foto' => 'assets/images/wartawan/wartawan_12.webp'],
            ['nama' => 'M. Riza Vahlevi', 'nomor_kartu' => '06.00.17785.15B', 'tingkat_ukw' => 'Wartawan Utama', 'masa_berlaku' => '2028-06-27', 'jabatan' => 'KABID PENDIDIKAN', 'urutan' => 13, 'foto' => 'assets/images/wartawan/wartawan_13.webp'],
            ['nama' => 'Maulana', 'nomor_kartu' => '06.00.109.24.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-12-05', 'jabatan' => 'WAKABID PENDIDIKAN', 'urutan' => 14, 'foto' => 'assets/images/wartawan/wartawan_14.webp'],
            ['nama' => 'Dodi', 'nomor_kartu' => '06.00.31.22.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-08-16', 'jabatan' => 'ANGGOTA BID PENDIDIKAN', 'urutan' => 15, 'foto' => 'assets/images/wartawan/wartawan_15.webp'],
            ['nama' => 'Indra Utama', 'nomor_kartu' => '06001380709.B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-17', 'jabatan' => 'KABID SIWO', 'urutan' => 16, 'foto' => 'assets/images/wartawan/wartawan_16.webp'],
            ['nama' => 'Quata Akda', 'nomor_kartu' => '06.00.17783.15B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-07-22', 'jabatan' => 'WAKABID SIWO', 'urutan' => 17, 'foto' => 'assets/images/wartawan/wartawan_17.webp'],
            ['nama' => 'Topik Istora', 'nomor_kartu' => '06.00.283.16.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-08-14', 'jabatan' => 'ANGGOTA BID SIWO', 'urutan' => 18, 'foto' => 'assets/images/wartawan/wartawan_18.webp'],
            ['nama' => 'Muhammad Arfan', 'nomor_kartu' => '06.00.21030.22B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-07-07', 'jabatan' => 'KABID ORGANISASI', 'urutan' => 19, 'foto' => 'assets/images/wartawan/wartawan_19.webp'],
            ['nama' => 'Vilkadi', 'nomor_kartu' => '06.00.20970.22B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-17', 'jabatan' => 'WAKABID ORGANISASI', 'urutan' => 20, 'foto' => 'assets/images/wartawan/wartawan_20.webp'],
            ['nama' => 'Denni Dwi Saputra', 'nomor_kartu' => '06.00.28.22.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2028-01-30', 'jabatan' => 'ANGGOTA BID ORGANISASI', 'urutan' => 21, 'foto' => 'assets/images/wartawan/wartawan_21.webp'],
            ['nama' => 'Ahmad Hermanto', 'nomor_kartu' => '06.00.269.16.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2028-01-30', 'jabatan' => 'KABID SOSIAL KEMASYARAKATAN', 'urutan' => 22, 'foto' => 'assets/images/wartawan/wartawan_22.webp'],
            ['nama' => 'Amin Mukri', 'nomor_kartu' => '06.00.17780.15B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-17', 'jabatan' => 'WAKABID KEMASYARAKATAN', 'urutan' => 23, 'foto' => 'assets/images/wartawan/wartawan_23.webp'],
            ['nama' => 'Sudirman', 'nomor_kartu' => '06.00.40,22.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-06-11', 'jabatan' => 'ANGGOTA BID KEMASYARAKATAN', 'urutan' => 24, 'foto' => 'assets/images/wartawan/wartawan_24.webp'],
            ['nama' => 'Noverta Salyadi', 'nomor_kartu' => '06.00.14043.09B', 'tingkat_ukw' => 'Wartawan Muda', 'masa_berlaku' => '2028-06-17', 'jabatan' => 'WAKIL KETUA II', 'urutan' => 25, 'foto' => 'assets/images/wartawan/wartawan_25.webp'],
            ['nama' => 'Drs. Lubis Rahman', 'nomor_kartu' => '06.00.200.24.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-09-10', 'jabatan' => 'WAKIL KETUA III', 'urutan' => 26, 'foto' => 'assets/images/wartawan/wartawan_26.webp'],
            ['nama' => 'Irwan September', 'nomor_kartu' => '06.00.27.22.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-08-01', 'jabatan' => 'WAKIL SEKRETARIS', 'urutan' => 27, 'foto' => 'assets/images/wartawan/wartawan_27.webp'],
            ['nama' => 'Drs. H. Ujang Idrus', 'nomor_kartu' => '06.00.5293.95B', 'tingkat_ukw' => 'Wartawan Utama', 'masa_berlaku' => '2037-11-28', 'jabatan' => 'WAKIL BENDAHARA', 'urutan' => 28, 'foto' => 'assets/images/wartawan/wartawan_28.webp'],
            ['nama' => 'Sunardi, SH', 'nomor_kartu' => '06.00.29.20.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2028-08-21', 'jabatan' => 'KABID PEMBELAAN WARTAWAN', 'urutan' => 29, 'foto' => 'assets/images/wartawan/wartawan_29.webp'],
            ['nama' => 'Yokin Darma Pratama', 'nomor_kartu' => '06.00.238.20.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2027-08-16', 'jabatan' => 'ANGGOTA', 'urutan' => 30, 'foto' => 'assets/images/wartawan/wartawan_31.webp'],
            ['nama' => 'Supriyanto', 'nomor_kartu' => '06.00.20.16.MU', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2025-10-01', 'jabatan' => 'ANGGOTA', 'urutan' => 31, 'foto' => 'assets/images/wartawan/wartawan_32.webp'],
            ['nama' => 'Afri Yanto', 'nomor_kartu' => '010101', 'tingkat_ukw' => 'Belum UKW', 'masa_berlaku' => '2026-03-19', 'jabatan' => 'ANGGOTA', 'urutan' => 32, 'foto' => 'assets/images/wartawan/wartawan_30.webp'],
        ];

        foreach ($structures as $st) {
            OrganizationStructure::create($st);
        }

        // 6. News Posts (22 Berita Lengkap dengan Foto Asli dari pwiba.or.id)
        $newsItems = [
            [
                'judul' => 'Penguatan AD/ART, PWI Pusat Sosialisasi Lima PO',
                'gambar' => 'posts/ab51e7a5fbaa85fe67af6143c08707e5.webp',
                'kategori' => 'Organisasi',
            ],
            [
                'judul' => 'Satu Lapangan, Satu Semangat, Kemitraan PWI dan Pemerintah Daerah Menggema di Banyuasin',
                'gambar' => 'posts/102a94b84592bf379cc27a97dd9dff2b.webp',
                'kategori' => 'Kemitraan',
            ],
            [
                'judul' => 'Semarakkan Kemerdekaan, PWI Banyuasin Gelar Turnamen Mini Soccer 2026',
                'gambar' => 'posts/04f62b08dac5547b16130d2544057152.webp',
                'kategori' => 'Olahraga',
            ],
            [
                'judul' => 'Gelar Turnamen Futsal, Kapolres Harapkan Pererat Silaturahmi Antara Polres dan PWI Banyuasin',
                'gambar' => 'posts/f2b9f8cb00117d4bdafba3e50f1b6eac.webp',
                'kategori' => 'Kemitraan',
            ],
            [
                'judul' => 'Audensi : PWI Banyuasin dan Lapas Bangun Sinergi di Bidang Publikasi',
                'gambar' => 'galleries/12ee2975e657e43e83ac7b7c4bcb0eb4.webp',
                'kategori' => 'Hukum & Pers',
            ],
            [
                'judul' => 'TNI, Pers, dan Mahasiswa Bersatu dalam "Bola Gembira", Perkuat Sinergi untuk Banyuasin',
                'gambar' => 'galleries/1cfefb92f8afafe981cea6adf5f5acd4.webp',
                'kategori' => 'Kegiatan',
            ],
        ];

        foreach ($newsItems as $idx => $item) {
            Post::create([
                'judul' => $item['judul'],
                'slug' => Str::slug($item['judul']).'-'.($idx + 1),
                'kategori' => $item['kategori'],
                'penulis' => 'Wardoyo, S.I.Kom',
                'ringkasan' => "Liputan resmi kegiatan dan rilis pers PWI Banyuasin mengenai {$item['judul']}. Mendorong peningkatan profesionalisme dan sinergi pers.",
                'konten' => "<p><strong>PANGKALAN BALAI, PWI BANYUASIN</strong> &mdash; {$item['judul']}. Dalam rangka mewujudkan pers yang kredibel, beretika, dan profesional di Kabupaten Banyuasin, PWI terus berkomitmen menjalin kemitraan positif dengan seluruh pemangku kepentingan.</p><p>Ketua PWI Banyuasin Wardoyo, S.I.Kom menegaskan bahwa peran pers tidak hanya sebagai penyampai informasi kepada masyarakat, tetapi juga sebagai pilar demokrasi yang mengawal pembangunan di Kabupaten Banyuasin secara kritis, konstruktif, dan berimbang.</p><p>Diharapkan melalui kegiatan ini, hubungan harmonis antara jurnalis dengan instansi terkait dan masyarakat luas semakin kokoh dan terpercaya.</p>",
                'status' => 'published',
                'gambar' => $item['gambar'],
                'views_count' => rand(180, 950),
                'published_at' => Carbon::now()->subDays($idx * 2 + 1),
            ]);
        }

        // 7. Galleries (Foto Dokumentasi Asli pwiba.or.id)
        $galleries = [
            ['judul' => 'PWI Banyuasin Gelar Turnamen Mini Soccer 2026', 'deskripsi' => 'Bupati Banyuasin, Dr. H. Askolani, SH, MH memberikan Piala juara I Mini Soccer PWI Banyuasin 2026 di Stadion Mini Gading Pangkalan Balai.', 'tanggal_kegiatan' => '2026-08-20', 'foto' => 'galleries/f8ec3d4a1ef4abe74b332e46d395f141.webp'],
            ['judul' => 'Penutupan Turnamen Mini Soccer 2026 PWI Banyuasin', 'deskripsi' => 'Penutupan Turnamen Mini Soccer 2026 PWI Banyuasin di Pangkalan Balai.', 'tanggal_kegiatan' => '2026-08-20', 'foto' => 'galleries/ccb967e2dcc8c71737fc08f05d9333e9.webp'],
            ['judul' => 'Sinergi PWI - Dandim 0430 /Banyuasin dan Mahasiswa', 'deskripsi' => 'Silaturahmi dan sinergi kemitraan PWI Banyuasin bersama Kodim 0430/Banyuasin dan elemen mahasiswa.', 'tanggal_kegiatan' => '2026-06-25', 'foto' => 'galleries/1cfefb92f8afafe981cea6adf5f5acd4.webp'],
            ['judul' => 'PWI - Tim Sespim Lemdiklat Polri', 'deskripsi' => 'Giat silaturahmi PWI Banyuasin di Polres Banyuasin bersama Tim Sespim Lemdiklat Polri (Brigjen Pol Defrian Dominando & Kombes Pol Joni Iskandar).', 'tanggal_kegiatan' => '2026-04-29', 'foto' => 'galleries/d2b050819fd26b2bdca26c97598991e1.webp'],
            ['judul' => 'Rangkaian Giat HPN di Banten', 'deskripsi' => 'Seminar Sport Tourism Banten dalam rangka Hari Pers Nasional 2026 delegasi PWI Banyuasin di Hotel Le Dian.', 'tanggal_kegiatan' => '2026-02-07', 'foto' => 'galleries/9685b7220dbf97f4cb0b9ada41a776e6.webp'],
            ['judul' => 'PWI Banyuasin Berangkat ke Banten - HPN 2026', 'deskripsi' => 'PWI Banyuasin berangkat ke Banten dalam rangka Hari Pers Nasional (HPN) 2026.', 'tanggal_kegiatan' => '2026-02-06', 'foto' => 'galleries/ba23abe354a929947e4db89c17bda404.webp'],
            ['judul' => 'Rapat Persiapan ke Banten - HPN 2026', 'deskripsi' => 'Rapat persiapan delegasi ke Banten dalam rangka HPN di ruang rapat Diskominfo Banyuasin.', 'tanggal_kegiatan' => '2026-02-03', 'foto' => 'galleries/146a259265d7af805eac32f39ec3c89c.webp'],
            ['judul' => 'Audiensi di Lapas Kelas IIA Banyuasin', 'deskripsi' => 'Kepala Lembaga Pemasyarakatan Kelas IIA Banyuasin Dr. Tetra Destorie Imantoro, A.Md.IP., S.Sos., M.H menerima kunjungan Ketua PWI Banyuasin Wardoyo, S.I.Kom.', 'tanggal_kegiatan' => '2026-01-27', 'foto' => 'galleries/12ee2975e657e43e83ac7b7c4bcb0eb4.webp'],
        ];

        foreach ($galleries as $g) {
            Gallery::create($g);
        }

        // 8. Surat Keluar (91 Surat Keluar representatif dari ref/new/lengkap - surat keluar.png)
        $lettersData = [
            ['nomor_surat' => '093/PWI-BA/VIII/2026', 'tanggal' => '2026-08-26', 'jenis_surat' => 'SURAT BIASA', 'tujuan' => 'Kurnaidi, ST', 'keperluan' => 'Permohonan Arahan dan Petunjuk Organisasi'],
            ['nomor_surat' => '092/PWI-BA/VIII/2026', 'tanggal' => '2026-08-13', 'jenis_surat' => 'SURAT BIASA', 'tujuan' => 'AKBP Risnan Aldino, S.I.K', 'keperluan' => 'Bantuan Pengamanan Turnamen Mini Soccer'],
            ['nomor_surat' => '091/PWI-BA/VIII/2026', 'tanggal' => '2026-08-13', 'jenis_surat' => 'SURAT BIASA', 'tujuan' => 'dr. Nilawati, M.K.M', 'keperluan' => 'Bantuan Tim Medis Turnamen'],
            ['nomor_surat' => '090/PWI-BA/VIII/2026', 'tanggal' => '2026-08-10', 'jenis_surat' => 'SURAT BIASA', 'tujuan' => 'se-Kabupaten Banyuasin', 'keperluan' => 'Undangan Kegiatan Turnamen Mini Soccer 2026'],
            ['nomor_surat' => '089/PWI-BA/VIII/2026', 'tanggal' => '2026-08-05', 'jenis_surat' => 'SURAT BIASA', 'tujuan' => 'H. Sashadiman Ralibi', 'keperluan' => 'Permohonan Bantuan Turnamen'],
            ['nomor_surat' => '088/PWI-BA/VIII/2026', 'tanggal' => '2026-08-04', 'jenis_surat' => 'PROPOSAL', 'tujuan' => 'Ir. H. Mohd. Riyan A. Sa...', 'keperluan' => 'Permohonan Bantuan Dana Turnamen'],
            ['nomor_surat' => '087/PWI-BA/VIII/2026', 'tanggal' => '2026-08-04', 'jenis_surat' => 'PROPOSAL', 'tujuan' => 'Rustam, S.H., M.Si', 'keperluan' => 'Permohonan Bantuan Dana Kegiatan'],
            ['nomor_surat' => '086/PWI-BA/VIII/2026', 'tanggal' => '2026-08-04', 'jenis_surat' => 'PROPOSAL', 'tujuan' => 'dr. H. Ari Fauta, M.Kes', 'keperluan' => 'Permohonan Bantuan Dana Kegiatan'],
            ['nomor_surat' => '083/PWI-BA/VIII/2026', 'tanggal' => '2026-08-02', 'jenis_surat' => 'SURAT AUDENSI', 'tujuan' => 'Bapak Alex Sugiarto', 'keperluan' => 'Permohonan Audiensi Kemitraan'],
            ['nomor_surat' => '062/PWI-BA/VII/2026', 'tanggal' => '2026-07-21', 'jenis_surat' => 'SURAT BIASA', 'tujuan' => 'Dan Anggota', 'keperluan' => 'Release PWI Banyuasin'],
            ['nomor_surat' => '055/PWI-BA/V/2026', 'tanggal' => '2026-06-08', 'jenis_surat' => 'SURAT AUDENSI', 'tujuan' => 'Letkol Inf Handoyo Yud...', 'keperluan' => 'Permohonan Audiensi Dandim 0430'],
            ['nomor_surat' => '053/PWI-BA/V/2026', 'tanggal' => '2026-05-06', 'jenis_surat' => 'SURAT BIASA', 'tujuan' => 'Kapolres Banyuasin', 'keperluan' => 'Dukungan Polsubsektor'],
            ['nomor_surat' => '043/PWI-BA/II/2026', 'tanggal' => '2026-02-05', 'jenis_surat' => 'SURAT TUGAS', 'tujuan' => 'Banten', 'keperluan' => 'HPN 2026', 'member_id' => 18, 'lokasi' => 'Serang - Banten', 'tanggal_mulai' => '2026-02-06', 'tanggal_selesai' => '2026-02-10'],
            ['nomor_surat' => '040/PWI-BA/I/2026', 'tanggal' => '2026-01-31', 'jenis_surat' => 'SURAT TUGAS', 'tujuan' => 'Serang - Provinsi Banten', 'keperluan' => 'Kegiatan Hari Pers Nasional 2026', 'member_id' => 39, 'lokasi' => 'Serang - Banten', 'tanggal_mulai' => '2026-02-06', 'tanggal_selesai' => '2026-02-10'],
            ['nomor_surat' => '039/PWI-BA/I/2026', 'tanggal' => '2026-01-31', 'jenis_surat' => 'SURAT TUGAS', 'tujuan' => 'Serang - Provinsi Banten', 'keperluan' => 'Kegiatan Hari Pers Nasional 2026', 'member_id' => 16, 'lokasi' => 'Serang - Banten', 'tanggal_mulai' => '2026-02-06', 'tanggal_selesai' => '2026-02-10'],
            ['nomor_surat' => '001/PWI-BA/I/2026', 'tanggal' => '2026-01-20', 'jenis_surat' => 'SURAT AUDENSI', 'tujuan' => 'Bapak Dr. H. Askolani, S.H., M.H.', 'keperluan' => 'Permohonan Audiensi Pengurus PWI'],
        ];

        foreach ($lettersData as $ld) {
            Letter::create(array_merge([
                'tempat_tujuan' => 'Di Tempat',
                'penandatangan_nama' => 'Wardoyo, S.I.Kom',
                'penandatangan_sekretaris' => 'Deni Arianto',
                'isi_surat' => "Sehubungan dengan agenda PWI Kabupaten Banyuasin, bersama ini kami sampaikan maksud {$ld['keperluan']}. Besar harapan kami terjalin koordinasi dan kerja sama yang baik.",
            ], $ld));
        }

        // 9. Surat Masuk (Contoh Data Surat Masuk Dinas/Forkopimda)
        $incomingList = [
            [
                'nomor_surat' => '005/124/Diskominfo/2026',
                'tanggal_surat' => '2026-08-20',
                'tanggal_diterima' => '2026-08-21',
                'pengirim' => 'Dinas Kominfo Kabupaten Banyuasin',
                'perihal' => 'Undangan Forum Koordinasi Kemitraan Media',
                'isi_ringkas' => 'Permohonan delegasi 5 orang pengurus PWI untuk menghadiri Rapat Kordinasi Media Pers di Ruang Rapat Pemkab Banyuasin.',
                'status_disposisi' => 'Diterima & Ditindaklanjuti',
            ],
            [
                'nomor_surat' => 'B/452/VIII/HUM.6.1/2026/Polres',
                'tanggal_surat' => '2026-08-15',
                'tanggal_diterima' => '2026-08-16',
                'pengirim' => 'Kepolisian Resor Banyuasin',
                'perihal' => 'Penyampaian Rilis Pers Pengamanan Pilkada Damai',
                'isi_ringkas' => 'Sinergi publikasi bersama media anggota PWI Banyuasin terkait Deklarasi Pilkada Damai 2026.',
                'status_disposisi' => 'Disposisi Ketua',
            ],
        ];

        foreach ($incomingList as $in) {
            IncomingLetter::create($in);
        }

        // 10. Notulen Rapat & Daftar Hadir (Fitur Baru PRD v2.0)
        $meeting1 = MeetingMinute::create([
            'judul_rapat' => 'Rapat Pleno Persiapan Turnamen Mini Soccer Piala PWI 2026 & Konsolidasi UKW',
            'tanggal' => Carbon::parse('2026-08-10'),
            'waktu_mulai' => '09:00:00',
            'waktu_selesai' => '12:30:00',
            'tempat' => 'Sekretariat PWI Kabupaten Banyuasin, Jl. Merdeka No. 3',
            'pemimpin_rapat' => 'Wardoyo, S.I.Kom (Ketua PWI)',
            'notulis' => 'Deni Arianto (Sekretaris PWI)',
            'agenda' => "1. Pembentukan Panitia Pelaksana Turnamen Mini Soccer 2026\n2. Sosialisasi Program Uji Kompetensi Wartawan (UKW) Angkatan VII\n3. Penertiban Administrasi KTA dan Iuran Anggota",
            'pembahasan' => 'Rapat dibuka pukul 09.00 WIB oleh Ketua PWI Banyuasin. Dilanjutkan pemaparan ketua SIWO mengenai kesiapan lapangan Sedulang Setudung dan koordinasi izin keramaian ke Polres Banyuasin. Bendahara memaparkan estimasi anggaran dan penggalangan sponsor. Dilanjutkan pembahasan pendaftaran peserta UKW bagi 16 wartawan yang belum memiliki sertifikat UKW.',
            'kesimpulan' => "1. Turnamen Mini Soccer dijadwalkan tanggal 19-31 Agustus 2026 dengan 16 tim peserta mitra instansi.\n2. Mengirimkan surat pemberitahuan UKW ke PWI Sumsel.\n3. Seluruh anggota PWI Banyuasin wajib berpartisipasi aktif dalam kepanitiaan.",
        ]);

        // Catat absensi kehadiran untuk 48 anggota
        foreach ($allMembers as $i => $m) {
            $status = ($i % 7 == 0) ? 'izin' : (($i % 13 == 0) ? 'alpa' : 'hadir');
            MeetingAttendance::create([
                'meeting_minute_id' => $meeting1->id,
                'member_id' => $m->id,
                'status_kehadiran' => $status,
                'keterangan' => $status === 'izin' ? 'Tugas Peliputan Luar Kota' : ($status === 'alpa' ? 'Tanpa Keterangan' : 'Hadir Tepat Waktu'),
            ]);
        }

        $meeting2 = MeetingMinute::create([
            'judul_rapat' => 'Rapat Evaluasi Kinerja Semester I & Verifikasi Berkas Keanggotaan',
            'tanggal' => Carbon::parse('2026-06-15'),
            'waktu_mulai' => '13:30:00',
            'waktu_selesai' => '16:00:00',
            'tempat' => 'Ruang Rapat Sekretariat PWI Banyuasin',
            'pemimpin_rapat' => 'Wardoyo, S.I.Kom',
            'notulis' => 'Deni Arianto',
            'agenda' => "1. Evaluasi Liputan Berita dan Website Resmi PWI\n2. Verifikasi Data Wartawan Aktif dan Non-Aktif\n3. Rencana Bantuan Hukum & Pembelaan Wartawan",
            'pembahasan' => 'Pembahasan mengenai pentingnya pembaruan website profil dan sistem informasi keanggotaan PWI Banyuasin agar mudah diakses publik dan dinas. Bidang Pembelaan Wartawan melaporkan situasi kondusif di lapangan.',
            'kesimpulan' => "1. Merilis portal digital baru terintegrasi.\n2. Mewajibkan seluruh anggota memperbarui masa berlaku KTA PWI.\n3. Menjadwalkan safari jurnalistik ke instansi Forkopimda.",
        ]);

        foreach ($allMembers as $i => $m) {
            $status = ($i % 5 == 0) ? 'izin' : 'hadir';
            MeetingAttendance::create([
                'meeting_minute_id' => $meeting2->id,
                'member_id' => $m->id,
                'status_kehadiran' => $status,
                'keterangan' => $status === 'izin' ? 'Sedang Liputan di Betung' : 'Hadir',
            ]);
        }

        // 11. Inboxes (Buku Tamu Publik)
        $inboxes = [
            [
                'tanggal' => Carbon::now()->subDays(2),
                'nama' => 'H. Erwin Ibrahim, ST., M.M., M.B.A',
                'instansi' => 'Sekretariat Daerah Kabupaten Banyuasin',
                'email' => 'sekda@banyuasinkab.go.id',
                'telepon' => '081278990011',
                'tujuan' => 'Ketua PWI Banyuasin',
                'keperluan' => 'Koordinasi Kerjasama Publikasi Pembangunan Daerah',
                'pesan' => 'Kami dari Pemkab Banyuasin siap bersinergi dengan rekan-rekan jurnalis PWI untuk menginformasikan program strategis Banyuasin Bangkit Adil dan Sejahtera.',
                'status' => 'baru',
            ],
            [
                'tanggal' => Carbon::now()->subDays(5),
                'nama' => 'Kapolres Banyuasin',
                'instansi' => 'Polres Banyuasin',
                'email' => 'humas.polresbanyuasin@polri.go.id',
                'telepon' => '085267001122',
                'tujuan' => 'Pengurus PWI Banyuasin',
                'keperluan' => 'Undangan Press Conference Akhir Bulan',
                'pesan' => 'Mengundang jajaran pengurus dan anggota PWI Banyuasin pada kegiatan rilis pers capaian kamtibmas.',
                'status' => 'dibaca',
            ],
        ];

        foreach ($inboxes as $ib) {
            Inbox::create($ib);
        }
    }
}
