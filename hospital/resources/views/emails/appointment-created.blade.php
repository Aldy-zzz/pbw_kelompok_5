<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #3b82f6, #10b981); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .box { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .button { display: inline-block; background: #10b981; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
        .warning { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Pendaftaran Berhasil!</h1>
            <p>RS Sehat Sejahtera</p>
        </div>
        
        <div class="content">
            <p><strong>Halo {{ $appointment->patient->user->name }},</strong></p>
            
            <p>Terima kasih telah mendaftar di RS Sehat Sejahtera. Pendaftaran Anda telah berhasil dicatat.</p>
            
            <div class="box">
                <h3 style="margin-top: 0; color: #3b82f6;">📋 Informasi Pendaftaran</h3>
                <div class="info-row">
                    <strong>ID Pendaftaran:</strong>
                    <span style="color: #3b82f6; font-family: monospace; font-weight: bold;">{{ $appointment->appointment_id }}</span>
                </div>
                <div class="info-row">
                    <strong>Dokter:</strong>
                    <span>{{ $appointment->doctor->name }}</span>
                </div>
                <div class="info-row">
                    <strong>Spesialisasi:</strong>
                    <span>{{ $appointment->doctor->specialty }}</span>
                </div>
                <div class="info-row">
                    <strong>Tanggal:</strong>
                    <span>{{ $appointment->formatted_date }}</span>
                </div>
                <div class="info-row">
                    <strong>Waktu:</strong>
                    <span>{{ $appointment->formatted_time }}</span>
                </div>
                <div class="info-row">
                    <strong>Biaya Konsultasi:</strong>
                    <span style="color: #10b981; font-weight: bold;">{{ $appointment->formatted_fee }}</span>
                </div>
            </div>
            
            <div class="box" style="background: #dbeafe;">
                <h3 style="margin-top: 0; color: #1e40af;">🔐 Informasi Akun</h3>
                <p><strong>Email:</strong> {{ $appointment->patient->user->email }}</p>
                <p><strong>Password:</strong> <code style="background: white; padding: 5px 10px; border-radius: 5px; font-size: 16px;">{{ $password }}</code></p>
                <p style="color: #1e40af; font-size: 14px;">⚠️ Simpan password ini dengan aman. Anda dapat login menggunakan email dan password ini.</p>
            </div>
            
            <div class="warning">
                <strong>⏰ Langkah Selanjutnya:</strong>
                <ol style="margin: 10px 0 0 0;">
                    <li>Admin akan menghubungi Anda dalam 1x24 jam untuk konfirmasi</li>
                    <li>Setelah dikonfirmasi, lakukan pembayaran</li>
                    <li>Upload bukti pembayaran melalui dashboard</li>
                    <li>Datang 15 menit sebelum jadwal konsultasi</li>
                </ol>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('patient.dashboard') }}" class="button">Buka Dashboard Saya</a>
            </div>
            
            <div style="text-align: center; color: #6b7280; font-size: 14px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                <p><strong>RS Sehat Sejahtera</strong></p>
                <p>Jl. Kesehatan Raya No. 123, Jakarta</p>
                <p>📞 (021) 123-4567 | ✉️ info@rssehat.co.id</p>
            </div>
        </div>
    </div>
</body>
</html>