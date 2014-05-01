/* global Backbone */
/* global ablefutures */
(function() {
    'use strict';

    ablefutures.cadmedical.views.detail = Backbone.View.extend({

        tagName: 'li',

        render :  function()
        {
            this.$el.empty();

            this.$el.append(this.model.get('description'));

            return this;
        }

    });

}());