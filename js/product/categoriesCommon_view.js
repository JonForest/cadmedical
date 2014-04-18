/* global Backbone */
/* global ablefutures */
/* global _ */

(function() {
    'use strict';

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

            if (this.model.get('sizingHtml') && this.model.get('sizingHtml').trim() !== '') {
                this.$('.categoryDetails').append(this.sizingString);
            }


            return this;
        },

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


