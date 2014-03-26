/**
 * Created by jonforest on 02/02/2014.
 */


ablefutures.cadmedical.app.categoryEdit = (function($,_) {

    'use strict';

    var isNewCategory,
        category;


    /**
     *
     * @param {bool} isNewCategoryArg
     * @param {ablefutures.cadmedical.models.category} categoryArg
     */
    function init(isNewCategoryArg, categoryArg)
    {
        isNewCategory = isNewCategoryArg;
        category = categoryArg;


        renderForm();
//        eventsInit();
    }

    function renderForm()
    {

        if (isNewCategory) {
            var categoryEdit = new ablefutures.cadmedical.views.categoryEdit({
                model : new ablefutures.cadmedical.models.category()
            });
            $('#body').html(categoryEdit.render().$el);
        } else {
            var productEdit = new ablefutures.cadmedical.views.productEdit({
                model : category
            });
            $('#body').html(productEdit.render().$el);

        }
    }

    function eventsInit()
    {

    }


    return {
        init : init
    }

})($,_);

