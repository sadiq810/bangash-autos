import React from 'react';

export default class LayoutOptionsComponent extends React.PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        let {selectedLayout, layoutHandler} = this.props;
        return (
            <div className="product-filter product-filter-top filters-panel">
                <div className="row">
                    <div className="col-sm-5 view-mode">
                        <div className="list-view">
                            <div className="btn btn-gridview">Grid View:</div>
                            <button type="button" className={ (selectedLayout == 2 ? 'active' : '') + " btn btn-view hidden-sm hidden-xs" } onClick={() => layoutHandler(2)}>2</button>
                            <button type="button" className={ (selectedLayout == 3 ? 'active' : '') + " btn btn-view hidden-sm hidden-xs" } onClick={() => layoutHandler(3)}>3</button>
                            <button type="button" className={ (selectedLayout == 4 ? 'active' : '') +  " btn btn-view hidden-sm hidden-xs"} onClick={() => layoutHandler(4)}>4</button>
                            <button type="button" className={ (selectedLayout == 5 ? 'active' : '') +  " btn btn-view hidden-sm hidden-xs"} onClick={() => layoutHandler(5)}>5</button>
                            <button type="button" className={ (selectedLayout == 'grid' ? 'active' : '') +  " btn btn-default grid hidden-lg hidden-md"} title="Grid" onClick={() => layoutHandler('grid')}><i className="fa fa-th-large"/></button>
                            <button type="button" id="list-view" className={ (selectedLayout == 'list' ? 'active' : '') +  " btn btn-default list"} title="List" onClick={() => layoutHandler('list')}><i className="fa fa-bars"/></button>
                            <button type="button" id="table-view" className={ (selectedLayout == 'grid' ? 'active' : '') +  " btn btn-view"} onClick={() => layoutHandler('grid')}><i className="fa fa-table" aria-hidden="true"/></button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
