(function($) {
    'use strict';

    $(document).ready(function() {
        // Interceptar el clic en el enlace de desactivación del plugin
        $('body').on('click', '[data-slug="avilib"] .deactivate a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            if (confirm('¿Estás seguro de que quieres desinstalar el plugin Avilib? Todos los datos relacionados con la biblioteca de videos serán eliminados permanentemente.')) {
                window.location.href = url;
            }
        });
    });

})(jQuery);