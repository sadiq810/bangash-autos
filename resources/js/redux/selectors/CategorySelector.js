import _ from 'lodash';

export const selectSpecificCategoryProducts = (products, subCategoryFilter = [], priceRange = {}) => {
    if (products === undefined)
        return [];
    let fp = subCategoryFilter.length > 0
        ? products.filter(prd => subCategoryFilter.includes(prd.sub_category_id))
        : products;

    if (priceRange.max && priceRange.min) {
        fp = fp.filter(prd => prd.sale_price >= priceRange.min && prd.sale_price <= priceRange.max);
    }

    return fp;
};


export const getProductCategoryBySlug = (categories, product) => {
    let category = _.find(categories, function(cat) {
        return (cat && product && cat.id == product.category_id)
    });

    let subCategory = category ? _.find(category.sub_categories, function(sc) { return sc.id == product.sub_category_id}) : null;

    return {category, subCategory};
};

export const selectAllSubCategories = (categories) => {
    if (typeof categories == 'object') {
        let subCategories = [];

        categories.forEach(cat => {
           subCategories = [...subCategories, ...cat.sub_categories];
        });

        return subCategories;
    }

    return [];
};

export const selectSalesProducts = (categories, subCategoryFilter = [], priceRange = {}) => {
    let products = [];

    categories.forEach(cat => {
        if (cat.products) {
            cat.products.products.forEach(prd => {
                if (prd.discount > 0)
                    products.push(prd);
            })
        }
    });

    products = subCategoryFilter.length > 0
        ? products.filter(prd => subCategoryFilter.includes(prd.sub_category_id))
        : products;

    if (priceRange.max && priceRange.min) {
        products = products.filter(prd => prd.sale_price >= priceRange.min && prd.sale_price <= priceRange.max);
    }

    return products;
};

export const selectVersionsFromSelectModelsOfProducts = (categories, model) => {
    const versions = [];

    categories.forEach(cat => {
        if (cat.products) {
            cat.products.forEach(prd => {
                if (prd.car_model_id == model.id)
                    if (!versions.includes(prd.car_version))
                        versions.push(prd.car_version);
            })
        }
    });

    return versions.sort();
};


export const selectFilterProducts = (categories, subCategoryFilter = [], priceRange = {}, filters = {}) => {
    let products = [];

    categories.forEach(cat => {
        if (cat.products) {
            cat.products.forEach(prd => {
                if (filters.selectedVersion && filters.selectedModel && Object.keys(filters.selectedModel).length > 0 ) {
                    if (prd.car_model_id == filters.selectedModel.id && prd.car_version == filters.selectedVersion)
                        products.push(prd);
                } else if(filters.selectedModel && Object.keys(filters.selectedModel).length > 0) {
                    if (prd.car_model_id == filters.selectedModel.id)
                        products.push(prd);
                } else if(filters.models && Object.keys(filters.models).length > 0) {
                        let parent = filters.models[0].parent;
                        if (parent != undefined && prd.car_brand_id == parent)
                            products.push(prd);
                } else {
                    products.push(prd);
                }
            })
        }
    });

    products = subCategoryFilter.length > 0
        ? products.filter(prd => subCategoryFilter.includes(prd.sub_category_id))
        : products;

    if (priceRange.max && priceRange.min) {
        products = products.filter(prd => prd.sale_price >= priceRange.min && prd.sale_price <= priceRange.max);
    }

    return products;
};


export const searchProduct = (categories, searchString) => {
    let products = [];

    categories.forEach(cat => {
        if (cat.products) {
            cat.products.forEach(prd => {
                if (prd.title.toLowerCase().includes(searchString.toLowerCase()))
                    products.push(prd);
            })
        }
    });

    return products;
};

export const selectFinalPriceWithOptionSelected = (product) => {
    let optionPrice = 0;
    if (product.selectedColor && Object.keys(product.selectedColor).length > 0)
        optionPrice = parseFloat(product.selectedColor.price);

    return parseFloat(product.final_price) + optionPrice;
};

export const calculateShippingFee = (cart) => {
    let total = 0;

    if (shipCostMethod == 2) {
        let totalWeight = cart.reduce((total, prd) => {
            let weight = parseFloat(prd.weight);
            return (total + (weight * prd.orderQuantity));
        }, 0);

        let kgCost = parseInt(perKgCharges);
        let weightInGrams = totalWeight * 1000;

        if (kgCost) {
            total = Math.ceil(weightInGrams/1000) * kgCost;
        } else {
            if (weightInGrams <= 500)
                total = 190;
            else if(weightInGrams <= 1000)
                total = 220;
            else {
                total = 220;
                let remainingWeightInGrams = weightInGrams - 1000;
                let remainingWeightInKg = remainingWeightInGrams/1000;

                total += (remainingWeightInKg * 150);
            }//.... end if-else() .....//
        }
    } else {
        total = cart.reduce((total, prd) => {
            let length = parseInt(prd.dimension.length);
            let width = parseInt(prd.dimension.width);
            let height = parseInt(prd.dimension.height);
            let amount = (length * width * height)/5000;
            return (total + (amount * prd.orderQuantity));
        }, 0);
    }//..... end if-else() .....//

    return total.toFixed(2)
};


export const applyPromotionToAmount = (subTotal, shippingFee, voucher, is_delivery_free, is_flat_discount ) => {
    let total = subTotal + (is_delivery_free ? 0 : parseFloat(shippingFee));

    if (voucher)
        total -= voucher.amount;

    if (is_flat_discount)
        total -= is_flat_discount;

    return total.toFixed(2).toLocaleString();
};


export const isDeliveryFree = (promotions, totalAmount) => {
    return _.find(promotions, function(o) {
        return o.outcome == "free_delivery" && parseInt(o.trigger_amount) <= totalAmount;
    });
};

export const isFlatDiscount = (promotions, totalAmount) => {
    let discount = _.find(promotions, function(o) {
        return o.outcome == "discount" && parseInt(o.trigger_amount) <= totalAmount;
    });

    return discount ? discount.amount : 0;
};
