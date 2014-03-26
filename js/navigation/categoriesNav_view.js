
(function() {
'use strict'

ablefutures.cadmedical.views.categoriesNav = Backbone.View.extend({

    template : _.template($('#categoriesNav_template').html()),

    tagName : 'ul',

    className : 'nav nav-pills',

    initialize :  function(options)
    {
        this.categoryId = options.categoryId;
    },

    render :  function()
    {
        this.$el.empty();
        var els =[];
        this.collection.each(function(model) {
            if (parseInt(model.get('categoryId')) === parseInt(this.categoryId)) {
                model.set('selected', 'class="active"');
            }
            els.push(this.template({model : model}));
        }.bind(this));

        this.$el.append(els);

        return this;
    }

});

}());