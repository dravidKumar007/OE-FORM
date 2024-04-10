document.addEventListener('DOMContentLoaded', () => {
    const countdownElement = document.getElementById('countdown');

    function updateCountdown(targetDate) {
        const now = new Date();
        const timeDifference = targetDate - now;

        if (timeDifference <= 0) {
            countdownElement.textContent = 'Countdown Finished';
            window.open('index.php', '_self');
        } else {
            const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

            countdownElement.textContent = formatTime(days) + ':' + formatTime(hours) + ':' + formatTime(minutes) + ':' + formatTime(seconds);
            if (days === 0 && hours === 0 && minutes === 0 && seconds === 0) {
                stop();
            }
        }

        requestAnimationFrame(() => updateCountdown(targetDate));
    }

    function formatTime(time) {
        return time < 10 ? '0' + time : time;
    }

    function stop() {
        window.open('index.php', '_self');
    }

    // Make AJAX request to fetch target date
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_target_date.php');
    xhr.onload = function () {
        if (xhr.status === 200) {
            const targetDate = new Date(xhr.responseText);
            updateCountdown(targetDate);
        } else {
            console.error('Error fetching target date:', xhr.statusText);
        }
    };
    xhr.onerror = function () {
        console.error('Error fetching target date:', xhr.statusText);
    };
    xhr.send();

});

