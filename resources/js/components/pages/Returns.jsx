import React, {Component} from 'react';

class Returns extends Component {
    constructor(props) {
        super(props);
        this.state = {
            selectedTab: 'howToReturn'
        };
    }//..... end of constructor() .....//

    handleTabClick = (selectedTab) => {
        this.setState(() => ({selectedTab}));
    };

    render() {
        return (
            <>
                <section className="mainCatSection innercatbg" style={{backgroundPosition: 'center left', backgroundColor: 'rgb(132, 132, 132)'}}>
                    <div className="main-overlay" style={{ backgroundColor: 'rgb(177, 235, 0)' ,opacity:0.6 }}>&nbsp;</div>
                    <div className="container">
                        <div className="row">
                            <div className="col-xs-12">
                                <h1>Returns and Refunds <small>GulAutos</small></h1>
                            </div>
                        </div>
                    </div>
                </section>

                <div className="container returnPage" style={{padding: '50px 0px'}}>
                    <div className=" margin-top-20 margin-btm-30">
                        <ul className="nav nav-pills nav-justified">
                            <li className={this.state.selectedTab == 'howToReturn' ? 'active':''}>
                                <a href="#" onClick={(e) => {e.preventDefault(); this.handleTabClick('howToReturn');}}>How to Return a Product</a>
                            </li>
                            <li className={this.state.selectedTab == 'returnPolicy' ? 'active':''} style={{padding: '0 10px'}}>
                                <a href="#" onClick={(e) => {e.preventDefault(); this.handleTabClick('returnPolicy');}}>Returns Policy</a>
                            </li>
                            <li className={this.state.selectedTab == 'refundPolicy' ? 'active':''}>
                                <a href="#" onClick={(e) => {e.preventDefault(); this.handleTabClick('refundPolicy');}}>Refunds Policy</a>
                            </li>
                        </ul>
                    </div>
                    <div className=" ">

                        {this.state.selectedTab === 'returnPolicy' &&
                        <div className="col-sm-8">
                            <div className="row">
                                <div className="col-sm-10">
                                    <h3 style={{marginTop: 0}}>Returns Policy</h3>
                                    <ol className="custom-counter">
                                        <li>If your product is defective / damaged or the order is Incorrect/Incomplete at the time of delivery, please contact us within the applicable time period of return. Your product may be eligible for refund or replacement depending on the product category and condition. Please see the detailed terms in the relevant category below</li>
                                        <li>Please note that not all products are eligible for a return, if the product is "No longer needed"</li>
                                        <li>For device related issues after usage or the expiration of the return window, we will refer you to the brand warranty center (if applicable). For more information on warranty claims please view our<a href="/terms-conditions"> Warranty Policy</a></li>
                                    </ol>
                                    <p>You will always find the relevant terms on the product page (Return Policy tab).</p>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-sm-10">
                                    <h3>Valid reasons to return an item</h3>
                                    <ol className="custom-counter">
                                        <li>Delivered Product is damaged (physically destroyed or broken) / defective (dead on arrival)</li>
                                        <li>Delivered Product is Incorrect (different than the one presented on our website) / Incomplete (missing parts)</li>
                                        <li>
                                            Delivered Product is “No longer needed”* (implies that you no longer have a use for the product / you have changed your mind about the purchase / the size of a fashion product does not fit / you do not like the product after opening the package) *Eligible for selected products only
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        }

                        {this.state.selectedTab === 'howToReturn' &&
                        <div className="col-sm-8">
                            <ul className="custom-counter return-product-step margin-btm-30">
                                <li>
                                    <div className="row">
                                        <div className="col-sm-10" style={{marginTop: '-20px'}}>
                                            <p>Call <strong>03101-6000011</strong> to create your <strong>return request</strong></p>
                                        </div>
                                        <div className="col-sm-2" style={{marginTop: '-45px'}}>
                                            <img src="/images/73eebeabdcdf4542f7a7d900a80fcf43.jpg" alt="" style={{}} />
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div className="row">
                                        <div className="col-sm-10" style={{marginTop: '-20px'}}>
                                            <p className="liwidth">Repack your GulAutos.PK parcel securely with the product in the<strong> original undamaged manufacturer's packaging</strong> you received, on the time of delivery</p>
                                        </div>
                                        <div className="col-sm-2" style={{marginTop: '-45px'}}>
                                            <img src="/images/466c6658c502b7419e3db9c935edf935.jpg" alt="" />
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div className="row">
                                        <div className="col-sm-10" style={{marginTop: '-20px'}}>
                                            <p className="liwidth">Attach the <strong>return label</strong>, that you received with your order, to the top of the parcel (ensure that the delivery label is covered/secured)</p>
                                        </div>
                                        <div className="col-sm-2" style={{marginTop: '-45px'}}>
                                            <img src="/images/54e3e583eacb556eb0b40865eb4e2032.jpg" alt="" />
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div className="row">
                                        <div className="col-sm-10" style={{marginTop: '-20px'}}>
                                            <p className="liwidth">Send To Our Gul Autos Head Office Branch <br /> <strong>Address: </strong>GulAutos.PK, Tehkal, Tambwano Morr, Near with ZONG Head Office, University Road, Peshawar, Pakistan</p>
                                        </div>
                                        <div className="col-sm-2" style={{marginTop: '-45px'}}>
                                            <img src="/images/291acb62d7b09ea08fcf57dccbdddfa5.jpg" alt="" />
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        }


                        {this.state.selectedTab === 'refundPolicy' &&
                        <div className="col-sm-8">
                            <div className="row">
                                <div className="col-sm-10">
                                    <h3 style={{marginTop: 0}}>Issuance of Refunds</h3>
                                    <p>If your product is eligible for a refund, you can choose your preferred refund method based on the table below. The shipping fee is not refunded along with the amount paid for your returned product.</p>
                                    <p>The time required to complete a refund depends on the refund method you have selected. The expected processing time mentioned below is after we have received your product (2-3 working days) and it has undergone a quality control (1-2 working days).</p>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-sm-10 margin-top-20">
                                    <table className="table table-bordered refund-table">
                                        <thead>
                                        <tr>
                                            <th className="th" style={{textAlign: 'left'}}>Payment Method</th>
                                            <th className="th" style={{textAlign: 'left'}}>Refund Option</th>
                                            <th className="th" style={{textAlign: 'left', width: '34%'}}>Refund Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td rowSpan={2} className="trgap">1 Link Bank Transfer</td>
                                            <td rowSpan={1}>Bank Deposit</td>
                                            <td>20 working days</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-sm-10 margin-top-10 margin-btm-30">
                                    <section id className="acrdion-main block-acrdion-main">
                                        <h3 style={{marginTop: 0}}>Modes of Refund</h3>
                                        <div className="panel-group accordion-content" id="accordion">
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a className="accordion-toggle">Bank Deposit</a><i className="indicator glyphicon glyphicon-chevron-down  pull-right" /></h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: 'block'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck " style={{display: 'block'}}>
                                                            <div className="question ">
                                                                <p>The bank account details provided must be correct and the account must be active and should hold some balance. Do not provide account details of Basic Bank Account (BBA), National Bank and Khyber bank as refunds for these modes cannot be processed.</p>
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
                        }

                        {this.state.selectedTab !== 'refundPolicy' &&
                        <div className="col-sm-4">
                            <div className="boxed">
                                <h3 style={{textAlign: 'center'}}>Conditions for Returns</h3>
                                <ol className="olclass" style={{marginTop: '-4px'}}>
                                    <li>
                                        The product must be unused, unworn, unwashed and without any flaws. Fashion products can be tried on to see if they fit and will still be considered unworn. If a product is returned to us in an inadequate condition, we reserve the right to send it back to you.
                                    </li>
                                    <li>The product must include the original tags, user manual, warranty cards, freebies and accessories.</li>
                                    <li>The product must be returned in the original and undamaged manufacturer packaging / box. If the product was delivered in a second layer of GulAutos.pk packaging, it must be returned in the same condition with return shipping label attached. Do not put tape or stickers on the manufacturers box.</li>
                                </ol>
                            </div>
                        </div>
                        }
                    </div>
                </div>
            </>
        );
    }//..... end of render() .....//
}//..... end of Returns.

export default Returns;
