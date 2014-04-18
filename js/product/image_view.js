/* global Backbone */
/* global ablefutures */
/* global _ */

(function() {
    'use strict';

    ablefutures.cadmedical.views.image = Backbone.View.extend({

        template : _.template($('#imageview_template').html()),

        render :  function()
        {
            this.$el.empty();

            this.$el.append(this.template({model : this.model}));

            return this;
        }

    });

}());