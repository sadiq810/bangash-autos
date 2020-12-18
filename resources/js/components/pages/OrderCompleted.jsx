import React, {Component} from 'react';

class OrderCompleted extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    render() {
        return (
            <section className="gray">
                <div className="container">
                    <div className="row">
                        <div className="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">
                            <div className="thankYou">
                                <div className="row">
                                    <div className="col-xs-12 col-sm-12 col-md-offset-2 col-md-8 thankYouBox">
                                        <h1>Thankyou!! <small>for your Purchase</small></h1>
                                        <hr />
                                        <p className="text-center">
                                            Your order has been received.<br />
                                            We may call you in the next 24 hours if we require more information to confirm it.
                                        </p>
                                        <div className="row ordeInfoBox">
                                            <div className="col-xs-12 col-sm-6 col-md-6">
                                                <div className="orderInfo">
                                                    <p><span>Order Number:</span>6283269</p>
                                                </div>
                                            </div>
                                            <div className="col-xs-12 col-sm-6 col-md-6">
                                                <div className="orderInfo">
                                                    <p><span>Order Date:</span>20 / 10 / 2019</p>
                                                </div>
                                            </div>
                                            <div className="col-xs-12 col-sm-6 col-md-6">
                                                <div className="orderInfo">
                                                    <p><span>Total Amount:</span>Rs. 2,299</p>
                                                </div>
                                            </div>
                                            <div className="col-xs-12 col-sm-6 col-md-6">
                                                <div className="orderInfo">
                                                    <p>
                                                        <span>Payment Method:</span>
                                                        Cash On Delivery
                                                    </p>
                                                </div>
                                            </div>
                                            <p>The delivery may take 4-5 working days depending on your product weight &amp; volume!</p>
                                            <div className="clearfix" />
                                            <div className="button2">
                                                <a href="/" className="btn btn-primary">Continue Shopping</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }//..... end of render() .....//
}//..... end of OrderCompleted.

export default OrderCompleted;
