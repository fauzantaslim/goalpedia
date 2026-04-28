@extends('layouts.app')

@section('content')

    <x-breadcrumbs :links="[
        ['label' => 'Pedoman Media Siber'],
    ]" />

    <article class="mx-auto w-full max-w-4xl pb-20">

        {{-- ═══ HEADER ══════════════════════════════ --}}
        <header class="relative mb-14 overflow-hidden border-b-8 border-[var(--color-text-primary)] pb-10 pt-12">
            <div class="pointer-events-none absolute right-0 top-0 flex h-full items-end gap-2 opacity-[0.04]" aria-hidden="true">
                <div class="h-full w-12 -skew-x-6 bg-[var(--color-accent-secondary)]"></div>
                <div class="h-3/4 w-8 -skew-x-6 bg-[var(--color-accent-primary)]"></div>
            </div>
            
            <div class="mb-4 flex items-center gap-4">
                <div class="h-5 w-5 rotate-45 bg-[var(--color-accent-secondary)]"></div>
                <p class="text-[10px] font-black uppercase tracking-[0.35em] text-[var(--color-accent-secondary)]">Regulasi & Kebijakan</p>
            </div>
            
            <h1 class="text-5xl font-black uppercase leading-[0.9] tracking-tighter text-[var(--color-text-primary)] md:text-7xl lg:text-[80px]">
                Pedoman<br><span class="text-[var(--color-accent-primary)]">Media Siber.</span>
            </h1>
        </header>

        {{-- ═══ CONTENT ══════════════════════════════ --}}
        <div class="prose max-w-none text-justify font-medium leading-relaxed text-[var(--color-text-secondary)]
                    prose-h2:mt-10 prose-h2:border-b-2 prose-h2:border-[var(--color-text-primary)] prose-h2:pb-2 prose-h2:text-2xl prose-h2:font-black prose-h2:uppercase prose-h2:tracking-tight prose-h2:text-[var(--color-text-primary)]
                    prose-h3:mt-8 prose-h3:text-lg prose-h3:font-black prose-h3:uppercase prose-h3:text-[var(--color-text-primary)]
                    prose-p:mb-5 prose-p:text-base
                    prose-ol:mb-5 prose-ol:list-decimal prose-ol:pl-6 prose-ol:font-medium
                    prose-ul:mb-5 prose-ul:list-disc prose-ul:pl-6 prose-ul:font-medium
                    prose-li:mb-2 prose-li:pl-2
                    md:prose-p:text-lg">
            
            <p>
                Kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers adalah hak asasi manusia yang dilindungi Pancasila, Undang-Undang Dasar 1945, dan Deklarasi Universal Hak Asasi Manusia PBB. Keberadaan media siber di Indonesia juga merupakan bagian dari kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers.
            </p>
            <p>
                Media siber memiliki karakter khusus sehingga memerlukan pedoman agar pengelolaannya dapat dilaksanakan secara profesional, memenuhi fungsi, hak, dan kewajibannya sesuai Undang-Undang Nomor 40 Tahun 1999 tentang Pers dan Kode Etik Jurnalistik. Untuk itu Dewan Pers bersama organisasi pers, pengelola media siber, dan masyarakat menyusun Pedoman Pemberitaan Media Siber sebagai berikut:
            </p>

            <h2>1. Ruang Lingkup</h2>
            <ol class="list-[lower-alpha]">
                <li>Media Siber adalah segala bentuk media yang menggunakan wahana internet dan melaksanakan kegiatan jurnalistik, serta memenuhi persyaratan Undang-Undang Pers dan Standar Perusahaan Pers yang ditetapkan Dewan Pers.</li>
                <li>Isi Buatan Pengguna (User Generated Content) adalah segala isi yang dibuat dan atau dipublikasikan oleh pengguna media siber, antara lain, artikel, gambar, komentar, suara, video dan berbagai bentuk unggahan yang melekat pada media siber, seperti blog, forum, komentar pembaca atau pemirsa, dan bentuk lain.</li>
            </ol>

            <h2>2. Verifikasi dan keberimbangan berita</h2>
            <ol class="list-[lower-alpha]">
                <li>Pada prinsipnya setiap berita harus melalui verifikasi.</li>
                <li>Berita yang dapat merugikan pihak lain memerlukan verifikasi pada berita yang sama untuk memenuhi prinsip akurasi dan keberimbangan.</li>
                <li>Ketentuan dalam butir (a) di atas dikecualikan, dengan syarat:
                    <ol class="list-decimal mt-2">
                        <li>Berita benar-benar mengandung kepentingan publik yang bersifat mendesak;</li>
                        <li>Sumber berita yang pertama adalah sumber yang jelas disebutkan identitasnya, kredibel dan kompeten;</li>
                        <li>Subyek berita yang harus dikonfirmasi tidak diketahui keberadaannya dan atau tidak dapat diwawancarai;</li>
                        <li>Media memberikan penjelasan kepada pembaca bahwa berita tersebut masih memerlukan verifikasi lebih lanjut yang diupayakan dalam waktu secepatnya. Penjelasan dimuat pada bagian akhir dari berita yang sama, di dalam kurung dan menggunakan huruf miring.</li>
                    </ol>
                </li>
                <li>Setelah memuat berita sesuai dengan butir (c), media wajib meneruskan upaya verifikasi, dan setelah verifikasi didapatkan, hasil verifikasi dicantumkan pada berita pemutakhiran (update) dengan tautan pada berita yang belum terverifikasi.</li>
            </ol>

            <h2>3. Isi Buatan Pengguna (User Generated Content)</h2>
            <ol class="list-[lower-alpha]">
                <li>Media siber wajib mencantumkan syarat dan ketentuan mengenai Isi Buatan Pengguna yang tidak bertentangan dengan Undang-Undang No. 40 tahun 1999 tentang Pers dan Kode Etik Jurnalistik, yang ditempatkan secara terang dan jelas.</li>
                <li>Media siber mewajibkan setiap pengguna untuk melakukan registrasi keanggotaan dan melakukan proses log-in terlebih dahulu untuk dapat mempublikasikan semua bentuk Isi Buatan Pengguna. Ketentuan mengenai log-in akan diatur lebih lanjut.</li>
                <li>Dalam registrasi tersebut, media siber mewajibkan pengguna memberi persetujuan tertulis bahwa Isi Buatan Pengguna yang dipublikasikan:
                    <ol class="list-decimal mt-2">
                        <li>Tidak memuat isi bohong, fitnah, sadis dan cabul;</li>
                        <li>Tidak memuat isi yang mengandung prasangka dan kebencian terkait dengan suku, agama, ras, dan antargolongan (SARA), serta menganjurkan tindakan kekerasan;</li>
                        <li>Tidak memuat isi diskriminatif atas dasar perbedaan jenis kelamin dan bahasa, serta tidak merendahkan martabat orang lemah, miskin, sakit, cacat jiwa, atau cacat jasmani.</li>
                    </ol>
                </li>
                <li>Media siber memiliki kewenangan mutlak untuk mengedit atau menghapus Isi Buatan Pengguna yang bertentangan dengan butir (c).</li>
                <li>Media siber wajib menyediakan mekanisme pengaduan Isi Buatan Pengguna yang dinilai melanggar ketentuan pada butir (c). Mekanisme tersebut harus disediakan di tempat yang dengan mudah dapat diakses pengguna.</li>
                <li>Media siber wajib menyunting, menghapus, dan melakukan tindakan koreksi setiap Isi Buatan Pengguna yang dilaporkan dan melanggar ketentuan butir (c), sesegera mungkin secara proporsional selambat-lambatnya 2 x 24 jam setelah pengaduan diterima.</li>
                <li>Media siber yang telah memenuhi ketentuan pada butir (a), (b), (c), dan (f) tidak dibebani tanggung jawab atas masalah yang ditimbulkan akibat pemuatan isi yang melanggar ketentuan pada butir (c).</li>
                <li>Media siber bertanggung jawab atas Isi Buatan Pengguna yang dilaporkan bila tidak mengambil tindakan koreksi setelah batas waktu sebagaimana tersebut pada butir (f).</li>
            </ol>

            <h2>4. Ralat, Koreksi, dan Hak Jawab</h2>
            <ol class="list-[lower-alpha]">
                <li>Ralat, koreksi, dan hak jawab mengacu pada Undang-Undang Pers, Kode Etik Jurnalistik, dan Pedoman Hak Jawab yang ditetapkan Dewan Pers.</li>
                <li>Ralat, koreksi dan atau hak jawab wajib ditautkan pada berita yang diralat, dikoreksi atau yang diberi hak jawab.</li>
                <li>Di setiap berita ralat, koreksi, dan hak jawab wajib dicantumkan waktu pemuatan ralat, koreksi, dan atau hak jawab tersebut.</li>
                <li>Bila suatu berita media siber tertentu disebarluaskan media siber lain, maka:
                    <ol class="list-decimal mt-2">
                        <li>Tanggung jawab media siber pembuat berita terbatas pada berita yang dipublikasikan di media siber tersebut atau media siber yang berada di bawah otoritas teknisnya;</li>
                        <li>Koreksi berita yang dilakukan oleh sebuah media siber, juga harus dilakukan oleh media siber lain yang mengutip berita dari media siber yang dikoreksi itu;</li>
                        <li>Media yang menyebarluaskan berita dari sebuah media siber dan tidak melakukan koreksi atas berita sesuai yang dilakukan oleh media siber pemilik dan atau pembuat berita tersebut, bertanggung jawab penuh atas semua akibat hukum dari berita yang tidak dikoreksinya itu.</li>
                    </ol>
                </li>
                <li>Sesuai dengan Undang-Undang Pers, media siber yang tidak melayani hak jawab dapat dijatuhi sanksi hukum pidana denda paling banyak Rp500.000.000 (Lima ratus juta rupiah).</li>
            </ol>

            <h2>5. Pencabutan Berita</h2>
            <ol class="list-[lower-alpha]">
                <li>Berita yang sudah dipublikasikan tidak dapat dicabut karena alasan penyensoran dari pihak luar redaksi, kecuali terkait masalah SARA, kesusilaan, masa depan anak, pengalaman traumatik korban atau berdasarkan pertimbangan khusus lain yang ditetapkan Dewan Pers.</li>
                <li>Media siber lain wajib mengikuti pencabutan kutipan berita dari media asal yang telah dicabut.</li>
                <li>Pencabutan berita wajib disertai dengan alasan pencabutan dan diumumkan kepada publik.</li>
            </ol>

            <h2>6. Iklan</h2>
            <ol class="list-[lower-alpha]">
                <li>Media siber wajib membedakan dengan tegas antara produk berita dan iklan.</li>
                <li>Setiap berita/artikel/isi yang merupakan iklan dan atau isi berbayar wajib mencantumkan keterangan &rdquo;advertorial&rdquo;, &rdquo;iklan&rdquo;, &rdquo;ads&rdquo;, &rdquo;sponsored&rdquo;, atau kata lain yang menjelaskan bahwa berita/artikel/isi tersebut adalah iklan.</li>
            </ol>

            <h2>7. Hak Cipta</h2>
            <p>
                Media siber wajib menghormati hak cipta sebagaimana diatur dalam peraturan perundang-undangan yang berlaku.
            </p>

            <h2>8. Pencantuman Pedoman</h2>
            <p>
                Media siber wajib mencantumkan Pedoman Pemberitaan Media Siber ini di medianya secara terang dan jelas.
            </p>

            <h2>9. Sengketa</h2>
            <p>
                Penilaian akhir atas sengketa mengenai pelaksanaan Pedoman Pemberitaan Media Siber ini diselesaikan oleh Dewan Pers.
            </p>

            <p class="mt-10 text-lg font-black uppercase tracking-widest text-[var(--color-text-primary)]">
                Jakarta, 3 Februari 2012
            </p>

        </div>
    </article>

@endsection
