//javascript
$(document).ready(function() {
    // Set the interval to change slides every 5 seconds (5000 milliseconds)
    setInterval(function() {
        $('.carousel').carousel('next');
    }, 5000);
});