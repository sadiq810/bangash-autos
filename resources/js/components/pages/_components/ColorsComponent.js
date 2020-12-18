import React from "react";
export default ({product, handleOption, selectedColor}) => {
    return (
        <div id="product">
            <h3>Available Colors </h3>
            <div style={{width: '100%', display: 'inline-table'}}>
                {product && product.colors.map((clr) => {
                    return <div key={clr.id} onClick={() => handleOption(clr.id)} style={{minWidth: '39px', backgroundColor: '#fafafa', float: 'left', padding: '10px', margin: (selectedColor.id == clr.id ? '1px' : '2px'), cursor: 'pointer', color: (clr.title == 'Without Paint' ? 'red' : clr.color), border: (selectedColor.id == clr.id ? '1px solid red' : '')}}>{clr.title}</div>
                })}
            </div>
        </div>
    );
};
