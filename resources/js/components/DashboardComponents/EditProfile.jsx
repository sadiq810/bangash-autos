import React, {Component} from 'react';
import {connect} from 'react-redux';

class EditProfile extends Component {
    constructor(props) {
        super(props);
        this.state = {
            fname: '',
            lname: '',
            email: '',
            phone:'',
            address: '',
            image: null
        };
    }//..... end of constructor() .....//

    handleFieldChange = (field, value) => {
        return this.setState(() => ({[field] : value}))
    };

    componentDidMount() {
        let {fname, lname, email, phone, address} = this.props.user;
        this.setState(() => ({fname, lname, email, phone, address}));
    }//..... end of componentDidMount() .....//

    handleFormSubmit = (e) => {
        e.preventDefault();
        let {fname, lname, phone, address, image} = this.state;
        axios.post(BaseUrl+'/api/update-customer-profile', {fname, lname, phone, address, image, hash: this.props.user.access_token}).then((response) => {
            if (response.data.status) {
                this.setState(() => ({success: response.data.message, error: null, password: '', confirm_password: ''}), () => {
                    this.props.dispatch({type: 'SET_USER_DATA', payload: response.data.data});
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
            this.setState(() => ({error: 'Error occurred while updating profile, please try again later.'}), () => {
                let $this = this;
                setTimeout(function () {
                    $this.setState({error: null});
                }, 3000)
            })
        });
    };

    handleFileBtnClick = (e) => {
        e.preventDefault();
        $('#image').trigger('click');
    };

    handleImageSelection = (file) => {
        let input = file.target;
        let $this = this;

        let reader = new FileReader();
        reader.onload = function(){
            let dataURL = reader.result;
            $this.setState(() => ({image: dataURL}));
        };
        reader.readAsDataURL(input.files[0]);
    };

    render() {
        return (
            <div id="content" className="col-sm-9">
                <h1>My Account Information</h1>
                {this.state.error && (
                    <div className="alert alert-danger alert-dismissible"><i className="fa fa-exclamation-circle"></i> {this.state.error}.</div>
                )}

                {this.state.success && (
                    <div className="alert alert-success alert-dismissible"><i className="fa fa-exclamation-circle"></i> {this.state.success}.</div>
                )}
                <form action="" method="post" encType="multipart/form-data" className="form-horizontal" onSubmit={this.handleFormSubmit}>
                    <fieldset>
                        <legend>Your Personal Details</legend>
                        <div className="form-group required">
                            <label className="col-sm-2 control-label" htmlFor="input-firstname">First Name </label>
                            <div className="col-sm-8">
                                <input type="text" value={this.state.fname} onChange={(e) => this.handleFieldChange('fname', e.target.value)} placeholder="First Name" required={'required'} className="form-control" />
                            </div>
                        </div>
                        <div className="form-group required">
                            <label className="col-sm-2 control-label" htmlFor="input-lastname">Last Name</label>
                            <div className="col-sm-8">
                                <input type="text" value={this.state.lname} onChange={(e) => this.handleFieldChange('lname', e.target.value)} placeholder="Last Name" required={'required'} className="form-control" />
                            </div>
                        </div>
                        <div className="form-group required">
                            <label className="col-sm-2 control-label" htmlFor="input-email">E-Mail</label>
                            <div className="col-sm-8">
                                <input type="email" value={this.state.email} placeholder="E-Mail" readOnly className="form-control" />
                            </div>
                        </div>
                        <div className="form-group required">
                            <label className="col-sm-2 control-label" htmlFor="input-telephone">Telephone</label>
                            <div className="col-sm-8">
                                <input type="tel" value={this.state.phone} onChange={(e) => this.handleFieldChange('phone', e.target.value)} placeholder="Telephone" required={'required'} className="form-control" />
                            </div>
                        </div>
                        <div className="form-group required">
                            <label className="col-sm-2 control-label" htmlFor="address">Address</label>
                            <div className="col-sm-8">
                                <input type="text" value={this.state.address} onChange={(e) => this.handleFieldChange('address', e.target.value)} placeholder="Address" required={'required'} className="form-control" />
                            </div>
                        </div>
                        <div className="form-group custom-field" data-sort={6}>
                            <label className="col-sm-2 control-label">Profile Image</label>
                            <div className="col-sm-2 profileimg">
                                <a href={'#'} className="profileimage btn btn-default" onClick={this.handleFileBtnClick}>
                                    <i className="fa fa-upload" aria-hidden="true" /> Upload file
                                </a>
                                <input type="file" style={{display: 'none'}} name="img" id="image" defaultValue={''} accept={'image/*'} onChange={this.handleImageSelection}/>
                            </div>
                            <div className="col-sm-2">
                                {this.state.image &&
                                    <img src={this.state.image} className="img-thumbnail" />
                                }

                            </div>
                        </div>
                    </fieldset>
                    <div className="buttons clearfix col-sm-8 col-sm-offset-2">
                        <div className="pull-left">
                            <a onClick={() => this.props.setView('order_history')} className="btn btn-default">Back</a>
                        </div>
                        <div className="pull-right">
                            <button type="submit" className="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        );
    }//..... end of render() .....//
}//..... end of EditProfile.

const mapStateToProps = (state) => {
    return {};
};

export default connect(mapStateToProps)(EditProfile);
