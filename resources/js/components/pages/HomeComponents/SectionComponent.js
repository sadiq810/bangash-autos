import React from "react";
import {Link} from "react-router-dom";
import ProductSlider from "./ProductSlider";

export default class SectionComponent extends React.PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        let {cat_title, cat_img, cat_slug, products, showProductAddedModal, quickView} = this.props;

        return (
            <div className="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_mokk  col-style">
                <div className="module so-listing-tabs-ltr listingtab-layout2">
                    <div className="pre">
                        <div className="banners hidden-xs">
                            <div>
                                <Link to={`/${cat_slug}`}>
                                    <img src={cat_img ? BaseUrl+cat_img : BaseUrl+"/assets/frontend/image/catalog/banners/banner8.jpg"} alt={cat_title}/>
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div className="modcontent">
                        <div className="so-listing-tabs first-load module">
                            <div className="ltabs-wrap ">
                                <div className="ltabs-tabs-container">
                                    <div className="ltabs-tabs-wrap">
                                        <span className="ltabs-tab-selected"/>
                                        <span className="ltabs-tab-arrow">▼</span>
                                        <ul className="ltabs-tabs cf list-sub-cat font-title">
                                            <li className="ltabs-tab   tab-sel tab-loaded ">
                                                <span className="ltabs-tab-label" style={this.props.tabTitleStyle}>{cat_title}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div className="wap-listing-tabs products-list grid">
                                    <div className="ltabs-items-container">
                                        <div className="products-list ltabs-items  ltabs-items-selected ltabs-items-loaded items-category-sell">
                                            <div className="ltabs-items-inner owl2-carousel  ltabs-slider HomeItems">
                                                <ProductSlider products={products} showProductAddedModal={showProductAddedModal} quickView={quickView}/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
