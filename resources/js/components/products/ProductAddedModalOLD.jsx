import React, {Component} from 'react';
import {connect} from 'react-redux';
import {Link} from "react-router-dom";

class ProductAddedModalOLD extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    componentDidMount() {
        $('#productAddedModal').modal('show');
    }

    closeModal = () => {
        this.props.showProductAddedModal('');
        $('#productAddedModal').modal('hide');
    };

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (this.props.prd.id != prevProps.prd.id)
            $('#productAddedModal').modal('show');
    }

    render() {
        return (
            <div className="modal fadev ProductModal" id="productAddedModal" role="dialog">
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="modal-header modal_header">
                            <div className="media">
                                <div className="media-left">
                                    <img src={ BaseUrl+"/images/check_icon2.png" } alt="Check" />
                                </div>
                                <div className="media-body">
                                    <h4 className="modal-title header_title media-heading">Product added successfully to your cart!</h4>
                                </div>
                                <div className="media-right">
                                    <a href="#" className="btn btn-success close_button">
                                        <button type="button" className="close close_btn" onClick={this.closeModal}>×</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div className="modal-body modal_body AddToCartModal">
                            <div className="col-sm-12 col-md-5 col-lg-5">
                                <div className="image image_p">
                                    <span id="mSaleCircle" style={{textAlign: 'center'}} />
                                    <span id="mBadge" style={{textAlign: 'center'}} />
                                    <div className="qviewImg">
                                        <img id="mProductImage" src={`${BaseUrl}/uploads/${this.props.prd.image[0]}`} alt={ this.props.prd.title } alt="Product Image" className="img-responsive modalImage" />
                                    </div>
                                </div>
                            </div>
                            <div className="col-sm-12 col-md-7 col-lg-7">
                                <div className="row">
                                    <div className="col-sm-12 col-md-7 col-lg-8">
                                        <div className="slider_bottomside">
                                            <p id="text">
                                            </p>
                                            <h4 id="mProductTitle">{ this.props.prd.title }</h4>
                                            <p />
                                            <div className="p-price" id="mProductPrice">Rs: { this.props.prd.final_price}</div>
                                        </div>
                                        <hr />
                                        <pre className="haq">
                                            <p>
                                                <b>
                                                    <span className="pull-left">Shipping Cost</span>
                                                    <span className="pull-right">Rs:<span id="ModalCartDeliveryTotal">0</span></span>
                                                </b>
                                            </p>
                                        </pre>
                                        <pre className="haq">
                                            <p>
                                                <b>
                                                    <span className="pull-left">Cart Total</span>
                                                    <span className="pull-right">Rs: <span id="ModalCartTotal">{this.props.cartTotal.toFixed(2)}</span></span>
                                                </b>
                                            </p>
                                        </pre>
                                        <pre className="haq"><p> <b>Free Shipping Over Rs. 1000 /-</b>{"\n"}</p></pre>
                                        <div className="clearfix" />
                                        <hr />
                                        <div className="row comentBoxes">
                                            <div className="col-sm-12 col-md-4 col-lg-4">
                                                <div className="box1">
                                                    <img src={ BaseUrl+"/images/check_icon.png" } alt="check" className="img-responsive check_icon" />
                                                    <p className="text1">
                                                        7 Days Money back Guarantee
                                                    </p>
                                                </div>
                                            </div>
                                            <div className="col-sm-12 col-md-4 col-lg-4">
                                                <div className="box1">
                                                    <img src={ BaseUrl+"/images/check_icon.png" } alt="check" className="img-responsive check_icon" />
                                                    <p className="text1">
                                                        Authentic &amp; Reliable Products
                                                    </p>
                                                </div>
                                            </div>
                                            <div className="col-sm-12 col-md-4 col-lg-4">
                                                <div className="box1">
                                                    <img src={ BaseUrl+"/images/check_icon.png" } alt="check" className="img-responsive check_icon" />
                                                    <p className="text1">
                                                        Fast Deliveries All Over Pakistan.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="btn-popup">
                                            <ul className="list-inline btn_inline">
                                                <li><Link to={'/cart'} className="btn btn-view" onClick={() => $('#productAddedModal').modal('hide')}>View Cart</Link></li>
                                                <li><Link to={'/checkout'} className="btn btn-primary btn-check" onClick={() => $('#productAddedModal').modal('hide')}>Checkout</Link></li>
                                                <li><a href="#" onClick={this.closeModal} className="btn btn-view">Continue shop </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="clearfix" />
                        </div>
                    </div>
                </div>
            </div>

        );
    }//..... end of render() .....//
}//..... end of ProductAddedModal.
const mapStateToProps = (state) => {
    return {
        cartTotal : state.cart.cart.reduce((total, prd) => {
            return total + (prd.final_price * prd.orderQuantity);
        }, 0)
    }
};

export default connect(mapStateToProps)(ProductAddedModalOLD);
