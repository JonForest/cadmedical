
(function() {
    'use strict'

    ablefutures.cadmedical.views.page = Backbone.View.extend({

        template : _.template($('#pageMain_template').html()),

        render :  function()
        {
            this.$el.html(this.template({model : this.model}));
            return this;
        }


    });

}());