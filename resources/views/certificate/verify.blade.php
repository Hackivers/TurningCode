<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kompetensi | {{ $certificate->user->name }} - TurningCode</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@700;800&family=JetBrains+Mono:wght@500;700&display=swap');

        :root {
            --neo-bg: #f5f5f5;
            --neo-text-dark: #121212;
            --neo-text-light: #555555;
            --neo-accent: #3b82f6;
            --neo-border: rgba(0, 0, 0, 0.1);
            --neo-card-bg: #ffffff;
            --neo-radius: 24px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--neo-bg);
            color: var(--neo-text-dark);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(59, 130, 246, 0.1), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(16, 185, 129, 0.1), transparent 25%);
        }

        .cert-container {
            width: 100%;
            max-width: 900px;
            padding: 24px;
            box-sizing: border-box;
        }

        .cert-card {
            background: var(--neo-card-bg);
            border-radius: var(--neo-radius);
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            overflow: hidden;
            border: 1px solid var(--neo-border);
            position: relative;
        }

        .cert-header {
            background: var(--neo-text-dark);
            color: white;
            padding: 32px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cert-brand {
            font-family: 'Outfit', sans-serif;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cert-brand-icon {
            width: 40px;
            height: 40px;
            background: white;
            color: var(--neo-text-dark);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .cert-body {
            padding: 64px 48px;
            text-align: center;
            background-image: url('data:image/svg+xml;utf8,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><g fill="%23f0f0f0" fill-opacity="0.5" fill-rule="evenodd"><circle cx="50" cy="50" r="1"/></g></svg>');
        }

        .cert-title {
            font-family: 'Outfit', sans-serif;
            font-size: 56px;
            font-weight: 800;
            letter-spacing: -2px;
            margin: 0 0 24px;
            background: linear-gradient(135deg, #121212, #555);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cert-subtitle {
            font-size: 18px;
            color: var(--neo-text-light);
            margin: 0 0 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .cert-recipient {
            font-size: 48px;
            font-weight: 800;
            color: var(--neo-accent);
            margin: 0 0 16px;
            line-height: 1.2;
            text-transform: capitalize;
        }

        .cert-desc {
            font-size: 18px;
            color: var(--neo-text-light);
            margin: 0 auto 40px;
            max-width: 600px;
            line-height: 1.6;
        }

        .cert-course {
            font-size: 28px;
            font-weight: 700;
            color: var(--neo-text-dark);
            margin: 0 0 48px;
        }

        .cert-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 48px;
            padding-top: 48px;
            border-top: 2px dashed rgba(0,0,0,0.05);
        }

        .cert-meta {
            text-align: left;
        }

        .cert-meta-label {
            font-size: 12px;
            color: var(--neo-text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .cert-meta-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 16px;
            font-weight: 700;
            color: var(--neo-text-dark);
        }

        .cert-verify-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #ecfdf5;
            color: #10b981;
            padding: 12px 20px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 14px;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 180px;
            font-weight: 900;
            color: rgba(0,0,0,0.02);
            pointer-events: none;
            white-space: nowrap;
            font-family: 'Outfit', sans-serif;
        }

        @media (max-width: 768px) {
            .cert-header { padding: 24px; flex-direction: column; gap: 16px; align-items: flex-start; }
            .cert-body { padding: 40px 24px; }
            .cert-title { font-size: 40px; }
            .cert-recipient { font-size: 32px; }
            .cert-course { font-size: 24px; }
            .cert-footer { flex-direction: column; gap: 32px; align-items: center; text-align: center; }
            .cert-meta { text-align: center; }
            .watermark { font-size: 100px; }
        }
    </style>
</head>
<body>

<div class="cert-container">
    <div class="cert-card">
        <div class="watermark">TURNINGCODE</div>
        
        <div class="cert-header">
            <div class="cert-brand">
                <div class="cert-brand-icon">
                    <i class='bx bx-code-alt'></i>
                </div>
                TurningCode
            </div>
            <div style="font-size: 14px; opacity: 0.8; font-weight: 500;">
                Kredensial Publik Resmi
            </div>
        </div>

        <div class="cert-body">
            <div class="cert-subtitle">Sertifikat Kelulusan</div>
            <h1 class="cert-title">Sertifikat Kompetensi</h1>
            
            <p class="cert-desc">Diberikan dengan bangga kepada:</p>
            
            <div class="cert-recipient">{{ $certificate->user->name }}</div>
            
            <p class="cert-desc">Atas keberhasilannya dalam menyelesaikan materi pembelajaran dan lulus ujian evaluasi kompetensi pada program:</p>
            
            <div class="cert-course">{{ $certificate->materi->title }}</div>

            <div class="cert-footer">
                <div class="cert-meta">
                    <div class="cert-meta-label">Diterbitkan Pada</div>
                    <div class="cert-meta-value">{{ $certificate->issued_at->translatedFormat('d F Y') }}</div>
                </div>
                
                <div class="cert-verify-badge">
                    <i class='bx bxs-badge-check' style="font-size: 20px;"></i>
                    Kredensial Terverifikasi
                </div>

                <div class="cert-meta" style="text-align: right;">
                    <div class="cert-meta-label">Nomor Sertifikat</div>
                    <div class="cert-meta-value">{{ $certificate->certificate_code }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 32px;">
        <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--neo-text-light); text-decoration: none; font-weight: 600; font-size: 14px; transition: color 0.2s;" onmouseover="this.style.color='#121212'" onmouseout="this.style.color='var(--neo-text-light)'">
            <i class='bx bx-arrow-back'></i> Kembali ke Beranda
        </a>
    </div>
</div>

</body>
</html>
