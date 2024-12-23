// untuk memunculkan sidebar ketika layar lebih kecil
$(function() {
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar, #content').toggleClass('active');
    });
});