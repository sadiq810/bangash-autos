import React from 'react';

export default class SearchComponent extends React.PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        let {searchText, handleSearchInput, performSearch} = this.props;
        return (
            <li className="so-filter-options" data-option="search">
                <div className="so-filter-heading">
                    <div className="so-filter-heading-text">
                        <span>Search</span>
                    </div>
                    <i className="fa fa-chevron-down"/>
                </div>
                <div className="so-filter-content-opts">
                    <div className="so-filter-content-opts-container">
                        <div className="so-filter-option">
                            <div className="so-option-container">
                                <div className="input-group">
                                    <input type="text" className="form-control" value={searchText} onChange={handleSearchInput}/>
                                    <div className="input-group-btn">
                                        <button className="btn btn-default" type="button" onClick={performSearch}>
                                            <i className="fa fa-search"/>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        );
    }
}
