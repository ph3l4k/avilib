(function($) {
    'use strict';

    $(document).ready(function() {
        // Video request form
        $('.avilib-form').on('submit', function(e) {
            e.preventDefault();
            // Aquí iría la lógica para enviar el formulario mediante AJAX
        });

        // Video list search and filter
        $('#avilib-search').on('input', filterVideos);
        $('.avilib-category-filter input').on('change', filterVideos);

        function filterVideos() {
            var searchTerm = $('#avilib-search').val().toLowerCase();
            var selectedCategories = $('.avilib-category-filter input:checked').map(function() {
                return $(this).val();
            }).get();

            $('.avilib-video-item').each(function() {
                var $item = $(this);
                var title = $item.data('title').toLowerCase();
                var categories = $item.data('categories').split(',');

                var matchesSearch = title.includes(searchTerm);
                var matchesCategory = selectedCategories.length === 0 || 
                    selectedCategories.some(function(cat) {
                        return categories.includes(cat);
                    });

                $item.toggle(matchesSearch && matchesCategory);
            });
        }
    });

})(jQuery);