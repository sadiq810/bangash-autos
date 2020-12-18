import React, {Component} from 'react';
import {Link, withRouter} from "react-router-dom";
import parser from "html-react-parser";
import {connect} from "react-redux";

class SearchComponent extends Component {
    constructor(props) {
        super(props);
        this.state = {
            searchResult: [],
            searchString: '',
            selectedBrand: undefined,
            selectedModel: undefined,
            year: ''
        };
    }//..... end of constructor() .....//

    CancelToken = null;
    call1 = null;

    handleSearchInput = (e) => {
        let str = e.target.value;
        this.setState(() => ({searchString: str, searchResult: []}), () => {
            if (str.length >= 3)
                this.handleSearchBtn();
        });
    };

    handleYearInput = (e) => {
        let year = e.target.value;
        this.setState({year});
    };

    handleSearchBtn = () => {
        if (this.call1) {
            this.call1.cancel('Operation canceled by the user.');
        }
        this.CancelToken = axios.CancelToken;
        this.call1 = this.CancelToken.source();
        if (this.state.searchString) {
            axios.get(BaseUrl+'/api/search?search='+this.state.searchString,
                {
                    cancelToken: this.call1.token
                }).then(response => {
                    if (this.state.searchString.length >= 3)
                        this.setState(() => ({searchResult: response.data.data}));
            }).catch(err => {
                console.log(err);
            })
        } else {
            this.setState(() => ({searchResult: []}));
        }
    };

    handleSearchCloseBtn = () => {
      this.setState(() => ({searchResult: [], searchString: ''}))
    };

    handleBrandChange = (event) => {
        let brandId = event.target.value;
        let brand = this.props.brands.find(b => b.id == brandId);
        this.setState({selectedBrand: brand ? brand : undefined, selectedModel: undefined});
    };

    handleModelChange = (event) => {
        let id = event.target.value;
        let model = this.state.selectedBrand.models.find(m => m.id == id);
        this.setState({selectedModel: model ? model : undefined});
    };

    render() {
        return (
            <div className="bottom2 col-lg-7 col-md-6 col-sm-6">
                <div className="search-header-w">
                    <div id="sosearchpro" className="sosearchpro-wrapper so-search ">
                        <div id="search0" className="search input-group form-group search__container">
                            <input className="autosearch-input form-control" onChange={this.handleSearchInput} type="text" value={this.state.searchString} size={80} autoComplete="off" placeholder="Search by Title..." onKeyPress={event => {
                                if (event.key === 'Enter') {
                                    this.handleSearchBtn()
                                }
                            }}/>

                            <span className="input-group-btn">
                                <button type="button" className="button-search btn btn-default btn-lg"  onClick={this.handleSearchBtn}>Search</button>
                            </span>
                        </div>
                        <div id="search01" className="search input-group form-group search__container">
                            <span className={'cntr__filter'}>
                                <select className="form-control search__select" style={{width: '24%', marginLeft: '10px'}} onChange={this.handleBrandChange} value={this.state.selectedBrand ? this.state.selectedBrand.id : ''}>
                                    <option value="" selected={'selected'}>Brand</option>
                                    { this.props.brands.map(brand => {
                                        return <option key={brand.id} value={brand.id}>{brand.title}</option>;
                                    })}
                                </select>

                                <select className="form-control search__select" style={{width: '24%', marginLeft: '10px'}}  onChange={this.handleModelChange} value={this.state.selectedModel ? this.state.selectedModel.id : ''}>
                                    <option value="" selected={'selected'}>Model</option>
                                    { this.state.selectedBrand && this.state.selectedBrand.models.map(model => {
                                        return <option key={model.id} value={model.id}>{model.title}</option>;
                                    })}
                                </select>

                                <input className="search__select form-control" onChange={this.handleYearInput} type="text" value={this.state.year} autoComplete="off" placeholder="Year" style={{width: '18%', marginLeft: '10px'}}/>
                                <Link to={'/filter'+'?brand='+(this.state.selectedBrand ? this.state.selectedBrand.id : '')+'&model='+(this.state.selectedModel ? this.state.selectedModel.id : '')+'&year='+this.state.year} className="btn--filter"><i className={'fa fa-search'}></i></Link>
                            </span>
                        </div>


                    </div>
                </div>

                {this.state.searchResult.length > 0 && (
                    <div style={{position: 'absolute', width: '85%', zIndex: 1000}}>
                        <ul className="dropdown-menu shoppingcart-box" style={{opacity: 1, width: '100%', marginTop: 0, visibility: 'visible', maxHeight: '500px', overflow: 'auto'}} >
                            <li className="content-item">
                                <table className="table table-striped" style={{marginBottom: '10px'}}>
                                    <tbody>
                                    {this.state.searchResult.map(prd => {
                                        return (
                                            <tr key={prd.id}>
                                                <td className="text-center size-img-cart">
                                                    <Link to={'/product/'+prd.slug} onClick={this.handleSearchCloseBtn}>
                                                        <img className="img-thumbnail lazyautosizes lazyloaded" data-sizes="auto"
                                                             src={`${BaseUrl}/uploads/thumbs/${prd.image[0]}`} alt={ prd.title} title={parser(prd.title)} sizes="64px"/>
                                                    </Link>
                                                </td>
                                                <td className="text-left" style={{verticalAlign: 'middle'}}>
                                                    <Link to={'/product/'+prd.slug} onClick={this.handleSearchCloseBtn}>{parser(prd.title)}</Link> <br/>
                                                </td>
                                                <td className="text-right" style={{verticalAlign: 'middle'}}>Rs { prd.final_price }</td>
                                            </tr>
                                        );
                                    })}
                                    </tbody>
                                </table>
                            </li>
                            <li>
                                <div className="checkout clearfix">
                                    <a className="btn btn-checkout pull-right" href="#" onClick={this.handleSearchCloseBtn}>Close</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                )}
            </div>
        );
    }//..... end of render() .....//
}//..... end of SearchComponent.

const mapStateToProps = (state) => {
    return {
        brands: state.common.brands
    }
};

export default connect(mapStateToProps)(SearchComponent);
