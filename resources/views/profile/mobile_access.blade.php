@extends('layouts.portal')
@section('title', 'Mobile Access')
@section('content')
<div style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center;">
    <h2 style="font-size: 24px; font-weight: 700; color: #333; margin-bottom: 10px;">Connect Mobile Device</h2>
    <p style="color: #666; margin-bottom: 30px;">Scan the QR code below using the RCOS Mobile App to log in instantly. This code expires in 1 minute.</p>

    <div id="qr-container" style="background: #fafafa; border: 2px dashed #ddd; border-radius: 10px; padding: 40px; margin-bottom: 20px; display: flex; justify-content: center; align-items: center; min-height: 250px;">
        <div class="spinner-border text-primary" role="status" id="qr-loading">
            <span class="sr-only">Loading...</span>
        </div>
        <img id="qr-image" src="" style="display: none; max-width: 200px;" alt="Login QR Code">
    </div>

    <p id="expiry-timer" style="color: #e74c3c; font-weight: bold; font-size: 18px; display: none;">Expires in: <span id="time-left">60</span>s</p>

    <button class="btn-modern" id="refresh-qr" style="margin-top: 15px; display: none;" onclick="generateQR()">
        <i class='bx bx-refresh'></i> Generate New QR
    </button>
</div>
@endsection

@push('scripts')
<script>
    let timerInterval;

    function generateQR() {
        $('#qr-loading').show();
        $('#qr-image').hide();
        $('#expiry-timer').hide();
        $('#refresh-qr').hide();
        clearInterval(timerInterval);

        $.post('{{ route('profile.generate_qr') }}', {
            _token: '{{ csrf_token() }}'
        }, function(response) {
            if(response.success) {
                // Generate QR Code URL using a public API for simplicity
                // In production, you might want to use a local library like endroid/qr-code
                const qrData = JSON.stringify({ qrToken: response.qrToken });
                const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(qrData)}`;
                
                $('#qr-image').attr('src', qrUrl).on('load', function() {
                    $('#qr-loading').hide();
                    $('#qr-image').show();
                    $('#expiry-timer').show();
                    
                    let timeLeft = response.expiresIn;
                    $('#time-left').text(timeLeft);
                    
                    timerInterval = setInterval(() => {
                        timeLeft--;
                        $('#time-left').text(timeLeft);
                        if(timeLeft <= 0) {
                            clearInterval(timerInterval);
                            $('#qr-image').css('opacity', 0.2);
                            $('#time-left').text('0');
                            $('#refresh-qr').show();
                        }
                    }, 1000);
                });
            }
        });
    }

    $(document).ready(function() {
        generateQR();
    });
</script>
@endpush
