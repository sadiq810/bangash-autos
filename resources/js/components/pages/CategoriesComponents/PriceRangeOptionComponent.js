import React from 'react';

export default class PriceRangeOptionComponent extends React.PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        let {min, max, handleRange, loadData} = this.props;

        return (
            <li className="so-filter-options" data-option="Price">
                <div className="so-filter-heading">
                    <div className="so-filter-heading-text">
                        <span>Price</span>
                    </div>
                    <i className="fa fa-chevron-down"/>
                </div>
                <div className="so-filter-content-opts">
                    <div className="so-filter-content-opts-container" style={{height: '50px', clear: 'both'}}>

                        <div className="put-min put-min_max">
                            <span className="name-curent" style={{float: 'left', padding: '6px'}}>Rs</span>
                            <input type="text" className="input_min form-control" min={0} max={9999999} value={min} style={{width: '70px', float: 'right'}} onChange={(e) => handleRange('min', e.target.value)} onBlur={() => loadData()}/>
                        </div>
                        <div className="put-max put-min_max">
                            <span className="name-curent" style={{float: 'left', padding: '6px'}}>Rs</span>
                            <input type="text" className="input_min form-control" min={0} max={9999999} value={max} style={{width: '70px', float: 'right'}} onChange={(e) => handleRange('max', e.target.value)} onBlur={() => loadData()}/>
                        </div>
                    </div>
                </div>
            </li>
        );
    }
}
