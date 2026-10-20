<!DOCTYPE html>
<html>
<head>
    <title>Update Status Bug</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #0284c7;">Halo, ada update pada Bug Anda!</h2>
    
    <p>Bug yang Anda laporkan di Qora Tracker telah mengalami perubahan status penanganan.</p>
    
    <div style="background-color: #f1f5f9; padding: 15px; border-radius: 5px;">
        <p><strong>Judul Bug:</strong> {{ $bug->title }}</p>
        <p><strong>Status Sebelumnya:</strong> <span style="color: #dc2626;">{{ $oldStatus }}</span></p>
        <p><strong>Status Saat Ini:</strong> <span style="color: #16a34a;">{{ $bug->status }}</span></p>
        <p><strong>Prioritas:</strong> {{ strtoupper($bug->priority) }}</p>
    </div>

    <p>Silakan login ke dashboard Qora untuk melihat detail lebih lanjut.</p>
    <br>
    <p>Terima kasih,<br><strong>Tim Qora Bug Tracker</strong></p>
</body>
</html>