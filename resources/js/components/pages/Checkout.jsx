import React, {Component} from 'react';
import {connect} from "react-redux";
import {Link, withRouter} from 'react-router-dom';
import {getCitiesList, loginUser, placeOrderAndAdjustUserDetails} from "../../redux/actions/CommonActions";
import {
    applyPromotionToAmount,
    calculateShippingFee, isDeliveryFree, isFlatDiscount,
    selectFinalPriceWithOptionSelected
} from "../../redux/selectors/CategorySelector";

class Checkout extends Component {
    constructor(props) {
        super(props);
        this.state = {
            id: null,
            fname: '',
            lname: '',
            email: '',
            phone: '',
            password: '',
            city_id: '',
            address: '',
            notes: '',
            customerState: '',
            country: 'Pakistan',
            voucher_code: '',
            voucherError: '',
            voucherValidMsg: '',
            isValidatingVoucher: false,
            voucher: null,
            promotions: [],
            pwdFieldRef: undefined,
            isPwdFieldVisible: false
        };
    }//..... end of constructor() .....//

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (this.props.user && prevProps.user != this.props.user) {
            if (typeof this.props.user === 'object' && Object.keys(this.props.user).length > 0)
                this.setState(() => ({...this.props.user, customerState: ''}));
            else
                this.setState((prevState) => ({customerState: prevState.customerState === '' ? 'old' : prevState.customerState}));

            $('.webloader').hide();
        }

