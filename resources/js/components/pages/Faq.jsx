import React, {Component} from 'react';
import {Link} from "react-router-dom";

class Faq extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    render() {
        return (
            <>
                <section className="mainCatSection innercatbg" style={{backgroundPosition: 'center left', backgroundColor: 'rgb(132, 132, 132)'}}>
                    <div className="main-overlay" style={{ backgroundColor: 'rgb(177, 235, 0)' ,opacity:0.6 }}>&nbsp;</div>
                    <div className="container">
                        <div className="row">
                            <div className="col-xs-12">
                                <h1>FAQ <small>BangashAutos</small></h1>
                            </div>
                        </div>
                    </div>
                </section>

                <div className="container returnPage" style={{padding: '50px 0px'}}>
                    <div className>
                        <div className="col-sm-12">
                            <div className="row">
                                <div className="col-sm-12 margin-top-10 margin-btm-30">
                                    <section id className="acrdion-main block-acrdion-main">
                                        <h3 style={{marginTop: 0}}>Frequently Asked Questions</h3>
                                        <div className="panel-group accordion-content" id="accordion">
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a className="accordion-toggle">How can I pay for the product(s)?</a><i className="indicator glyphicon glyphicon-chevron-down  pull-right" /></h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: 'block'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck " style={{display: 'block'}}>
                                                            <div className="question ">
                                                                <p>
                                                                    There are four methods through which you can pay on BangashAutos.pk by using your debit/credit cards, EasyPaisa mobile accounts or via any EasyPaisa Shop, though the fourth method Cash on Delivery (COD) is only available in a few selected cities. For more details visit our Payment Options page.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a className="accordion-toggle">How can I track the product(s) I have ordered?</a><i className="indicator glyphicon glyphicon-chevron-down  pull-right" /></h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: 'block'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck " style={{display: 'block'}}>
                                                            <div className="question ">
                                                                <p>
                                                                    Yes, product(s) can be returned if and only if the returned commodity fulfills our Returns Policy. To know about our returns policy kindly visit the Returns Policy page, for returning a product go to our Returns page. To know about how to obtain a refund go to our Refunds Policy page.
                                                                </p>
                                                                <p>
                                                                    If you have any specific queries <Link to={'/contact'}>Contact Us</Link>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </>
        );
    }//..... end of render() .....//
}//..... end of Faq.

export default Faq;
