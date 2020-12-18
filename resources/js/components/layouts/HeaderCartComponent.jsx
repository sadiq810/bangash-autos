import React, {Component} from 'react';
import {connect} from "react-redux";
import {Link} from 'react-router-dom';
import {removeProductFromCart} from "../../redux/actions/CartActions";
import {selectFinalPriceWithOptionSelected} from "../../redux/selectors/CategorySelector";

class HeaderCartComponent extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    render() {
        return (
            <div className="shopping_cart">
                <div id="cart" className="btn-shopping-cart">
                    <Link to={'/cart'} className="btn-group top_cart dropdown-toggle" data-toggle="dropdown">
                        <div className="shopcart">
                            <span className="icon-c"><i className="fa fa-shopping-bag"/></span>
                            <div className="shopcart-inner">
                                <p className="text-shopping-cart">My cart</p>
                                <span className="total-shopping-cart cart-total-full">
                                    <span className="items_cart">{ this.props.totalItemsInCart }</span>
                                    <span className="items_cart2"> item(s)</span>
                                    <span className="items_carts"> Rs {this.props.subTotal.toFixed(2).toLocaleString()} </span>
                                </span>
                            </div>
                        </div>
                    </Link>
                    <ul className="dropdown-menu pull-right shoppingcart-box">
                        {this.props.totalItemsInCart == 0 &&
                            <li>
                                <p className="text-center empty">Your shopping cart is empty!</p>
                            </li>
                        }

                        {this.props.totalItemsInCart > 0 &&
                            <>
                            <li className="content-item">
                                <table className="table table-striped" style={{ marginBottom: '10px'}}>
                                    <tbody>
                                        {this.props.cart.map(prd => {
                                            return (
                                                <tr key={prd.id}>
                                                    <td className="text-center size-img-cart" style={{width: '20%'}}>
                                                        <a href="#">
                                                            <img className="img-thumbnail lazyautosizes lazyloaded" data-sizes="auto" src={`${BaseUrl}/uploads/thumbs/${prd.image[0]}`} alt={ prd.title } title={ prd.title } sizes="57px"/>
                                                        </a>
                                                    </td>
                                                    <td className="text-left" style={{width: '40%'}}>
                                                        <Link to={'/product/'+prd.slug} style={{fontSize: 8}}>{ prd.title }</Link> <br/>
                                                        {prd.selectedColor.name && (
                                                            <>- <small>Select {prd.selectedColor.name}</small></>
                                                        )}

                                                    </td>
                                                    <td className="text-right" style={{fontSize: 8}}>x {prd.orderQuantity}</td>
                                                    <td className="text-right" style={{fontSize: 8}}>Rs {selectFinalPriceWithOptionSelected(prd) * prd.orderQuantity}</td>
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
                            </li>
                                <li>
                                    <div className="checkout clearfix">
                                        <Link to={'/cart'} className="btn btn-view-cart inverse"> View Cart</Link>
                                        <Link to={'/checkout'} className="btn btn-checkout pull-right">Checkout</Link>
                                    </div>
                                </li>
                            </>
                        }

                    </ul>
                </div>
            </div>
        );
    }//..... end of render() .....//
}//..... end of HeaderCartComponent.

const mapStateToProps = (state) => {
    return {
        cart: state.cart.cart,
        totalItemsInCart: state.cart.cart.reduce((total, prd) => total + prd.orderQuantity, 0),
        subTotal: state.cart.cart.reduce((total, prd) => total + (prd.orderQuantity * prd.final_price), 0)
    }
};

const mapPropsToActions = (dispatch) => {
    return {
        removeProduct:     (id) => dispatch(removeProductFromCart(id))
    };
};

export default connect(mapStateToProps, mapPropsToActions)(HeaderCartComponent);
