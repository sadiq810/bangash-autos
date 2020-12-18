import React, {Component} from 'react';
import {withRouter, Link} from 'react-router-dom';
import Slider from "../products/Slider";
import {connect} from "react-redux";
import parse from 'html-react-parser';
import {addProductToCart} from "../../redux/actions/CartActions";
import ProductAddedModal from "../products/ProductAddedModal";
import QuickviewComponent from "../products/QuickviewComponent";
import RelatedProductsSlider from "../products/RelatedProductsSlider";
import LoaderComponent from "../layouts/LoaderComponent";
import ColorsComponent from "./_components/ColorsComponent";
import { Twitter, Facebook, Whatsapp, Pinterest } from 'react-social-sharing';

class ProductDetail extends Component {
    constructor(props) {
        super(props);
        this.state = {
            quantity: 1,
            productAdded: null,
            quickView: null,
            loader: false,
            product: null,
            optionPrice: 0,
            selectedColor: {},
            relatedProducts: []
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

    addToCart = (prd, gotoCheckout = false) => {
        if (prd.colors.length > 0 &&  Object.keys(this.state.selectedColor).length == 0) {
            alert('Please choose an option.');
            return false;
        }

        this.props.dispatch(addProductToCart(prd, this.state.quantity, this.state.selectedColor));
        this.setState({productAdded: prd});

        if (gotoCheckout)
            this.props.history.push('/checkout');
    };

    showProductAddedModal = (prd = null) => {
        this.setState(() => {
            return {
                productAdded: prd
            }
        });
    };

    showModal = (prd = null) => {
        this.setState(prevState => {
            return {
                quickView: prd
            }
        })
    };

    componentDidMount() {
        let slug = this.props.match.params.productName;
        this.loadData(slug);
    }//..... end of componentDidMount() .....//

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (this.props.match.params.productName != prevProps.match.params.productName) {
            let slug = this.props.match.params.productName;
            this.loadData(slug);
        }
    }

    loadData = (slug) => {
        this.setState({loader: true});

        fetch(   BaseUrl+"/api/get-product-by-slug",{
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                slug
            }),
        })
            .then(response => response.json())
            .then(json => {
                this.setState(() => ({
                    product: json.data.pop(),
                    loader: false,
                    relatedProducts: json.relatedProducts
                }));
                window.scrollTo(0, 0);
            }).catch(err => {
            this.setState({loader: false});
        });
    };

    handleOption = (colorId) => {
        let color = this.state.product.colors.filter(clr => clr.id == colorId).pop();
        this.setState((prevState) => {
            return {
                optionPrice: prevState.selectedColor != color && color ? color.price : 0,
                selectedColor: prevState.selectedColor != color && color ? color : {}
            }
        })
    };

    render() {
        const product = this.state.product;
        return (
            <div className="product-product">
                <div className="breadcrumbs ">
                    <div className="container">
                        <ul className="breadcrumb">
                            <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                            <li><a>{ product ? product.title : 'Product details' }</a></li>
                        </ul>
                    </div>
                </div>

                <div className="content-main container product-detail  ">
                    <div className="row">
                        <div id="content" className="product-view col-md-12 col-sm-12">
                            <div className="content-product-mainheader clearfix">
                                <div className="row">
                                    <div className="content-product-left eqWrap col-md-7 col-sm-12 col-xs-12">
                                        <div className="content-left" style={{maxWidth: '626px'}}>
                                            {product && <Slider key={product ? product.id : 0} product={product} url={product ? product.url : null}/>}
                                        </div>
                                    </div>
                                    <div className="content-product-right eqWrap col-md-5 col-sm-12 col-xs-12">
                                        <div className="content-right">
                                            <div className="product_page_price price">
                                                <span className="price-new">
                                                  <span itemProp="price" style={{fontSize: '12px'}}>
                                                    { product ? product.title : 'Product details' }
                                                  </span>
                                                </span>
                                            </div>
                                            <div className="product-box-desc">
                                                <div className="inner-box-desc">
                                                    <div className="brand">
                                                        <span>SKU </span>
                                                        <a><span>{ product ? product.sku : '' }</span></a>
                                                    </div>
                                                    <div className="model"><span>Price: </span> Rs {product ? (parseFloat(product.final_price) + parseFloat(this.state.optionPrice)) : 0}</div>
                                                    <div className="stock"><span> Stock </span> <i
                                                        className="fa fa-check"/> In Stock
                                                    </div>
                                                    <div className="model">
                                                        <span>Free Items </span>{product ? product.free_items : ''}
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="product">
                                                <div className="box-cart clearfix form-group">
                                                    <div className="form-group box-info-product">

                                                        <ColorsComponent product={product} handleOption={this.handleOption} selectedColor={this.state.selectedColor}/>

                                                        <div className="option quantity">
                                                            <label className="control-label" htmlFor="input-quantity">Quantity:</label>
                                                            <div className="input-group quantity-control">
                                                                <span className="input-group-addon product_quantity_down fa fa-minus" onClick={this.decrementQuantity}/>
                                                                <input className="form-control" type="text" name="quantity" readOnly value={this.state.quantity} style={{zIndex: 0}}/>
                                                                <span className="input-group-addon product_quantity_up fa fa-plus" onClick={this.incrementQuantity}/>
                                                            </div>
                                                        </div>

                                                        <div className="detail-action">
                                                            <div className="cart">
                                                                <input type="button" defaultValue="Add to Cart" className="btn btn-mega" onClick={() => this.addToCart(product)}/>
                                                                <input type="button" defaultValue="Buy Now" className="btn btn-checkout"  onClick={() => {this.addToCart(product, true)}}/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div className="clearfix"/>
                                                    <div>
                                                        <Twitter link={window.location.href} />
                                                        <Facebook link={window.location.href} />
                                                        <Whatsapp link={window.location.href} />
                                                        <Pinterest link={window.location.href} />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="content-product-mainbody clearfix row">
                                <div className="content-product-content col-sm-12">
                                    <div className="content-product-midde clearfix">
                                        <div className="producttab ">
                                            <div className="tabsslider   horizontal-tabs  col-xs-12">
                                                <ul className="nav nav-tabs font-sn">
                                                    <li className="active" style={{display: 'block'}}>
                                                        <a data-toggle="tab" href="#tab-description">Description</a>
                                                    </li>
                                                </ul>
                                                <div className="tab-content  col-xs-12">
                                                    <div className="tab-pane active" id="tab-description">
                                                        <div id="collapse-description" className="desc-collapse showup">
                                                            {(product && product.description) ? parse(product.description) : ''}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="content-product-bottom clearfix">
                                        <ul className="nav nav-tabs">
                                            <li className="active">
                                                <a data-toggle="tab" href="#product-related">Related Products</a>
                                            </li>
                                        </ul>
                                        <div className="tab-content">
                                            <div id="product-related" className="tab-pane fade in active">
                                                <div className="clearfix module related-horizontal ">
                                                    <div className="related-products products-list  contentslider owl2-carousel owl2-theme owl2-responsive-1200 owl2-loaded">
                                                        <div className="owl2-stage-outer">
                                                            {
                                                                (this.state.relatedProducts.length > 0) &&
                                                                <RelatedProductsSlider products={this.state.relatedProducts} showProductAddedModal={this.addToCart} quickView={this.showModal}/>
                                                            }
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

                {this.state.loader && <LoaderComponent />}
                {this.state.productAdded && <ProductAddedModal prd={this.state.productAdded} optionPrice={this.state.optionPrice} showProductAddedModal={this.showProductAddedModal}/>}
                {this.state.quickView &&
                <QuickviewComponent onHide={this.showModal}  prd={this.state.quickView} />}
            </div>
        );
    }//..... end of render() .....//
}//..... end of ProductDetails.

const mapStateToProps = (state) => {
    return {
        categories: state.categories.categories
    };
};
export default connect(mapStateToProps)(withRouter(ProductDetail));
