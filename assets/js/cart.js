const quantitySelects = document.querySelectorAll('.quantity-select');

    quantitySelects.forEach(function(select) {
        select.addEventListener('change', function() {
            const productId = select.getAttribute('data-product-id');
            const newQuantity = select.value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/update-cart/' + productId, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            updateCartUI(productId, response.productTotal, response.cartTotal, response.shippingCost);
                        } catch (error) {
                            console.error('Erreur lors de la conversion JSON :', error);
                        }
                    } else {
                        console.error('Erreur lors de la mise à jour du panier:', xhr.status);
                    }
                }
            };
            xhr.send('quantity=' + newQuantity);
        });
    });

    function updateCartUI(productId, productTotal, cartTotal, shippingCost) {
        const productItem = document.querySelector('.cart__content__products__item[data-product-id="' + productId + '"]');
        if (productItem) {
            const totalElement = productItem.querySelector('#product-total-amount');
            if (totalElement) {
                totalElement.textContent = productTotal.toFixed(2) + ' €';
            }
        }

        const totalAmountElement = document.querySelector('#total-amount');
        if (totalAmountElement) {
            totalAmountElement.textContent = (cartTotal + shippingCost).toFixed(2) + ' €';
        }

        const shippingElement = document.querySelector('#shipping-cost');
        if (shippingElement) {
            if (shippingCost > 0) {
                shippingElement.textContent = shippingCost.toFixed(2) + ' €';
            } else {
                shippingElement.textContent = 'GRATUIT';
            }
        }
    }