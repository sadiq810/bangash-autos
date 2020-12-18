import React, {Component} from 'react';
import {Link} from "react-router-dom";
import {decrementQuantityInCart, incrementQuantityInCart, removeProductFromCart} from "../../redux/actions/CartActions";
import {connect} from "react-redux";
import {selectFinalPriceWithOptionSelected} from "../../redux/selectors/CategorySelector";

class Cart extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    render() {
        return (
            <>
                <div className="container checkout-cart" >
                    <div className="breadcrumbs ">
                        <div className="container">
                            <div className="current-name">
                                &nbsp;
                            </div>
                            <ul className="breadcrumb">
                                <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                                <li><a href={'#'}>Shopping Cart</a></li>
                            </ul>
                        </div>
                    </div>

                    <div className="row">
                        <div id="content" className="col-sm-12">
                            <div className="content-cart">
                                <div className="table-responsive">
                                    <table className="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td className="text-center">Image</td>
                                            <td className="text-left">Product Name</td>
                                            <td className="text-left">Model</td>
                                            <td className="text-left">Quantity</td>
                                            <td className="text-right">Unit Price</td>
                                            <td className="text-right">Total</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {this.props.cart.map(prd => {
                                            return (
                                                <tr key={prd.id}>
                                                    <td className="text-center">
                                                        <Link to={'/product/'+prd.slug}>
                                                            <img src={`${BaseUrl}/uploads/thumbs/${prd.image[0]}`} alt={ prd.title } title={ prd.title } className="img-thumbnail" style={{width: '47px', height: '47px'}}/>
                                                        </Link>
                                                    </td>
                                                    <td className="text-left">
                                                        <Link to={'/product/'+prd.slug}>{prd.title}</Link>
                                                        {prd.selectedColor.title && (
                                                            <><br/> <small>Select color: {prd.selectedColor.title}</small></>
                                                        )}
                                                        <br/>
                                                        <small>SKU: {prd.sku}</small>
                                                    </td>
                                                    <td className="text-left">{ prd.car_version } - {prd.version_through}</td>
                                                    <td className="text-left">
                                                        <div className="input-group btn-block" style={{maxWidth: '200px'}}>
                                                            <span className="input-group-btn">
                                                                <button type="submit" title="Minus" className="btn btn-primary" onClick={() => this.props.decrementQuantity(prd.id)} style={{ height: '38px' }}>
                                                                    <i className="fa fa-minus"></i>
                                                                </button>
                                                            </span>
                                                            <input type="text" size="1" className="form-control" value={prd.orderQuantity} readOnly/>
                                                            <span className="input-group-btn">
                                                                <button type="submit" title="" className="btn btn-primary" onClick={() => this.props.incrementQuantity(prd.id)} style={{ height: '38px' }}>
                                                                    <i className="fa fa-plus"></i>
                                                                </button>
                                                                <button type="button" title="Remove" className="btn btn-danger"  onClick={() => this.props.removeProduct(prd.id)} style={{ height: '38px' }}>
                                                                    <i className="fa fa-times-circle"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td className="text-right">RS {selectFinalPriceWithOptionSelected(prd)}</td>
                                                    <td className="text-right">RS {(prd.orderQuantity * selectFinalPriceWithOptionSelected(prd).toFixed(2))}</td>
                                                </tr>
                                            );
                                        })}
                                        </tbody>

                                    </table>
                                </div>

                                <br/>
                                <div className="row">
                                    <div className="col-sm-4 col-sm-offset-8">
                                        <table className="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <td className="text-right"><strong>Sub-Total:</strong></td>
                                                <td className="text-right">Rs: {this.props.subTotal.toFixed(2).toLocaleString()}</td>
                                            </tr>
                                            <tr>
                                                <td className="text-right"><strong>Total:</strong></td>
                                                <td className="text-right">Rs: {this.props.subTotal.toFixed(2).toLocaleString()}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div className="buttons clearfix">
                                    <div className="pull-left">
                                        <Link to={'/'} className="btn btn-default">Continue Shopping</Link>
                                    </div>
                                    <div className="pull-right">
                                        <Link to={'/checkout'} className="btn btn-primary">Checkout</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </>
        );
    }//..... end of render() .....//
}//..... end of Cart.

const mapStateToProps = (state) => {
    return {
        cart: state.cart.cart,
        subTotal: state.cart.cart.reduce((total, prd) => total + (selectFinalPriceWithOptionSelected(prd) * prd.orderQuantity), 0)
    };
};

const mapPropsToActions = (dispatch) => {
    return {
        incrementQuantity: (id) => dispatch(incrementQuantityInCart(id)),
        decrementQuantity: (id) => dispatch(decrementQuantityInCart(id)),
        removeProduct:     (id) => dispatch(removeProductFromCart(id))
    }
};

export default connect(mapStateToProps, mapPropsToActions)(Cart);
