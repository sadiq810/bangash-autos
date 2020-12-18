import React, {Component} from 'react';
import {connect} from "react-redux";
import {addProductToCart} from "../../redux/actions/CartActions";

class QuickviewComponent extends Component {
    constructor(props) {
        super(props);
        this.state = {
            quantity: 1
        };
    }//..... end of constructor() .....//

    incrementQuantity = () => {
      this.setState(prevState => {
          return {
              quantity: prevState.quantity >= 100 ? prevState.quantity : ++prevState.quantity
          }
      });
    };

    decrementQuantity = () => {
      this.setState(prevState => {
          return {
              quantity: prevState.quantity <= 1 ? prevState.quantity : --prevState.quantity
          }
      });
    };

    addToCart = (prd) => {
        this.props.dispatch(addProductToCart(prd, this.state.quantity));
        this.closeModal();
    };

    componentDidMount() {
        $('#quickViewModel').modal('show');
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (this.props.prd.id != prevProps.prd.id)
            $('#quickViewModel').modal('show');
    }

    closeModal = () => {
        $('#quickViewModel').modal('hide');
        this.props.showModal('');
    };

    render() {
        return (
            <div className="modal fadev " id="quickViewModel" role="dialog">
                <div className="modal-dialog modal-lg quickView-modal">
                    <div className="modal-content">
                        <div className="modal-header modal_header">
                            <div className="media">
                                <div className="media-left">
                                </div>
                                <div className="media-body">
                                    <h4 className="modal-title header_title media-heading">Quick View!</h4>
                                </div>
                                <div className="media-right">
                                    <a href="#" className="btn btn-success close_button">
                                        <button type="button" className="close close_btn" onClick={() => this.closeModal()}>×</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div className="modal-body modal_body">
                            <div className="col-sm-12 col-md-6 col-lg-6">
                                <div className="image_p">
                                    <span id="qSaleCircle" style={{textAlign: 'center'}}/>
                                    <span id="qBadge" style={{textAlign: 'center'}}/>
                                    <div className="qviewImg">
                                        <img id={'qProductImage'} src={`${BaseUrl}/uploads/${this.props.prd.image[0]}`} alt={ this.props.prd.title } alt="Product" className="img-responsive modalImage"/>
                                    </div>
                                </div>
                            </div>
                            <div className="col-sm-12 col-md-6 col-lg-6">
                                <div className="main_area">
                                    <div className="slider_bottomside">
                                        <h4 className="f_text" id="qProductTitle">{ this.props.prd.title }</h4>
                                        <p id="qProductSku">SKU: { this.props.prd.sku }</p>
                                        <div className="p-price" id="qProductPrice">Rs: { this.props.prd.final_price }</div>
                                    </div>
                                    <div className="box">
                                        <ul className="list-inline">
                                            <li>
                                                <div className="center">
                                                    <div className="input-group">
                                                      <span className="input-group-btn">
                                                        <button type="button" className="btn btn-default btn-number minus-btn btn-produt-counter" onClick={this.decrementQuantity}>
                                                          <span className="glyphicon glyphicon-minus"/>
                                                        </button>
                                                      </span>
                                                        <input type="text" readOnly className="form-control input-number counterMain value" value={this.state.quantity} />
                                                        <span className="input-group-btn">
                                                            <button type="button" className="btn btn-default btn-number btn-produt-counter" onClick={this.incrementQuantity}>
                                                                <span className="glyphicon glyphicon-plus"/>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div className="clearfix"/>
                                        <div className="button modalbtn">
                                            <a href="#" className="btn btn-warning btn-block" onClick={() => this.addToCart(this.props.prd)}>Buy Now</a>
                                        </div>
                                    </div>
                                    <div className="row comentBoxes">
                                        <div className="tempBoxes">
                                            <div className="col-sm-12 col-md-4 col-lg-4">
                                                <div className="box1">
                                                    <img src={ BaseUrl+"/images/check_icon.png" } alt="check"
                                                         className="img-responsive check_icon"/>
                                                    <p className="text1">
                                                        7 Days Money back Guarantee
                                                    </p>
                                                </div>
                                            </div>
                                            <div className="col-sm-12 col-md-4 col-lg-4">
                                                <div className="box1">
                                                    <img src={ BaseUrl+"/images/check_icon.png" } alt="check"
                                                         className="img-responsive check_icon"/>
                                                    <p className="text1">
                                                        Authentic &amp; Reliable Products
                                                    </p>
                                                </div>
                                            </div>
                                            <div className="col-sm-12 col-md-4 col-lg-4">
                                                <div className="box1">
                                                    <img src={ BaseUrl+"/images/check_icon.png" } alt="check"
                                                         className="img-responsive check_icon"/>
                                                    <p className="text1">
                                                        Fast Deliveries All Over Pakistan.
                                                    </p>
                                                </div>
                                            </div>
                                            <div className="clearfix"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="clearfix"/>
                        </div>
                    </div>
                </div>
            </div>
        );
    }//..... end of render() .....//
}//..... end of QuickviewComponent.

const mapStateToProps = (state) => {
    return {};
};
export default connect(mapStateToProps)(QuickviewComponent);
