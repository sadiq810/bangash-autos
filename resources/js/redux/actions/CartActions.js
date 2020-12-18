export const addProductToCart = (prd = {}, quantity, selectedColor = {}) => {
    return {type: 'ADD_PRODUCT_TO_CART', payload: {...prd, orderQuantity: quantity, selectedColor}}
};

export const incrementQuantityInCart = (id) => {
    return {type: 'INCREMENT_QUANTITY_IN_CART', payload:{id}};
};

export const decrementQuantityInCart = (id) => {
    return {type: 'DECREMENT_QUANTITY_IN_CART', payload:{id}};
};

export const removeProductFromCart = (id) => {
    return {type: 'REMOVE_PRODUCT_FROM_CART', payload: {id}};
};

export const saveCartToLocalStorage = (cart) => {
    localStorage.setItem('cartData', JSON.stringify(cart));
};
