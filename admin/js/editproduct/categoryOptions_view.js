(function() {

    'use strict'

    ablefutures.cadmedical.views.categoryOptions = Backbone.View.extend({

        template: _.template($('#categorylist_template').html()),

        tagName: 'option',

        render : function()
        {
            this.$el.append(this.template({model : this.model}));
            this.$el.attr('value', this.model.get('categoryId'));

            return this;
        }
    });
}());