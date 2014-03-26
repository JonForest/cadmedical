ablefutures.cadmedical.views.productList = Backbone.View.extend({

    template : _.template($('#productsList_template').html()),

    tagName: 'tr',

    events : {
//        'click .productItemLink' : 'showProducts'
    },

    render : function()
    {
        //var self = this;

        this.$el.addClass('product')
            .attr('data-categoryId', this.model.get('categoryId'));

        this.$el.append(this.template({model : this.model}));

        return this;
    }

});