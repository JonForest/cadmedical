(function($) {

    'use strict';

    ablefutures.cadmedical.views.pageEdit = Backbone.View.extend({

        template : _.template($('#contentEdit_template').html()),

        events : {
            'click #submitButton' : 'savePage',
            'change #pageName' : 'syncPageName',
            'change #reference' : 'syncReference',
            'change #heroText' : 'syncHeroText'
        },

        render : function()
        {
            this.$el.html(this.template({model : this.model}));
            this.syncPageName();
            this.syncReference();
            return this;
        },

        syncPageName : function()
        {
            this.$('#pageNamePreview').html(this.$('#pageName').val());
        },

        syncReference :  function()
        {
            this.$('#referencePreview').html(this.$('#reference').val());
        },

        syncHeroText : function() {
            this.$('#heroTextPreview').html(this.$('#heroText').val());
        },

        savePage : function(e)
        {
            e.preventDefault();

            //Pull the model together
            this.model.set('title', this.$('#pageName').val());
            this.model.set('reference', this.$('#reference').val());
            this.model.set('html', editor.getSession().getValue());
            this.model.set('heroText', this.$('#heroText').val());

            console.log('Saving Id: ' + this.model.get('pageId'));



            this.model.save({}, {
                url: '../api/pageRouter.php?action=save',
                method: 'POST',
                success : function(result) {
                    console.log('save succeeded: '  + result);
                    window.location.href = 'landing.php?a=content';
                },
                error : function(result) {
                    console.log('failed: ' + result);
                }
            });
        }
    })
}($));