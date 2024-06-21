document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');

    addToCartButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const productId = button.getAttribute('data-product-id');
            const quantity = button.getAttribute('data-quantity');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/add-to-cart/' + productId + '/' + quantity, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            showPopin();
                        } catch (error) {
                            console.error('Erreur lors de la conversion JSON :', error);
                        }
                    } else {
                        console.error('Erreur lors de l\'ajout au panier:', xhr.status);
                    }
                }
            };
            xhr.send();
        });
    });
    
    function showPopin() {
        const popin = document.querySelector('.product__add-to-cart__message');
        if (popin) {
            popin.style.display = 'block';
            setTimeout(() => {
                popin.style.display = 'none';
            }, 3000);
        }
    }
});