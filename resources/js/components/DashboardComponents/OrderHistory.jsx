import React, {Component} from 'react';

class OrderHistory extends Component {
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
                <h1>Order History</h1>
                <div className="table-responsive">
                    <table className="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td className="text-right">Order ID</td>
                            <td className="text-left">Total</td>
                            <td className="text-right">Discount</td>
                            <td className="text-left">Status</td>
                            <td className="text-right">Sub Total</td>
                            <td className="text-left">Date</td>
                            <td />
                        </tr>
                        </thead>
                        <tbody>
                        {
                            this.props.ordersData.map(order => {
                                return (
                                    <tr key={order.id}>
                                        <td className="text-right">#{order.id}</td>
                                        <td className="text-left">Rs {order.total}</td>
                                        <td className="text-right">{order.discount}</td>
                                        <td className="text-left">{this.state.statuses[order.status]}</td>
                                        <td className="text-right"> RS: {(order.sub_total).toFixed(2).toLocaleString()}</td>
                                        <td className="text-left">{order.date}</td>
                                        <td className="text-right">
                                            <button title={'view details'} className="btn btn-info" onClick={() => this.props.setOrderDetails(order,'order-details')}>
                                                <i className="fa fa-eye" />
                                            </button>
                                        </td>
                                    </tr>
                                )
                            })
                        }
                        </tbody>
                    </table>
                </div>
                <div className="row">
                    <div className="col-sm-6 text-left" />

                    <div className="col-sm-6 text-right">Showing 0 to {this.props.loaded} of {this.props.total}</div>
                </div>
                <div className="buttons clearfix">
                    <div className="pull-right">
                        <a className="btn btn-primary" onClick={this.props.loadMore} style={{pointerEvents: this.props.total == this.props.loaded ? "none" : ''}}>Load More</a>
                    </div>
                </div>
            </div>
        );
    }//..... end of render() .....//
}//..... end of OrderHistory.

export default OrderHistory;
