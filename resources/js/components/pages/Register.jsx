import React, {Component} from 'react';
import {Link, withRouter} from "react-router-dom";
import {connect} from 'react-redux';
import {getCitiesList, registerUser} from "../../redux/actions/CommonActions";

class Register extends Component {
    constructor(props) {
        super(props);
        this.state = {
            fname: '',
            lname: '',
            email: '',
            phone: '',
            password: '',
            city_id: '',
            country: 'pakistan',
            address: ''
        };
    }//..... end of constructor() .....//

    componentDidMount() {
        if (this.props.cities.length == 0)
            this.props.loadCities();

        this.redirectIfAuthenticated();
    }//..... end of componentDidMount() .....//

    handleFieldChange = (field, value) => {
        if (field == 'phone' && isNaN(value))
            return false;

        this.setState(() => {
            return {[field]: value}
        });
    };

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevProps.user != this.props.user)
            $('.webloader').hide();

        this.redirectIfAuthenticated();
    }//...... end of componentDidUpdate() ......//

    handleFormSubmit = (e) => {
        e.preventDefault();
        $('.webloader').show();
        this.props.registerUser(this.state);
    };//..... end of handleFormSubmit() ......//

    redirectIfAuthenticated = () => {
        if (typeof this.props.user == 'object' && Object.keys(this.props.user).length > 0)
            this.props.history.push('/');
    };

    render() {
        return (
            <div className="account-register">
                <div id="account-register" className="container">
                    <ul className="breadcrumb">
                        <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                        <li><a>Register</a></li>
                    </ul>
                    <div className="row">
                        <div id="content" className="col-sm-12">
                            <h1>Register Account</h1>
                            {
                                typeof this.props.user == 'string' && (
                                    <div className="alert alert-danger alert-dismissible"><i className="fa fa-exclamation-circle"></i> {this.props.user}.</div>
                                )
                            }
                            <p>If you already have an account with us, please login at the <Link to={'/login'}>login page</Link>.</p>
                            <form action="#" method="post" onSubmit={this.handleFormSubmit} className="form-horizontal">
                                <fieldset id="account">
                                    <legend>Your Personal Details</legend>

                                    <div className="form-group required">
                                        <label className="col-sm-2 control-label" htmlFor="input-firstname">First Name</label>
                                        <div className="col-sm-8">
                                            <input required="required" type="text" value={this.state.fname} onChange={(e) => this.handleFieldChange('fname', e.target.value)} placeholder="First Name" className="form-control" />
                                        </div>
                                    </div>

                                    <div className="form-group required">
                                        <label className="col-sm-2 control-label" htmlFor="input-lastname">Last Name</label>
                                        <div className="col-sm-8">
                                            <input required="required" type="text" value={this.state.lname} onChange={(e) => this.handleFieldChange('lname', e.target.value)} placeholder="Last Name" className="form-control" />
                                        </div>
                                    </div>

                                    <div className="form-group required">
                                        <label className="col-sm-2 control-label" htmlFor="input-email">E-Mail</label>
                                        <div className="col-sm-8">
                                            <input required="required" type="email" value={this.state.email} onChange={(e) => this.handleFieldChange('email', e.target.value)} placeholder="E-Mail" className="form-control" />
                                        </div>
                                    </div>

                                    <div className="form-group required">
                                        <label className="col-sm-2 control-label" htmlFor="input-telephone">Telephone</label>
                                        <div className="col-sm-8">
                                            <input type="tel" required="required" value={this.state.phone} onChange={(e) => this.handleFieldChange('phone', e.target.value)} placeholder="Telephone" className="form-control" />
                                        </div>
                                    </div>

                                    <div className="form-group required">
                                        <label className="col-sm-2 control-label" htmlFor="input-country">Telephone</label>
                                        <div className="col-sm-8">
                                            <input type="text" required="required" value={this.state.country} onChange={(e) => this.handleFieldChange('country', e.target.value)} placeholder="Country" className="form-control" />
                                        </div>
                                    </div>

                                    <div className="form-group required">
                                        <label className="col-sm-2 control-label" htmlFor="input-telephone">City</label>
                                        <div className="col-sm-8">
                                            <select required="required" name={'city'} value={this.state.city_id}  onChange={(e) => this.handleFieldChange('city_id', e.target.value)} style={{ width: '100%'}}>
                                                <option value>-- Select City --</option>
                                                {
                                                    this.props.cities.map(city => {
                                                        return (<option key={city.id} value={city.id}>{city.title}</option>)
                                                    })
                                                }
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Your Password</legend>
                                    <div className="form-group required">
                                        <label className="col-sm-2 control-label" htmlFor="input-password">Password</label>
                                        <div className="col-sm-8">
                                            <input required="required" type="password" name={'password'} value={this.state.password} onChange={(e) => this.handleFieldChange('password', e.target.value)} placeholder="Password" className="form-control" />
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Address</legend>
                                    <div className="form-group">
                                        <label className="col-sm-2 control-label">Address</label>
                                        <div className="col-sm-8">
                                            <textarea cols={20} name={'address'} required="required" rows={2} style={{width: '920px', height: '101px', margin: 0}} value={this.state.address} onChange={(e) => this.handleFieldChange('address', e.target.value)}/>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                <div className="buttons col-sm-10">
                                    <div className="pull-right">
                                        <input type="submit" defaultValue="Continue" className="btn btn-primary" />
                                    </div>
                                </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        )
    }//..... end of render() .....//
}//..... end of Register.

const mapStateToProps = (state) => {
    return {
        cities: state.common.cities,
        user: state.common.user
    };
};

const mapPropsToActions = (dispatch) => {
    return {
        loadCities: () => dispatch(getCitiesList()),
        registerUser: (user) => dispatch(registerUser(user))
    };
};

export default connect(mapStateToProps, mapPropsToActions)(withRouter(Register));
