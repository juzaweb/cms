function addToCart(variantId, quantity) {
    let res = $.ajax({
        type: 'POST',
        url: jwdata.base_url + '/ajax/cart/add-to-cart',
        dataType: 'json',
        async: false,
        data: {
            variant_id: variantId,
            quantity: quantity,
            _token: $('meta[name="csrf-token"]').attr('content'),
        }
    }).responseText;
    
    return JSON.parse(res);
}

function removeItemCart(variantId) {
    let res = $.ajax({
        type: 'DELETE',
        url: jwdata.base_url + '/ajax/cart/remove-item',
        dataType: 'json',
        async: false,
        data: {
            variant_id: variantId,
            quantity: quantity,
        }
    }).responseText;
    
    return JSON.parse(res);
}
