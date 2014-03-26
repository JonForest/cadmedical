
(function() {
    'use strict'

    ablefutures.cadmedical.views.categoriesCommon = Backbone.View.extend({

        template : _.template($('#categoryHeroText_template').html()),
        commonDetailsTemplate : _.template($('#categoryDetail_template').html()),
        modalTemplate : _.template($('#productModal_template').html()),
        className : 'overlay',
        sizingString : '<div class="overlay"><a href="javascript: void(0)" id="showSizingInfo">Show sizing information</a></div>',

        events : {
            'click #showSizingInfo' : 'showSizingInfo'
        },

        render :  function()
        {
            this.$el.empty();

            this.$el.append(this.template({model : this.model}));

            //If we have any categoryDetailItems then go and draw them
//            if (this.model.get('categoryDetailItems').length) {
//                this.$('#categoryDetailsList').append(this.renderCategoryDetailItems(this.model.get('categoryDetailItems')));
//            }
//
            if (this.model.get('sizingHtml') && this.model.get('sizingHtml').trim() !== '') {
                this.$('.categoryDetails').append(this.sizingString);
            }


            return this;
        },

//        renderCategoryDetailItems : function(collection)
//        {
//            var self = this;
//            var $html = [];
//            if (typeof collection !== 'undefined' && !$.isEmptyObject(collection) && collection.length !== 0) {
//                collection.each(function(model) {
//                    $html.push(self.commonDetailsTemplate({model:model}));
//                });
//            }
//            return $html;
//        }


        /**
         *
         * @param {Event} e
         */
        showSizingInfo : function(e)
        {
            e.preventDefault();
            if (!$('#productModal').length) {
                $('body').append(this.modalTemplate({model : this.model}));
            }
            $('#productModal').modal('show');
        }
    });

}());


