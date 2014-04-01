
ablefutures.cadmedical.views.pagesList = Backbone.View.extend({

    template : _.template($('#pagesList_template').html()),

    render : function()
    {
        this.collection.each(function(model) {
            var $tr = $('<tr>').addClass('page');
            $tr.append(this.template({model : model}));
            this.$el.append($tr);
        }.bind(this));

        return this;
    }




});