        if (this.props.cart.length !== prevProps.cart.length)
            this.redirectUser();
    }

    componentDidMount() {
        if (this.props.cities.length == 0)
            this.props.loadCities();
        if (typeof this.props.user === 'object')
            this.setState(() => ({...this.props.user, customerState: Object.keys(this.props.user).length == 0 ? 'old' : ''}));
        else
            this.setState((prevState) => ({customerState: prevState.customerState === '' ? 'old' : prevState.customerState}));

        this.redirectUser();
        this.loadPromotions();
    }//..... end of componentDidMount() .....//

    redirectUser = () => {
        if (this.props.cart.length == 0) {
            if (Object.keys(this.props.user) == 0)
                this.props.history.push('/');
            else
                this.props.history.push('/thank-you')
        }
    };

    handleFieldChange = (field, value) => {
        if (field == 'phone' && isNaN(value))
            return false;

        this.setState(() => {
            if ( field == 'customerState')
                return {[field]: value, fname: '', lname: '', email: '', phone: '', password: '', city_id: '', address: '', notes: '',};

            return {[field]: value};
        });
    };

    handleFormSubmit = (e) => {
        e.preventDefault();
        e.stopPropagation();

        $('.webloader').show();
        let {id, fname, lname, email, phone, password, city_id, address, notes, customerState, country} = this.state;
        let user = {id, fname, lname, email, phone, password, city_id, address, notes, customerState, country};
        let orderData = this.props.cart;
        let voucher = this.state.voucher;

        this.props.placeOrderAndAdjustUser(user, orderData, voucher);
    };//..... end of handleFormSubmit() ......//

    handleSignInSubmit = (e) => {
        e.preventDefault();
        $('.webloader').show();
        this.props.login({email: this.state.email, password: this.state.password});
    };

    validateVoucher = () => {
        if (this.state.voucher_code == '')
            return false;

        this.setState(() => ({
            isValidatingVoucher: true,
            voucherError: '',
            voucherValidMsg: '',
            voucher: null
        }));

        axios.post(BaseUrl+'/api/validate-voucher', {voucher: this.state.voucher_code})
            .then(response => {
                let res = response.data;
                this.setState(() => ({
                    isValidatingVoucher: false,
                    voucherError: res.status == false ? res.message: '',
                    voucherValidMsg: res.status == true ? res.message: '',
                    voucher: res.status == true ? res.data: null
                }));
            }).catch(error => {
            this.setState(() => ({
                isValidatingVoucher: false,
                voucherError: '',
                voucherValidMsg: '',
                voucher: null
            }));
        });
    };

    loadPromotions = () => {
        axios.post(BaseUrl+'/api/load-promotions', {voucher: this.state.voucher_code})
            .then(response => {
                if (response.data.status)
                this.setState(() => ({promotions: response.data.data}));
            }).catch(error => {
            //
        });
    };

    changePwdVisibility = () => {
        if (this.pwdFieldRef.getAttribute('type') == 'password') {
            this.pwdFieldRef.setAttribute('type', 'text');
            this.setState(() => ({isPwdFieldVisible: true}));
        } else {
            this.pwdFieldRef.setAttribute('type', 'password');
            this.setState(() => ({isPwdFieldVisible: false}));
        }
    };

    render() {
        const is_delivery_free = isDeliveryFree(this.state.promotions, this.props.subTotal);
        const is_flat_discount = isFlatDiscount(this.state.promotions, this.props.subTotal);
        const totalAmount = applyPromotionToAmount(this.props.subTotal, this.props.shippingFee, this.state.voucher, is_delivery_free, is_flat_discount);

        return (
            <div className="checkout-checkout">
                <div className="container-fluid">
                    <div className="breadcrumbs ">
                        <div className="container-fluid">
                            <div className="current-name">
                                &nbsp;
                            </div>
                            <ul className="breadcrumb">
                                <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                                <li><Link to={'/cart'}>Shopping Cart</Link></li>
                                <li><a href={'#'}>Checkout</a></li>
                            </ul>
                        </div>
                    </div>

                    <div className="row">
                        <div id="content" className="col-sm-12">
                            <h1>Checkout</h1>
                            {typeof this.props.user === 'string' && (
                                <div className="alert alert-danger alert-dismissible"><i className="fa fa-exclamation-circle"></i> {this.props.user}.</div>
                            )}
                            <div className="so-onepagecheckout layout1 ">
                                <form action="#" method="post" onSubmit={this.handleFormSubmit}>
                                    <div className="col-left col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        {
                                            (Object.keys(this.props.user).length == 0 || typeof this.props.user === 'string') && (
                                                <>
                                                    <div className="checkout-content login-box">
                                                        <h2 className="secondary-title"><i className="fa fa-user" />Create an Account or Login</h2>
                                                        <div className="box-inner">
                                                            <div className="radio">
                                                                <label>
                                                                    <input type="radio" name="account" checked={this.state.customerState == 'new'} onChange={() => this.handleFieldChange('customerState', 'new')} />
                                                                    New Registration
                                                                </label>
                                                            </div>
                                                            <div className="radio">
                                                                <label>
                                                                    <input type="radio" name="account" checked={this.state.customerState == 'old'} onChange={() => this.handleFieldChange('customerState', 'old')} />
                                                                    Returning Customer
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {this.state.customerState == 'old' && (
                                                            <div className="checkout-content checkout-login" style={{display: 'block'}}>
                                                                <fieldset>
                                                                    <h2 className="secondary-title"><i className="fa fa-unlock" />Returning Customer</h2>
                                                                    <div className="box-inner">
                                                                        <div className="form-group">
                                                                            <input type="email" required={'required'} value={this.state.email} onChange={(e) => this.handleFieldChange('email', e.target.value)} placeholder="E-Mail" className="form-control" />
                                                                        </div>
                                                                        <div className="form-group">
                                                                            <input type="password" required={'required'} value={this.state.password} onChange={(e) => this.handleFieldChange('password', e.target.value)} placeholder="Password" className="form-control" ref={(ref) => this.pwdFieldRef = ref}/>
                                                                            <i className={"fa "+ (this.state.isPwdFieldVisible ? "fa-eye-slash" : "fa-eye")} style={{
                                                                                position: "absolute",
                                                                                top: "11px",
                                                                                right: "13px",
                                                                                cursor: "pointer"
                                                                            }} onClick={this.changePwdVisibility}></i>
                                                                        </div>
                                                                        <div className="form-group">
                                                                            <input type="button" defaultValue="Login" id="button-login" data-loading-text="Loading..." className="btn-primary button" onClick={this.handleSignInSubmit}/>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                    )}
                                                </>
                                        )}

                                        <div className="checkout-content checkout-register">
                                            {(this.state.customerState == 'new' || (typeof this.props.user === 'object' && Object.keys(this.props.user).length > 0)) && (<>
                                            <fieldset id="account">
                                                <h2 className="secondary-title"><i className="fa fa-user-plus" />Your Personal Details</h2>
                                                <div className="payment-new box-inner">
                                                    <div className="form-group input-firstname required" style={{width: '49%', float: 'left'}}>
                                                        <input type="text"  value={this.state.fname} onChange={(e) => this.handleFieldChange('fname', e.target.value)} placeholder="First Name *" className="form-control"  required={'required'}/>
                                                    </div>

                                                    <div className="form-group input-lastname required" style={{width: '49%', float: 'right'}}>
                                                        <input type="text" value={this.state.lname} onChange={(e) => this.handleFieldChange('lname', e.target.value)} placeholder="Last Name *" className="form-control"  required={'required'}/>
                                                    </div>

                                                    <div className="form-group required" style={{width: '49%', float: 'left'}}>
                                                        <select required="required" name={'city'} value={this.state.city_id}  onChange={(e) => this.handleFieldChange('city_id', e.target.value)}>
                                                            <option value>-- Select City --</option>
                                                            {
                                                                this.props.cities.map(city => {
                                                                    return (<option key={city.id} value={city.id}>{city.title}</option>)
                                                                })
                                                            }
                                                        </select>
                                                    </div>

                                                    <div className="form-group required telephone__input__container" style={{width: '49%', float: 'right'}}>
                                                        <input type="text" name="telephone" value={this.state.phone} onChange={(e) => this.handleFieldChange('phone', e.target.value)} placeholder="Telephone *" className="form-control"  required={'required'}/>
                                                    </div>

                                                    <div className="form-group fax-input">
                                                        <input type="text" name="country" value={this.state.country} onChange={(e) => this.handleFieldChange('country', e.target.value)} placeholder="Country" className="form-control"  required={'required'}/>
                                                    </div>

                                                    <div className="form-group required">
                                                        <input type="text" required={'required'} value={this.state.address} onChange={(e) => this.handleFieldChange('address', e.target.value)} placeholder="Address *" className="form-control" />
                                                    </div>

                                                    {this.state.customerState == 'new' && (
                                                        <>
                                                        <div className="form-group required">
                                                            <input type="email" value={this.state.email} onChange={(e) => this.handleFieldChange('email', e.target.value)} placeholder="E-Mail *"  required={'required'} className="form-control" />
                                                        </div>
                                                        <div className="form-group required">
                                                            <input type="password" onChange={(e) => this.handleFieldChange('password', e.target.value)} value={this.state.password} placeholder="Password *"  required={'required'} className="form-control" />
                                                        </div>
                                                        </>
                                                    )}
                                                </div>
                                            </fieldset>
                                            </>)}

                                            <fieldset id="password" style={{display: 'block'}}>
                                                <h2 className="secondary-title"><i className="fa fa-gift" />Apply Voucher</h2>
                                                <div className="box-inner">
                                                    <div className="form-group required">
                                                        <input type="text" value={this.state.voucher_code} onChange={(e) => this.handleFieldChange('voucher_code', e.target.value)} placeholder="Voucher" className="form-control" />
                                                    </div>
                                                    <div className="form-group">
                                                        <input type="button" defaultValue="Apply Voucher" className="btn-primary button" onClick={this.validateVoucher} disabled={this.state.isValidatingVoucher}/>
                                                        {this.state.isValidatingVoucher && <img src={BaseUrl+'/images/lazy-loader.gif'} style={{marginLeft: '20px'}}/>}
                                                        <span style={{color: this.state.voucherValidMsg ? 'green' : (this.state.voucherError ? 'red' : 'black'), marginLeft: '10px'}}>{this.state.voucherError || this.state.voucherValidMsg}</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div className="col-right col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <section className="section-left">
                                            <div className="ship-payment">
                                                <div className="checkout-content checkout-payment-methods">
                                                    <h2 className="secondary-title"><i className="fa fa-credit-card" />Payment Method</h2>
                                                    <div className="box-inner">
                                                        <div className="radio">
                                                            <label>
                                                                <input type="radio" name="payment_method" defaultValue="cod" defaultChecked="checked" />
                                                                Cash On Delivery
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section className="section-right">
                                            <div className="checkout-content checkout-cart">
                                                <h2 className="secondary-title"><i className="fa fa-shopping-cart" />Shopping Cart </h2>
                                                <div className="box-inner">
                                                    <div className="table-responsive checkout-product">
                                                        <table className="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th className="text-left name" colSpan={2}>Product Name</th>
                                                                <th className="text-center quantity">Quantity</th>
                                                                <th className="text-center price">Unit Price</th>
                                                                <th className="text-right total">Total</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            {this.props.cart.map(prd => {
                                                                return (
                                                                    <tr key={prd.id}>
                                                                        <td className="text-left name" colSpan={2} style={{width: '40%'}}>
                                                                            <Link to={'/product/'+prd.slug} style={{display: 'inline-block', width: '15%'}}>
                                                                                <img src={`${BaseUrl}/uploads/thumbs/${prd.image[0]}`} alt={prd.title} title={prd.title} className="img-thumbnail" style={{width: '47px', height: '47px'}}/>
                                                                            </Link>
                                                                            <Link to={'/product/'+prd.slug} className="product-name" style={{display: 'inline-block', width: '85%', wordBreak: 'break-word', fontSize: '11px'}}>{prd.title}</Link>
                                                                            {prd.selectedColor.title && (
                                                                                <><br/> <small>Select color: {prd.selectedColor.title}</small></>
                                                                            )}
                                                                        </td>
                                                                        <td className="text-left quantity" style={{width: '10%'}}>
                                                                            {prd.orderQuantity}
                                                                        </td>
                                                                        <td className="text-right price" style={{width: '20%'}}>Rs: {selectFinalPriceWithOptionSelected(prd)}</td>
                                                                        <td className="text-right total" style={{width: '30%'}}>Rs: {(prd.orderQuantity * selectFinalPriceWithOptionSelected(prd)).toFixed(2)}</td>
                                                                    </tr>
                                                                )})}
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colSpan={4} className="text-left">Sub-Total:</td>
                                                                    <td className="text-right">Rs: {this.props.subTotal.toFixed(2).toLocaleString()}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colSpan={4} className="text-left">Flat Shipping Rate:</td>
                                                                    <td className="text-right">Rs {is_delivery_free ? 0 : this.props.shippingFee}</td>
                                                                </tr>
                                                                {this.state.voucher &&
                                                                    <tr>
                                                                        <td colSpan={4} className="text-left">Voucher Applied:</td>
                                                                        <td className="text-right">Rs {this.state.voucher.amount}</td>
                                                                    </tr>
                                                                }
                                                                {is_flat_discount > 0 &&
                                                                    <tr>
                                                                        <td colSpan={4} className="text-left">Promotional Discount:</td>
                                                                        <td className="text-right">Rs {is_flat_discount}</td>
                                                                    </tr>
                                                                }
                                                                <tr>
                                                                    <td colSpan={4} className="text-left">Total:</td>
                                                                    <td className="text-right">Rs: {totalAmount}</td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                    <div id="payment-confirm-button" className="payment-">
                                                        <h2 className="secondary-title"><i className="fa fa-credit-card" />Payment Details</h2>
                                                        <div className="buttons">
                                                            <div className="pull-right">
                                                                <input type="button" defaultValue="Confirm Order" id="button-confirm" data-loading-text="Loading..." className="btn btn-primary" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="checkout-content confirm-section">
                                                <div>
                                                    <h2 className="secondary-title"><i className="fa fa-comment" />Add Comments About Your Order</h2>
                                                    <label>
                                                        <textarea name="comment" rows={8} className="form-control requried"  value={this.state.notes} onChange={(e) => this.handleFieldChange('notes', e.target.value)} placeholder={'Add extra note for this order.'} />
                                                    </label>
                                                </div>
                                                <div>
                                                    <p style={{color: 'red'}}>**The product(s) price(s) and Shipping cost will be different for outside country. The customer will be contacted before processing the order. Thanks**</p>
                                                </div>
                                                <div className="confirm-order">
                                                    <button type='submit' className="btn btn-primary button confirm-button">Confirm Order</button>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }//..... end of render() .....//
}//..... end of Checkout.

const mapStateToProps = (state) => {
    return {
        cart: state.cart.cart,
        subTotal: state.cart.cart.reduce((total, prd) => total + (selectFinalPriceWithOptionSelected(prd) * prd.orderQuantity), 0),
        shippingFee: calculateShippingFee(state.cart.cart),
        user: state.common.user,
        cities: state.common.cities
    };
};

const mapPropsToActions = (dispatch) => {
    return {
        loadCities: () => dispatch(getCitiesList()),
        placeOrderAndAdjustUser: (user, orderData, voucher) => dispatch(placeOrderAndAdjustUserDetails(user, orderData, voucher)),
        login: (userCredentials) => dispatch(loginUser(userCredentials))
    };
};

export default connect(mapStateToProps, mapPropsToActions)(withRouter(Checkout));

