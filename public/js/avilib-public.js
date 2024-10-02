(function($) {
    'use strict';

    $(document).ready(function() {
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

        // Video modal
        // Abrir el modal al hacer clic en la miniatura
        $('.avilib-video-thumbnail').click(function() {
            var videoUrl = $(this).data('video-url');
            var iframe = $('<iframe>', {
                src: videoUrl,
                frameborder: '0',
                allow: 'autoplay; fullscreen',
                allowfullscreen: ''
            });
            $('#avilib-modal-video-container').html(iframe);
            $('#avilib-video-modal').fadeIn();
            $('body').css('overflow', 'hidden');
        });

        // Cerrar el modal
        $('.avilib-close, #avilib-video-modal').click(function(e) {
            if (e.target !== this) return;
            $('#avilib-video-modal').fadeOut();
            $('#avilib-modal-video-container').empty();
            $('body').css('overflow', 'auto');
        });

        // Manejar la orientación del dispositivo
        $(window).on('orientationchange', function() {
            if ($('#avilib-video-modal').is(':visible')) {
                setTimeout(function() {
                    var containerWidth = $('#avilib-modal-video-container').width();
                    var containerHeight = containerWidth * (9/16); // Mantener relación de aspecto 16:9
                    $('#avilib-modal-video-container').css('height', containerHeight);
                }, 100);
            }
        });

        $(window).on('resize orientationchange', function() {
            if ($('#avilib-video-modal').is(':visible')) {
                var windowWidth = $(window).width();
                var windowHeight = $(window).height();
                var aspectRatio = 16/9;
                
                var videoWidth, videoHeight;
                if (windowWidth / windowHeight > aspectRatio) {
                    videoHeight = windowHeight * 0.9;
                    videoWidth = videoHeight * aspectRatio;
                } else {
                    videoWidth = windowWidth * 0.9;
                    videoHeight = videoWidth / aspectRatio;
                }
                
                $('#avilib-modal-video-container').css({
                    'width': videoWidth + 'px',
                    'height': videoHeight + 'px'
                });
            }
        });
        
    });

})(jQuery);