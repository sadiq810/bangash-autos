export const calculatePercentForDiscount = (price, discount) => {
    let discountInPercent = (parseInt(discount) * 100)/parseInt(price);

    return Math.round(discountInPercent);
};
