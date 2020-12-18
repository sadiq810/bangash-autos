import React, {Component} from 'react';
import {connect} from 'react-redux';
import {Link} from "react-router-dom";
import {selectFinalPriceWithOptionSelected} from "../../redux/selectors/CategorySelector";

class ProductAddedModal extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    closeModal = () => {
        this.props.showProductAddedModal();
    };

    render() {
        return (
            <>
            <div id="previewModal" className="modal fade in" tabIndex="-1" role="dialog" style={{display: 'block'}}>
                <div className="modal-dialog modal-lg" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close"  onClick={this.closeModal}>
                                <span aria-hidden="true">×</span>
                            </button>
                            <h4 className="modal-title"> Added to cart successfully. What is next?</h4>
                        </div>
                        <div className="modal-body">
                            <div className="row">
                                <div className="col-lg-9 col-sm-6 col-xs-12 cart-popup-left">
                                    <div className="product-image col-lg-5">

                                        <Link className="product-tag" to={`/product/${this.props.prd.slug}`}>
                                            <img src={`${BaseUrl}/uploads/${this.props.prd.image[0]}`} alt={ this.props.prd.title } title={ this.props.prd.title }/>
                                        </Link>
                                    </div>

                                    <div className="cart-popup-info col-lg-7">
                                        <h3 className="product-name">{ this.props.prd.title }</h3>
                                        <div className="price">
                                            <span className="price-quantity">1 x</span>
                                            <span className="price-new">Rs: { (parseFloat(this.props.prd.final_price) + (this.props.optionPrice ? parseFloat(this.props.optionPrice) : 0))} </span>
                                        </div>
                                    </div>
                                </div>

                                <div className="col-lg-3 col-sm-6 col-xs-12 cart-popup-right">

                                    <div className="cart-popup-action">
                                        <Link to={'/checkout'} className="btn btn-checkout" onClick={this.closeModal}>Checkout</Link>
                                        <div className="cart-popup-imgbottom">
                                            Order subtotal <span className="previewCartCheckout-price">Rs {this.props.cartTotal.toFixed(2)}</span>
                                            <span className="cart-popup-total">Your cart contains {this.props.totalItems} items</span>
                                        </div>
                                        <a href="#" className="btn btn-view-cart inverse" data-dismiss="modal" aria-label="Close" onClick={this.closeModal}>Continue shopping</a>
                                        <Link to={'/cart'} className="btn btn-view-cart inverse" onClick={this.closeModal}> View Cart</Link>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
                <div className="modal-backdrop fade in"></div>
            </>
        );
    }//..... end of render() .....//
}//..... end of ProductAddedModal.

const mapStateToProps = (state) => {
    return {
        totalItems: state.cart.cart.length,
        cartTotal : state.cart.cart.reduce((total, prd) => {
            return total + (selectFinalPriceWithOptionSelected(prd) * prd.orderQuantity);
        }, 0)
    }
};

export default connect(mapStateToProps)(ProductAddedModal);
