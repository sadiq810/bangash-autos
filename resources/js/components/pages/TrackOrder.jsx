import React, {Component} from 'react';

class TrackOrder extends Component {
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
                                <h1>Track Shipment</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <div className="container">
                    <div className="col-sm-12 col-md-4 col-md-offset-4">
                        <div className="input-group" style={{marginTop: '15px'}}>
                            <input type="text" className="form-control input-lg input" placeholder="Enter Order Id"/>
                            <span className="input-group-btn">
                                <button className="btn btn-search btn-lg btn-warning" type="button" style={{color: '#fff', backgroundColor: '#a9e21e', borderColor: '#7fcc1a'}}>Track</button>
                            </span>
                        </div>
                    </div>
                </div>

                <div className="container" style={{display: 'none'}} id="msgdiv">
                    <div className="row">
                        <div className="col-xs-12 col-md-12 col-md-offset-1">
                            <p className>Your Consignment Number is <span id="cnNumber" /> Click on this link to track your order   <a href="http://leopards.com.pk/tracking/index.php?cn_number=780987619" id="trackidd" target="_blank">Track</a></p>
                        </div>
                    </div>
                </div>

                <div className="container" style={{padding: '20px 0px'}}>
                    <div className="col-xs-12 col-md-10 col-md-offset-1">
                        <section className="card card-lg" id="about-about">
                            <p>Tracking shipments has become extremely convenient due to the help of our distribution partner TCS and M&amp;P, which has now offered the service to track the ordered product(s) on any given time.</p>
                            <p>Once a consignment is with TCS or M&amp;P, our customers can track their shipment at any period of the transit through various tools provided by TCS or M&amp;P which enables one to know the whereabouts of their shipment, even to figure by whom the shipment was received and at what time and date. A customer can select a TCS or M&amp;P Tracking Tool from the choices offered to receive updates and current status of their shipment any time they want to know the status.</p>
                        </section>
                    </div>
                </div>

            </>
        );
    }//..... end of render() .....//
}//..... end of TrackOrder.

export default TrackOrder;
