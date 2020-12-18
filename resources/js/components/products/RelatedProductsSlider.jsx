import React, {Component} from 'react';
import Carousel from "react-multi-carousel";
import "react-multi-carousel/lib/styles.css";
import {Link} from "react-router-dom";
import parser from "html-react-parser";
import {calculatePercentForDiscount} from "../../redux/selectors/PriceSelector";

const responsive = {
    superLargeDesktop: {
        breakpoint: { max: 4000, min: 3000 },
        items: 6,
    },
    desktop: {
        breakpoint: { max: 3000, min: 1024 },
        items: 4,
    },
    tablet: {
        breakpoint: { max: 1024, min: 464 },
        items: 2,
    },
    mobile: {
        breakpoint: { max: 464, min: 0 },
        items: 1,
    },
};

class RelatedProductsSlider extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    render() {
        return <Carousel responsive={responsive} swipeable={true} draggable={true}>
            {this.props.products && this.props.products.map(prd => {
                return (
                    <div className="owl2-item" style={{width: '270px', marginRight: '30px'}} key={prd.id}>
                        <div className="product-layout product-grid">
                            <div className="product-item-container">
                                <div className="left-block">
                                    <div className="product-image-container">
                                        <Link className="product-tag" to={`/product/${prd.slug}`} title={prd.title}>
                                            <img data-sizes="auto" src={`${BaseUrl}/uploads/thumbs/${prd.image[0]}`} title={prd.title} className="img-responsive lazyautosizes lazyloaded" sizes="270px"/>
                                        </Link>
                                    </div>
                                    <div className="box-label">
                                        {prd.discount > 0 &&
                                        <span className="label-product label-sale" style={{ width: '53px', height: '53px', backgroundColor: 'white', lineHeight: '16px', paddingTop: '10px', backgroundImage: `url(${BaseUrl}/images/circle.png)`}}>Off <br/> {calculatePercentForDiscount(prd.sale_price, prd.discount)}%</span>
                                        }
                                    </div>
                                    <div className="button-group cartinfo--right">
                                        <button className="addToCart btn-button" type="button" title="Add to Cart" onClick={() => this.props.showProductAddedModal(prd)}>
                                            <i className="fa fa-shopping-basket"/><span>Add to Cart</span>
                                        </button>

                                        <a className="quickview iframe-link visible-lg btn-button" title="Quickview" onClick={() => this.props.quickView(prd)}>
                                            <i className="fa fa-eye"/><span>Quick view</span>
                                        </a>
                                    </div>
                                </div>
                                <div className="right-block">
                                    <h4>
                                        <Link className="product-tag" to={`/product/${prd.slug}`}>{ prd.title}</Link>
                                    </h4>
                                    <div className="price">
                                        <span className="price-new">Rs {prd.final_price}</span>
                                        {prd.discount > 0 &&
                                        <span className="price-old">Rs {prd.sale_price} </span>
                                        }
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                );
            })}
        </Carousel>;
    }//..... end of render() .....//
}//..... end of RelatedProductsSlider.

export default RelatedProductsSlider;
