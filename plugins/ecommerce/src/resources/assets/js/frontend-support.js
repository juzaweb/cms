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
            variant_id: variantId
        }
    }).responseText;
    
    return JSON.parse(res);
}

function removeCart() {
    let res = $.ajax({
        type: 'DELETE',
        url: jwdata.base_url + '/ajax/cart/remove',
        dataType: 'json',
        async: false,
        data: {}
    }).responseText;
    
    return JSON.parse(res);
}
