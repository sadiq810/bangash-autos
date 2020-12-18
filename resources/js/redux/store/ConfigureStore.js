import {createStore, combineReducers, applyMiddleware, compose} from 'redux';
import CategoriesReducer from "../reducers/CategoriesReducer";
import CartReducer from "../reducers/CartReducer";
import thunk from "redux-thunk";
import CommonReducer from "../reducers/CommonReducer";
import OrderReducer from "../reducers/OrderReducer";

const storeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

export default () => {
    return createStore(combineReducers({
        categories: CategoriesReducer,
        cart: CartReducer,
        common: CommonReducer,
        orders: OrderReducer
    }),
        storeEnhancers(applyMiddleware(thunk))
        );
};
