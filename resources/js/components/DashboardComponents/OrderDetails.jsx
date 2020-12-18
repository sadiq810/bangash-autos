import React, {Component} from 'react';
import {Link} from "react-router-dom";

class OrderDetails extends Component {
    constructor(props) {
        super(props);
        this.state = {
            statuses: {
                0: 'Pending',
                1: 'Processing',
                2: 'Completed',
                3: 'Cancelled/Returned'
            }
        };
    }//..... end of constructor() .....//

    render() {
        return (
            <div id="content" className="col-sm-9">
                <h2>Order History</h2>
                <table className="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <td className="text-left" colSpan={2}>Order Details</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td className="text-left" style={{width: '50%'}}>
                            <b>Order ID: #</b> #{this.props.order.id}<br />
                            <b>Date Added:</b> {this.props.order.date}
                        </td>
                        <td className="text-left" style={{width: '50%'}}>
                            <b>Payment Method:</b> Cash On Delivery <br />
                            <b>Order Status:</b> {this.state.statuses[this.props.order.status]}</td>
                    </tr>
                    </tbody>
                </table>
                <div className="table-responsive">
                    <table className="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td className="text-left">Product Name</td>
                            <td className="text-left">Discount</td>
                            <td className="text-right">Quantity</td>
                            <td className="text-right">Return Quantity</td>
                            <td className="text-right">Price</td>
                            <td className="text-right">Total</td>
                        </tr>
                        </thead>
                        <tbody>
                        {this.props.order.detail.map(dt => {
                            return (
                                <tr key={dt.id}>
                                    <td className="text-left">
                                        <Link to={'/product/'+dt.product.slug} target={'_blank'}>{dt.product.title}</Link>
                                    </td>
                                    <td className="text-left">{dt.discount}</td>
                                    <td className="text-right">{dt.quantity - dt.return_quantity}</td>
                                    <td className="text-right">{dt.return_quantity}</td>
                                    <td className="text-right">Rs {dt.unit_price}</td>
                                    <td className="text-right">Rs {dt.sub_total}</td>
                                </tr>
                            );
                        })}

                        </tbody>
                        <tfoot>
                        <tr>
                            <td colSpan={3} />
                            <td className="text-right"><b>Total</b></td>
                            <td className="text-right">Rs {this.props.order.total}</td>
                            <td />
                        </tr>
                        <tr>
                            <td colSpan={3} />
                            <td className="text-right"><b>Flat Shipping Rate</b></td>
                            <td className="text-right">Rs {this.props.order.shipping_cost}</td>
                            <td />
                        </tr>
                        <tr>
                            <td colSpan={3} />
                            <td className="text-right"><b>Sub-Total</b></td>
                            <td className="text-right">Rs {this.props.order.sub_total}</td>
                            <td />
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <table className="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <td className="text-left">Order Comments</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td className="text-left">{this.props.order.description}</td>
                    </tr>
                    </tbody>
                </table>

                <div className="buttons clearfix">
                    <div className="pull-right">
                        <button className="btn btn-primary" onClick={() => this.props.setView('order_history')}>Back</button>
                    </div>
                </div>
            </div>

        );
    }//..... end of render() .....//
}//..... end of OrderDetails.

export default OrderDetails;
