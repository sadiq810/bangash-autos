export default ( state = {cities: [], user: {}, slider: [], brands: [], globalFilter: {}, pages: {headerPages: [], footerPages: []}, ads: []}, actions) => {
    switch (actions.type) {
        case 'SET_CITIES_DATA':
            return {...state, cities: actions.cities};
        case 'SET_USER_DATA':
            if (typeof actions.payload === 'object')
                localStorage.setItem('userData', JSON.stringify(actions.payload));

            return {...state, user: actions.payload};

        case 'SET_USER_DATA_AFTER_CHECKOUT':

            if (typeof actions.payload === 'object')
                localStorage.setItem('userData', JSON.stringify(actions.payload));

            return {...state, user: actions.payload};
        case 'SET_SLIDER_DATA':
            return {...state, slider: actions.payload};
        case 'SET_CAR_BRANDS_DATA':
            return {...state, brands: actions.payload};
        case 'SET_GLOBAL_FILTER_DATA': {
            return {...state, globalFilter : actions.payload};
        }
        case 'SET_PAGES':
            return {...state, pages: {headerPages: actions.payload.headerPages, footerPages: actions.payload.footerPages}}

        case 'SET_ADS_DATA':
            return {...state, ads: actions.payload};
        default:
            return state;
    }
}
