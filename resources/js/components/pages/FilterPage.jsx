import React, {Component} from 'react';
import {addProductToCart} from "../../redux/actions/CartActions";
import {connect} from "react-redux";
import QuickviewComponent from "../products/QuickviewComponent";
import ProductAddedModal from "../products/ProductAddedModal";
import 'react-input-range/lib/css/index.css';
import Pagination from "react-js-pagination";
import LoaderComponent from "../layouts/LoaderComponent";
import LayoutOptionsComponent from "./CategoriesComponents/LayoutOptionsComponent";
import SearchComponent from "./CategoriesComponents/SearchComponent";
import PriceRangeOptionComponent from "./CategoriesComponents/PriceRangeOptionComponent";
import ProductComponent from "./CategoriesComponents/ProductComponent";
import CategoryFilterOptions from "./CategoriesComponents/CategoryFilterOptions";
import BreadcrumbComponent from "./CategoriesComponents/BreadcrumbComponent";
import {withRouter} from 'react-router-dom';

class FilterPage extends Component {
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
            categoryFilter: [],
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
        this.loadData();
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevProps.location.search != this.props.location.search)
            this.loadData();
    }

    handleSubCategoryFilter = (id) => {
        this.setState((prevState) => {
            return {categoryFilter: prevState.categoryFilter.includes(id) ? prevState.categoryFilter.filter(cid => cid != id) : [...prevState.categoryFilter, id]};
        }, () => {
            this.loadData();
        });
    };

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
        this.setState({loader: true});
        let qs = this.props.location.search;

        fetch(   BaseUrl+"/api/filtered-products-paginate"+qs,{
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                categories: this.state.categoryFilter,
                page,
                searchText: this.state.searchText,
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

                window.scrollTo(0, 0);
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
                <BreadcrumbComponent title={'Filtered Products'} />

                <div className="container product-listing content-main ">
                    <div className="row">
                        <div className="col-md-9 col-sm-12 col-xs-12 fluid-sidebar">
                            <div className="products-category clearfix">
                                <h3 className="title-category ">Filtered Products</h3>
                                <div className="form-group category-info">
                                    <div className=" row">
                                    </div>
                                </div>

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
                                        <CategoryFilterOptions isCatListShown={this.state.isSubCatListShown} handleCatVisibility={this.handleSubCategoryVisibility} categories={this.props.categories} categoryFilter={this.state.categoryFilter} handleSubCategoryFilter={this.handleSubCategoryFilter} title={'Filter By Categories'}/>
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
        categories: state.categories.categories
    }
};

const mapDispatchToProps = (dispatch) => {
    return {
        addToCart: (prd, qty) => dispatch(addProductToCart(prd, qty))
    };
};

export default connect(mapStateToProps, mapDispatchToProps)(withRouter(FilterPage));
