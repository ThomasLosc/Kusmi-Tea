document.addEventListener('DOMContentLoaded', function() {
    if(window.matchMedia('(max-width: 960px)').matches) {
        const openMenuBtn = document.querySelector('#btn-menu-open');
        const closeMenuBtn = document.querySelector('#btn-menu-close');
        const menu = document.querySelector('.header__menu');
        const backBtns = document.querySelectorAll('.header__menu__back');
        const menuItems = document.querySelectorAll('.header__menu__categories__item-children');
    
        openMenuBtn.addEventListener('click', function() {
            menu.style.display = 'block';
        });
    
        closeMenuBtn.addEventListener('click', function() {
            menu.style.display = 'none';
        });
    
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const dropdown = this.querySelector('.header__menu__categories__item__dropdown');
                dropdown.style.display = "grid";
            });
        });
    
        backBtns.forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                this.closest('.header__menu__categories__item__dropdown').style.display = "none";
            });
        });   
    }
});