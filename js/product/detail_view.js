
(function() {
    'use strict'

    ablefutures.cadmedical.views.detail = Backbone.View.extend({

        //template : _.template($('#details_template').html()),
        tagName: 'li',

        render :  function()
        {
            this.$el.empty();

            //this.$el.append(this.template({model : this.model}));
            this.$el.append(this.model.get('description'));

            return this;
        }

    });

}());