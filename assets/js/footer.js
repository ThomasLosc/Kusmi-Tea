document.addEventListener('DOMContentLoaded', function() {
    const footerCategories = document.querySelectorAll('.footer__content__links__list__title');

    footerCategories.forEach(function(category) {
        category.addEventListener('click', function() {
            const list = category.parentElement;
            list.classList.toggle('active');
        });
    });
});