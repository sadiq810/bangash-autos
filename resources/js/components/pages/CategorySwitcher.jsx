import React, {Component} from 'react';
import {withRouter} from 'react-router-dom';
import {connect} from 'react-redux';
import SubCategory from "./SubCategory";
import Category from "./Category";

class CategorySwitcher extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    render() {
        let {subCategory: subCategorySlug} = this.props.match.params;
        let mainCategorySlug = this.props.match.url.split('/')[1];
        let mainCategory = null;
        let subCategory = null;

        mainCategory = this.props.categories.filter(cat => cat.slug === mainCategorySlug).pop();

        if (subCategorySlug) {
            subCategory = mainCategory.sub_categories.filter(subg => subg.slug === subCategorySlug).pop();
            return <SubCategory mainCategory={mainCategory} subCategory={subCategory} />
        } else {
            return <Category mainCategory={mainCategory} />
        }//..... end if-else() .....//
    }//..... end of render() .....//
}//..... end of Categories.

const mapStateToProps = (state) => {
    return {
        categories: state.categories.categories
    }
};

export default connect(mapStateToProps)(withRouter(CategorySwitcher));
