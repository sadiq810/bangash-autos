export const getCitiesList = () => {
    return function (dispatch) {
        return fetch(BaseUrl+'/api/cities')
            .then(response => response.json())
            .then(response => {
                dispatch({type: 'SET_CITIES_DATA', cities: response.data});
            })
    }
};

export const registerUser = (user = {}) => {
    return function(dispatch) {
        return axios.post(BaseUrl+'/api/user', user)
            .then(response => {
                if (!response.data.status)
                    dispatch({type: 'SET_USER_DATA', payload: {}});

                dispatch({type: 'SET_USER_DATA', payload: response.data.status ? response.data.data : response.data.message});
            }).catch(error => dispatch({type: 'SET_USER_DATA', payload: 'Internal Server Error Occurred, Please try later.'}));
    }
};

export const loginUser = (user = {}) => {
    return function(dispatch) {
        return axios.post(BaseUrl+'/api/user/login', user)
            .then(response => {
                dispatch({type: 'SET_USER_DATA_AFTER_CHECKOUT', payload: {}});
                dispatch({type: 'SET_USER_DATA', payload: response.data.status ? response.data.data : response.data.message})
            }).catch(error => dispatch({type: 'SET_USER_DATA', payload: 'Internal Server Error Occurred, Please try later.'}));
    }
};

export const placeOrderAndAdjustUserDetails = (user = {}, orderData = [], voucher = null) => {
    return function (dispatch) {
        return axios.post(BaseUrl+'/api/place-order-adjust-user', {user, orderData, voucher})
            .then(response => {
                dispatch({type: 'SET_USER_DATA_AFTER_CHECKOUT', payload: {}});
                dispatch({type: 'SET_USER_DATA_AFTER_CHECKOUT', payload: response.data.status ? response.data.data : response.data.message});
                if (response.data.status)
                    dispatch({type: 'RESET_CART'});
            }).catch(error => dispatch({type: 'SET_USER_DATA_AFTER_CHECKOUT', payload: 'Internal Server Error Occurred, Please try later.'}));
    }
};

export const loadSliderData = () => {
    return function(dispatch) {
        return axios.get(BaseUrl+'/api/slider')
            .then(response => {
                dispatch({type: 'SET_SLIDER_DATA', payload: response.data.status ? response.data.data : []})
            }).catch(error => dispatch({type: 'SET_SLIDER_DATA', payload: []}));
    }
};

export const loadCarBrands = () => {
    return function(dispatch) {
        return axios.get(BaseUrl+'/api/car-brands-models')
            .then(response => {
                dispatch({type: 'SET_CAR_BRANDS_DATA', payload: response.data.status ? response.data.data : []})
            }).catch(error => dispatch({type: 'SET_CAR_BRANDS_DATA', payload: []}));
    }
};

export const loadAds = () => {
    return function(dispatch) {
        return axios.get(BaseUrl+'/api/load-ads')
            .then(response => {
                dispatch({type: 'SET_ADS_DATA', payload: response.data.status ? response.data.data : []})
            }).catch(error => dispatch({type: 'SET_ADS_DATA', payload: []}));
    }
};
