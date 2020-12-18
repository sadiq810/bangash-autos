import React, {Component} from 'react';
import {Link} from 'react-router-dom';

class Help extends Component {
    constructor(props) {
        super(props);
        this.state = {
            selectedTab: 'popular_questions',
            expended: 0
        };
    }//..... end of constructor() .....//

    setSelectedTab = (tab) => {
        this.setState(() => ({selectedTab: tab}))
    };

    handleExpended = (exp) => {
      this.setState((prevState) => ({expended: prevState.expended == exp ? 0 : exp}))
    };

    render() {
        return (
            <>
                <section className="mainCatSection innercatbg" style={{backgroundPosition: 'center left', backgroundColor: 'rgb(132, 132, 132)'}}>
                    <div className="main-overlay" style={{ backgroundColor: 'rgb(177, 235, 0)' ,opacity:0.6 }}>&nbsp;</div>
                    <div className="container">
                        <div className="row">
                            <div className="col-xs-12">
                                <h1>Help <small>Frequently Asked Questions</small></h1>
                            </div>
                        </div>
                    </div>
                </section>

                <div className="container" style={{padding: '50px 0px'}}>
                    <div className="helpPage">
                        <div className="col-sm-8" style={{paddingRight: '16px'}}>
                            <ul className="nav nav-pills">
                                <h3 style={{color: '#F68B1E'}}>Look up your question by issue type</h3>
                                <li className="col-sm-4">
                                    <a href="#" onClick={(e) => {e.preventDefault(); this.setSelectedTab('products_and_prices');}}>
                                        <img className="menu-img " src="/images/Prices-Products.png" alt=" " style={{height: '90px'}} />
                                        <h3 className="my-heading">Products &amp; Prices</h3>
                                    </a>
                                </li>
                                <li className="col-sm-4" style={{marginLeft: '3px'}}>
                                    <a href="#" onClick={(e) => {e.preventDefault(); this.setSelectedTab('order')}}>
                                        <img className="menu-img " src="/images/Buy.png" alt=" " style={{height: '90px'}} />
                                        <h3 className="my-heading">Order</h3>
                                    </a>
                                </li>
                                <li className="col-sm-4" style={{marginLeft: '3px'}}>
                                    <a href="#" onClick={(e) => {e.preventDefault(); this.setSelectedTab('payment')}}>
                                        <img className="menu-img " src="/images/Payment.png" alt=" " style={{height: '90px'}} />
                                        <h3 className="my-heading">Payment</h3>
                                    </a>
                                </li>
                                <li className="col-sm-4">
                                    <Link to={'/returns'} >
                                        <img className="menu-img " src="/images/Return.png" alt=" " style={{height: '90px'}} />
                                        <h3 className="my-heading">Returns &amp; Refunds</h3>
                                    </Link>
                                </li>
                                <li className="col-sm-4" style={{marginLeft: '3px'}}>
                                    <a href="#" onClick={(e) => {e.preventDefault(); this.setSelectedTab('delivery')}}>
                                        <img className="menu-img " src="/images/Delivery.png" alt=" " style={{height: '90px'}} />
                                        <h3 className="my-heading">Delivery</h3>
                                    </a>
                                </li>
                                <li className="col-sm-4" style={{marginLeft: '3px'}}>
                                    <a href="#" onClick={(e) => {e.preventDefault(); this.setSelectedTab('other_topics')}}>
                                        <img className="menu-img " src="/images/Other-Topics.png" alt=" " style={{height: '90px'}} />
                                        <h3 className="my-heading">Other Topics</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div className="col-sm-4" style={{paddingLeft: '15px'}}>
                            <h3 style={{color: '#F68B1E'}}>Learn more about us</h3>
                            <ul className="nav">
                                <li className="col-sm-6">
                                    <Link to={'/about-us'}>
                                        <img className="img-responsive" style={{padding: '5px', maxWidth: '100%'}} src="/assets/images/logo.png" alt="" />
                                        <h3 className="my-heading">About Us</h3>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div className="margin-btm-30">
                        <div className="col-xs-12 col-sm-8" style={{paddingRight: '15px'}}>
                            <div className="tab-content">
                                {this.state.selectedTab == 'popular_questions' &&
                                    <div className="tab-pane fade in active">
                                        <section className="acrdion-main block-acrdion-main">
                                            <div className="acrdion-title">
                                                <h3 style={{color: '#F68B1E'}}>Popular Questions</h3>
                                            </div>
                                            <div className="panel-group accordion-content" id="accordion">
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 1 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(1)}}>Are all products on GulAutos.PK original and genuine?</a>
                                                            <i className="indicator glyphicon glyphicon-chevron-down  pull-right" /></h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 1 ? 'block': 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 1 ? 'block': 'none'}}>
                                                                <div className="question ">
                                                                    <p>Yes, we are committed for offering our customers only 100% genuine and original products. We also take all necessary actions to ensure this. Any Any non-genuine products is immediately delisted from GulAutos.PK.</p>
                                                                    <p>Please send us an email on <a href="mailto:complains@GulAutos.pk">complains@GulAutos.pk</a> if you think a product listed on our website does not fulfill these standards.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 2 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(2)}}>How do I place an order? </a>
                                                            <i className="indicator glyphicon glyphicon-chevron-down  pull-right" /></h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 2 ? 'block': 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 2 ? 'block': 'none'}}>
                                                                <div className="question">
                                                                    <p>Shopping on GulAutos.PK is easy!</p>
                                                                    <p>Once you have found the product you want to buy, just follow the steps below:</p>
                                                                    <ul>
                                                                        <li>Click on ‘buy now’, to add this product to your cart</li>
                                                                        <li>Click on ‘Check out’ to confirm the order</li>
                                                                        <li>You will then need to fill in your contact details and preferred shipping address</li>
                                                                        <li>Choose your preferred payment option before clicking the ’Confirm order’ button</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 3 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(3)}}>How can I get a refund or replacement for my product?</a>
                                                            <i className="indicator glyphicon glyphicon-chevron-down  pull-right" /></h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 3 ? 'block':'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 3 ? 'block':'none'}}>
                                                                <div className="question">
                                                                    <strong>Step 1: Contact us</strong>
                                                                    <ul>  <li>Call us at 0310-6000011 to create your return request, select the product you wish to return on the return form that arrived with your order.</li> </ul>
                                                                    <strong>Step 2: Pack your product </strong>
                                                                    <ul>
                                                                        <li>Pack your product according to the return conditions</li>
                                                                        <li>Include all tags, accessories or free gifts you received</li>
                                                                    </ul>
                                                                    <strong>Step 3: Return  your product </strong>
                                                                    <ul>
                                                                        <li>If you requested a pickup, we will contact you to arrange a pickup time</li>
                                                                        <li>Please attach the address label included with your package on the box (no shipping charges will apply)</li>
                                                                        <li>Product replacement / refund will be eligible after the product is received and quality checked by us</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 4 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(4)}}>Are there any hidden costs or charges if I order from GulAutos.PK?</a>
                                                            <i className="indicator glyphicon glyphicon-chevron-down  pull-right" /></h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 4 ? 'block' : 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 4 ? 'block' : 'none'}}>
                                                                <div className="question">
                                                                    <p>
                                                                        There are no hidden costs or charges when you order from GulAutos.PK. All costs are 100% visible at the end of the checkout process.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 5 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(5)}}>How can I track my order?</a>
                                                            <i className="indicator glyphicon glyphicon-chevron-down  pull-right" /></h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 5 ? 'block' : 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 5 ? 'block' : 'none'}}>
                                                                <div className="question">
                                                                    <p>We will send you regular updates about the status of your order via emails and SMS. After your order has left our warehouse and is on its way to you, you can also track its status by logging into customer area.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                }

                                {this.state.selectedTab == 'products_and_prices' &&
                                    <div className="tab-pane fade in active">
                                        <section className="acrdion-main block-acrdion-main">
                                            <div className="acrdion-title">
                                                <h3 style={{color: '#F68B1E'}}>Product &amp; Prices</h3>
                                            </div>
                                            <div className="panel-group accordion-content" id="accordion">
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 6 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(6)}}>Are all products on GulAutos.PK original and genuine?</a>
                                                            <i className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 6 ? 'block' : 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 6 ? 'block' : 'none'}}>
                                                                <div className="question ">
                                                                    <p>Yes, we are committed to offering our customers only
                                                                        100% genuine and original products. We also take all
                                                                        necessary actions to ensure this: any seller found
                                                                        to be selling non-genuine prodcts is immediately
                                                                        delisted from GulAutos.PK.</p>
                                                                    <p>Please send us an email on
                                                                        <a href="mailto:complains@GulAutos.pk">complains@GulAutos.pk</a> if
                                                                        you think a product listed on our website does not
                                                                        fulfill these standards.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 7 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(7)}}>Are all products on
                                                            GulAutos.PK new and unused?</a>
                                                            <i className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 7 ? 'block' : 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 7 ? 'block' : 'none'}}>
                                                                <div className="question ">
                                                                    <p>
                                                                    </p>
                                                                    <p>Yes, GulAutos.PK only offers 100% new and unused
                                                                        products.</p>
                                                                    <p>Please send us an email on <a
                                                                        href="mailto:complains@GulAutos.pk">complains@GulAutos.pk</a> if
                                                                        you think a product listed on our website that does
                                                                        not meet these criteria.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 8 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(8)}}>Where can I find more
                                                            detailed information about a product?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 8 ? 'block' : 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 8 ? 'block' : 'none'}}>
                                                                <div className="question ">
                                                                    <p>Information regarding your product are described in
                                                                        the 'Key Features' section at the top of the product
                                                                        page. More detailed information can be found on the
                                                                        'Description' and 'Specifications' tabs on the
                                                                        product pages.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 9 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(9)}}>Are there any hidden
                                                            costs or charges if I order from GulAutos.PK?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 9 ? 'block': 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 9 ? 'block': 'none'}}>
                                                                <div className="question ">
                                                                    <p>There are no hidden costs or charges when you order
                                                                        from GulAutos.PK. All costs are 100% visible at
                                                                        the end of the checkout process. </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 10 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(10)}}>Are the prices on
                                                            GulAutos.PK negotiable?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended== 10 ? 'block' : 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended== 10 ? 'block' : 'none'}}>
                                                                <div className="question ">
                                                                    <p>Prices on GulAutos.PK are not negotiable.
                                                                        GulAutos.PK has thousands of sellers which offer
                                                                        you the best prices and deals.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 11 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(11)}}>How do I know if a
                                                            product comes with free installation?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended== 11 ? 'block' : 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended== 11 ? 'block' : 'none'}}>
                                                                <div className="question ">
                                                                    <p>Free installation is offered for selected products
                                                                        only. Be sure to check the product description of
                                                                        products to get more details about installation.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 12 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(12)}}>How do I know if a
                                                            product comes with warranty?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended== 12 ? 'block' : 'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended== 12 ? 'block' : 'none'}}>
                                                                <div className="question ">
                                                                    <p>If a warranty is offered on a product, the warranty
                                                                        period will be displayed on the product page.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                }

                                {this.state.selectedTab == 'order' &&
                                    <div className="tab-pane fade in active">
                                        <section className="acrdion-main block-acrdion-main">
                                            <div className="acrdion-title">
                                                <h3 style={{color: '#F68B1E'}}>Order</h3>
                                            </div>
                                            <div className="panel-group accordion-content" id="accordion">
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 13 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(13)}}>Do I need an account to
                                                            shop on GulAutos.PK?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 13? 'block':'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 13? 'block':'none'}}>
                                                                <div className="question ">
                                                                    <p>
                                                                        Having a GulAutos.PK account helps us to make your shopping experience fast, secure and convenient. You can create your own GulAutos.PK account or simply use your Facebook login.<Link to={"/register"}>Click here to create your account now </Link>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 14 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(14)}}>How can I track my
                                                            order?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 14? 'block':'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 14? 'block':'none'}}>
                                                                <div className="question ">
                                                                    <p>We will send you regular updates about the status of
                                                                        your order via emails and SMS. After your order has
                                                                        left our warehouse and is on its way to you, you can
                                                                        also track its status by logging into customer area.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 15 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(15)}}>How quickly can I get my
                                                            order?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 15? 'block':'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 15? 'block':'none'}}>
                                                                <div className="question ">
                                                                    <p>
                                                                        We do our best to get your orders delivered by the
                                                                        date listed on the product page. We also offer a
                                                                        premium delivery service for selected brands called
                                                                        GulAutos.PK Express. GulAutos.PK Express
                                                                        products are delivered within 48 hours in Karachi,
                                                                        and within 24 hours in Lahore and Islamabad.
                                                                        <br/>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 16 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(16)}}>What are the shipping
                                                            charges?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 16? 'block':'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 16? 'block':'none'}}>
                                                                <div className="question ">
                                                                    <p>Shipping charges are the costs undertaken by Gul
                                                                        Autos and our logistics partners to bring your
                                                                        ordered item to your doorstep. Shipping charges are
                                                                        calculated based on your location and the weight of
                                                                        the product(s) in you order.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 17 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(17)}}>How do I cancel my
                                                            order?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 17? 'block':'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 17? 'block':'none'}}>
                                                                <div className="question ">
                                                                    <p>
                                                                    </p>
                                                                    <ul>
                                                                        <li>If your order is not yet on its way to you, you
                                                                            can simply cancel your order by getting in touch
                                                                            with our Customer Support Team. You can reach
                                                                            our team 24/7 under <a
                                                                                href="mailto:info@GulAutos.pk">info@GulAutos.pk</a> or
                                                                            you can call us under +92301-6000011 (10am – 7:30pm).
                                                                        </li>
                                                                        <li>If your order is already on its way to you or if
                                                                            you have already received your order, you may be
                                                                            able to return your product
                                                                        </li>
                                                                    </ul>
                                                                    <p/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 18 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(18)}}>My order is delayed. What
                                                            should I do?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 18? 'block':'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 18? 'block':'none'}}>
                                                                <div className="question ">
                                                                    <p> We are sorry that your order is delayed. You can
                                                                        follow its progress by logging into customer area.
                                                                        If the status has not changed in a while, please get
                                                                        in touch with our Customer Support Team. You can
                                                                        reach our team 24/7 at <a
                                                                            href="mailto:info@GulAutos.pk">info@GulAutos.pk</a> or
                                                                        you can call us under +92301-6000011
                                                                        (10am – 7:30pm).</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 19 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(19)}}>Why am I having trouble
                                                            placing products in the cart?</a><i
                                                            className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 19? 'block':'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 19? 'block':'none'}}>
                                                                <div className="question ">
                                                                    <p>If you are having trouble placing products in your
                                                                        cart, please make sure that you have made all
                                                                        relevant size and color selections. If you still
                                                                        have problems, this may mean that the item you are
                                                                        trying to buy is sold out. Please get in touch with
                                                                        our Customer Support Team. You can reach our team
                                                                        24/7 under <a
                                                                            href="mailto:info@GulAutos.pk">info@GulAutos.pk</a> or
                                                                        you can call us under 92301-6000011
                                                                        (10am – 7:30pm).</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="panel panel-default">
                                                    <div className="panel-heading">
                                                        <h4 className="panel-title">
                                                            <a className={this.state.expended == 20 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(20)}}>My payment was processed
                                                            successfully but I didn't get any order confirmation. What
                                                            should I do?</a>
                                                            <i className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                        </h4>
                                                    </div>
                                                    <div className="panel-collapse" style={{display: this.state.expended == 20? 'block':'none'}}>
                                                        <div className="panel-body">
                                                            <div className="fbck " style={{display: this.state.expended == 20? 'block':'none'}}>
                                                                <div className="question ">
                                                                    <p>
                                                                        Please get in touch with us so we can look into the
                                                                        matter. You can reach our team 24/7 under <a
                                                                        href="mailto:info@GulAutos.pk">info@GulAutos.pk</a> or
                                                                        you can call us under 92301-6000011
                                                                        (10am – 7:30pm).
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                }

                                {this.state.selectedTab == 'payment' &&
                                <div className="tab-pane fade in active">
                                    <section className="acrdion-main block-acrdion-main">
                                        <div className="acrdion-title">
                                            <h3 style={{color: '#F68B1E'}}>Payment</h3>
                                        </div>
                                        <div className="panel-group accordion-content" id="accordion">
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title">
                                                        <a className={this.state.expended == 21 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(21)}}>Do I need to pre-pay for
                                                        my product when I order it?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 21? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 21? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>Pre-payment is 100% safe and easy. However,
                                                                    GulAutos.PK also offers you the possibility to
                                                                    pay through Cash On Delivery (CoD). With CoD, you
                                                                    can pay in cash to the delivery agent upon receipt
                                                                    of your order.</p>
                                                                <p>Note:</p>
                                                                <ul>
                                                                    <li>Some Items may not be available for COD</li>
                                                                    <li>The maximum order value for CoD is 100,000 PKR
                                                                    </li>
                                                                    <li>Gift cards or vouchers cannot be used to make
                                                                        COD payments
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title">
                                                        <a className={this.state.expended == 22 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(22)}}>Are there any hidden
                                                        charges when I make a purchase on GulAutos.PK?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 22? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck " style={{display: this.state.expended == 22? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>There are no hidden charges when you make a purchase
                                                                    on GulAutos.PK. The order amount is inclusive of
                                                                    all taxes and shipping fees. In case your order is
                                                                    delivered partially you will be required to pay only
                                                                    for the item that has been delivered to you. The
                                                                    order amount will be mentioned on the parcel and the
                                                                    invoice. Please note that we will never ask you to
                                                                    pay extra cash to the rider.</p>
                                                                <p>Note: For International Payment via Credit / Debit
                                                                    card you may be charged a cross border fee by your
                                                                    issuing bank as our payment processor is based
                                                                    outside Pakistan. For information on the exact
                                                                    charges please contact your issuing bank.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 23 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(23)}}>Is it safe to pay with
                                                        credit / debit card?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 23? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck " style={{display: this.state.expended == 23? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>Fraud detection and prevention are very important to
                                                                    us. We take all steps to ensure that transactions
                                                                    are genuine and that our customers’ details are
                                                                    completely secure.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                }

                                {this.state.selectedTab == 'delivery' &&
                                <div className="tab-pane fade in active">
                                    <section className="acrdion-main block-acrdion-main">
                                        <div className="acrdion-title">
                                            <h3 style={{color: '#F68B1E'}}>Delivery</h3>
                                        </div>
                                        <div className="panel-group accordion-content" id="accordion">
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 24 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(24)}}>Does GulAutos.PK
                                                        deliver across all of Pakistan?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 24? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 24? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>GulAutos.PK delivers all across Pakistan through
                                                                    its logistics partners M&amp;P, TCS and
                                                                    Leopards.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title">
                                                        <a className={this.state.expended == 25 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(25)}}>
                                                            How long does it take to receive my product?
                                                        </a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 25? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 25? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>Delivery timelines vary depending on your city and
                                                                    your selected product.</p>
                                                                <p/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 26 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(26)}}>How can I track my
                                                        order?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended ==26 ? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended ==26 ? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>We will send you regular updates about the status of
                                                                    your order via emails and SMS. After your order has
                                                                    left our warehouse and is on its way to you, you can
                                                                    also track its status by entering into customer area.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 27 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(27)}}>Can I change my shipping
                                                        address after I have placed my order?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 27? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 27? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>You can request for your order to be delivered to a
                                                                    different address within the same region or city
                                                                    before your order is shipped.</p>
                                                                <p>If you want to change the shipping address to a
                                                                    different region or city, we will have to cancel and
                                                                    replace the original order.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 28 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(28)}}>I found the package open
                                                        and the product seal broken on delivery. What should I do?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 28? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 28? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>You should refuse to accept an open package. If you
                                                                    do accept such a package by mistake or find out it
                                                                    has been tampered with, please get in touch with us
                                                                    immediately.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 29 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(29)}}>I missed my delivery.
                                                        What happens now?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 29? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 29? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>We’ll attempt to deliver your order again the next
                                                                    working day. We will try to deliver a total of 3
                                                                    times before cancelling your order.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 30 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(30)}}>What are the shipping
                                                        charges?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 30? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 30? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>Shipping charges are the costs undertaken by
                                                                    GulAutos.PK and our logistics partners to bring
                                                                    your ordered item to your doorstep. Shipping charges
                                                                    are calculated based on your location and the weight
                                                                    of the product(s) in you order.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 31 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(31)}}>My parcel has been
                                                        reported missing. What now?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 31? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 31? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>No need to worry. We will help you replace your order
                                                                    at no extra cost.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                }

                                {this.state.selectedTab == 'other_topics' &&
                                <div id="Other-Topics" className="tab-pane fade in active">
                                    <section className="acrdion-main block-acrdion-main">
                                        <div className="acrdion-title">
                                            <h3 style={{color: '#F68B1E'}}>Login my account</h3>
                                        </div>
                                        <div className="panel-group accordion-content" id="accordion">
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title">
                                                        <a className={this.state.expended == 32 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(32)}}>
                                                            How can I sign-up as a customer on GulAutos.PK?
                                                        </a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 32?'block':'none'}}>
                                                    <div className="panel-body" >
                                                        <div className="fbck" style={{display: this.state.expended == 32?'block':'none'}}>
                                                            <div className="question">
                                                                <ul>
                                                                    <li>Start by clicking on “My Account” and then “sign
                                                                        up” in the top right corner of your screen.
                                                                    </li>
                                                                    <li>You will then be asked to provide some basic
                                                                        information.
                                                                    </li>
                                                                    <li>When you have provided the required information,
                                                                        click submit to finish the sign-up process.
                                                                    </li>
                                                                    <li>We will also send you an email to welcome you to
                                                                        GulAutos.PK.
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 33 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(33)}}>How can I add a new
                                                        delivery address to my account? </a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 33?'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 33?'block':'none'}}>
                                                            <div className="question">
                                                                <p>To add an additional delivery address to your
                                                                    account:</p>
                                                                <ul>
                                                                    <li>Click on “Your Account” in the top right corner
                                                                        of your screen (if you are logged in you would
                                                                        see your name there)
                                                                    </li>
                                                                    <li>Now click on “Address Book” in the left side of
                                                                        the screen.
                                                                    </li>
                                                                    <li>
                                                                        Click on the “Add a New Address” button, enter
                                                                        the details of the new address and click on
                                                                        “Save this Address”
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 34 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(34)}}>Can I add multiple email
                                                        addresses to login to my account?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 34?'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 34?'block':'none'}}>
                                                            <div className="question">
                                                                <p>To make sure that your account is always secure,
                                                                    multiple email addresses cannot be added. However,
                                                                    you can replace your current email address with a
                                                                    new one.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 35 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(35)}}>Why do I need to provide
                                                        my email address to sign up?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 35?'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 35?'block':'none'}}>
                                                            <div className="question">
                                                                <p>Your email address helps us provide timely
                                                                    information to you about your order. It also acts as
                                                                    your username and helps you to login.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 36 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(36)}}>How can I change the
                                                        password of my account? </a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 36?'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 36?'block':'none'}}>
                                                            <div className="question">
                                                                <ul>
                                                                    <li>Click on “Your Account” in the top right corner
                                                                        of your screen (if you are logged in you would
                                                                        see your name there)
                                                                    </li>
                                                                    <li>In the Contact Details box click “Change
                                                                        Password”
                                                                    </li>
                                                                    <li>Enter the required information and click
                                                                        "Submit"
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 37 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(37)}}>How can I deactivate my
                                                        account?</a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 37?'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 37?'block':'none'}}>
                                                            <div className="question">
                                                                <p>Why not just let it be and come back to us whenever
                                                                    you want.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title"><a
                                                        className={this.state.expended == 38 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(38)}}>Would my account be
                                                        deactivated if I don’t use it for a long time? </a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 38?'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 38?'block':'none'}}>
                                                            <div className="question">
                                                                <p>We miss you when you don’t visit us enough but we
                                                                    never deactivate your account.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <section className="acrdion-main block-acrdion-main">
                                        <div className="acrdion-title">
                                            <h3 style={{color: '#F68B1E'}}>GulAutos.PK Sales Campaigns</h3>
                                        </div>
                                        <div className="panel-group accordion-content" id="accordion">
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title">
                                                        <a className={this.state.expended == 39 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(39)}}>
                                                            When can I start shopping?
                                                        </a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 39? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 39? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>Special event prices become active at midnight on the
                                                                    announced date. Stay tuned to <a
                                                                        href="/">GulAutos.PK</a> for more details.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title">
                                                        <a className={this.state.expended == 40 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(40)}}>
                                                            Can I buy as many items as I want during special events like
                                                            Black Friday and Mobile Week?
                                                        </a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 40? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 40? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>Usually there's no restriction on the quantity of an item you can buy but during special events like Black Friday and Mobile Week, we might put a restriction on some in demand items so that everybody gets a chance to enjoy our amazing deals.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title">
                                                        <a className={this.state.expended == 41 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(41)}}>
                                                            Will the products I ordered be delivered within the regular
                                                            timeline during special events like Black Friday or Mobile
                                                            Week?
                                                        </a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 41? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 41? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>GulAutos.PK makes special arrangements to make
                                                                    sure that all items ordered during special events
                                                                    like Black Friday and Mobile Week are delivered
                                                                    within the standard delivery timeline as
                                                                    communicated on the product page.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="panel panel-default">
                                                <div className="panel-heading">
                                                    <h4 className="panel-title">
                                                        <a className={this.state.expended == 42 ? "accordion-toggle" : "accordion-toggle collapsed"} onClick={(e) => {e.preventDefault(); this.handleExpended(42)}}>
                                                            If I place an order during a special event like Black Friday
                                                            or Mobile Week but only get it four days later, does the
                                                            discounted price still apply?
                                                        </a><i
                                                        className="indicator glyphicon glyphicon-chevron-down  pull-right"/>
                                                    </h4>
                                                </div>
                                                <div className="panel-collapse" style={{display: this.state.expended == 42? 'block':'none'}}>
                                                    <div className="panel-body">
                                                        <div className="fbck" style={{display: this.state.expended == 42? 'block':'none'}}>
                                                            <div className="question">
                                                                <p>If your order was placed while the special
                                                                    promotional prices were active that’s all you have
                                                                    to pay.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                }
                            </div>
                        </div>
                        <div className="col-xs-12 col-sm-4 margin-top-10" style={{paddingLeft: '15px'}}>
                            <div>
                                <h3 style={{color: '#F68B1E'}}>Issue still not solved?</h3>
                            </div>
                            <Link to={'/contact'}>
                                <div className="col-sm-6 btns">
                                    <h3>Contact Us</h3>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </>
        );
    }//..... end of render() .....//
}//..... end of Help.

export default Help;
