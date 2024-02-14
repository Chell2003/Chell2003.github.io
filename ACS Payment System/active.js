document.addEventListener('DOMContentLoaded', function () {
    var dashboardLink = document.querySelector('a[href="index.html"]');
    if (dashboardLink) {
        dashboardLink.classList.add('active');
    }
});
