import React from "react";

export default class CategoryFilterOptions extends React.PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        let {isCatListShown, handleCatVisibility, categories, categoryFilter, handleSubCategoryFilter, title} = this.props;
        return (
            <li className="so-filter-options" data-option="Checkbox">
                <div className="so-filter-heading" style={{ paddingBottom: '35px'}}>
                    <div className="so-filter-heading-text">
                        <span>{title}</span>
                    </div>
                    <i className={isCatListShown ? "fa fa-chevron-down": "fa fa-chevron-right"} style={{ paddingTop: '5px', cursor: 'pointer'}} onClick={handleCatVisibility}/>
                </div>
                <div className="so-filter-content-opts" style={{ display: isCatListShown ? 'block': 'none'}}>
                    <div className="so-filter-content-opts-container">

                        { categories.map(scat => {
                            let condition = categoryFilter.includes(scat.id);

                            return (
                                <div key={scat.id} className={condition ? "so-filter-option opt-select opt_enable opt-select opt_active" : "so-filter-option opt-select opt_enable"} onClick={ () => handleSubCategoryFilter(scat.id)}>
                                    <div className="so-option-container">
                                        <div className="option-input">
                                            <span className={ condition ? "fa fa-check": "fa fa-square-o"}></span>
                                        </div>
                                        <label style={{marginLeft: '27px', marginTop: '-23px'}}>{ scat.title }</label>
                                    </div>
                                </div>
                            );
                        })}

                    </div>
                </div>
            </li>
        );
    }
}
