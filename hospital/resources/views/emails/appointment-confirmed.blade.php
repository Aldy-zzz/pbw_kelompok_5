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
        .payment-info { background: #dbeafe; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Janji Temu Dikonfirmasi!</h1>
            <p>{{ $appointment->appointment_id }}</p>
        </div>
        
        <div class="content">
            <p><strong>Halo {{ $appointment->patient->user->name }},</strong></p>
            
            <p>Kabar baik! Janji temu Anda telah dikonfirmasi oleh admin kami.</p>
            
            <div class="box">
                <h3 style="margin-top: 0; color: #3b82f6;">📅 Detail Janji Temu</h3>
                <p><strong>Dokter:</strong> {{ $appointment->doctor->name }}<br>
                <strong>Tanggal:</strong> {{ $appointment->formatted_date }}<br>
                <strong>Waktu:</strong> {{ $appointment->formatted_time }}</p>
            </div>
            
            <div class="payment-info">
                <h3 style="margin-top: 0;">💰 Informasi Pembayaran</h3>
                <p><strong>Total yang harus dibayar:</strong> Rp {{ number_format($appointment->consultation_fee + 5000, 0, ',', '.') }}</p>
                <p><strong>Transfer ke:</strong><br>
                BCA: 1234567890<br>
                BNI: 0987654321<br>
                a.n. RS Sehat Sejahtera</p>
            </div>
            
            <p><strong>Langkah selanjutnya:</strong></p>
            <ol>
                <li>Lakukan pembayaran ke salah satu rekening di atas</li>
                <li>Upload bukti pembayaran melalui dashboard</li>
                <li>Tunggu konfirmasi pembayaran dari admin</li>
            </ol>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('patient.dashboard') }}" class="button">Upload Bukti Pembayaran</a>
            </div>
            
            <div style="text-align: center; color: #6b7280; font-size: 14px; margin-top: 30px;">
                <p><strong>RS Sehat Sejahtera</strong></p>
                <p>📞 (021) 123-4567 | ✉️ info@rssehat.co.id</p>
            </div>
        </div>
    </div>
</body>
</html>