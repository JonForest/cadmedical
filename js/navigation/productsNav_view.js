
(function() {
    'use strict'

    ablefutures.cadmedical.views.productsNav = Backbone.View.extend({

        template : _.template($('#productsNav_template').html()),

        tagName : 'li',


//        initialize :  function(options)
//        {
//            this.categoryId = options.categoryId;
//        },

        render :  function()
        {
            this.$el.empty();
//
//            var els =[];
//            this.collection.each(function(model) {
//                if (parseInt(model.get('categoryId')) === parseInt(this.categoryId)) {
//                    model.set('selected', 'class="active"');
//                }
//                els.push(this.template({model : model}));
//            }.bind(this));




            this.$el.append(this.template({model : this.model}));

            return this;
        }

    });

}());