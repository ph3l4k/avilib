(function($) {
    'use strict';

    $(document).ready(function() {
        // Video request form
        $('.avilib-form').on('submit', function(e) {
            e.preventDefault();
            // Aquí iría la lógica para enviar el formulario mediante AJAX
        });

        // Video list search
        $('#avilib-search').on('input', filterVideos);

        function filterVideos() {
            var searchTerm = $('#avilib-search').val().toLowerCase();

            $('.avilib-video-item').each(function() {
                var $item = $(this);
                var title = $item.data('title').toLowerCase();

                var matchesSearch = title.includes(searchTerm);

                $item.toggle(matchesSearch);
            });
        }
    });

})(jQuery);