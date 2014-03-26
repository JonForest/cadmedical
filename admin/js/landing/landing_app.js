/**
 * Created by jonforest on 02/02/2014.
 */


ablefutures.cadmedical.app.landing = (function($,_) {

    'use strict';


    function init()
    {
        renderTable();
        eventsInit();
    }

    function renderTable()
    {
//        var categories = new ablefutures.cadmedical.collections.categories();
//        categories.fetch({
//            success: function(collection, response, options) {
//                var categoryListView = new ablefutures.cadmedical.views.categoryList({
//                    collection : collection,
//                    el : '#categoryTable'
//                });
//                categoryListView.render();
//
//            },
//
//            error : function() {
//                console.log('Failed to retrieve categories');
//            }
//        })
    }

    function eventsInit()
    {

    }


    return {
        init : init
    }

})($,_)

$(document).ready(function() {
    ablefutures.cadmedical.app.landing.init();
});
