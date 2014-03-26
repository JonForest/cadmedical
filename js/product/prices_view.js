
(function() {
    'use strict'

    ablefutures.cadmedical.views.prices = Backbone.View.extend({

        //template : _.template($('#details_template').html()),
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