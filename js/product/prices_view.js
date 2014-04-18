/* global Backbone */
/* global ablefutures */
/* global _ */

(function() {
    'use strict';

    ablefutures.cadmedical.views.prices = Backbone.View.extend({

        tagName: 'ul',

        render :  function()
        {
            var $elems = [];
            this.$el.empty();


            this.collection.each(function(model) {
                var priceView = new ablefutures.cadmedical.views.price({model:model});
                $elems.push(priceView.render().$el);
            });

            this.$el.append($elems);

            return this;
        }

    });

}());