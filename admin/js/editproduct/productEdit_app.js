/**
 * Created by jonforest on 02/02/2014.
 */


ablefutures.cadmedical.app.newproduct = (function($,_) {

    'use strict';

    var newProduct,
        productId,
        categories;


    /**
     *
     * @param newProductArg
     * @param productIdArg
     * @param {ablefutures.cadmedical.collections.categories} categoriesArg
     */
    function init(newProductArg, productIdArg, categoriesArg)
    {
        newProduct = newProductArg;
        productId = productIdArg;
        categories = categoriesArg;

        renderForm();
        eventsInit();
    }

    function renderForm()
    {

        if (newProduct) {
            var productEdit = new ablefutures.cadmedical.views.productEdit({
                model : new ablefutures.cadmedical.models.product({productId : productId}),
                categories : categories
            });
            $('#body').html(productEdit.render().$el);
        } else {
            var product = new ablefutures.cadmedical.models.product();
            product.fetch({
                data : {productId : productId},
                success: function(model, response, options) {
                    var productEdit = new ablefutures.cadmedical.views.productEdit({
                        model : model,
                        categories: categories
                    });
                    $('#body').html(productEdit.render().$el);

                },

                error : function() {
                    console.log('Failed to retrieve product');
                }
            });
        }
    }

    function eventsInit()
    {

    }


    return {
        init : init
    }

})($,_);

