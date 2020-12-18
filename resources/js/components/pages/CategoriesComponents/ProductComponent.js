import React from 'react';
import {Link} from "react-router-dom";
import {calculatePercentForDiscount} from "../../../redux/selectors/PriceSelector";
import Countdown from "react-countdown";

export default class ProductComponent extends React.PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        let {prd, layoutConfigurations, selectedLayout, selectedImageView, handleImageView, showModal, showProductAddedModal} = this.props;

        let timeInMilliSeconds = null;

        if (prd.discount > 0 && prd.discount_end_date) {
            let date = prd.discount_end_date.split(' ').reverse().pop();
            timeInMilliSeconds = (new Date(date)).getTime() + (24*60*60*1000);
        }//..... end if() ....//

        return (
            <div className={layoutConfigurations[selectedLayout] + " product-layout "+ (selectedLayout == 'grid' ? 'col-xs-12': 'col-xs-6')}>
                <div className="product-item-container">
                    <div className="left-block">
                        <div className="product-card__gallery product-card__right">
                            {prd.image.map((img, key) => (
                                <div key={key} className={(!selectedImageView[prd.id] && key == 0) || selectedImageView[prd.id] == img ? "item-img thumb-active" : "item-img"} style={{ width: '47px', height: '47px'}}>
                                    <img onClick={() => handleImageView(prd.id, img)} className="lazyautosizes lazyloaded" data-sizes="auto" src={BaseUrl+'/uploads/thumbs/'+img} alt={prd.title}/>
                                </div>
                            ))}
                        </div>

                        <div className="product-image-container">
                            {prd.discount > 0 && timeInMilliSeconds &&
                                <div className={'discount--count--timer'}>
                                    <Countdown date={timeInMilliSeconds} onComplete={() => <span style={{color: 'red'}}>Discount Period Ended</span>}/>
                                </div>
                            }
                            <Link to={'/product/'+prd.slug} title={prd.title}>
                                <img src={`${BaseUrl}/uploads/${ ( selectedImageView[prd.id] ? selectedImageView[prd.id] : prd.image[0]) }`}
                                     alt={prd.title} title={prd.title} className="img-responsive"/>
                            </Link>
                        </div>

                        <div className="box-label">
                            {prd.discount > 0 &&
                            <span className="label-product label-sale saleIcon">Off <br/> {calculatePercentForDiscount(prd.sale_price, prd.discount)}%</span>
                            }
                        </div>

                        <div className="button-group cartinfo--left">
                            <a className="quickview iframe-link visible-lg btn-button" title="Quickview"  onClick={() => showModal(prd)}>
                                <i className="fa fa-eye"/><span>Quickview</span>
                            </a>
                        </div>
                    </div>
                    <div className="right-block">
                        <h4>
                            <Link to={'/product/'+prd.slug}>{prd.title} </Link>
                        </h4>
                        <div className="price">
                            <span className="price-new">Rs {prd.final_price}</span>
                            {prd.discount > 0 &&
                            <span className="price-old">Rs {prd.sale_price} </span>
                            }
                        </div>
                        <button className="addToCart btn-button" type="button" title="Add to Cart"  onClick={() => showProductAddedModal(prd)}>
                            <i className="fa fa-shopping-basket"/><span>Add to Cart</span>
                        </button>
                    </div>
                    <div className="list-block">
                        <button className="addToCart btn-button" type="button" title="Add to Cart"  onClick={() => showProductAddedModal(prd)}><i className="fa fa-shopping-basket"></i></button>
                    </div>
                </div>
            </div>
        )
    }
}
