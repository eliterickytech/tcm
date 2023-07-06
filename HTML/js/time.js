$(document).ready(function () {
    var duration = 60 * 1; // Seconds convert
    display = document.querySelector('#timer'); // select object time
    insert_code = document.querySelector('#insert_code'); // select object time
    startTimer(duration, display, insert_code); // init time
});

function startTimer(duration, display, insert_code) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.textContent = "Your code should arrive yout e-mail at 00:" + seconds + "s";
        if (--timer < 0) {
            timer = duration;
            display.remove();
            insert_code.textContent = "Please, verify your e-mail inbox. We sent you a 6 digit code. Insert it here.";
        }
    }, 1000);
}    