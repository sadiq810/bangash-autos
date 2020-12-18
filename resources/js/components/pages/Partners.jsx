import React, {Component} from 'react';

class Partners extends Component {
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
                                <h1>Our Partners <small>BangashAutos</small></h1>
                            </div>
                        </div>
                    </div>
                </section>
                <div className="container" style={{padding: '50px 0px'}}>
                    <div className="col-xs-12 col-md-10 col-md-offset-1">
                        <section className="card card-lg" id="about-about">
                            <p>At BangashAutos.PK, we believe in partnering up with companies that help us further the vision of Simplification and Digital Reimagination™. A partnership which entrusts the hopes, of our customers, that must be met under any circumstance. As only the most technologically advanced companies can survive in this digital age, thus, BangashAutos.PK has proudly partnered up with TCS, Daewoo and EasyPaisa.</p>
                            <p>These major partner firms lead their respective industries, in Pakistan, on the basis of their vast and strong network, and the ability to provide the necessary services to our company and its patrons. With the immense experience of our Partners, which include other firms ranging from Platform Vendors, IT Infrastructure Companies, Business Software Providers and Technological Solutions Companies, we come across all the hardships we face and deliver our services/products to our valued customers, successfully.</p>
                            <p>EasyPay is a payment solution from EasyPaisa (Telenor) that is specially designed for the benefit of E-Commerce customers and vendors in Pakistan. Our customers can, also, shop at BangashAutos.PK with greater ease and convenience using EasyPay through their debit/credit cards, EasyPaisa mobile accounts or via any EasyPaisa Shop, making EasyPay the most secure and hassle free way to shop online.</p>
                        </section>
                    </div>
                </div>

            </>
        );
    }//..... end of render() .....//
}//..... end of Partners.

export default Partners;
