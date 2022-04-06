function Main() {}

Main.prototype = {

    /**
     * Apply Ajax to all links
     */
    linkActions : function() {
        $(document).on('click','a[href]:not([data-toggle]):not([data-custom])', function(e){
            var linkObj = $(this);
            var ignore = ['#', 'javascript:;', 'http:', 'https:'];
            for (var i in ignore) if (linkObj.attr('href').indexOf(ignore[i]) === 0) {

                if (linkObj.attr('target') == '_blank') {
                    window.open(linkObj.attr('href'));
                } else {
                    window.location.href = linkObj.attr('href');
                }

                return false;
            }

            var action      = linkObj.attr('href');
            var keepUrl     = linkObj.attr('keepurl') != undefined;

            e.preventDefault();
            Main.setLoadingState(true);
            Html.Get(action, function(result) {
                Main.setLoadingState(false);
                Main.processResult(result, action, keepUrl);
                return false;
            });
        });

        $(document).on('click', '.item-remove', function(e) {
            e.preventDefault();
            var obj = $('#' + $(this).data('id'));
            if (obj != null && obj != undefined) {
                obj.remove();
            }
        });

        $(document).on('click', '[data-post]', function(e) {
            e.preventDefault();
            var url     = $(this).data('post');
            var inputId = $(this).data('input');
            var input   = $('#' + inputId);
            var name  = $(this).data('name');
            var value = input.val();

            var data = {};

            data[name] = value;
            Html.Post(url, data, function(result) {
                Main.processResult(result, url, true);
                return false;
            });
        });
    },

    /**
     * Apply Ajax to all Forms
     */
    formActions : function() {

        $(document).on('submit','form[action]', function(e) {
            e.preventDefault();
            if ($(this).attr('action') == undefined) return false;

            var data   = $(this).serializeArray();
            var method = 'post';

            if ($(this).attr('method') != undefined) {
                method = $(this).attr('method').toLowerCase();
            }
            var keepUrl = $(this).attr('keepUrl') != undefined;
            var url = $(this).attr('action');
            Main.setLoadingState(true);
            if (method == 'post') {
                Html.Post(url, data, function(result) {
                    Main.processResult(result, url, keepUrl);
                    return false;
                });
            } else if (method == 'get') {
                url = url + '?' + $(this).serialize();
                Html.Get(url, function(result){
                    Main.setLoadingState(false);
                    Main.processResult(result, url, keepUrl);
                    return false;
                });
            }

        });

        $(document).on('click', '[data-submit]', function(e) {
            $('#' + $(this).data('submit')).submit();
        });

    },


    /**
     *
     * Apply quick links
     * Usable in inline action on elements
     *
     * @param action
     * @param changeUrl
     * @param event
     * @param avoidElement
     * @returns {boolean}
     */
    quickLink : function(action, changeUrl,event, avoidElement) {

        if (event != undefined && avoidElement != undefined) {
            var target = event.target;
            if ($(target).is(avoidElement)) return false;
        }

        var ignore = ['#', 'javascript:;', 'http:', 'https:'];
        for (var i in ignore) if (action.indexOf(ignore[i]) === 0) {

            if (i == 0) {
                $('html, body').animate({
                    scrollTop: $(action).offset().top
                }, 500);
                return false;
            }

            if (event.target.attr('target') == '_blank') {
                window.open(action);
            } else {
                window.location.href = linkObj.attr('href');
            }

            return false;
        }

        Main.setLoadingState(true);
        Html.Get(action, function(result){
            Main.processResult(result, action, keepUrl);
            Main.setLoadingState(false);
            return false;
        });
    },

    /**
     * Creates a bas64 loader function for an input type="file"
     *
     */
    imageActions : function() {

        $(document).on('click', '.upload-image', function(e) {
            var input = $(this);
            var image = $('#' + input.data('image'));
            var base64input = $('#' + input.data('input'));

            var inputFile  = document.createElement('input');
            inputFile.type = 'file';
            inputFile.style.display = 'none';
            inputFile.addEventListener('change', readImage, false);
            inputFile.click();

            console.log('javascript is pure shit');
            // document.getElementById(input.attr('id')).addEventListener('change', readImage, false);

            function readImage(evt){

                var f = evt.target.files[0];
                if (!f) return false;

                var r = new FileReader();

                r.onloadend = function(e) {
                    var tempImg = new Image();
                    tempImg.src = e.target.result;

                    //Resize Image

                    tempImg.onload = function() {

                        var MAX_WIDTH = 1200;
                        var MAX_HEIGHT = 1200;
                        var tempW = tempImg.width;
                        var tempH = tempImg.height;
                        if (tempW > tempH) {
                            if (tempW > MAX_WIDTH) {
                                tempH *= MAX_WIDTH / tempW;
                                tempW = MAX_WIDTH;
                            }
                            if (tempH > MAX_HEIGHT) {
                                tempW *= MAX_HEIGHT / tempH;
                                tempH = MAX_HEIGHT;
                            }
                        } else {
                            if (tempH > MAX_HEIGHT) {
                                tempW *= MAX_HEIGHT / tempH;
                                tempH = MAX_HEIGHT;
                            }
                            if (tempW > MAX_WIDTH) {
                                tempH *= MAX_WIDTH / tempW;
                                tempW = MAX_WIDTH;
                            }
                        }
                        var canvas = document.createElement('canvas');
                        canvas.width = tempW;
                        canvas.height = tempH;
                        var ctx = canvas.getContext("2d");
                        ctx.drawImage(this, 0, 0, tempW, tempH);
                        var dataURL = canvas.toDataURL("image/png");

                        image.attr('src', dataURL);
                        console.log(image.attr('src'));
                        base64input.val(dataURL);

                        $(inputFile).remove();
                    }
                }

                r.readAsDataURL(f);

            }

        });
    },

    /**
     *
     * @param result
     * @param action
     * @param keepUrl
     * @returns {boolean}
     */
    processResult : function(result, action, keepUrl) {

        Main.setLoadingState(false);
        var backdrop = $('.modal-backdrop');

        if (result.dismiss_alert) {
            if ($('.modal-dialog') != undefined && $('[data-dismiss="modal"]') != undefined) {
                $('[data-dismiss="modal"]').trigger('click');
            }
        }

        if (backdrop.html() != undefined) backdrop.remove();

        if (result.command != undefined) {
            Main.processCommand(result);
            return false;
        }

        if (result.title != undefined) {
            var pageTitle = $('#page-title');
            if (pageTitle != undefined) pageTitle.text(result.title);
        }

        if (result.container != undefined && result.content != undefined) {
            var container = $('#' + result.container);
            if (container != undefined){

                if (result.append) {
                    container.append(result.content);
                } else {
                    container.html(result.content);
                }
            }

            if (result.toolbars != undefined) {
                var toolbar = $('#header-new');

                if (toolbar.html() != undefined) {
                    toolbar.replaceWith(result.toolbars);
                } else {
                    $('body').append(result.toolbars);
                }
            }
        }

        if (!keepUrl && action != null && action != undefined)
            window.history.pushState(undefined, '', action);
        return false;
    },

    /**
     *
     * @param   result
     * @returns {boolean}
     */
    processCommand : function (result) {

        Main.setLoadingState(false);
        if (result.command == undefined) return false;

        switch (result.command) {
            case 'redirect':
                var url = result.path ? result.path : result.url;
                window.location.href = url;
                break;
            case 'route':
                var action = result.path ? result.path : result.url;
                Html.Get(action, function(result){
                    Main.setLoadingState(false);
                    Main.processResult(result, action, false);
                    return false;
                });
                break;
            case 'display_message':

                var modal = $('.modal-dialog');

                if (modal != undefined) {
                     $('.modal-dialog').remove();
                     $('.modal').remove();
                }

                var dialog = bootbox.dialog({
                    title: result.title,
                    message: result.content,
                    show: false
                });

                dialog.on('shown.bs.modal',function(){
                    
                });

                dialog.modal("show");
                
                break;
        }

        return false;
    },

    /**
     *
     * @param state
     */
    setLoadingState : function (state) {

        if (state) {
            $('#loading').show();
        } else {
            $('#loading').hide();
        }
    },

    /**
     *
     */
    tabActions : function() {


        $(document).on('click','.tab-control > a', function(e) {

            var linkObj = $(this);

            if (linkObj.attr('href').indexOf('#') !== 0) {
                return false;
            }

            e.preventDefault();

            $('.tab-control').find('a').removeClass('active');
            linkObj.addClass('active');

            var tabs = $('.tabs');

            tabs.find('.tab').removeClass('tab-active');
            tabs.find('.tab' + linkObj.attr('href')).addClass('tab-active');

            return false;
        });
    },

    /**
     *
     */
    changeActions : function() {

        $(document).on('change', '[data-change="submit"]', function(e) {

           $(this).closest('form').submit();

        });

        $(document).on('change', '[data-change="toggle"]', function(e) {

            var input = $(this);
            var block = $('#' + input.data('toggle'));

            console.log([
                block.data('value'), 
                input.val()]
            );

            if (block.data('value').indexOf(',') != -1) {
                var valList = block.data('value').split(',');
                if ($.inArray(input.val(), valList) != -1) {
                    block.show();
                } else {
                    block.hide();
                }
            } else {
                if (block.data('value') == input.val()) {
                    block.show();
                } else {
                    block.hide();
                }
            }

        });
    },

    triggerForm: function(formId) {

        $('#' + formId).submit();
    },

    /**
     * Element interactions
     *
     * Useful for loading widgets or handling
     * data of the elements
     *
     */
    interactions : function() {

        var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );

        if (!iOS)
            window.onpopstate = function(e) {
                Main.setLoadingState(true);
                Html.Get(e.target.window.location.href, function(result) {
                    Main.setLoadingState(false);
                    Main.processResult(result, null, false);
                    return false;
                });
            }
    }

}

/**
 * Main Instance
 *
 * @type {Main}
 */
var Main = new Main();

/**
 * Initialize Methods
 */
Main.linkActions();
Main.formActions();
Main.tabActions();
Main.changeActions();
Main.imageActions();
Main.interactions();