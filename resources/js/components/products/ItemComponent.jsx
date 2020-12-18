import React from 'react';
import {Link} from 'react-router-dom';

function ItemComponent(props) {
    return (
        <li key={props.prd.id} className="transall">
            <Link to={'/product/'+props.prd.slug} className={'productLink'}>
                <div className="image p-image">
                    <img src={`${BaseUrl}/uploads/thumbs/${props.prd.image[0]}`} alt={ props.prd.title} className="img-responsive"/>
                </div>
                <p className="ptitle">
                    { props.prd.title}
                </p>
                <div className="p-price">Rs { props.prd.final_price }</div>
            </Link>
            <div className="icon_image">
                <ul className="list-inline cartBtns">
                    <li>
                        <a href="#" onClick={() => props.showModal(props.prd)}>
                            <img src={ BaseUrl+"/images/search.png"} className="img-responsive search_icon"/>
                        </a>
                    </li>
                    <li>
                        <a href="#" className="btn btn-cart-sm"  onClick={() => props.showProductAddedModal(props.prd)}>Buy Now</a>
                    </li>
                </ul>
            </div>
        </li>
    );
}

export default ItemComponent;
