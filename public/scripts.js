window.addEventListener('DOMContentLoaded', event => {
    const sidebarToggle = document.querySelector('#sidebarToggle');
    const wrapper = document.querySelector('#wrapper');

    // Cek state terakhir dari localStorage
    if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        wrapper.classList.add('toggled');
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            wrapper.classList.toggle('toggled');

            // Simpan state di localStorage
            localStorage.setItem('sb|sidebar-toggle', wrapper.classList.contains('toggled'));
        });
    }
});
