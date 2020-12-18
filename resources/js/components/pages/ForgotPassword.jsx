import React, {Component} from 'react';
import {Link, withRouter} from "react-router-dom";
import {loginUser} from "../../redux/actions/CommonActions";
import {connect} from "react-redux";

class ForgotPassword extends Component {
    constructor(props) {
        super(props);
        this.state = {
            email: '',
            status: undefined,
            message: null
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
        axios.post(BaseUrl+'/api/user/forgot-password',
            {email: this.state.email})
            .then(response => {
                $('.webloader').hide();
                this.setState(() => {
                    return {
                        status: response.data.status,
                        message: response.data.message
                    };
                });
            }).catch(error => {
            $('.webloader').hide();
            this.setState(() => {
                return {
                    status: false,
                    message: 'Internal server error occurred, please try again later.'
                };
            });
        });
    };

    componentDidUpdate(prevProps, prevState, snapshot) {
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
            <div className="account-forgotten">
                <div id="account-forgotten" className="container">
                    <ul className="breadcrumb">
                        <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                        <li><a href="#">Forgotten Password</a></li>
                    </ul>
                    <div className="row">
                        <div id="content" className="col-sm-12">
                            <h1>Forgot Your Password?</h1>
                            {
                                this.state.status == false && (
                                    <div className="alert alert-danger alert-dismissible"><i className="fa fa-exclamation-circle"></i> {this.state.message}.</div>
                                )
                            }
                            {   this.state.status == true && (
                                <div className={'alert alert-success alert-dismissible'}><i className="fa fa-exclamation-circle"></i> {this.state.message}</div>
                            )
                            }
                            <p>Enter the e-mail address associated with your account. Click submit to have a password reset link e-mailed to you.</p>
                            <form action="#" method="post" className="form-horizontal" onSubmit={this.handleSubmit}>
                                <fieldset>
                                    <legend>Your E-Mail Address</legend>
                                    <div className="form-group required">
                                        <label className="col-sm-2 control-label" htmlFor="input-email">E-Mail Address</label>
                                        <div className="col-sm-8">
                                            <input type="email" name="email" value={this.state.email} onChange={(e) => this.handleFieldChange('email', e.target.value)} placeholder="E-Mail Address" required={'required'} className="form-control" />
                                        </div>
                                    </div>
                                </fieldset>
                                <div className="buttons clearfix col-sm-8 col-sm-offset-2">
                                    <div className="pull-left">
                                        <Link to={'/login'} className="btn btn-default">Back</Link>
                                    </div>
                                    <div className="pull-right">
                                        <input type="submit" defaultValue="Continue" className="btn btn-primary" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        );
    }//..... end of render() .....//
}//..... end of ForgotPassword.

const mapStateToProps = (state) => {
    return {
        user: state.common.user
    }
};

export default connect(mapStateToProps)(withRouter(ForgotPassword));
