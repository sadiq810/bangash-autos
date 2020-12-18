export const loadOrders = (hash, skip) => {
    return function(dispatch) {
        return axios.post(BaseUrl+'/api/user/orders', {hash, skip})
            .then(response => {
                dispatch({type: 'SET_USER_ORDERS_DATA', payload: response.data.status ? response.data.data : response.data.message})
            }).catch(error => dispatch({type: 'SET_USER_ORDERS_DATA', payload: 'Internal Server Error Occurred, Please try later.'}));
    }
};
