export default ( state = {orders: [], total: 0, loaded: 0}, actions) => {
    switch (actions.type) {
        case 'SET_USER_ORDERS_DATA':
            if (typeof actions.payload == "string")
                return {...state, orders: actions.payload};
            else
                return {...state, orders: [...state.orders, ...actions.payload.orders], total: actions.payload.total, loaded: actions.payload.loaded};
        default:
            return state;
    }
}
