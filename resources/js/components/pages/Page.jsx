import React, {Component} from 'react';
import {Link, withRouter} from 'react-router-dom';
import parser from 'html-react-parser'

class Page extends Component {
    constructor(props) {
        super(props);
        this.state = {
            title: '',
            detail: '',
            loader: false
        };
    }//..... end of constructor() .....//

    componentDidMount() {
        this.loadData();
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevProps.match.params.pageName != this.props.match.params.pageName)
            this.loadData();
    }

    loadData = () => {
        let pageName = this.props.match.params.pageName;
        this.setState({loader: true});

        fetch(   BaseUrl+"/api/get-page-detail",{
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                pageName
            }),
        })
            .then(response => response.json())
            .then(json => {
                this.setState(() => ({
                    title: json.data.title || '',
                    detail: json.data.detail || '',
                    loader: false,
                }));
            }).catch(err => {
            this.setState({loader: false});
        });
    };

    render() {
        return (
            <div className={'container'}>
                <ul className="breadcrumb">
                    <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                    <li><a href="#">{ this.state.title }</a></li>
                </ul>
                <div className="row">
                    <div id="content" className="col-sm-12 item-article">
                        <div className="page_warranity">
                            <h3 className="color font30">{ this.state.title }</h3>
                            <p>
                                {parser(this.state.detail)}
                            </p>
                            <hr className="hr-lg" />
                        </div>
                    </div>
                </div>

            </div>
        );
    }//..... end of render() .....//
}//..... end of Page.

export default withRouter(Page);
