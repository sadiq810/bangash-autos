import React, {Component} from 'react';
import {Link, withRouter} from "react-router-dom";
import {connect} from 'react-redux'
import {loginUser} from "../../redux/actions/CommonActions";

class Login extends Component {
    constructor(props) {
        super(props);
        this.state = {
            email: '',
            password: ''
        };
    }//..... end of constructor() .....//

    handleFieldChange = (field, value) => {
        this.setState(() => {
            return {[field]: value};
        })
    };

    handleSubmit = (e) => {
        e.preventDefault();
        $('.webloader').show();
        this.props.login(this.state);
    };

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevProps.user != this.props.user)
            $('.webloader').hide();

        this.redirectIfAuthenticated();
    }

    componentDidMount() {
        this.redirectIfAuthenticated();
    }

    redirectIfAuthenticated = () => {
        if (typeof this.props.user == 'object' && Object.keys(this.props.user).length > 0)
            this.props.history.push('/');
    };

    render() {
        return (
            <div className="account-login">
                <div className="container">
                    <ul className="breadcrumb">
                        <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                        <li><a>Login</a></li>
                    </ul>
                    <div className="row">
                        <div id="content" className="col-md-9 col-sm-12 col-md-offset-1">
                            <div className="row">

                                <div className="col-sm-6">
                                    <div className="well ">
                                        <h2>New Customer</h2>
                                        <p><strong>Register</strong></p>
                                        <p>By creating an account you will be able to shop faster, be up to date on an
                                            order's status, and keep track of the orders you have previously made.</p>
                                        <Link to={'/register'} className="btn btn-primary">Continue</Link>
                                    </div>
                                </div>

                                <div className="col-sm-6">
                                    <div className="well col-sm-12">
                                        <h2>Returning Customer</h2>
                                        {
                                            typeof this.props.user == 'string' && (
                                                <div className="alert alert-danger alert-dismissible"><i className="fa fa-exclamation-circle"></i> {this.props.user}.</div>
                                            )
                                        }
                                        <p><strong>I am a returning customer</strong></p>
                                        <form action="#" method="post"  onSubmit={this.handleSubmit}>
                                            <div className="form-group">
                                                <label className="control-label" htmlFor="input-email">E-Mail Address</label>
                                                <input type="email" name="email" value={this.state.email} onChange={(e) => this.handleFieldChange('email', e.target.value)} placeholder="E-Mail Address" className="form-control" />
                                            </div>
                                            <div className="form-group">
                                                <label className="control-label" htmlFor="input-password">Password</label>
                                                <input type="password" name="password" value={this.state.password} onChange={(e) => this.handleFieldChange('password', e.target.value)} placeholder="Password" className="form-control" />
                                                <Link to={'/forgot-password'}>Forgotten Password</Link></div>
                                            <input type="submit" defaultValue="Login" className="btn btn-primary pull-left" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        );
    }//..... end of render() .....//
}//..... end of Login.

const mapStateToProps = (state) => {
    return {
        user: state.common.user
    }
};

const mapPropsToActions = (dispatch) => {
    return {
        login: (userCredentials) => dispatch(loginUser(userCredentials))
    };
};

export default connect(mapStateToProps, mapPropsToActions)(withRouter(Login));
