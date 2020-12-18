import _ from 'lodash';

export default (state = {categories: [], mainMenu: [], otherMenu: []}, actions) => {
    switch (actions.type) {
        case 'SET_CATEGORIES':
            return {...state, categories: actions.categories, mainMenu: actions.categories.slice(0,9), otherMenu: actions.categories.slice(9)};
        case 'CATEGORY_PRODUCTS_LOADED':
            let category = state.categories.filter(cat => cat.id == actions.category_id).pop();
            if (category.products.loaded > actions.products.loaded)
                return {...state};

            let categories = [...state.categories.filter(cat => cat.id != actions.category_id), {...category, products: {total: actions.products.total, loaded: actions.products.loaded, products:_.uniqBy([...category.products.products, ...actions.products.products], 'id')}}];
            return {...state, categories: _.orderBy(categories, ['order'], ['asc'])};
        case 'SET_MULTIPLE_CATEGORY_DATA': {
            let categories = state.categories.map(cat => {
                if (actions.payload[cat.id])
                    return {...cat, products: actions.payload[cat.id]};
                return cat;
            });
            return {...state, categories: categories};
        }
        default:
            return state;
    }//..... end switch() .....//
};
