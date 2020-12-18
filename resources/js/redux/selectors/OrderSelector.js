export const selectOrdersCustomData = (orders) => {
    let orderData = [];

    orders.forEach((order) => {
        order.detail.forEach(dt => {
           orderData.push({
               order_id: order.id,
               status: order.status,
               quantity: dt.quantity - dt.return_quantity,
               unit_price: dt.unit_price,
               discount: dt.discount,
               sub_total: dt.sub_total,
               title: dt.product.title,
               slug: dt.product.slug,
               date: order.date,
               image: dt.product.image,
               detail_id: dt.id
           });
        });
    });

    return orderData;
};
