import React, {Component} from 'react'
import {Link} from "react-router-dom";
import {connect} from "react-redux";
import {removeProductFromCart} from "../../redux/actions/CartActions";

class Footer extends Component{
    constructor(props) {
        super(props);
    }//.... end of constructor() .....//

    render() {
        return (
            <>
                <div id="contentDup">
                    <div id="so-groups" className="right so-groups-sticky hidden-xs" style={{top: '196px'}}>
                        <a className="sticky-categories" data-target="popup" data-popup="#popup-categories">
                            <span>Categories</span>
                            <i className="fa fa-align-justify"/>
                        </a>
                        <a className="sticky-mycart" data-target="popup" data-popup="#popup-mycart">
                            <span>Cart</span>
                            <i className="fa fa-shopping-cart"/>
                        </a>
                        <a className="sticky-backtop" data-target="scroll" data-scroll="html">
                            <span>Go to Top</span>
                            <i className="fa fa-angle-double-up"/>
                        </a>

                        <div className="popup popup-categories popup-hidden" id="popup-categories">
                            <div className="popup-screen">
                                <div className="popup-position">
                                    <div className="popup-container popup-small">
                                        <div className="popup-header">
                                            <span><i className="fa fa-align-justify"/>All Categories</span>
                                            <a className="popup-close" data-target="popup-close" data-popup-close="#popup-categories">×</a>
                                        </div>
                                        <div className="popup-content">
                                            <div className="nav-secondary">
                                                <ul>
                                                    {
                                                        this.props.categories.map((menu, key) => {
                                                            if (menu.sub_categories.length == 0)
                                                                return (
                                                                    <li key={menu.id}>
                                                                        <Link to={`/${menu.slug}`}>
                                                                            <i className="fa fa-chevron-down nav-arrow"/>{ menu.title }
                                                                        </Link>
                                                                    </li>
                                                                );
                                                            else
                                                                return (
                                                                    <li key={menu.id}>
                                                                        <span className="nav-action">
                                                                          <i className="fa fa-plus more"/>
                                                                          <i className="fa fa-minus less"/>
                                                                        </span>
                                                                        <Link to={`/${menu.slug}`}>
                                                                            <i className="fa fa-chevron-down nav-arrow"/>{ menu.title }
                                                                        </Link>
                                                                        <ul className="level-2">
                                                                            {menu.sub_categories.map(smenu => {
                                                                                return (
                                                                                    <li key={smenu.id}>
                                                                                        <Link to={`/${menu.slug}/${smenu.slug}`}>
                                                                                            <i className="fa fa-chevron-right flip nav-arrow"/>{ smenu.title }</Link>
                                                                                    </li>
                                                                                );
                                                                            })}
                                                                        </ul>
                                                                    </li>
                                                                );
                                                        })
                                                    }
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="popup popup-mycart popup-hidden" id="popup-mycart">
                            <div className="popup-screen">
                                <div className="popup-position">
                                    <div className="popup-container popup-small">
                                        <div className="popup-html">
                                            <div className="popup-header">
                                                <span><i className="fa fa-shopping-cart"/>Shopping Cart</span>
                                                <a className="popup-close" data-target="popup-close" data-popup-close="#popup-mycart">×</a>
                                            </div>
                                            <div className="popup-content">
                                                <div className="cart-header">
                                                    <div className="notification gray">
                                                        <table className="table table-striped" style={{ marginBottom: '10px'}}>
                                                            <tbody>
                                                            {this.props.cart.map(prd => {
                                                                return (
                                                                    <tr key={prd.id}>
                                                                        <td className="text-center size-img-cart">
                                                                            <a href="#">
                                                                                <img className="img-thumbnail lazyautosizes lazyloaded" data-sizes="auto" src={`${BaseUrl}/uploads/thumbs/${prd.image[0]}`} alt={ prd.title } title={ prd.title } sizes="57px"/>
                                                                            </a>
                                                                        </td>
                                                                        <td className="text-left">
                                                                            <a href="#">{ prd.title }</a> <br/>
                                                                            {prd.selectedColor.name && (
                                                                                <>- <small>Select {prd.selectedColor.name}</small></>
                                                                            )}

                                                                        </td>
                                                                        <td className="text-right">x {prd.orderQuantity}</td>
                                                                        <td className="text-right">Rs {prd.final_price}</td>
                                                                        <td className="text-center">
                                                                            <button type="button" title="Remove" className="btn btn-danger btn-xs" onClick={() => this.props.removeProduct(prd.id)}>
                                                                                <i className="fa fa-trash-o"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                );
                                                            })}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer className="footer-container typefooter-1">
                    <div className="footer-main collapse description-has-toggle" id="collapse-footer">
                        <div className="so-page-builder">
                            <div className="container page-builder-ltr">
                                <div className="row row_560y  footer-middle ">
                                    <div className="col-lg-4 col-md-4 col-sm-12 col-xs-12 col_i76p  col-style">
                                        <div className="infos-footer">
                                            <ul>
                                                <li className="adres" id={'addressLi'}></li>
                                                <li className="phone" id={'phoneLi'}></li>
                                                <li className="mail" id={'mailLi'}></li>
                                            </ul>
                                        </div>
                                        <div className="box-footer socical" id={'socialIconsContainer'}>
                                            <div className="module clearfix">
                                                <h3 className="title">JOIN US:</h3>
                                                <div className="modcontent">
                                                    <ul className="socials" id={'socialsList'}>
                                                        <li className="facebook" id={'fbLink'} style={{display: 'none'}}>
                                                            <a className="_blank" href="#" target="_blank"><i className="fa fa-facebook" /></a>
                                                        </li>
                                                        <li className="twitter" id={'twLink'} style={{display: 'none'}}>
                                                            <a className="_blank" href="#" target="_blank"><i className="fa fa-twitter" /></a>
                                                        </li>
                                                        <li className="pinterest" id={'pTLink'} style={{display: 'none'}}>
                                                            <a className="_blank" href="#" target="_blank"><i className="fa fa-pinterest" /></a>
                                                        </li>
                                                        <li className="youtube_play" id={'yTLink'} style={{display: 'none'}}>
                                                            <a className="_blank" href="#" target="_blank"><i className="fa fa-youtube-play" /></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-3 col-md-3 col-sm-4 col-xs-12 col_njm1  col-style">
                                        <div className="box-information box-footer">
                                            <div className="module clearfix">
                                                <h3 className="title">Information</h3>
                                                <div className="modcontent">
                                                    <ul className="menu">
                                                        {this.props.pages.map(page => {
                                                            return <li key={page.slug}>
                                                                <Link to={'/page/'+page.slug}> { page.title }</Link>
                                                            </li>
                                                        })}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="col-lg-5 col-md-5 col-sm-12 col-xs-12 col_5rbh  col-style">
                                        <div className="module newsletter-footer1">
                                            <div className="newsletter" style={{width: '100%', backgroundColor: '#fff'}}>
                                                <iframe
                                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13225.833469257126!2d71.53413978169844!3d34.03211143978064!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38d916469d211da3%3A0x52e52a4adb6abe0b!2sTahkal%20Payan%2C%20Peshawar%2C%20Khyber%20Pakhtunkhwa%2C%20Pakistan!5e0!3m2!1sen!2s!4v1577034705465!5m2!1sen!2s"
                                                    width="600" height="300" frameBorder="0" style={{border: "0"}} allowFullScreen=""></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="footer-bottom ">
                        <div className="container">
                            <div className="row">
                                <div className="copyright col-sm-12">
                                    ©BangashAutos 2020.
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        categories: state.categories.categories,
        cart: state.cart.cart,
        pages: state.common.pages.footerPages
    }
};

const mapPropsToActions = (dispatch) => {
    return {
        removeProduct:     (id) => dispatch(removeProductFromCart(id))
    };
};

export default connect(mapStateToProps, mapPropsToActions)(Footer);
