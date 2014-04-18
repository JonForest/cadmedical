/* global Backbone */
/* global ablefutures */
/* global _ */

(function() {
    'use strict';

    ablefutures.cadmedical.views.productsNav = Backbone.View.extend({

        template : _.template($('#productsNav_template').html()),

        tagName : 'li',

        render :  function()
        {
            this.$el.empty();

            this.$el.append(this.template({model : this.model}));

            return this;
        }

    });

}());