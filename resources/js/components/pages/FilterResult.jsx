import React, {Component} from 'react';
import {
    selectAllSubCategories,
    selectFilterProducts
} from "../../redux/selectors/CategorySelector";
import InputRange from "react-input-range";
import HomeProductItem from "../products/HomeProductItem";
import QuickviewComponent from "../products/QuickviewComponent";
import ProductAddedModal from "../products/ProductAddedModal";
import {getCategoryProducts} from "../../redux/actions/CategoryActions";
import {addProductToCart} from "../../redux/actions/CartActions";
import {connect} from "react-redux";

class FilterResult extends Component {
    constructor(props) {
        super(props);
        this.state = {
            loader: false,
            subCategoryFilter: [],
            quickView: null,
            productAdded: null,
            value: {
                min: 1,
                max: 20000,
            },
        };
    }//..... end of constructor() .....//

    componentDidMount() {
        /*if (this.props.products.length == 0)
            this.props.loadData(this.props.mainCategory.id);*/
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        /*if (prevProps.mainCategory.id != this.props.mainCategory.id)
            if (this.props.products.length == 0)
                this.props.loadData(this.props.mainCategory.id);*/
    }

    handleSubCategoryFilter = (id, e) => {
        let condition = e.target.checked;
        this.setState((prevState) => {
            return {subCategoryFilter: condition ? [...prevState.subCategoryFilter, id] : prevState.subCategoryFilter.filter(cid => cid != id)};
        });
    };

    showModal = (prd) => {
        this.setState(prevState => {
            return {
                quickView: prd
            }
        })
    };

    showProductAddedModal = (prd) => {
        if (prd)
            this.props.addToCart(prd, 1);

        this.setState(() => {
            return {
                productAdded: prd
            }
        });
    };

    render() {
        let products = selectFilterProducts(this.props.categories, this.state.subCategoryFilter, this.state.value, this.props.filters);
        return (
            <>
                <hr/>
                <section className="productListing">
                    <div className="container">
                        <div className="row">
                            <div className="col-sm-4 col-md-2" id="Sidebarfilter">
                                <div className="panel-group category_group" id="accordion">
                                    <div className="panel panel-default category_default">
                                        <div className="panel-heading category_heading">
                                            <h4 className="panel-title">
                                                <a>
                                                    <span className="glyphicon"></span>Price Range <span className="pull-right"/>
                                                </a>
                                            </h4>
                                        </div>
                                        <div>
                                            <div className="panel-body category_body priceRange">
                                                <InputRange
                                                    formatLabel={value => `Rs: ${value}`}
                                                    draggableTrack
                                                    maxValue={20000}
                                                    minValue={0}
                                                    onChange={value => this.setState({ value: value })}
                                                    value={this.state.value} />
                                                <div className="sidePrices">
                                                    &nbsp;
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="panel panel-default category_default">
                                        <div className="panel-heading category_heading">
                                            <h4 className="panel-title">
                                                <a><span className="glyphicon"></span>Sub Category</a>
                                            </h4>
                                        </div>
                                        <div>
                                            <div className="panel-body category_body">
                                                <ul className="categoryList list-unstyled sideList brand">
                                                    { this.props.subCategories.map(scat => {
                                                        return (
                                                            <li key={scat.id}>
                                                                <label>
                                                                    <input type="checkbox" className="subcategory" onChange={e => this.handleSubCategoryFilter(scat.id, e)} defaultValue={scat.id}/> { scat.title }
                                                                </label>
                                                            </li>
                                                        );
                                                    })}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-sm-10 col-md-10 col-lg-10">
                                <div className="productSlider" style={{borderRight: '1px solid #e1e1e1', borderLeft: '1px solid #e1e1e1', borderTop: '2px solid rgb(94, 153, 30)'}}>
                                    <div>
                                        <ul style={{padding: '0px'}} className="owl-carousel  owl-theme catProSlider list-inline indexProductList p-hover shopList">
                                            {products.map(prd => {
                                                return (
                                                    <HomeProductItem key={prd.id} prd={prd} showModal={this.showModal} showProductAddedModal={this.showProductAddedModal}/>
                                                );
                                            })}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
                {this.state.quickView && <QuickviewComponent prd={this.state.quickView} showModal={this.showModal}/>}
                {this.state.productAdded && <ProductAddedModal prd={this.state.productAdded} showProductAddedModal={this.showProductAddedModal}/>}
            </>);
    }//..... end of render() .....//
}//..... end of FilterResult.

const mapStateToProps = (state, props) => {
    return {
        categories: state.categories.categories,
        subCategories: selectAllSubCategories(state.categories.categories),
        filters: state.common.globalFilter
    }
};

const mapDispatchToProps = (dispatch) => {
    return {
        loadData: (category_id) => dispatch(getCategoryProducts(category_id)),
        addToCart: (prd, qty) => dispatch(addProductToCart(prd, qty))
    };
};

export default connect(mapStateToProps, mapDispatchToProps)(FilterResult);
