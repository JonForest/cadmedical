var ablefutures = ablefutures || {};
ablefutures.cadmedical = ablefutures.cadmedical || {collections : {}, app : {}, views : {}, models : {}};


ablefutures.cadmedical.models.price = Backbone.Model.extend({
    idAttribute: 'priceId'

});

ablefutures.cadmedical.collections.prices = Backbone.Collection.extend({
    model: ablefutures.cadmedical.models.price
});

ablefutures.cadmedical.models.productDetailItem = Backbone.Model.extend({
    idAttribute: 'productDetailItemId'
});

ablefutures.cadmedical.collections.productDetailItems = Backbone.Collection.extend({
    model: ablefutures.cadmedical.models.productDetailItem
});

ablefutures.cadmedical.models.categoryDetailItem = Backbone.Model.extend({
    idAttribute: 'categoryDetailItemId'
});

ablefutures.cadmedical.collections.categoryDetailItems = Backbone.Collection.extend({
    model: ablefutures.cadmedical.models.categoryDetailItem
});



ablefutures.cadmedical.models.image = Backbone.Model.extend({
    idAttribute : 'imageId'
});

ablefutures.cadmedical.collections.images = Backbone.Collection.extend({
    model : ablefutures.cadmedical.models.image
});

ablefutures.cadmedical.models.product = Backbone.Model.extend({

    url: '../api/productRouter.php',

    idAttribute : 'productId',

    parse : function(response)
    {
        response.prices = new ablefutures.cadmedical.collections.prices(response.prices);
        response.productDetailItems = new ablefutures.cadmedical.collections.productDetailItems(response.productDetailItems);
        response.images = new ablefutures.cadmedical.collections.images(response.images);

        return response;
    }


});


ablefutures.cadmedical.collections.products = Backbone.Collection.extend({

    model: ablefutures.cadmedical.models.product,
    url: 'api/productsRouter.php'

});

ablefutures.cadmedical.models.category = Backbone.Model.extend({
    idAttribute : 'categoryId',

    parse : function(response)
    {
        response.categoryDetailItems = new ablefutures.cadmedical.collections.categoryDetailItems(response.categoryDetailItems);

        return response;
    }
});


ablefutures.cadmedical.collections.categories = Backbone.Collection.extend({

    model: ablefutures.cadmedical.models.category,
    url: '../api/categoriesRouter.php'
});

ablefutures.cadmedical.models.content = Backbone.Model.extend({
    idAttribute : 'contentId'
});


ablefutures.cadmedical.models.page = Backbone.Model.extend({
    idAttribute : 'pageId',

    parse : function(response)
    {
        response.content = new ablefutures.cadmedical.models.content(response.content);

        return response;
    }
});

ablefutures.cadmedical.collections.pages = Backbone.Collection.extend({

    model: ablefutures.cadmedical.models.page,
    url: '../api/pagesRouter.php'
});

