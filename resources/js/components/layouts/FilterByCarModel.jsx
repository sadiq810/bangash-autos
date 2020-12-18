import React, {Component} from 'react';
import {connect} from "react-redux";
import {withRouter} from 'react-router-dom';
import {selectVersionsFromSelectModelsOfProducts} from "../../redux/selectors/CategorySelector";

class FilterByCarModel extends Component {
    constructor(props) {
        super(props);
        this.state = {
            models: [],
            selectedModel: null,
            versions: [],
            selectedVersion: null
        };
    }//..... end of constructor() .....//

    handleModelLoad = (models) => {
        this.setState(() => ({models, selectedModel: {}, versions: [], selectedVersion: null}))
    };

    handleModelClick = (model) => {
        this.setState(() => ({selectedModel: model, versions: [], selectedVersion: null}), () => this.populateVersions());
    };

    handleVersionClick = (version) => {
        this.setState(() => ({selectedVersion: version}));
    };

    populateVersions = () => {
        const versions = selectVersionsFromSelectModelsOfProducts(this.props.categories, this.state.selectedModel);
        this.setState(() => ({versions}))
    };

    windowClosedEvent = () => {
        this.setState(() => ({selectedModel: null, versions: [], selectedVersion: null}));
    };

    performFilterHandler = () => {
        $('#CarFilterModal').modal('hide');
        this.props.dispatch({type: 'SET_GLOBAL_FILTER_DATA', payload: this.state});
        this.props.history.push('/products-filter')
    };

    render() {
        return (
            <div id="CarFilterModal" className="get-car-name in modal fade" role="dialog">
                <div className="modal-dialog" style={{width: '902px'}}>
                    <div className="modal-content">
                        <div className="modal-body clearfix">
                            <div className="col col-3 cat-selection makes pull-left active">
                                <div className="header-car-info arrow-right">Make</div>
                                <div className="form-group nomargin">
                                    <h5 className="listing-title">Popular</h5>
                                    <ul className="fs14 get-listing make-listings">
                                        { this.props.brands.map(brand => {
                                            return <li key={brand.id} className={this.state.models.length > 0 && this.state.models[0].parent == brand.id ? "model active": "model"} onClick={() => this.handleModelLoad(brand.models)}>
                                                <a href="#">{brand.title}<i className="fa fa-angle-right"/>
                                                </a>
                                            </li>
                                        })}
                                    </ul>
                                </div>
                            </div>
                            <div className="col col-3 cat-selection models pull-left">
                                <div className="header-car-info arrow-right">Model</div>
                                <div className="form-group nomargin">
                                    <ul className="model-listings fs14 get-listing models_for_42">
                                        { this.state.models.map(model => {
                                            return <li key={model.id} className={this.state.selectedModel && this.state.selectedModel.id == model.id ? "model active": "model"} onClick={() => this.handleModelClick(model)}>
                                                <a href="#">{model.title}<i className="fa fa-angle-right"/>
                                                </a>
                                            </li>
                                        })}
                                    </ul>
                                </div>
                            </div>
                            <div className="col col-3 cat-selection versions pull-left">
                                <div className="header-car-info arrow-right">Version</div>
                                <div className="form-group nomargin version-listings-outer">
                                    <ul className="fs14 get-listing version-listings">
                                        { this.state.versions.map(version => {
                                            return <li key={version} className={this.state.selectedVersion && this.state.selectedVersion == version ? "version active": "version"} onClick={() => this.handleVersionClick(version)}>
                                                <a href="#">{version}<i className="fa fa-angle-right"/>
                                                </a>
                                            </li>
                                        })}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div className="modal-footer">
                            <a href="#" className="btn btn-primary" onClick={this.performFilterHandler}>Done</a>
                            <button className="btn btn-danger" data-dismiss="modal" onClick={this.windowClosedEvent}>Close</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }//..... end of render() .....//
}//..... end of FilterByCarModel.

const mapStateToProps = (state) => {
    return {
        brands: state.common.brands,
        categories: state.categories.categories
    }
};

export default connect(mapStateToProps)(withRouter(FilterByCarModel));
