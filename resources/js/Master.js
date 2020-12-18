import React from 'react';
import {connect} from 'react-redux'
import {BrowserRouter as Router, Route, Switch} from 'react-router-dom';

import Footer from "./components/layouts/Footer";
import Header from "./components/layouts/Header";
import Home from "./components/pages/Home";
import About from "./components/pages/About";
import Contact from "./components/pages/Contact";
import Login from "./components/pages/Login";
import Register from "./components/pages/Register";
import TermsAndConditions from "./components/pages/TermsAndConditions";
import PrivacyPolicy from "./components/pages/PrivacyPolicy";
import CategorySwitcher from "./components/pages/CategorySwitcher";
import ProductDetail from "./components/pages/ProductDetail";
import {
    getCategoryProducts,
    getMultipleCategoryProducts
} from "./redux/actions/CategoryActions";

import Cart from "./components/pages/Cart";
import ForgotPassword from "./components/pages/ForgotPassword";
import Checkout from "./components/pages/Checkout";
import Dashboard from "./components/pages/Dashboard";
import DiscountedProducts from "./components/pages/DiscountedProducts";
import {loadCarBrands} from "./redux/actions/CommonActions";
import FilterResult from "./components/pages/FilterResult";
import ThankYou from "./components/pages/ThankYou";
import Page from "./components/pages/Page";
import NewArrivals from "./components/pages/NewArrivals";
import FilterPage from "./components/pages/FilterPage";

class Master extends React.Component {
    constructor(props) {
        super(props);
    }

    componentDidMount = () => {
        this.props.loadCategories();
        this.props.loadCarBrandsWithModels();
        this.setUserData();
        this.setCartData();
        this.props.setPages(headerPages, footerPages);
    };

    setUserData = () => {
        let userData = localStorage.getItem('userData');
        if (userData) {
            userData = JSON.parse(userData);
            if (typeof userData === 'object')
                this.props.setUserData(userData);
        }
    };

    setCartData = () => {
        let cartData = localStorage.getItem('cartData');
        if (cartData) {
            cartData = JSON.parse(cartData);
            if (typeof cartData === 'object')
                this.props.setCartData(cartData);
        }
    };

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevProps.categories.length != this.props.categories.length) {
         let catIds = [];
            this.props.categories.forEach((cat) => {
                if (cat.products === undefined)
                    catIds.push(cat.id);
            });

            this.props.multipleCategoriesProducts(catIds);
        }
    }

    render() {
        return (
            <>
                <Router>
                    <Header />
                    {/*<Suspense fallback={<div>Loading.....</div>}>*/}
                        <Switch>
                            <Route exact path="/">
                                <Home />
                            </Route>

                            <Route exact path="/about-us">
                                <About />
                            </Route>

                          {/*  <Route exact path="/help">
                                <Help />
                            </Route>*/}

                            <Route exact path="/login">
                                <Login />
                            </Route>

                            <Route exact path="/register">
                                <Register />
                            </Route>
                            <Route exact path="/filter">
                                <FilterPage />
                            </Route>

                           {/* <Route exact path="/technical-support">
                                <TechnicalSupport />
                            </Route>*/}

                            {/*<Route exact path="/partners">
                                <Partners />
                            </Route>*/}

                            {/*<Route exact path="/track-order">
                                <TrackOrder />
                            </Route>
*/}
                            <Route exact path="/terms-conditions">
                                <TermsAndConditions />
                            </Route>

                            <Route exact path="/privacy-policy">
                                <PrivacyPolicy />
                            </Route>

                            {/*<Route exact path="/feedback">
                                <Feedback />
                            </Route>*/}

                            {/*<Route exact path="/faq">
                                <Faq />
                            </Route>*/}

                          {/*  <Route exact path="/returns">
                                <Returns />
                            </Route>*/}

                       {/*     <Route exact path="/payment-options">
                                <PaymentOptions />
                            </Route>*/}

                            <Route exact path="/forgot-password">
                                <ForgotPassword />
                            </Route>

                            <Route exact path="/cart">
                                <Cart />
                            </Route>

                            <Route exact path="/product/:productName">
                                <ProductDetail />
                            </Route>

                            <Route exact path="/page/contact-us">
                                <Contact />
                            </Route>

                            <Route exact path="/page/:pageName">
                                <Page />
                            </Route>

                            <Route exact path="/checkout">
                                <Checkout />
                            </Route>

                            <Route exact path="/thank-you">
                                <ThankYou />
                            </Route>

                            <Route exact path="/user/dashboard">
                                <Dashboard />
                            </Route>

                            <Route exact path="/discounted-products">
                                <DiscountedProducts />
                            </Route>
                            <Route exact path="/new-arrivals">
                                <NewArrivals />
                            </Route>

                            <Route exact path="/products-filter">
                                <FilterResult />
                            </Route>

                            {
                                this.props.categories.map((menu, key) => {
                                    return (
                                        <Route key={menu.id} path={`/${menu.slug}/:subCategory?`}>
                                            <CategorySwitcher />
                                        </Route>
                                    )
                                })
                            }
                        </Switch>
                    {/*</Suspense>*/}
                    <Footer />
                </Router>
            </>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        categories: state.categories.categories
    };
};

const mapDispatchToProps = (dispatch) => {
    return {
        loadCategories: () => dispatch({type: 'SET_CATEGORIES', categories: window.categories}),
        loadData: (category_id) => dispatch(getCategoryProducts(category_id)),
        multipleCategoriesProducts: (ids) => dispatch(getMultipleCategoryProducts(ids)),
        setUserData: (userData) => dispatch({type: 'SET_USER_DATA', payload: userData}),
        setCartData: (cartData) => dispatch({type: 'SET_CART_DATA', payload: cartData}),
        loadCarBrandsWithModels: () => dispatch(loadCarBrands()),
        setPages: (headerPages, footerPages) => dispatch({type: 'SET_PAGES', payload: {headerPages, footerPages}})
    };
};

export default connect(mapStateToProps, mapDispatchToProps)(Master);
