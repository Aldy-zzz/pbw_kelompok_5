<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .box { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .success { background: #d1fae5; border-left: 4px solid #10b981; padding: 15px; margin: 20px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💰 Pembayaran Berhasil Dikonfirmasi!</h1>
        </div>
        
        <div class="content">
            <p><strong>Halo {{ $appointment->patient->user->name }},</strong></p>
            
            <div class="success">
                <h3 style="margin-top: 0; color: #065f46;">✅ Pembayaran Lunas</h3>
                <p>Pembayaran Anda untuk janji temu <strong>{{ $appointment->appointment_id }}</strong> telah berhasil diverifikasi!</p>
            </div>
            
            <div class="box">
                <h3 style="margin-top: 0;">📅 Siap untuk Konsultasi</h3>
                <p><strong>Dokter:</strong> {{ $appointment->doctor->name }}<br>
                <strong>Tanggal:</strong> {{ $appointment->formatted_date }}<br>
                <strong>Waktu:</strong> {{ $appointment->formatted_time }}</p>
            </div>
            
            <div class="box" style="background: #fef3c7;">
            <h3 style="margin-top: 0; color: #92400e;">📝 Yang Perlu Dibawa:</h3>
                <ul style="margin: 10px 0;">
                    <li>KTP atau identitas resmi</li>
                    <li>Kartu BPJS (jika ada)</li>
                    <li>Daftar obat yang sedang dikonsumsi</li>
                    <li>Hasil pemeriksaan sebelumnya (jika ada)</li>
                </ul>
            </div>
            
            <div style="background: #dbeafe; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 0; color: #1e40af;">
                    <strong>⏰ Penting:</strong> Harap datang 15 menit sebelum jadwal konsultasi untuk proses registrasi.
                </p>
            </div>
            
            <div style="text-align: center; color: #6b7280; font-size: 14px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                <p><strong>RS Sehat Sejahtera</strong></p>
                <p>Jl. Kesehatan Raya No. 123, Jakarta</p>
                <p>📞 (021) 123-4567 | 🚨 Emergency: 119</p>
                <p>✉️ info@rssehat.co.id</p>
            </div>
        </div>
    </div>
</body>
</html>