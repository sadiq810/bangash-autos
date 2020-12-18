import React, {Component} from 'react';
import {Link} from "react-router-dom";

class ThankYou extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    render() {
        return (
            <div className="checkout-success">
                <div className="container">
                    <ul className="breadcrumb">
                        <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                        <li><a href="#">Shopping Cart</a></li>
                        <li><a href="#">Checkout</a></li>
                        <li><a href="#">Success</a></li>
                    </ul>
                    <div className="row">
                        <div id="content" className="col-sm-12">
                            <h1>Your order has been received!</h1>
                            <p>We may call you in the next 24 hours if we require more information to confirm it.</p>
                            <p>The delivery may take 4-5 working days depending on your product weight and volume</p>
                            <p>You can view your order history by going to the <Link to={'/user/dashboard'}>my account</Link> page and by clicking on <Link to={'/user/dashboard'}>history</Link>.</p>
                            <p>Thanks for shopping with us!</p>
                            <div className="buttons">
                                <div className="pull-right">
                                    <Link to={'/'} className="btn btn-primary">Continue</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }//..... end of render() .....//
}//..... end of ThankYou.

export default ThankYou;
