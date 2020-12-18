import React from "react";
import {Link} from "react-router-dom";

export default class BreadcrumbComponent extends React.PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        let {title, is_sub, mainCatLink, mainCatTitle} = this.props;

        return (
            <div className="breadcrumbs ">
                <div className="container">
                    <ul className="breadcrumb">
                        <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                        {is_sub && <li><Link to={mainCatLink}>{mainCatTitle}</Link></li>}
                        <li><a>{title}</a></li>
                    </ul>
                </div>
            </div>
        );
    }
}
