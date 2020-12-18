import React, {Component} from 'react';
import {addProductToCart} from "../../redux/actions/CartActions";
import {connect} from "react-redux";
import parser from "html-react-parser";
import Slider from "./Slider";
import {withRouter} from 'react-router-dom'
import ColorsComponent from "../pages/_components/ColorsComponent";


class QuickviewComponent extends Component {
    constructor(props) {
        super(props);
        this.state = {
            quantity: 1,
            selectedColor: {},
            optionPrice: 0
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

    handleColorSelection = (colorId) => {
        let color = this.props.prd.colors.filter(clr => clr.id == colorId).pop();
        this.setState((prevState) => {
            return {
                optionPrice: prevState.selectedColor != color && color ? color.price : 0,
                selectedColor: prevState.selectedColor != color && color ? color : {}
            }
        })
    };

    addToCart = (prd) => {
        this.props.dispatch(addProductToCart(prd, this.state.quantity, this.state.selectedColor));
        this.props.onHide();
    };

    render() {
        return (
            <>
                <div className="mfp-bg my-mfp-zoom-in mfp-ready"></div>
                <div className="mfp-wrap mfp-gallery mfp-close-btn-in mfp-auto-cursor my-mfp-zoom-in mfp-ready" tabIndex={-1} style={{overflow: 'hidden auto'}}>
                    <div className="mfp-container mfp-s-ready mfp-iframe-holder">
                        <div className="mfp-content" style={{ maxWidth: '1280px'}}>
                            <div className="mfp-iframe-scaler" style={{ background: '#fff', boxShadow: "none"}}>
                                <button title="Close (Esc)" type="button" className="mfp-close" onClick={() => this.props.onHide()}>×</button>
                                <div id="wrapper" style={{position: "absolute", top: 0, width: '90%'}}>
                                    <div className="product-detail">
                                        <div id="product-quick" className="product-info">
                                            <div className="product-view">
                                                <div className="left-content-product ">
                                                    <div className="content-product-left class-honizol  col-sm-6">
                                                        <Slider key={this.props.prd.id} product={this.props.prd} url={this.props.prd.url}/>
                                                    </div>
                                                    <div className="content-product-right col-sm-6">
                                                        <div className="row">
                                                            <div className="col-sm-12 col-xs-12">
                                                                <div className="title-product">
                                                                    <h1>{ this.props.prd.title } </h1>
                                                                </div>
                                                                <div className="product_page_price price">
                                                                    <span className="price-new">
                                                                        <span itemProp="price" id="price-old">Rs { (parseFloat(this.props.prd.final_price) + parseFloat(this.state.optionPrice))}</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="short_description form-group">
                                                            <h3>OverView</h3>
                                                            <div className="form-group">
                                                                <div style={{lineHeight: 1.6}}>{this.props.prd.description ? parser(this.props.prd.description) : ''}</div>
                                                            </div>
                                                        </div>

                                                        <ColorsComponent product={this.props.prd} handleOption={this.handleColorSelection} selectedColor={this.state.selectedColor}/>

                                                        <div className="form-group box-info-product" style={{marginTop: '12px'}}>
                                                            <div className="option quantity">
                                                                <label className="control-label" htmlFor="input-quantity"  style={{marginBottom: '17px'}}>Quantity:</label>
                                                                <div className="input-group quantity-control" unselectable="on" style={{userSelect: 'none'}}>
                                                                    <span className="input-group-addon product_quantity_down fa fa-minus"  onClick={this.decrementQuantity}/>
                                                                    <input className="form-control" type="text" name="quantity" value={this.state.quantity} readOnly={'readOnly'}/>
                                                                    <span className="input-group-addon product_quantity_up fa fa-plus"  onClick={this.incrementQuantity}/>
                                                                </div>
                                                            </div>
                                                            <div className="detail-action">
                                                                <div className="cart">
                                                                    <input type="button" defaultValue="Add to Cart" className="btn btn-mega" onClick={() => this.addToCart(this.props.prd)}/>
                                                                    <input type="button" defaultValue="Buy Now" className="btn btn-checkout" onClick={() => { this.addToCart(this.props.prd); this.props.history.push('/checkout')}}/>
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
                        </div>
                    </div>
                </div>
            </>
        );
    }//..... end of render() .....//
}//..... end of QuickviewComponent.

const mapStateToProps = (state) => {
    return {};
};
export default connect(mapStateToProps)(withRouter(QuickviewComponent));
