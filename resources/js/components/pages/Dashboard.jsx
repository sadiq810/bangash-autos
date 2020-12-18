import React, {Component} from 'react';
import {Link, withRouter} from "react-router-dom";
import {loadOrders} from "../../redux/actions/OrderActions";
import {connect} from "react-redux";
import OrderHistory from "../DashboardComponents/OrderHistory";
import OrderDetails from "../DashboardComponents/OrderDetails";
import EditProfile from "../DashboardComponents/EditProfile";
import ChangePassword from "../DashboardComponents/ChangePassword";

class Dashboard extends Component {
    constructor(props) {
        super(props);
        this.state = {
            activeView: 'order_history',
            order: null
        };
    }//..... end of constructor() .....//

    componentDidMount() {
        if (typeof this.props.user == 'object' && Object.keys(this.props.user) == 0)
            this.props.history.push('/login');

        if (this.props.user.access_token)
            this.props.loadUserOrders(this.props.user.access_token, this.props.loaded);
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevProps.user != this.props.user)
            this.props.loadUserOrders(this.props.user.access_token, this.props.loaded);
    }

    setView = (view) => {
        this.setState(() => ({activeView: view}));
    };

    setOrderDetails = (order, view) => {
        this.setState(() => ({activeView: view, order}));
    };

    loadMore = () => {
        this.props.loadUserOrders(this.props.user.access_token, this.props.loaded);
    };

    render() {
        return (
            <div className="account-order">
                <div id="account-order" className="container">
                <ul className="breadcrumb">
                    <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                    <li><a href="#">Account</a></li>
                </ul>
                <div className="row">

                    {this.loadView()}

                    <aside className="col-md-3 col-sm-4 col-xs-12 content-aside right_column sidebar-offcanvas">
                        <span id="close-sidebar" className="fa fa-times" />
                        <div className="myprofile">
                            <a className="myprofile--thumb thumbnail" href="#">
                                <img src={this.props.user.image ? BaseUrl+'/uploads/thumbs/'+this.props.user.image : BaseUrl+"/assets/frontend/image/placeholder.png"} className="img-responsive" />
                            </a>
                            <div className="myprofile--detail">
                                <h3>{this.props.user.fname} {this.props.user.lname}</h3>
                                <p>{this.props.user.email}</p>
                                <ul className="list-inline">
                                    <li>
                                        <a onClick={() => this.setView('edit-profile')} className="btn btn-default" title="Edit Profile">
                                            <i className="fa fa-pencil-square-o" aria-hidden="true" /> Edit Profile
                                        </a>
                                    </li>
                                    <li>
                                        <Link to={'/'} className="btn btn-default" title="Logout" onClick={() => {
                                            localStorage.removeItem('userData');
                                            this.props.logout();
                                        }}>
                                            <i className="fa fa-sign-out" aria-hidden="true" /> Logout
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div className="panel panel-default profile--panel">
                            <div className="panel-heading">My Account</div>
                            <div className="panel-body">
                                <a onClick={() => this.setView('change-password')} className="list-group-item">
                                    <i className="fa fa-key" aria-hidden="true" /> Change Password
                                </a>
                                <a onClick={() => this.setView('order_history')} className="list-group-item">
                                    <i className="fa fa-undo" aria-hidden="true" /> Order History
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
            </div>
        );
    }//..... end of render() .....//

    loadView = () => {
        switch (this.state.activeView) {
            case "order_history":
                return <OrderHistory setView={this.setView} setOrderDetails={this.setOrderDetails} ordersData={this.props.ordersData} total={this.props.total} loaded={this.props.loaded} loadMore={this.loadMore}/>;
            case 'order-details':
                return <OrderDetails setView={this.setView} order={this.state.order}/>;
            case 'edit-profile':
                return <EditProfile setView={this.setView} user={this.props.user}/>;
            case 'change-password':
                return <ChangePassword setView={this.setView} hash={this.props.user.access_token}/>;
            default:
                return <OrderHistory setView={this.setView} setOrderDetails={this.setOrderDetails} ordersData={this.props.ordersData} total={this.props.total} loaded={this.props.loaded} loadMore={this.loadMore}/>;
        }
    };
}//..... end of Dashboard.

const mapStateToProps = (state) => {
    return {
        user: state.common.user,
        ordersData: state.orders.orders,//selectOrdersCustomData(state.orders.orders)
        total: state.orders.total,
        loaded: state.orders.loaded
    };
};

const mapActionsToProps = (dispatch) => {
    return {
        loadUserOrders: (hash, loaded) => dispatch(loadOrders(hash, loaded)),
        logout: () => dispatch({type: 'SET_USER_DATA', payload: {}})
    };
};

export default connect(mapStateToProps, mapActionsToProps)(withRouter(Dashboard));
