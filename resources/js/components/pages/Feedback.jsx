import React, {Component} from 'react';

class Feedback extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    render() {
        return (
            <>
                <section className="mainCatSection innercatbg" style={{backgroundPosition: 'center left', backgroundColor: 'rgb(132, 132, 132)'}}>
                    <div className="main-overlay" style={{ backgroundColor: 'rgb(177, 235, 0)' ,opacity:0.6 }}>&nbsp;</div>
                    <div className="container">
                        <div className="row">
                            <div className="col-xs-12">
                                <h1>Feedback</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <div className="container" style={{padding: '50px 0px'}}>
                    <div className="col-xs-12 col-md-10 col-md-offset-1">
                        <section className="card card-lg" id="about-about">
                            <p>In order to consistently enhance customer service we strive to stay connected to our customers and encourage two-way communication between you, the patrons, and our Customer Care staff.</p>
                            <p>We understand that customers are the pulse of any successful business, and it is only through the cultivation of your feedback, regardless of whether it is positive or negative, we can grow into company that delivers you with the best of our capabilities.</p>
                            <p>
                                Kindly send us your valued feedback, through the following, so that we can discover new ways to provide ease and convenience to you our valued customers.
                            </p>
                            <h2>Contact Information</h2>
                            <div className="well">
                                <h3 style={{lineHeight: '20%'}}><i className="fa fa-home fa-1x" style={{lineHeight: '6%', color: '#e2941e'}} /> Address :</h3>
                                <p style={{marginTop: '6%'}}>
                                    <b>Retail Outlet:</b> Tehkal, Tambwano Morr, Near with ZONG Head Office, University Road, Peshawar, Pakistan.<br />
                                    <b>Head office:</b> Tehkal, Tambwano Morr, Near with ZONG Head Office, University Road, Peshawar, Pakistan.
                                </p>
                                <br />
                                <br />
                                <h3 style={{lineHeight: '20%'}}><i className="fa fa-envelope fa-1x" style={{lineHeight: '6%', color: '#e2941e'}} /> E-Mail:</h3>
                                <p style={{marginTop: '6%'}}><a href="mailto:info@BangashAutos.pk">info@BangashAutos.pk</a></p>
                                <br />
                                <br />
                                <h3 style={{lineHeight: '20%'}}><i className="fa fa-users fa-1x" style={{lineHeight: '6%', color: '#e2941e'}} /> Get In Touch:</h3>
                                <p style={{marginTop: '6%', lineHeight: '35%'}}>
                                </p><ul className="socialList list-unstyled">
                                <li>
                                    <span className="sircle"><i className="fa-2x fa fa-whatsapp" /> <a href="tel:+923106000011">(+92) 310-6000011</a></span>
                                </li>
                            </ul>
                                <ul className="list-inline">
                                    <li>
                                        <a href="https://www.facebook.com/Bangashautos/" target="_blank"><span className="sircle"><i className="fa-2x fa fa-facebook-square" /></span></a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/BangashAutos/" target="_blank"><span className="sircle"><i className="fa-2x fa fa-instagram" /></span></a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/BangashAutos" target="_blank"><span className="sircle"><i className="fa-2x fa fa-twitter-square" /></span></a>
                                    </li>
                                </ul>
                                <p />
                            </div>
                        </section>
                    </div>
                </div>

            </>
        );
    }//..... end of render() .....//
}//..... end of Feedback.

export default Feedback;
