(function($) {

    'use strict'

    ablefutures.cadmedical.views.productEdit = Backbone.View.extend({

        template : _.template($('#categoryedit_template').html()),
        categoryDetailsTemplate : _.template($('#commonDetails_template').html()),


        events : {
            'click #submitButton' : 'saveCategory',
            'keyup #heroTextTxt' : 'syncContent',
            'click #addDetailsButton' : 'addCategoryDetailItem',
            'click .removeDetail' : 'removeDetail',
            'keyup .categoryDetail' : 'syncDetailItems',
            'keyup #details' : 'syncDetails',
            'keyup #sizingTxt' : 'syncSizing',
            'switchChange.bootstrapSwitch #sizingRequiredChk' : 'toggleSizing'

        },

        render : function()
        {
            //var self = this;

            this.$el.empty();

            this.$el.append(this.template({model : this.model}));

            if (this.model.get('sizingHtml') && this.model.get('sizingHtml').trim() !== '') {
                this.$('#sizingInfo').removeClass('hidden');
                this.$('#sizingRequiredChk').bootstrapSwitch('state', true);
            }

            //this.$('#commonDetails').append(this.renderCategoryDetailItems(this.model.get('categoryDetailItems')));

            //this.syncDetails();


            return this;
        },

        /**
         * Currently DEPRECATED and not used
         * @param collection
         * @returns {Array}
         */
        renderCategoryDetailItems : function(collection)
        {
            var self = this;
            var $html = [];
            if (typeof collection !== 'undefined' && !$.isEmptyObject(collection) && collection.length !== 0) {
                collection.each(function(model) {
                    $html.push(self.categoryDetailsTemplate({model:model}));
                });
            }

            //Now add one empty input at the end
            $html.push(this.categoryDetailsTemplate({model : new ablefutures.cadmedical.models.categoryDetailItem}));

            return $html;
        },

        saveCategory : function(e)
        {
            e.preventDefault();

            //Pull the model together
            this.model.set('name', this.$('#categoryNameInput').val());
            this.model.set('heroText', this.$('#heroTextTxt').val());
            this.model.set('categoryDetailItems', this.getCategoryDetails());
            this.model.set('details', this.$('#details').val());

            if (this.$('#sizingRequiredChk').bootstrapSwitch('state')) {
                this.model.set('sizingHtml', this.$('#sizingTxt').val());
            } else {
                this.model.set('sizingHtml', '');
            }

            console.log('Saving Id: ' + this.model.get('productId'));



            this.model.save({}, {
                url: '../api/categoriesRouter.php?action=save',
                method: 'POST',
                success : function(result) {
                    console.log('save succeeded: '  + result);
                    window.location.href = 'landing.php';
                },
                error : function(result) {
                    console.log('failed: ' + result);
                }
            });
        },

        syncContent : function(e)
        {
            //Keep default action

            this.$('#heroTextPreview').html(this.$('#heroTextTxt').val());
        },

        getCategoryDetails : function()
        {
            var categoryDetailItems = new ablefutures.cadmedical.collections.categoryDetailItems();
            $.each($('.categoryDetail'), function(key, value) {
                var $value = $(value);
                if ($value.val().trim() !== '' ) {
                    var categoryDetailItemObj = {};
                    categoryDetailItemObj.description = $value.val();
                    if ($value.attr('data-categorydetailitemid') !== '') {
                        categoryDetailItemObj.categoryDetailItemId = $value.attr('data-categorydetailitemid');
                    }

                    categoryDetailItems.add(categoryDetailItemObj);
                }
            });
            return categoryDetailItems;
        },

        addCategoryDetailItem : function(e)
        {
            e.preventDefault();

            this.$('#commonDetails').append(this.categoryDetailsTemplate({model : new ablefutures.cadmedical.models.categoryDetailItem}));
        },

        /**
         *
         * @param {Event} e
         */
        removeDetail : function(e)
        {
            e.preventDefault();
            //Model gets built at save, so don't need to update here.
            //we do need to remove from the UI though
            this.$(e.target).parents('li').remove();
            this.syncDetails();
        },

        syncDetailItems : function()
        {
            var $html = [];
            $.each(this.$('input.categoryDetail'), function(key, value) {
               var val = $(value).val();
               if (val !== '') {
                $html.push('<li>' + $(value).val() + '</li>');
               }
            });

            this.$('#previewCommonDetails').html($html);
        },

        syncDetails : function()
        {
            this.$('#detailsPreview').html(this.$('#details').val());
        },

        /**
         *
         * @param {Event} e
         */
        toggleSizing : function(e)
        {
            if ($(e.target).bootstrapSwitch('state')) {
                // Show the sizing information textbox
                $('#sizingInfo').removeClass('hidden');

            } else {
                // Hide the textbox
                $('#sizingInfo').addClass('hidden')
            }
        },

        syncSizing : function(e)
        {
            this.$('#sizingPreview').html(this.$('#sizingTxt').val());
        }


    });

}($));