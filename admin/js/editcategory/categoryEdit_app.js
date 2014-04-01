/**
 * Created by jonforest on 02/02/2014.
 */


ablefutures.cadmedical.app.categoryEdit = (function($) {

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
    }

    function renderForm()
    {
        var categoryEdit;

        if (isNewCategory) {
            categoryEdit = new ablefutures.cadmedical.views.categoryEdit({
                model : new ablefutures.cadmedical.models.category()
            });
            $('#body').html(categoryEdit.render().$el);
        } else {
            categoryEdit = new ablefutures.cadmedical.views.categoryEdit({
                model : category
            });
            $('#body').html(categoryEdit.render().$el);

        }
    }


    return {
        init : init
    }

})($);

