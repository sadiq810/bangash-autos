import React from "react";
import {Link} from "react-router-dom";

export default class SubCategoryFilterOptions extends React.PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        let {isCatListShown, handleCatVisibility, categories, mainCategory, title} = this.props;
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

                        <ul className="accordion" id="accordion-category">
                            { categories.map(scat => {
                                return (
                                    <li key={scat.id} style={{width: '100%'}}>
                                        <Link to={'/'+mainCategory.slug+'/'+scat.slug}>{ scat.title }</Link>
                                    </li>
                                );
                            })}
                        </ul>

                    </div>
                </div>
            </li>
        );
    }
}
