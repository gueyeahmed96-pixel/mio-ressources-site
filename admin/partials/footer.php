        </div></main></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', event => {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const adminWrapper = document.getElementById('admin-wrapper');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            adminWrapper.classList.toggle('toggled');
        });
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', event => {
            adminWrapper.classList.remove('toggled');
        });
    }
    
    // Le code pour le mode sombre/clair a été retiré, car le thème "Rocker" est un thème sombre fixe.
    
    const notificationBell = document.getElementById('notificationBell');
    if (notificationBell) {
        notificationBell.addEventListener('show.bs.dropdown', function () {
            const badge = this.querySelector('.badge');
            if (!badge) return;
            fetch('mark-notifications-read.php', { method: 'POST' }).then(response => { if (response.ok) { badge.style.display = 'none'; } });
        });
    }
    
    // Fermer le sidebar quand on clique sur un lien en mode mobile
    const sidebarLinks = document.querySelectorAll('#sidebar-wrapper .nav-link');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                adminWrapper.classList.remove('toggled');
            }
        });
    });
    
    // Fermer le sidebar quand on redimensionne la fenêtre au-dessus du breakpoint
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            adminWrapper.classList.remove('toggled');
        }
    });
});
</script>
</body></html>