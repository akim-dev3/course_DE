// слайдер на главной
(function () {
    var slider = document.getElementById('slider');
    if (!slider) return;

    var track = slider.querySelector('.slider-track');
    var total = track.children.length;
    var pos = 0;
    var timer;

    function show(i) {
        pos = (i + total) % total;
        track.style.transform = 'translateX(-' + pos * 100 + '%)';
    }

    function start() {
        timer = setInterval(function () { show(pos + 1); }, 3000);
    }

    function go(delta) {
        show(pos + delta);
        clearInterval(timer); start();
    }

    document.getElementById('next').onclick = function () { go(1); };
    document.getElementById('prev').onclick = function () { go(-1); };

    start();
})();

// alert сам пропадает
setTimeout(function () {
    var a = document.querySelector('.alert');
    if (a) { a.style.transition = 'opacity .4s'; a.style.opacity = '0'; setTimeout(function(){ a.remove(); }, 400); }
}, 3000);

// маска телефона 8(999)123-45-67
var phone = document.querySelector('input[name="phone"]');
if (phone) {
    phone.addEventListener('input', function () {
        var d = this.value.replace(/\D/g, '').substring(0, 11);
        if (d.length && d[0] !== '8') d = '8' + d.substring(0, 10);
        var r = '';
        if (d.length > 0) r = d.substring(0, 1);
        if (d.length > 1) r += '(' + d.substring(1, 4);
        if (d.length >= 4) r += ')' + d.substring(4, 7);
        if (d.length >= 7) r += '-' + d.substring(7, 9);
        if (d.length >= 9) r += '-' + d.substring(9, 11);
        this.value = r;
    });
}

// маска даты
var dateInput = document.querySelector('input[name="start_date"]');
if (dateInput) {
    dateInput.addEventListener('input', function () {
        var d = this.value.replace(/\D/g, '').substring(0, 8);
        var r = d.substring(0, 2);
        if (d.length > 2) r += '.' + d.substring(2, 4);
        if (d.length > 4) r += '.' + d.substring(4, 8);
        this.value = r;
    });
}
