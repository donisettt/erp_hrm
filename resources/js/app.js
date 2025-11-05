import 'bootstrap';

const sidebarToggle = document.getElementById('sidebar-toggle');
if (sidebarToggle) {
    sidebarToggle.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Toggle class di <body>
        document.body.classList.toggle('sidebar-collapsed');
    });
}