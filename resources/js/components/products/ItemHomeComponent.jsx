import React from 'react';
import {Link} from "react-router-dom";
import HomeProductItem from "./HomeProductItem";

function ItemHomeComponent(props) {
    return (
        <section className="mainCatSection indexCatSec ">
            <div className="main-overlay"/>
            <div className="container">
                <div className="row">
                    <div className="col-xs-12 col-sm-12 col-md-12 col-lg-2 nopadcat">
                        <Link to={`/${props.cat.slug}`} className="mainCatLink">
                            <h2 style={{color: '#abd037'}}>{props.cat.title} <small>Accessories</small></h2>
                        </Link>

                        <ul className="categoryList list-unstyled">
                            {props.cat.sub_categories.map(scat => {
                                return (
                                    <li key={scat.id}>
                                        <Link to={`/${props.cat.slug}/${scat.slug}`}>{ scat.title }</Link>
                                    </li>
                                );
                            })}
                        </ul>
                    </div>
                    <div className="col-xs-12 col-sm-12 col-md-12 col-lg-10 nopadcat">
                        <div className="productSlider" style={{borderRight: '1px solid #e1e1e1', borderLeft: '1px solid #e1e1e1', borderTop: '2px solid rgb(94, 153, 30)'}}>
                            <div>
                                <ul style={{padding: '0px'}} className="owl-carousel  owl-theme catProSlider list-inline indexProductList p-hover shopList">
                                    {props.cat.products && props.cat.products.map(prd => {
                                        return (
                                            <HomeProductItem key={prd.id} prd={prd} showModal={props.showModal} showProductAddedModal={props.showProductAddedModal}/>
                                        );
                                    })}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}//..... end of ItemHomeComponent.

export default ItemHomeComponent;
