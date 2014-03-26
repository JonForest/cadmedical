
(function() {
    'use strict'

    ablefutures.cadmedical.views.price = Backbone.View.extend({

        template : _.template($('#price_template').html()),

        tagName: 'li',

        render :  function()
        {
            this.$el.empty();

            this.$el.append(this.template({model : this.model}));

            return this;
        }

    });

}());