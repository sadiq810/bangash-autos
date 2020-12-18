import React, {Component} from 'react';
import {getCategoryProducts} from "../../redux/actions/CategoryActions";
import {addProductToCart} from "../../redux/actions/CartActions";
import {connect} from "react-redux";
import {Link} from "react-router-dom";
import QuickviewComponent from "../products/QuickviewComponent";
import ProductAddedModal from "../products/ProductAddedModal";
import 'react-input-range/lib/css/index.css';
import Pagination from "react-js-pagination";
import LoaderComponent from "../layouts/LoaderComponent";
import LayoutOptionsComponent from "./CategoriesComponents/LayoutOptionsComponent";
import ProductComponent from "./CategoriesComponents/ProductComponent";
import SearchComponent from "./CategoriesComponents/SearchComponent";
import SubCategoryFilterOptions from "./CategoriesComponents/SubCategoryFilterOptions";
import PriceRangeOptionComponent from "./CategoriesComponents/PriceRangeOptionComponent";
import BreadcrumbComponent from "./CategoriesComponents/BreadcrumbComponent";

class SubCategory extends Component {
    constructor(props) {
        super(props);
        this.state = {
            selectedLayout: 4,
            layoutConfigurations: {
                2:  'product-grid product-grid-2 col-lg-6 col-md-6 col-sm-6',
                3: 'product-grid product-grid-3 col-lg-4 col-md-4 col-sm-6',
                4: 'product-grid product-grid-4 col-lg-3 col-md-4 col-sm-6',
                5: 'product-grid product-grid-5 col-lg-15 col-md-4 col-sm-6',
                list: 'product-list',
                grid: 'product-table'
            },
            subCategoryFilter: [],
            quickView: null,
            productAdded: null,
            min: 1,
            max: 1000000,
            selectedImageView: {},
            isSubCatListShown: true,
            searchText: '',
            activePage: 1,
            total: 0,
            products: [],
            perPage: 20,
            loader: false,
        };
    }//..... end of constructor() .....//

    handleSubCategoryVisibility = () => {
        this.setState(prevState => ({isSubCatListShown: !prevState.isSubCatListShown}))
    };

    handleImageView = (prd_id, image) => {
        this.setState((prevState) => {
            let selectedImageView = prevState.selectedImageView;
            selectedImageView[prd_id] = image;
            return {
                selectedImageView
            };
        });
    };

    layoutHandler = (layout) => {
        this.setState(() => ({selectedLayout: layout}))
    };


    componentDidMount() {
        this.setState(() => ({total: this.props.total || 0, products: this.props.products, subCategoryFilter: [this.props.subCategory.id]}), () => this.loadData());
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevProps.mainCategory.id != this.props.mainCategory.id)
                this.loadData();

            if (prevProps.subCategory.id != this.props.subCategory.id)
                this.setState(() => ({subCategoryFilter: [this.props.subCategory.id], products: []}), () => this.loadData());
    }

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

    handleSearchInput = (e) => {
        let searchText = e.target.value;
        this.setState(() => ({searchText}));
    };

    loadData = (page = 1) => {
        let category_id = this.props.mainCategory.id;
        this.setState({loader: true});

        fetch(   BaseUrl+"/api/products-paginate",{
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                category_id: category_id,
                page,
                searchText: this.state.searchText,
                subCategories: this.state.subCategoryFilter,
                min: this.state.min,
                max: this.state.max
            }),
        })
            .then(response => response.json())
            .then(json => {
                this.setState(() => ({
                    products: json.data,
                    total: json.total,
                    activePage: json.currentPage,
                    perPage: json.perPage,
                    loader: false,
                }));
            }).catch(err => {
            this.setState({loader: false});
        });
    };

    performSearch = () => {
        this.loadData();
    };

    handlePageChange = (pageNumber) => {
        this.loadData(pageNumber);
    };

    handleRange = (field, value) => {
        if (isFinite(value))
            this.setState({[field] : value});
    };

    render() {
        let products = this.state.products;

        return (
            <>
                <BreadcrumbComponent title={this.props.subCategory.title} is_sub={true} mainCatTitle={this.props.mainCategory.title} mainCatLink={`/${this.props.mainCategory.slug}`}/>

                <div className="container product-listing content-main ">
                    <div className="row">
                        <div id="content" className="col-md-9 col-sm-12 col-xs-12 fluid-sidebar">
                            <div className="products-category clearfix">
                                <h3 className="title-category ">{this.props.subCategory.title}</h3>
                                <LayoutOptionsComponent selectedLayout={this.state.selectedLayout} layoutHandler={this.layoutHandler}/>

                                <div className="products-list row nopadding-xs so-filter-gird">
                                    {products.map(prd => {
                                        return (
                                            <ProductComponent key={prd.id} handleImageView={this.handleImageView} prd={prd} showModal={this.showModal} selectedImageView={this.state.selectedImageView} layoutConfigurations={this.state.layoutConfigurations} selectedLayout={this.state.selectedLayout} showProductAddedModal={this.showProductAddedModal}/>
                                        )
                                    })}
                                </div>
                                <div className="product-filter product-filter-bottom filters-panel">
                                    <div className="row">
                                        <div className="col-sm-6 text-left">
                                            <Pagination
                                                activePage={this.state.activePage}
                                                itemsCountPerPage={this.state.perPage}
                                                totalItemsCount={this.state.total}
                                                onChange={this.handlePageChange}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <aside className="col-md-3 col-sm-4 col-xs-12 content-aside right_column sidebar-offcanvas">
                            <span id="close-sidebar" className="fa fa-times"/>
                            <div className="module so_filter_wrap block-shopby">
                                <div className="modcontent">
                                    <ul>
                                        <SearchComponent handleSearchInput={this.handleSearchInput} performSearch={this.performSearch} searchText={this.state.searchText}/>
                                        <SubCategoryFilterOptions isCatListShown={this.state.isSubCatListShown} handleCatVisibility={this.handleSubCategoryVisibility} categories={this.props.mainCategory.sub_categories} mainCategory={this.props.mainCategory} title={this.props.mainCategory.title +"- Sub Categories"}/>
                                        <PriceRangeOptionComponent min={this.state.min} max={this.state.max} handleRange={this.handleRange} loadData={this.loadData}/>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>

                {this.state.loader && <LoaderComponent />}
                {this.state.quickView &&
                <QuickviewComponent onHide={this.showModal}  prd={this.state.quickView} />}
                {this.state.productAdded && <ProductAddedModal prd={this.state.productAdded} showProductAddedModal={this.showProductAddedModal}/>}
            </>
        )
    }//..... end of render() .....//
}//..... end of Category.

const mapStateToProps = (state, props) => {
    return {
        products : props.mainCategory.products == undefined ? [] :  props.mainCategory.products.products,
        total: props.mainCategory.products ? props.mainCategory.products.total: 0,
        loaded: props.mainCategory.products ? props.mainCategory.products.loaded: 0
    }
};

const mapDispatchToProps = (dispatch) => {
    return {
        loadData: (category_id) => dispatch(getCategoryProducts(category_id)),
        addToCart: (prd, qty) => dispatch(addProductToCart(prd, qty))
    };
};

export default connect(mapStateToProps, mapDispatchToProps)(SubCategory);
