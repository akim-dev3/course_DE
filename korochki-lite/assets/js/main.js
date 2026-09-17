// слайдер на главной
(function () {
    var slider = document.getElementById('slider');
    if (!slider) return;

    var track = slider.querySelector('.slider-track');
    var total = track.children.length;
    var pos = 0;

    function show(i) {
        pos = (i + total) % total;
        track.style.transform = 'translateX(-' + pos * 100 + '%)';
    }

    document.getElementById('next').onclick = function () { show(pos + 1); };
    document.getElementById('prev').onclick = function () { show(pos - 1); };

    setInterval(function () { show(pos + 1); }, 3000);
})();