import React, {Component} from 'react';
import {Link} from "react-router-dom";
import {connect} from 'react-redux';
import HeaderCartComponent from "./HeaderCartComponent";
import SearchComponent from "./SearchComponent";

class Header extends Component {
    constructor(props) {
        super(props);
        this.state = {
            showAll: false,
            itemsToShow: 11
        };
    }//..... end of constructor() .....//

    toggleCategories = () => {
        this.setState(prevState => ({showAll: !prevState.showAll}));
    };

    render() {
        return (
            <header id="header" className=" variant typeheader-2">
                <div className="header-top hidden-compact">
                    <div className="container">
                        <div className="row">
                            <div
                                className="header-top-left hidden-xs hidden-sm col-lg-6 col-md-4 col-sm-12 col-xs-12">
                                <ul className="top-link list-inline">
                                    <li className="account" id="my_account">
                                        {
                                            typeof this.props.user === 'object' && Object.keys(this.props.user).length > 0 &&
                                            <Link to={'/user/dashboard'}>
                                                <span className="hidden-xs">My Account </span>
                                            </Link>
                                        }
                                    </li>
                                </ul>
                            </div>
                            <div className="header-top-right collapsed-block col-lg-6 col-md-8 col-sm-12 col-xs-12">
                                <ul className="top-link list-inline lang-curr">
                                    <li className="login">
                                        {
                                            typeof this.props.user === 'object' && Object.keys(this.props.user).length > 0 &&
                                            <span className="hidden-xs">
                                                <i className="fa fa-user-o" aria-hidden="true"/>Hello. {this.props.user.fname+' '+this.props.user.lname}
                                            </span>
                                        }

                                        {
                                            (typeof this.props.user === 'string' || (typeof this.props.user === 'object' && Object.keys(this.props.user).length == 0)) &&
                                            <Link to="/login">Login</Link>
                                        }
                                    </li>

                                    <li className="register">
                                        {
                                            (typeof this.props.user === 'string' || (typeof this.props.user === 'object' && Object.keys(this.props.user).length == 0)) &&
                                            <Link to="/register">Register</Link>
                                        }

                                        {
                                            typeof this.props.user === 'object' && Object.keys(this.props.user).length > 0 &&
                                            <Link to={'/'} onClick={() => {
                                                localStorage.removeItem('userData');
                                                this.props.dispatch({type: 'RESET_CART'});
                                                this.props.dispatch({type: 'SET_USER_DATA', payload: {}});
                                            }}>Logout</Link>
                                        }
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="header-middle ">
                    <div className="container">
                        <div className="row">
                            <div className="navbar-logo col-lg-3 col-md-2 col-sm-4 col-xs-5">
                                <div className="">
                                    <Link to={'/'}>
                                        <img className="lazyload" data-sizes="auto" src={BaseUrl+'/assets/frontend/image/logo1.png'} title="GulAutos" alt="GulAutos" style={{height: '70px'}}/>
                                    </Link>
                                </div>
                            </div>
                            <div className="main-menu col-lg-6 col-md-7 col-sm-4">
                                <div className="responsive megamenu-style-dev">
                                    <nav className="navbar-default">
                                        <div className=" container-megamenu   horizontal ">
                                            <div className="navbar-header">
                                                <button type="button" id="show-megamenu" data-toggle="collapse" className="navbar-toggle">
                                                    <span className="icon-bar"/>
                                                    <span className="icon-bar"/>
                                                    <span className="icon-bar"/>
                                                </button>
                                            </div>
                                            <div className="megamenu-wrapper">
                                                <span id="remove-megamenu" className="fa fa-times"/>
                                                <div className="megamenu-pattern">
                                                    <div className="container">
                                                        <ul className="megamenu" data-transition="slide" data-animationtime={500} id={'topHeaderMenu'}>
                                                            <li className="home">
                                                                <Link to={'/'}><span><strong> Home </strong></span></Link>
                                                            </li>
                                                            {this.props.pages.map(page => {
                                                                return <li key={page.slug}>
                                                                    <Link to={'/page/'+page.slug}><span><strong> { page.title } </strong></span></Link>
                                                                </li>
                                                            })}
                                                            <li>
                                                                <Link to={'/page/contact-us'}><span><strong> Contact Us </strong></span></Link>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <HeaderCartComponent />
                        </div>
                    </div>
                </div>
                <div className="header-bottom hidden-compact">
                    <div className="container" style={{width: '99%'}}>
                        <div className="row">
                            <div className="bottom1 menu-vertical col-lg-3 col-md-3 col-sm-3">
                                <div className="responsive megamenu-style-dev">
                                    <div className="so-vertical-menu no-gutter">
                                        <nav className="navbar-default">
                                            <div className="container-megamenu container vertical">
                                                <div id="menuHeading">
                                                    <div className="megamenuToogle-wrapper">
                                                        <div className="megamenuToogle-pattern">
                                                            <div className="container"><div><span/><span/><span/></div>Shop Categories</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="navbar-header">
                                                    <button type="button" id="show-verticalmenu" data-toggle="collapse" className="navbar-toggle">
                                                        <i className="fa fa-bars"/>
                                                        <span className="hidden-xs hidden-sm">Shop Categories</span>
                                                    </button>
                                                </div>
                                                <div className="vertical-wrapper">
                                                    <span id="remove-verticalmenu" className="fa fa-times"/>
                                                    <div className="megamenu-pattern">
                                                        <div className="container">
                                                            <ul className="megamenu" data-transition="slide" data-animationtime={300}>

                                                                {
                                                                    this.props.categories.map((menu, key) => {
                                                                        if (menu.sub_categories.length == 0)
                                                                            return (
                                                                                <li  key={menu.id}  className="item-vertical" style={{display: !this.state.showAll && key > this.state.itemsToShow ? 'none' : ''}}>
                                                                                    <p className="close-menu"/>
                                                                                    <Link to={`/${menu.slug}`} className="clearfix">
                                                                                        <span>
                                                                                            <strong>{ menu.title }</strong>
                                                                                        </span>
                                                                                    </Link>
                                                                                </li>
                                                                            );
                                                                        else
                                                                        return (
                                                                            <li  key={menu.id}  className="item-vertical  item-style2 with-sub-menu hover"  style={{display: !this.state.showAll && key > this.state.itemsToShow ? 'none' : ''}}>
                                                                                <p className="close-menu"/>
                                                                                <Link to={`/${menu.slug}`} className="clearfix">
                                                                                    <span><strong>{ menu.title }</strong></span>
                                                                                    <b className="fa fa-angle-right"/>
                                                                                </Link>
                                                                                <div className="sub-menu" style={{width: '335px'}}>
                                                                                    <div className="content">
                                                                                        <div className="row">
                                                                                            <div className="col-sm-12">
                                                                                                <ul className="subcategory ">
                                                                                                    <li>
                                                                                                        <Link to={`/${menu.slug}`} className="title-submenu ">{ menu.title }</Link>
                                                                                                        <div className="row">
                                                                                                            <div className="col-sm-12 hover-menu">
                                                                                                                <div className="menu">
                                                                                                                    <ul>
                                                                                                                        {menu.sub_categories.map(smenu => {
                                                                                                                            return (
                                                                                                                                <li key={smenu.id}>
                                                                                                                                    <Link to={`/${menu.slug}/${smenu.slug}`} className="main-menu">{ smenu.title }</Link>
                                                                                                                                </li>
                                                                                                                            );
                                                                                                                        })}
                                                                                                                    </ul>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        );
                                                                    })
                                                                }
                                                                {
                                                                    this.props.categories.length > 9 &&  <li className="loadmore" onClick={this.toggleCategories}>
                                                                        <i className={this.state.showAll ? "fa fa-minus-square" : "fa fa-plus-square"}></i>
                                                                        <span className="more-view">More Categories</span>
                                                                    </li>
                                                                }

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <SearchComponent />
                            <div className="telephone col-lg-2 hidden-xs" id={'phoneDiv'}></div>
                        </div>
                    </div>
                </div>
            </header>
        );
    }//..... end of render() .....//
}//..... end of Header.

const mapStateToProps = (state) => {
    return {
        categories: state.categories.categories,
        cart: state.cart.cart,
        totalItemsInCart: state.cart.cart.reduce((total, prd) => total + prd.orderQuantity, 0),
        subTotal: state.cart.cart.reduce((total, prd) => total + (prd.orderQuantity * prd.sale_price), 0),
        user: state.common.user,
        pages: state.common.pages.headerPages
    }
};

export default connect(mapStateToProps)(Header);
