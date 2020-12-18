import React, {Component} from 'react';
import {Link} from "react-router-dom";
import LoaderComponent from "../layouts/LoaderComponent";

class Contact extends Component {
    constructor(props) {
        super(props);
        this.state = {
            address: '',
            phone: '',
            email: '',
            facebookPageUrl: '',
            twitterUrl: '',
            pinterestUrl: '',
            youtubeUrl: '',
            name: '',
            cemail: '',
            enquiry: '',
            loader: false,
            image: null,
            cphone: ''
        };
    }//..... end of constructor() .....//

    componentDidMount() {
        this.setState({
            address: officeAddress,
            phone: phone,
            email: contactEmail,
            facebookPageUrl: facebookPageUrl,
            twitterUrl: twitterUrl,
            pinterestUrl: pinterestUrl,
            youtubeUrl: youtubeUrl,
        });
    }

    handleField = (value, field) => {
        this.setState(() => ({[field]: value}))
    };

    handleFormSubmit = (e) => {
        e.preventDefault();
        this.setState({loader: true});

        fetch(   BaseUrl+"/api/save-contact-us",{
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                name: this.state.name,
                email: this.state.cemail,
                detail: this.state.enquiry,
                phone: this.state.cphone,
                image: this.state.image
            }),
        })
            .then(response => response.json())
            .then(json => {
                this.setState(() => ({
                    name: '',
                    enquiry: '',
                    cemail: '',
                    cphone: '',
                    loader: false,
                }));
            }).catch(err => {
            this.setState({loader: false});
        });
    };

    getBase64 = (files) => {
        if (files.length <= 0) {
         this.setState(() => ({image: null}));
         return false;
        }//..... end if() ....//

        let file = files[0];
        if (! file.type.includes('image')) {
            alert('Please select an image.');
            return false;
        }//..... end if() ....//

        let reader = new FileReader();
        reader.readAsDataURL(file);
        let $this = this;
        reader.onload = function () {
            $this.setState(() => ({image: reader.result}))
        };
        reader.onerror = function (error) {
            console.log('Error: ', error);
        };
    };

    render() {
        return (<>
            <div className="breadcrumbs">
                <div className="container">
                    <ul className="breadcrumb">
                        <li><Link to={'/'}><i className="fa fa-home" /></Link></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <div className="container">
                <div className="row">
                    <div id="content" className="col-sm-12">
                        <div className="info-contact row">
                            <div className="col-sm-4 col-xs-12">
                                <div className="info-store">
                                    <div className="name-store"><h3>Address & Contact Info</h3></div>
                                    <address>
                                        <div className="address clearfix form-group">
                                            <div className="pull-left">
                                                <i className="fa fa-home" />
                                            </div>
                                            <div className="text">{this.state.address}</div>
                                        </div>
                                        <div className="form-group">
                                            <div className="pull-left">
                                                <i className="fa fa-phone" />
                                            </div>
                                            <div className="text">{ this.state.phone }</div>
                                        </div>
                                        <div className="form-group">
                                            <div className="pull-left">
                                                <i className="fa fa-envelope" />
                                            </div>
                                            <div className="text"> {this.state.email}</div>
                                        </div>
                                    </address>
                                    <div className="socials">
                                        <ul>
                                            {this.state.facebookPageUrl &&
                                            <li><a href={this.state.facebookPageUrl}><i className="fa fa-facebook" /></a></li>
                                            }

                                            {this.state.twitterUrl &&
                                            <li><a href={this.state.twitterUrl}><i className="fa fa-twitter" /></a></li>
                                            }

                                            {this.state.pinterestUrl &&
                                            <li><a href={this.state.pinterestUrl}><i className="fa fa-pinterest" /></a></li>
                                            }

                                            {this.state.youtubeUrl &&
                                            <li><a href={this.state.youtubeUrl}><i className="fa fa-youtube" /></a></li>
                                            }
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div className="col-sm-8 col-xs-12">
                                <div className="contact-form">
                                    <form action="#" method="post" onSubmit={this.handleFormSubmit} encType="multipart/form-data" className="form-horizontal">
                                        <fieldset>
                                            <legend><h2>Contact Us </h2></legend>
                                            <div className="form-group required">
                                                <div className="col-sm-12">
                                                    <input type="text" name="name" value={this.state.name} onChange={(e) => this.handleField(e.target.value, 'name') } id="input-name" className="form-control" placeholder="Your Name *" required={'required'}/>
                                                </div>
                                            </div>
                                            <div className="form-group required">
                                                <div className="col-sm-12">
                                                    <input type="text" name="email" value={this.state.cemail} onChange={(e) => this.handleField(e.target.value, 'cemail') } id="input-email" className="form-control" placeholder="E-Mail Address *" required={'required'} />
                                                </div>
                                            </div>
                                            <div className="form-group required">
                                                <div className="col-sm-12">
                                                    <input type="tel" name="phone" value={this.state.cphone} onChange={(e) => this.handleField(e.target.value, 'cphone') } id="input-phone" className="form-control" placeholder="Phone *" required={'required'} />
                                                </div>
                                            </div>
                                            <div className="form-group required">
                                                <div className="col-sm-12">
                                                    <input type="file" name="image" defaultValue={''} onChange={(e) => this.getBase64(e.target.files) } className="form-control" placeholder="Image" accept={'image/*'} />
                                                </div>
                                            </div>
                                            <div className="form-group required">
                                                <div className="col-sm-12">
                                                    <textarea name="enquiry" value={this.state.enquiry} onChange={(e) => this.handleField(e.target.value, 'enquiry') } rows={10} id="input-enquiry" placeholder="Enquiry *" className="form-control" required={'required'}/>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div className="buttons">
                                            <div className="pull-left">
                                                <button className="btn btn-info" type="submit"><span>Submit </span></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div className="info-store">
                            <div id="map-canvas" />
                        </div>
                    </div>
                </div>
            </div>
            {this.state.loader && <LoaderComponent />}
        </>);
    }//..... end of render() .....//
}//..... end of Contact.

export default Contact;
