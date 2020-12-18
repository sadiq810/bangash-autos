import {saveCartToLocalStorage} from "../actions/CartActions";

export default (state = {cart: []}, actions) => {
    switch (actions.type) {
        case 'ADD_PRODUCT_TO_CART': {
            let product = state.cart.filter(prd => prd.id == actions.payload.id).pop();
            let order = actions.payload;
            let orderQuantity = order.orderQuantity;
            let cart = state.cart;

            if (product) {
                cart = cart.filter(prd => prd.id != order.id);
                orderQuantity = orderQuantity + product.orderQuantity;
            }//..... end if() .....//

            let cartData = [...cart, {...order, orderQuantity}];

            saveCartToLocalStorage(cartData);

            return {...state, cart: cartData};
        }
        case 'INCREMENT_QUANTITY_IN_CART': {
            let cart = state.cart.map((prd) => {
                if (prd.id == actions.payload.id && prd.orderQuantity < 100)
                    prd.orderQuantity = prd.orderQuantity + 1;

                return prd;
            });

            let cartData = [...cart];
            saveCartToLocalStorage(cartData);

            return {...state, cart: cartData};
        }
        case 'DECREMENT_QUANTITY_IN_CART': {
            let cart = state.cart.map((prd) => {
                if (prd.id == actions.payload.id && prd.orderQuantity > 1)
                    prd.orderQuantity = prd.orderQuantity - 1;

                return prd;
            });

            let cartData = [...cart];
            saveCartToLocalStorage(cartData);
            return {...state, cart: cartData};
        }
        case 'REMOVE_PRODUCT_FROM_CART': {

            let cartData = state.cart.filter(prd => prd.id !== actions.payload.id);
            saveCartToLocalStorage(cartData);

            return {...state, cart: cartData};
        }

        case 'RESET_CART': {
            saveCartToLocalStorage([]);
            return {...state, cart: []};
        }

        case 'SET_CART_DATA': {
            return {...state, cart: actions.payload};
        }
        default:
            return state;
    }
};
