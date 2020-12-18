import React, {Component} from 'react';

class ChangePassword extends Component {
    constructor(props) {
        super(props);
        this.state = {
            password: '',
            confirm_password: '',
            error: null,
            success: null
        };
    }//..... end of constructor() .....//

    handleFieldChange = (field, value) => {
        return this.setState(() => ({[field] : value}))
    };

    handleSubmit = (e) => {
        e.preventDefault();
        this.setState({error: null, success: null});

      if (this.state.password != this.state.confirm_password) {
          this.setState(() => ({error: 'Password and Confirm password do not match, Please type again.'}));
          return false;
      }

      if (this.state.password.length < 6) {
          this.setState(() => ({error: 'Password must be at least 6 characters.'}));
          return false;
      }

      axios.post(BaseUrl+'/api/change-password', {password: this.state.password, hash: this.props.hash}).then((response) => {
          if (response.data.status) {
              this.setState(() => ({success: 'Password changed successfully.', error: null, password: '', confirm_password: ''}), () => {
                  let $this = this;
                  setTimeout(function () {
                      $this.setState({success: null});
                  }, 3000)
              });
          } else {
              this.setState(() => ({error: response.data.message}), () => {
                  let $this = this;
                  setTimeout(function () {
                      $this.setState({error: null});
                  }, 3000)
              })
          }

      }).catch((error) => {
          this.setState(() => ({error: 'Error occurred while changing password, please try again later.'}), () => {
              let $this = this;
              setTimeout(function () {
                  $this.setState({error: null});
              }, 3000)
          })
      });
    };

    render() {
        return (
            <div id="content" className="col-sm-9">
                <h1>Change Password</h1>
                {this.state.error && (
                    <div className="alert alert-danger alert-dismissible"><i className="fa fa-exclamation-circle"></i> {this.state.error}.</div>
                )}

                {this.state.success && (
                    <div className="alert alert-success alert-dismissible"><i className="fa fa-exclamation-circle"></i> {this.state.success}.</div>
                )}
                <form action="#" method="post" onSubmit={this.handleSubmit} className="form-horizontal">
                    <fieldset>
                        <legend>Change Password</legend>
                        <div className="form-group required">
                            <label className="col-sm-2 control-label" htmlFor="input-password">Password</label>
                            <div className="col-sm-8">
                                <input type="password" name="password" onChange={(e) => this.handleFieldChange('password', e.target.value)} value={this.state.password} placeholder="Password" className="form-control" />
                            </div>
                        </div>
                        <div className="form-group required">
                            <label className="col-sm-2 control-label" htmlFor="input-confirm">Password Confirm</label>
                            <div className="col-sm-8">
                                <input type="password" name="confirm" onChange={(e) => this.handleFieldChange('confirm_password', e.target.value)} value={this.state.confirm_password} placeholder="Password Confirm" className="form-control" />
                            </div>
                        </div>
                    </fieldset>
                    <div className="buttons clearfix col-sm-8 col-sm-offset-2">
                        <div className="pull-left">
                            <a onClick={() => this.props.setView('order_history')} className="btn btn-default">Back</a>
                        </div>
                        <div className="pull-right">
                            <button type="submit" className="btn btn-primary">Change</button>
                        </div>
                    </div>
                </form>
            </div>
        );
    }//..... end of render() .....//
}//..... end of ChangePassword.

export default ChangePassword;
