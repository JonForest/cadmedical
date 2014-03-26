(function($) {

    'use strict'

ablefutures.cadmedical.views.productEdit = Backbone.View.extend({

    template : _.template($('#productedit_template').html()),
    categoryTemplate: _.template($('#categorylist_template').html()),
    imageLoadedTemplate : _.template($('#imageLoaded_template').html()),
    productDetailItemTemplate : _.template($('#productdetail_template').html()),
    priceTemplate  : _.template($('#prices_template').html()),
    thumbnail : {},
    categories: {},

    initialize : function(options)
    {
        this.categories = options.categories;
    },

    events : {
        'click #submitButton' : 'saveProduct',
        'click #addDetailsButton' : 'addProductDetailItem',
        'click #uploadImageButton' : 'launchFileBrowser',
        'change #file_upload' : 'ajaxUpload',
        'click #removeImageLink' : 'removeImage',
        'click .removePrice' : 'removePrice',
        'click .removeDetail' : 'removeDetail',
        'click #addPricesButton' : 'addPrices',
        'change .priceOnRequestChk' : 'togglePrice'
    },

    render : function()
    {
        var self = this;

        this.$el.empty();

        this.$el.append(this.template({model : this.model}));

        var $catHtml = [];
        //categories variable is declared globally
       this.categories.each(function(category){
            var categoryOptions = new ablefutures.cadmedical.views.categoryOptions({model: category});
            $catHtml.push(categoryOptions.render().$el);
        });

        this.$('#categorySelect').append($catHtml);
        this.$('#categorySelect').find('option[value=' + this.model.get('categoryId') + ']')
            .prop('selected', true);

        this.$('#prices').append(this.renderPrices(this.model.get('prices')));
        this.$('#detailsGroup').append(this.renderProductDetailItems(this.model.get('productDetailItems')));
        this.$('#thumbnailsDiv').append(this.renderImages(this.model.get('images')));
        return this;
    },

    renderPrices :  function(collection)
    {
        var self = this;
        var $html = [];

        if (typeof collection !== 'undefined' && !$.isEmptyObject(collection) && collection.length !== 0) {
            collection.each(function(model) {
                var $price = $(self.priceTemplate({model:model}));

                if (model.get('priceOnRequest')) {
                    $price.find('.priceOnRequestChk').prop('checked', true);
                    $price.find('.productPrice').prop('disabled', true);
                    $price.find('.priceFrom').prop('disabled', true);
                } else {
                    if (model.get('priceFrom')) {
                        $price.find('.priceFrom').prop('checked', true);
                    }
                }

                $html.push($price);

            });
        } else {
            //Add one empty input at the end
            $html.push(this.priceTemplate({model : new ablefutures.cadmedical.models.price}));
        }

        return $html;
    },

    renderProductDetailItems : function(collection)
    {
        var self = this;
        var $html = [];
        if (typeof collection !== 'undefined' && !$.isEmptyObject(collection) && collection.length !== 0) {
            collection.each(function(model) {
                $html.push(self.productDetailItemTemplate({model:model}));
            });
        }

        //Now add one empty input at the end
        $html.push(this.productDetailItemTemplate({model : new ablefutures.cadmedical.models.productDetailItem}));

        return $html;
    },

    renderImages : function(images)
    {
        var self = this;
        var $html = [];
        if (typeof images !== 'undefined' && !$.isEmptyObject(images) && images.length !== 0) {
            images.each(function(image) {
                $html.push(self.imageLoadedTemplate({model : image}));
            });

            this.$('#thumbnailsDiv').html($html);
        }
    },

    addProductDetailItem : function(e)
    {
        e.preventDefault();

        this.$('#detailsGroup').append(this.productDetailItemTemplate({model : new ablefutures.cadmedical.models.productDetailItem}));
    },

    addPrices : function(e)
    {
        e.preventDefault();
        this.$('#prices').append(this.priceTemplate({model : new ablefutures.cadmedical.models.price}));

    },

    saveProduct : function(e)
    {
        e.preventDefault();

        //validate
        var self = this;

        //Collect into model
        this.model.set('name', this.$('#productNameInput').val());
        this.model.set('price', this.$('#productPriceInput').val());
        this.model.set('categoryId', this.$('#categorySelect').val());

        if (this.model.get('images') !== undefined) {
            //At the moment only one image, so all we worry about
            var image = this.model.get('images').at(0);

            if (image) {
                image.set({
                    imageTitle: this.$('#titleInput').val(),
                    caption : this.$('#captionTxt').val()
                });
                this.model.get('images').set(image);
            }
        }

        var productDetailItems = new ablefutures.cadmedical.collections.productDetailItems();
        $.each($('.productDetail'), function(key, value) {
            var $value = $(value);
            if ($value.val().trim() !== '' ) {
                var productDetailItemObj = {};
                productDetailItemObj.description = $value.val();
                if ($value.attr('data-productdetailitemid') !== '') {
                    productDetailItemObj.productDetailItemId = $value.attr('data-productdetailitemid');
                }

                productDetailItems.add(productDetailItemObj);
            }
        });
        this.model.set('productDetailItems', productDetailItems);


        var prices = new ablefutures.cadmedical.collections.prices();
        $.each($('.price'), function(key, value) {
            var $value = $(value);
            var price = new ablefutures.cadmedical.models.price();
            if ($value.find('.priceOnRequestChk').is(':checked')) {
                price.set('price',null);
                price.set('priceFrom',null)
                price.set('priceOnRequest', $value.find('.priceOnRequestChk').is(':checked'));
            } else {
                price.set('price',$value.find('.productPrice').val());
                price.set('priceFrom',$value.find('.priceFrom').is(':checked'))
                price.set('priceOnRequest', $value.find('.priceOnRequestChk').is(':checked'));
            }
            price.set('priceDiscriminator', $value.find('.priceDiscriminator').val());
            if (!( (price.get('price')===0 || price.get('price') === '')  &&
                price.get('priceOnRequest') === false )) {
                prices.add(price);
            }
        });
        this.model.set('prices', prices);

        console.log('Saving Id: ' + this.model.get('productId'));

        this.model.save({}, {
            url: '../api/productRouter.php',
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
    },

    removeImage : function(e)
    {
        var self = this;
        e.preventDefault();
        this.model.get('images').at(0).destroy({
            url: '../api/imageRouter.php?a=delete',
            data: this.model.get('images').at(0).get('imageId'),
            method: 'POST',
            success : function(result) {
                console.log('delete image success');
                self.model.unset('images')
            }
        });

        this.render();

    },

    removePrice : function(e)
    {
        //Remove from the UI
        this.$(e.target).parents('.price').remove();

        //Don't worry about removing from the model, as it will get refreshed when saving
    },

    launchFileBrowser : function(e)
    {
        e.preventDefault();

        var self=this;

        $('#file_upload').click();

    },

    ajaxUpload : function(e)
    {
        var self = this;

        var file = document.getElementById(e.target.id).files[0];
        var name = file.name;
        var size = file.size;
        var type = file.type;

        if(file.name.length < 1) {

        }
        else if(file.size > 10000000) { //10MB
            alert("File is to big");
        }
        else if(file.type != 'image/png' && file.type != 'image/jpg' && !file.type != 'image/gif' && file.type != 'image/jpeg' ) {
            alert("File doesnt match png, jpg or gif");
        }
        else {
            var formData = new FormData(document.getElementById('imageForm'));
            $.ajax({
                url: '../api/imageRouter.php?action=upload',  //server script to process data
                type: 'POST',
                xhr: function() {  // custom xhr
                    var myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload){ // if upload property exists
                        myXhr.upload.addEventListener('progress', self.progressHandlingFunction, false); // progressbar
                    }
                    return myXhr;
                },
                //Ajax events
                success: function(data) {

                    var mediaModel = new ablefutures.cadmedical.models.image(data);
                    var images = self.model.get('images');
                    if (images === undefined) {
                        images = new ablefutures.cadmedical.collections.images();
                    }
                    debugger;
                    images.add(mediaModel);
                    self.model.set({images : images});
                    self.renderImages(self.model.get('images'));

                },
                /*
                 *
                 */
                error: function(d) {
                    alert("File failed to upload");
                },
                // Form data
                data: formData,
                //Options to tell JQuery not to process data or worry about content-type
                cache: false,
                contentType: false,
                processData: false
            }, 'json');
        }
    },

    togglePrice : function(e)
    {
        if ($(e.target).is(':checked')) {
            $(e.target).closest('.row').find('.productPrice').prop('disabled', true)
                .val('');
            $(e.target).closest('.row').find('.priceFrom').prop('disabled', true)
                .prop('checked', false);
        } else {
            $(e.target).closest('.row').find('.productPrice').prop('disabled', false);
            $(e.target).closest('.row').find('.priceFrom').prop('disabled', false);
        }

    },

    progressHandlingFunction : function(w)
    {
        console.log(w);
    }

});

}($));