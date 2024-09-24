document.addEventListener('DOMContentLoaded', function() {
    const categoryItems = document.querySelectorAll('.category-item');

    categoryItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const checkbox = this.querySelector('input[type="checkbox"]');
            if (e.target.tagName !== 'INPUT') {
                checkbox.checked = !checkbox.checked;
            }
            this.classList.toggle('selected', checkbox.checked);
            console.log('Checkbox checked:', checkbox.checked);
        });
    });

    console.log('form.js loaded');
});
