/* global Backbone */
/* global ablefutures */
/* global _ */

(function() {
    'use strict';

    ablefutures.cadmedical.views.details = Backbone.View.extend({

        tagName : 'ul',

        render :  function()
        {
            var $elems = [];
            this.$el.empty();


            this.collection.each(function(model) {
                var detailView = new ablefutures.cadmedical.views.detail({model:model});
                $elems.push(detailView.render().$el);
            });

            this.$el.append($elems);

            return this;
        }

    });

}());