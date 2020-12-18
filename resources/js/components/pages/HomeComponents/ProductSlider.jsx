import React, {Component} from 'react';
import Carousel from "react-multi-carousel";
import "react-multi-carousel/lib/styles.css";
import {Link} from "react-router-dom";
import Countdown from "react-countdown";
import {calculatePercentForDiscount} from "../../../redux/selectors/PriceSelector";

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

class ProductSlider extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    render() {
        return <Carousel responsive={responsive} swipeable={true} draggable={true}>
            {this.props.products && this.props.products.map(prd => {
                let timeInMilliSeconds = null;

                if (prd.discount > 0 && prd.discount_end_date) {
                    let date = prd.discount_end_date.split(' ').reverse().pop();
                    timeInMilliSeconds = (new Date(date)).getTime() + (24*60*60*1000);
                }//..... end if() ....//

                return (<div className="ltabs-item" key={prd.id}>
                    <div className="item-inner product-layout transition product-grid first-item">
                        <div className="product-item-container">
                            <div className="left-block">
                                <div className="product-image-container  second_img">
                                    {prd.discount > 0 && timeInMilliSeconds &&
                                    <div className={'discount--count--timer'} style={{position: 'initial'}}>
                                        <Countdown date={timeInMilliSeconds} onComplete={() => <span style={{color: 'red'}}>Discount Period Ended</span>}/>
                                    </div>
                                    }
                                    <Link className="product-tag" to={`/product/${prd.slug}`}>
                                        <img data-sizes="auto" src={`${BaseUrl}/uploads/thumbs/${prd.image[0]}`} alt={ prd.title} className="lazyload"/>
                                        {prd.image[1] &&
                                        <img data-sizes="auto" src={`${BaseUrl}/uploads/thumbs/${prd.image[1]}`} className="img-2 lazyautosizes lazyloaded" alt={ prd.title} sizes="202px"/>
                                        }
                                    </Link>
                                </div>
                                <div className="box-label">
                                    {prd.discount > 0 &&
                                        <span className="label-product label-sale saleIcon">Off <br/> {calculatePercentForDiscount(prd.sale_price, prd.discount)}%</span>
                                    }
                                </div>
                                <div className="button-group so-quickview cartinfo--right">
                                    <a className="visible-lg btn-button quickview quickview_handler" title="Quick view" onClick={() => this.props.quickView(prd)}>
                                        <i className="fa fa-eye"></i><span>Quick view</span>
                                    </a>
                                </div>
                            </div>
                            <div className="right-block">
                                <Link className="product-tag home--item-title" to={`/product/${prd.slug}`} title={prd.title}>{ prd.shortTitle}</Link>
                                <div className="caption" style={{marginTop: '50px'}}>
                                    <div className="price">
                                        <span className="price-new">Rs {prd.final_price}</span>
                                        {prd.discount > 0 &&
                                            <span className="price-old">Rs {prd.sale_price} </span>
                                        }
                                    </div>
                                    <button type="button" className="addToCart btn-button" title="Add to cart" onClick={() => this.props.showProductAddedModal(prd)}>
                                        <i className="fa fa-shopping-basket"/><span>Add to cart </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>);
            })}
        </Carousel>;
    }//..... end of render() .....//
}//..... end of ProductSlider.

export default ProductSlider;
