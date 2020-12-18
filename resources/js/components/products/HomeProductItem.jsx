import React from 'react';
import {Link} from "react-router-dom";

function HomeProductItem(props) {
    return (
        <li key={props.prd.id} className="transall item ">
            <Link to={`/product/${props.prd.slug}`}>
                {/*<span>
                                                         <span className="pbadge" style={{background: '#62b959'}}>Hot</span>
                                                     </span>*/}
                {
                    props.prd.discount > 0 && <span id="productCircle-9553">
                                                        <span className="circle">
                                                            <img src={BaseUrl+"/images/circle.png"} alt="circle"/>
                                                            <span className="usp">
                                                                <div className="usp_1">
                                                                    Off<br/><span className="usp_off">Rs. {props.prd.discount}</span>
                                                                </div>
                                                            </span>
                                                        </span>
                                                    </span>
                }

                <div className="p-image">
                    <img src={`${BaseUrl}/uploads/thumbs/${props.prd.image[0]}`} alt={props.prd.title} className="img-responsive"/>
                </div>
                <p>{props.prd.title}</p>
                <div className="p-price">
                    { props.prd.discount > 0 && (<span className="sale">
                                                            <s>Rs: {props.prd.sale_price}</s>
                                                        </span>) }
                    Rs: {props.prd.final_price}
                </div>
            </Link>

            <Link to={`/product/${props.prd.slug}`} className="mask"/>
            <div className="cartBtn">
                <a href="#" className="btn btn-search" onClick={() => props.showModal(props.prd)}>
                    <img src={BaseUrl+"/images/icon-search-btn.png"} alt="search"/>
                </a>
                <a href="#" className="btn btn-cart-sm" onClick={() => props.showProductAddedModal(props.prd)}>Buy</a>
            </div>
        </li>
    );
}//..... end of HomeProductItem.

export default HomeProductItem;
