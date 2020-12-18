import React, {Component} from 'react';
import {connect} from "react-redux";
import {getMultipleCategoryProducts} from "../../redux/actions/CategoryActions";
import {addProductToCart} from "../../redux/actions/CartActions";
import HomeSlider from "../layouts/HomeSlider";
import {Link} from "react-router-dom";
import QuickviewComponent from "../products/QuickviewComponent";
import ProductAddedModal from "../products/ProductAddedModal";
import {selectSalesProducts} from "../../redux/selectors/CategorySelector";
import SectionComponent from "./HomeComponents/SectionComponent";

class Home extends Component {
    constructor(props) {
        super(props);
        this.state = {
            quickView: null,
            productAdded: null,
        };
    }//..... end of constructor() .....//

    showModal = (prd = null) => {
        this.setState(prevState => {
            return {
                quickView: prd
            }
        })
    };

    showProductAddedModal = (prd = null) => {
        if (prd)
            this.props.addToCart(prd, 1);

        this.setState(() => {
            return {
                productAdded: prd
            }
        });
    };

    componentDidMount() {
        $('body').addClass('common-home');
        window.scrollTo(0, 0);
    }

    componentWillUnmount() {
        $('body').removeClass('common-home');
    }

    render() {
        let products = selectSalesProducts(this.props.categories, this.state.subCategoryFilter);

        return (
            <div id="content">
                <div className="so-page-builder">
                    <section id="h2-section-style1" className="h2-section-style1 box-content1 ">
                        <div className="container page-builder-ltr">
                            <div className="row row_gw42  ">
                                <div className="col-lg-3 col-md-3 col-sm-6 col-xs-12 col_bipa  col-style">
                                </div>
                                <div className="col-lg-9 col-md-9 col-sm-12 col-xs-12 col_6s4m ">
                                    <div className="module sohomepage-slider ">
                                        <div className="form-group">
                                        </div>
                                        <div className="modcontent">
                                            <HomeSlider/>
                                        </div>
                                        {/*/.modcontent*/}
                                        <div className="form-group">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div className="container page-builder-ltr">
                        <div className="row row_7qar  row-style ">
                            <div className="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_pfg8  col-style">
                                <ul className="block-infos">
                                    <li className="info1">
                                        <div className="inner">
                                            <div className="info-cont">
                                                <Link to={'/new-arrivals'}>New Arrivals</Link>
                                                <p className={'heart'}>Latest in Stock</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li className="info4">
                                        <div className="inner">
                                            <div className="info-cont">
                                                <Link to={'/discounted-products'}>Discounts</Link>
                                                <p className={'heart'}>Discounted Items</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div className="container page-builder-ltr">
                        <div className="row row_akx2  row-style ">
                            <SectionComponent key={'sale'} cat_title={'Sale/Discounted Products'} cat_img={saleCategoryBanner ? '/uploads/'+saleCategoryBanner : "/assets/frontend/image/sale.jpg"} cat_slug={`discounted-products`} products={products} showProductAddedModal={this.showProductAddedModal} quickView={this.showModal} tabTitleStyle={{fontSize: '25px'}}/>

                            {this.props.categories.map(cat => {
                                return (
                                    cat.products && cat.products.products ?
                                        <SectionComponent key={cat.id} cat_title={cat.title} cat_img={'/uploads/'+cat.image} cat_slug={cat.slug} products={cat.products.products} showProductAddedModal={this.showProductAddedModal} quickView={this.showModal}/> : ''
                                );
                            })}

                        </div>
                    </div>
                </div>

                {this.state.quickView &&
                <QuickviewComponent onHide={this.showModal}  prd={this.state.quickView} />}

                {this.state.productAdded && <ProductAddedModal prd={this.state.productAdded} showProductAddedModal={this.showProductAddedModal}/>}

            </div>

        );
    }//..... end of render() .....//
}//..... end of Home.

const mapStateToProps = (state) => {
    return {
        categories: state.categories.categories
    }
};

const mapDispatchToProps = (dispatch) => {
    return {
        multipleCategoriesProducts: (ids) => dispatch(getMultipleCategoryProducts(ids)),
        addToCart: (prd, qty) => dispatch(addProductToCart(prd, qty))
    };
};

export default connect(mapStateToProps, mapDispatchToProps)(Home);
