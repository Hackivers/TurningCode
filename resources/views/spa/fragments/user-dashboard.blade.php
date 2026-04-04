@include('spa.fragments.user-headerCard')
@include('spa.fragments.user-timeCard')
@include('spa.fragments.user-materiCard', ['data' => $data, 'mainMateri' => $mainMateri])
@include('spa.fragments.user-progres', ['mainMateri' => $mainMateri])

<script>
    // Clock update
    function updateClock() {
        const now = new Date();
        const hour = document.getElementById('hour');
        const minute = document.getElementById('minute');
        if (hour) hour.textContent = String(now.getHours()).padStart(2, '0');
        if (minute) minute.textContent = ':' + String(now.getMinutes()).padStart(2, '0');
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Time-based greeting
    const timeText = document.getElementById('time-text');
    if (timeText) {
        const h = new Date().getHours();
        if (h < 6) timeText.textContent = 'masih begadang ngoding ya? semangat!';
        else if (h < 12) timeText.textContent = 'selamat pagi! yok mulai belajar';
        else if (h < 17) timeText.textContent = 'siang-siang gini, waktunya ngoding!';
        else if (h < 21) timeText.textContent = 'sore menjelang malam, ayo lanjut belajar!';
        else timeText.textContent = 'udah malam nih, istirahat atau lanjut ngoding?';
    }
</script>
