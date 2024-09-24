document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const categoryItems = document.querySelectorAll('.category-item');
    const videos = document.querySelectorAll('.video-item');

    console.log('searchInput:', searchInput);
    console.log('categoryItems:', categoryItems);
    console.log('videos:', videos);

    function filterVideos() {
        if (!searchInput) {
            console.log('No search input found');
            return; // Guard clause if searchInput doesn't exist
        }
        const searchTerm = searchInput.value.toLowerCase();
        console.log('searchTerm:', searchTerm);

        const selectedCategories = Array.from(document.querySelectorAll('input[name="category"]:checked'))
            .map(cb => cb.nextElementSibling.textContent.toLowerCase().trim());

        console.log('selectedCategories:', selectedCategories);

        videos.forEach(function(video) {
            const title = video.getAttribute('data-title').toLowerCase();
            const videoCategories = video.getAttribute('data-categories').toLowerCase().split(',');

            console.log('video title:', title);
            console.log('video categories:', videoCategories);

            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = selectedCategories.length === 0 || 
                selectedCategories.some(cat => videoCategories.includes(cat.trim()));

            console.log('matchesSearch:', matchesSearch);
            console.log('matchesCategory:', matchesCategory);

            video.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
        });
    }

    if (categoryItems.length > 0) {
        categoryItems.forEach(item => {
            item.addEventListener('click', function(e) {
                console.log('Clicked on category item:', item);
                if (e.target.tagName !== 'INPUT') {
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    console.log('Checkbox checked:', checkbox.checked);
                }
                this.classList.toggle('selected', this.querySelector('input[type="checkbox"]').checked);
                filterVideos();
            });
        });
    } else {
        console.log('No category items found');
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            console.log('Search input changed:', searchInput.value);
            filterVideos();
        });
    } else {
        console.log('No search input found');
    }

    // Initial filter
    filterVideos();
});
