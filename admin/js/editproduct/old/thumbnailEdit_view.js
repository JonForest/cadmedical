(function($) {

    'use strict'

    ablefutures.cadmedical.views.thumbnailEdit = Backbone.View.extend({
        template: _.template($('#completeActivity_thumbnail').html()),

        events : {
            'click .addCaption' : 'addCaption',
            'click #cancelCaptionBtn' : 'cancelCaption',
            'click #saveCaptionBtn' : 'saveCaption'


        },

        render : function()
        {
            this.$el.append(this.template({model : this.model}));

            return this;
        },

        addCaption : function(e)
        {
            e.preventDefault(); //stop the hash

            this.$('.captionArea').removeClass('hidden');
            this.$('.addCaption').addClass('hidden');
        },

        cancelCaption : function(e)
        {
            e.preventDefault(); //stop the hash
            this.$('#captionTxt').val('');
            this.$('#titleInput').val('');

            this.$('.captionArea').addClass('hidden');
            this.$('.addCaption').removeClass('hidden');

        },

        saveCaption : function(e)
        {
            //Can be called from external source without the event argument
            if (e) {
                e.preventDefault(); //stop the hash
            }

            debugger;
            this.model.set({
                imageTitle: this.$('#titleInput').val(),
                caption : this.$('#captionTxt').val()
            });

            this.model.save({}, {
                url: '../api/imageRouter.php?a=caption',
                method: 'POST',
                success : function(result) {
                    console.log('Image save succeeded: '  + result);
                    window.location.href = 'landing.php';
                },
                error : function(result) {
                    console.log('failed: ' + result);
                }
            });
        }

    });

}($));