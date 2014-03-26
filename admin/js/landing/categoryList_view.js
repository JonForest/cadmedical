
ablefutures.cadmedical.views.categoryList = Backbone.View.extend({

    template : _.template($('#categoriesList_template').html()),

    events : {
        'click .showproducts' : 'showProducts',
        'click .productItemLink' : 'selectProduct',
        'click .editCategory' : 'editCategory'
    },

    render : function()
    {
        var self = this;

        this.collection.each(function(model) {
            var $tr = $('<tr>').addClass('category');
            $tr.append(this.template({model : model}));
            this.$el.append($tr);
        }.bind(this));

        return this;
    },

    /**
     *
     * @param {Event} e
     */
    showProducts : function(e)
    {
        e.preventDefault();
        e.stopPropagation();

        var $btn = $(e.target);
        var categoryId = $btn.attr('data-categoryId');

        if ($btn.hasClass('showProducts')) {
            $btn.text('Hide Products')
                .removeClass('showProducts')
                .addClass('hideProducts');

            var products = new ablefutures.cadmedical.collections.products();
            products.fetch({
                url: '../' + products.url,
                data : {
                    categoryId : categoryId
                },
                success : function(collection, response, options) {
                    console.log('here');
                    if (collection.length === 0) {
                        var $tr = $('<tr>')
                            .addClass('product')
                            .attr('data-categoryId', categoryId);

                        $tr.append('<td></td><td>No products</td><td></td>');
                        //$btn.parents('tr').after('<tr><td></td><td>No products</td><td></td></tr>')
                        $btn.parents('tr').after($tr);

                        return this;
                    } else {
                        console.log('Here');
                        console.log(JSON.stringify(collection));
                        var $rows = [];
                        collection.each(function(model) {
                            var productListView = new ablefutures.cadmedical.views.productList({model : model});
                            $rows.push(productListView.render().$el);
                        });
                        $btn.parents('tr').after($rows);
                    }
                },
                error : function(message) {
                    console.log('error:  ' + message)
                }

            });
        } else {
            $btn.text('Show Products')
                .removeClass('hideProducts')
                .addClass('showProducts');

            //if it has a data attribute of data-categgoryId = categoryId then remove
            this.$('tr[data-categoryId="' + categoryId + '"].product').remove();
        }
    },

    editCategory : function(e)
    {
        e.preventDefault();

    }




});