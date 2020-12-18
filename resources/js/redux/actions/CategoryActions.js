export const getCategoryProducts = (category_id, skip = 0) => {
    return function (dispatch) {
        return fetch(   BaseUrl+"/api/products/"+category_id+'?skip='+skip)
            .then(response => response.json())
            .then(json => {
                dispatch({ type: "CATEGORY_PRODUCTS_LOADED", products: json.data, category_id });
            });
    }
};

export const getMultipleCategoryProducts = (IDs) => {
    return function (dispatch) {
        return axios.post(BaseUrl+'/api/categories-products', {'ids' : IDs})
            .then(response => dispatch({type: 'SET_MULTIPLE_CATEGORY_DATA', payload: response.data.data}))
            .catch(error => dispatch({type: 'SET_MULTIPLE_CATEGORY_DATA', payload: []}));
    }
};
