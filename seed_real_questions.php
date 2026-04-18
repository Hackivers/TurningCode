<?php
$questionsData = [
    [
        "q" => "Apa kepanjangan dari OSINT?",
        "options" => ["Open Source Intelligence", "Open Security Intelligence", "Online System Integration", "Outside Source Investigation"],
        "answer" => 0
    ],
    [
        "q" => "Fokus utama dari OSINT adalah...",
        "options" => ["Menggali data dari sistem tertutup", "Mengumpulkan informasi dari sumber terbuka (publik)", "Memasukkan malware ke jaringan target", "Mendapatkan akses fisik ke server"],
        "answer" => 1
    ],
    [
        "q" => "Alat manakah yang sering digunakan untuk memetakan jaringan dan mencari email di OSINT?",
        "options" => ["Metasploit", "theHarvester", "Burp Suite", "Aircrack-ng"],
        "answer" => 1
    ],
    [
        "q" => "Pencarian lanjutan menggunakan operator khusus di Google disebut...",
        "options" => ["Google Dorking", "Google Hacking", "Google Phishing", "Google Crawling"],
        "answer" => 0
    ],
    [
        "q" => "Manakah yang BUKAN merupakan sumber OSINT?",
        "options" => ["Media Sosial", "Forum Publik", "Rekam Medis Pasien yang Dilindungi", "Artikel Berita"],
        "answer" => 2
    ],
    [
        "q" => "Shodan adalah mesin pencari yang fokus pada...",
        "options" => ["Kueri dokumen akademik", "Perangkat IoT dan server yang terhubung ke internet", "Pencarian profil media sosial pengguna", "Video hiburan"],
        "answer" => 1
    ],
    [
        "q" => "EXIF data pada foto dapat digunakan dalam OSINT untuk mendeteksi...",
        "options" => ["Password pengguna", "Username email", "Lokasi GPS dan model kamera", "Isi pesan teks yang dienkripsi"],
        "answer" => 2
    ],
    [
        "q" => "Sistem yang sering digunakan analis OSINT untuk memvisualisasikan relasi data adalah...",
        "options" => ["Maltego", "Wireshark", "John the Ripper", "Nmap"],
        "answer" => 0
    ],
    [
        "q" => "Dalam proses investigasi, apa yang dinamakan 'sock puppet'?",
        "options" => ["Kabel fisik", "Akun online palsu untuk menyembunyikan identitas penyelidik", "Protokol jaringan", "Pesan error pada malware"],
        "answer" => 1
    ],
    [
        "q" => "Operator pencarian Google apa yang digunakan untuk mencari tipe file tertentu?",
        "options" => ["inurl:", "site:", "filetype:", "intitle:"],
        "answer" => 2
    ],
    [
        "q" => "Apa fungsi dari operator Google 'site:'?",
        "options" => ["Membatasi hasil pencarian pada sebuah domain situs tertentu", "Menampilkan situs serupa", "Mencari halaman yang terhapus", "Membuat situs baru"],
        "answer" => 0
    ],
    [
        "q" => "Internet Archive Wayback Machine sangat berguna dalam OSINT karena...",
        "options" => ["Dapat melancarkan serangan otomatis", "Menyimpan versi halaman web di masa lalu meskipun kini telah dihapus", "Mengambil alih server target", "Membuka password file PDF"],
        "answer" => 1
    ],
    [
        "q" => "Tool OSINT yang digunakan untuk menemukan nama domain yang berafiliasi atau sub-domain adalah...",
        "options" => ["Sublist3r", "Hashcat", "Snort", "Tcpdump"],
        "answer" => 0
    ],
    [
        "q" => "Metode mencari nama asal pemilik website dapat diselidiki melalui...",
        "options" => ["WHOIS Record", "Cross-site Scripting (XSS)", "SQL Injection", "ARP Spoofing"],
        "answer" => 0
    ],
    [
        "q" => "Berikut ini mana yang dikategorikan sebagai SOCMINT?",
        "options" => ["Social Media Intelligence", "Security Operations Center Intelligence", "Socket Communication Intelligence", "System Optimization Intelligence"],
        "answer" => 0
    ],
    [
        "q" => "Reverse image search merupakan teknik yang berguna untuk...",
        "options" => ["Mengubah gambar menjadi teks", "Mengonfirmasi keaslian gambar atau letak asalnya", "Menambahkan exif data", "Membuat gambar baru"],
        "answer" => 1
    ],
    [
        "q" => "Tool OSINT apa yang paling terkenal untuk mencari celah/kerentanan pada kode sumber secara publik?",
        "options" => ["GitHub", "Facebook", "Instagram", "Tinder"],
        "answer" => 0
    ],
    [
        "q" => "Mengumpulkan informasi identitas staf perusahan di sebuah direktori publik disebut gaya OSINT...",
        "options" => ["Pasif", "Aktif", "Agresif", "Destruktif"],
        "answer" => 0
    ],
    [
        "q" => "Apabila investigator ingin mencari username secara bersamaan di banyak platform medsos, tool yang sering digunakan adalah...",
        "options" => ["Sherlock", "Nikto", "Nessus", "DirBuster"],
        "answer" => 0
    ],
    [
        "q" => "Apakah mengumpulkan dokumen rahasia negara dari dalam server terlindungi termasuk OSINT?",
        "options" => ["Ya, itu OSINT", "Tidak, OSINT hanya merujuk pada pemanfaatan sumber data publik/terbuka", "Tergantung situasinya", "Itu disebut Legal OSINT"],
        "answer" => 1
    ],
    [
        "q" => "Sebuah platform yang menunjukkan letak kapal laut secara real-time berdasarkan AIS open data disebut...",
        "options" => ["MarineTraffic", "Flightradar24", "Strava", "Waze"],
        "answer" => 0
    ],
    [
        "q" => "Penyedia informasi pelacakan penerbangan pesawat udara secara terbuka sering memanfaatkan platform...",
        "options" => ["Flightradar24", "Uber", "MarineTraffic", "Google Scholar"],
        "answer" => 0
    ],
    [
        "q" => "Apa yang dimaksud dengan HUMINT?",
        "options" => ["Human Intelligence", "Hub Manipulation Intelligence", "Hardware Utility Intelligence", "Hunt Malware Intelligence"],
        "answer" => 0
    ],
    [
        "q" => "Mana dari elemen berikut yang dapat bocor tanpa disadari dan dimanfaatkan analis OSINT dari sebuah dokumen Word?",
        "options" => ["Macro malware", "Metadata (Penulis, Waktu dibuat)", "Alamat IP jaringan internal selalu", "Password akun Microsoft"],
        "answer" => 1
    ],
    [
        "q" => "OSINT Pasif berarti...",
        "options" => ["Berinteraksi langsung dengan target", "Mengumpulkan informasi langsung tanpa alert atau deteksi dari target", "Menghubungi target lewat telepon pura-pura", "Melakukan port scan ke server target secara berlebihan"],
        "answer" => 1
    ],
    [
        "q" => "Apakah situs Pastebin sering digunakan dalam OSINT? Untuk apa?",
        "options" => ["Tidak, dilarang", "Ya, sering memuat kebocoran kredensial (dump) atau kode sumber oleh peretas publik", "Hanya untuk menyimpan sandi perusahaan", "Tidak berhubungan dengan OSINT"],
        "answer" => 1
    ],
    [
        "q" => "Situs web 'Have I Been Pwned' berguna untuk...",
        "options" => ["Menguji antivirus", "Mengetahui apakah email seseorang pernah ada dalam kebocoran data pihak ketiga (data breach)", "Menerima notifikasi diskon belanja", "Menghapus malware dari email"],
        "answer" => 1
    ],
    [
        "q" => "Dalam dunia cyber, GEOINT berkaitan dengan intelijen berbasis...",
        "options" => ["Logika geometri", "Geospatial/Geolokasi dari koordinat bumi", "Kode genetik", "Geometri database"],
        "answer" => 1
    ],
    [
        "q" => "Recon-ng adalah tool yang dituliskan dalam bahasa apa untuk reconnaissance otomatis OSINT?",
        "options" => ["Java", "Python", "Ruby", "Golang"],
        "answer" => 1
    ],
    [
        "q" => "Mengapa seorang analis OSINT biasanya menonaktifkan ad-tracker dan memakai VPN?",
        "options" => ["Agar internet lambat", "Untuk tetap anonim dan tidak mencemari rekam jejak digital miliknya", "Biar terlihat seperti peretas", "Agar bisa memecahkan kode sandi wifi"],
        "answer" => 1
    ],
    [
        "q" => "Salah satu keuntungan OSINT yang paling besar adalah...",
        "options" => ["Murah/Gratis dan lebih terhindar dari konsekuensi legal dibanding peretasan", "Memberi kemudahan menyebar virus", "Langsung bisa matikan sistem korban", "Tidak perlu menggunakan internet"],
        "answer" => 0
    ],
    [
        "q" => "Sebuah platform agregator besar yang mengatur dataset kebocoran breach secara terstruktur dan dapat dicari di OSINT biasanya...",
        "options" => ["DeHashed", "Github Search", "Wikipedia", "Youtube"],
        "answer" => 0
    ],
    [
        "q" => "Teknik mengumpulkan informasi yang dapat diestimasi lewat analisis visual bayangan gedung pada sebuah video publik disebut teknik...",
        "options" => ["Shadow Analysis (Analisis Kronologis/GEOINT)", "Social Engineering", "SQL Injection", "Phishing"],
        "answer" => 0
    ],
    [
        "q" => "Google Dork 'intitle:\"index of /\"' pada umumnya akan menampilkan...",
        "options" => ["Halaman login administrator", "Direktori terbuka (open directory) pada web server", "Kode sumber enkripsi", "Keranjang belanja E-commerce"],
        "answer" => 1
    ],
    [
        "q" => "Siapa yang dapat memanfaatkan OSINT secara sah?",
        "options" => ["Peretas topi hitam", "Semua orang, jurnalis investigasi, penegak hukum, serta perusahaan cyber security", "Hanya kepolisian", "Hanya badan intelijen negara"],
        "answer" => 1
    ],
    [
        "q" => "Operasi apa dalam intelijen kompetitor perusahaan (Competitive Intelligence) yang merupakan OSINT?",
        "options" => ["Membobol email saingan", "Menganalisis laporan keuangan perusahaan lawan yang dipublikasikan secara reguler", "Menyuap karyawan saingan", "Merusak server kompetitor"],
        "answer" => 1
    ],
    [
        "q" => "Aplikasi Tineye biasanya sering digunakan untuk kebutuhan analis...",
        "options" => ["Web Scraping Teks otomatis", "Reverse Image Search (Mencari sumber asal gambar)", "Eksploitasi Jaringan DNS", "Analisa Hash Malware"],
        "answer" => 1
    ],
    [
        "q" => "Guna menjaga kredibilitas dan tidak membiaskan sistem mesin pencari, analis OSINT direkomendasikan melakukan kliring...",
        "options" => ["CPU Register", "Browser Cache & Cookies sebelum investigasi", "RAM dan ROM server", "Laporan Polisi"],
        "answer" => 1
    ],
    [
        "q" => "Mencari informasi tentang sebuah DNS domain (misal subdomain atau data registrasi MX record) sering disebut...",
        "options" => ["DNS OSINT", "DNS Spoofing", "DNS Poisoning", "DNS Sinkholing"],
        "answer" => 0
    ],
    [
        "q" => "SpiderFoot merupakan salah satu tool yang membantu proses...",
        "options" => ["Pembuatan aplikasi Android", "OSINT yang terotomatisasi secara luas dengan memanen berbagai sumber dari satu IP/Domain", "Menghancurkan database MySQL", "Video Editing Forensic"],
        "answer" => 1
    ],
    [
        "q" => "Dalam konteks forensik open source, FOCA sering dipakai untuk analisis...",
        "options" => ["Gambar di Whatsapp", "Metadata dalam dokumen terpublikasi yang sudah didownload", "Menganalisis cuitan X/Twitter", "Menghitung ping response"],
        "answer" => 1
    ],
    [
        "q" => "Bellingcat dikenal sangat baik karena menggunakan OSINT untuk...",
        "options" => ["Mebobol akun artis", "Jurnalisme investigasi dalam mendeteksi kebenaran sebuah kejahatan internasional dan zona perang", "Menjual data kartu kredit ilegal", "Membuat meme internet"],
        "answer" => 1
    ],
    [
        "q" => "Jejak yang ditinggalkan seseorang tanpa sadar di internet (misal komen lama di forum) merupakan bagian dari...",
        "options" => ["Hardware footprint", "Digital Footprint (Jejak Digital)", "Software Patching", "Cloud Architecture"],
        "answer" => 1
    ],
    [
        "q" => "Sebuah gambar diposting online tanpa Exif. Bagaimana agen OSINT masih bisa mencari jejak lokasinya?",
        "options" => ["Mustahil dicari", "Mengumpulkan visual clues secara manual (gedung, bahasa di plang jalan, dll)", "Menebak asal dari warna langit semata", "Mengirimkan malware klik gambar"],
        "answer" => 1
    ],
    [
        "q" => "Mencocokkan pelat nomor mobil terekam pada video warga ke dalam sebuah basis data publik lalu lintas adalah contoh dari...",
        "options" => ["Web hacking", "OSINT lintas dataset terbuka milik institusi jalan raya", "Pelanggaran privasi berat anonim", "Serangan Brute-force"],
        "answer" => 1
    ],
    [
        "q" => "Manakah yang merupakan tantangan besar dalam melacak identitas orang secara OSINT hari ini?",
        "options" => ["Orang sering menggunakan banyak nama berbeda/alias/anonim online", "Internet sudah habis kapasitasnya", "Gambar JPEG dan PNG tidak bisa dibuka", "Browser tidak lagi memiliki add-on"],
        "answer" => 0
    ],
    [
        "q" => "Sistem pendaftaran alamat IPv4 secara global yang berguna melacak siapa pemilik IP tertentu bernama...",
        "options" => ["DHCP", "DNS Resolver", "BGP", "Bases data registrasi RIR (seperti ARIN, APNIC, RIPE)"],
        "answer" => 3
    ],
    [
        "q" => "OSINT tools seperti 'Buscador' merupakan wujud dari...",
        "options" => ["Sistem operasi Linux pre-compiled untuk OSINT investigator", "Malware Android buatan Meksiko", "Aplikasi sosial media chatting", "Tipe dokumen intelijen klandestin"],
        "answer" => 0
    ],
    [
        "q" => "Istilah OPSEC sering berdampingan dengan OSINT. OPSEC merupakan singkatan dari...",
        "options" => ["Operation Sections", "Operational Security (Keamanan Operasional diri investigator)", "Optimized Search Engine Crawling", "Opening Secure Environments"],
        "answer" => 1
    ],
    [
        "q" => "Bila investigator ingin mentranslate sebuah tulisan misterius pada sebuah tembok via Google Street view, ia menggabungkan unsur...",
        "options" => ["Pencurian log lokal", "GEOINT, OSINT, dan Machine Translation (Image to Text translation)", "Social Engineering Level 2", "Reverse Engineering Binary"],
        "answer" => 1
    ]
];

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$subMateriId = 1;
\App\Models\Question::where('sub_materi_id', $subMateriId)->delete();

$insertData = [];
$order = 1;
foreach ($questionsData as $idx => $qData) {
    // Susun array untuk insert
    $insertData[] = [
        'sub_materi_id'  => $subMateriId,
        'question'       => $qData['q'],
        'options'        => json_encode($qData['options']),
        'correct_option' => $qData['answer'],
        'order'          => $order++,
        'created_at'     => now(),
        'updated_at'     => now(),
    ];
}

\App\Models\Question::insert($insertData);
echo "50 Real OSINT Questions successfully seeded!\n";
