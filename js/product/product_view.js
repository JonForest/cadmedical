/* global Backbone */
/* global ablefutures */
/* global _ */

(function() {
    'use strict';

    ablefutures.cadmedical.views.product = Backbone.View.extend({

        template : _.template($('#product_template').html()),

        render :  function()
        {
            this.$el.empty();


            this.$el.append(this.template({model : this.model}));

            var prices = new ablefutures.cadmedical.views.prices({
                collection : this.model.get('prices')
            });
            this.$('.prices').append(prices.render().$el);

            var details = new ablefutures.cadmedical.views.details({
                collection : this.model.get('productDetailItems')
            });
            this.$('#productDetailsList').append(details.render().$el);

            var $productImage = this.$('#productImage');
            $productImage.empty();
            this.model.get('images').each(function(model){
                var image = new ablefutures.cadmedical.views.image({model : model});
                $productImage.append(image.render().$el);
            });

            this.$el.addClass('product');
            this.$el.attr('id',this.model.get('productId'));

            return this;
        },

        renderPrices : function()
        {

        }

    });

}());