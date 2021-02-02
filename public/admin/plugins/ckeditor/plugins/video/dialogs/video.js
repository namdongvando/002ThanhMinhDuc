/**
 * @file
 * Written by Henri MEDOT <henri.medot[AT]absyx[DOT]fr>
 * http://www.absyx.fr
 */

(function(undefined) {
    'use strict';
    var trim = CKEDITOR.tools.trim;
    var unbind = function(video$) {
        video$.onloadedmetadata = video$.onerror = null;
    };
    var cache = {};
    var getMetadata = function(dialog, readyCallback) {
        var video$ = dialog.video.$;
        unbind(video$);
        var url = trim(dialog.getValueOf('info', 'src'));
        if (!url.length) {
            return false;
        }

        if (cache[url] !== undefined) {
            return cache[url];
        }
        video$.onloadedmetadata = video$.onerror = function() {
            unbind(video$);
            var w = video$.videoWidth;
            var h = video$.videoHeight;
            cache[url] = w && h ? {width: w, height: h} : false;
            readyCallback();
        };
        video$.src = url;
        video$.width = video$.width;
        video$.height = video$.height;
    };
    var clearPreview = function(dialog) {
        var video = dialog.video.setStyle('display', 'none');
        var video$ = video.$;
        unbind(video$);
        video$.src = '';
    };
    var updatePreview = function(dialog) {

        var metadata = getMetadata(dialog, function() {
            updatePreview(dialog);
        });
        var video = dialog.video;
        if (metadata) {
            try {
//                dialog.setValueOf('info', 'video-height', metadata.height);
//                dialog.setValueOf('info', 'video-width', metadata.width);
//                updateWidthHeight(dialog);
                dialog.commitContent(video);
            } catch (e) {
                console.log(e.message);
            }
            var ratio = (100 * metadata.height / metadata.width).toFixed(5) + '%';
            video.setStyle('display', 'block').getParent().getParent().setStyle('padding-top', ratio);
        } else {
            video.setStyle('display', 'none');
        }
    };
    var updateWidthHeight = function(dialog) {

        try {
            var video = dialog.getSelectedElement().$;
            dialog.getContentElement('info', 'video-height').setValue(video.height);
            dialog.getContentElement('info', 'video-width').setValue(video.width);
        } catch (e) {
            console.log(e.message);
        }

//        dialog.setValueOf('info', 'video-height', video.height);
//        dialog.setValueOf('info', 'video-width', video.width);
    }


    CKEDITOR.dialog.add('video', function(editor) {
        return {
            title: editor.lang.video.title,
            minWidth: 400,
            minHeight: 300,
            contents: [

                {
                    id: 'info',
                    label: editor.lang.common.generalTab,
                    elements: [
                        {
                            id: 'src',
                            type: 'text',
                            label: editor.lang.video.url,
                            required: true,
                            onChange: function() {
                                updatePreview(this.getDialog());
                            },
                            validate: CKEDITOR.dialog.validate.notEmpty(editor.lang.video.emptySrc),
                            setup: function(element) {
                                this.setValue(element && element.getAttribute('src') || '');
                            },
                            commit: function(element) {
                                element.setAttribute('src', trim(this.getValue()));
                            }
                        }, {
                            id: 'browse',
                            type: 'button',
                            label: '&nbsp; ',
                            filebrowser: 'info:src',
                            hidden: true,
                            label: editor.lang.common.browseServer
                        },

                        {
                            type: 'hbox',
                            widths: ['50%', '50%'],
                            children: [
                                {
                                    id: 'video-width',
                                    type: 'text',
                                    setup: function(element) {
                                        this.setValue(element && element.getAttribute('width') || '');
                                    },
                                    'default': editor.getSelection().getSelectedText().toString(),
                                    label: editor.lang.common.width
                                },
                                {
                                    id: 'video-height',
                                    type: 'text',
                                    setup: function(element) {
                                        this.setValue(element && element.getAttribute('height') || '');
                                    },
                                    'default': editor.getSelection().getSelectedText().toString(),
                                    label: editor.lang.common.height
                                },
                            ]
                        },
                        {
                            type: 'hbox',
                            widths: ['50%', '50%'],
                            children: [

                                {
                                    id: 'controls',
                                    type: 'checkbox',
                                    label: editor.lang.video.controls,
                                    'default': true,
                                    onChange: function() {
                                        var dialog = this.getDialog();
                                        if (!this.getValue()) {
                                            dialog.getContentElement('info', 'muted_looping_autoplay').setValue(true, true);
                                        }
                                        updatePreview(dialog);
                                    },
                                    setup: function(element) {
                                        this.setValue(!!(element && element.hasAttribute('controls')));
                                    },
                                    commit: function(element) {
                                        if (this.getValue()) {
                                            element.setAttribute('controls', 'controls');
                                        } else {
                                            element.removeAttribute('controls');
                                        }
                                    }
                                }, {
                                    id: 'muted_looping_autoplay',
                                    type: 'checkbox',
                                    label: editor.lang.video.mutedLoopingAutoplay,
                                    onChange: function() {
                                        var dialog = this.getDialog();
                                        if (!this.getValue()) {
                                            dialog.getContentElement('info', 'controls').setValue(true, true);
                                        }
                                        updatePreview(dialog);
                                    },
                                    setup: function(element) {
                                        this.setValue(!!(element && element.hasAttribute('autoplay')));
                                    },
                                    commit: function(element) {
                                        if (this.getValue()) {
                                            element.setAttributes({autoplay: 'autoplay', loop: 'loop', muted: 'muted'});
                                        } else {
                                            element.removeAttributes(['autoplay', 'loop', 'muted']);
                                        }
                                    }
                                }
                            ]
                        },
                        {
                            id: 'authcustome',
                            type: 'html',
                            html: '<div>edit by: <a href="mailTo:namdong92@gmail.com" >namdong92@gmail.com</a></div>'
                        }, {
                            id: 'preview',
                            type: 'html',
                            html: '<label>' + editor.lang.video.preview + '</label><div class="cke_dialog_ui_labeled_content" style="display:none;position:relative;background-color:#f8f8f8;border:1px solid #d1d1d1;"><div style="height:0;padding-top:56.25%"><div style="position:absolute;bottom:0;left:0;right:0;top:0;"><video preload="metadata" style="width:100%;height:100%;display:none;"></video></div></div></div>'
                        }
                    ]
                }],
            onLoad: function() {

                console.log("Load");
                this.video = this.getContentElement('info', 'preview').getElement().getNext().getFirst().getFirst().getFirst();
                this.video.$.addEventListener('loadedmetadata', function(e) {
                    var video$ = e.target;
                    video$.muted = video$.hasAttribute('muted');
                }, false);
                this.height = this.getContentElement('info', 'video-height');
                console.log(this.height);
//                this.width = this.getContentElement('info', 'video-width');
                var self = this;
                console.log(this.video);
                console.log("endLoad");
            },
            onShow: function() {
                console.log("Show");
//                console.log(this.video.$);
//                this.setValueOf('info', 'video-width', this.video.$.video-width);
//                this.setValueOf('info', 'video-height', this.video.$.video-height);
                var element = this.getSelectedElement();
                if (element && element.data('cke-real-element-type') == 'video') {
                    var realElement = editor.restoreRealElement(element);
                    this.setupContent(realElement);
                    updatePreview(this);
                }
            },
            onOk: function() {
                console.log("Ok");
                var dialog = this;
                var metadata = getMetadata(dialog, function() {
                    dialog.definition.onOk.apply(dialog);
                });
                if (metadata) {
                    var realElement = CKEDITOR.dom.element.createFromHtml('<cke:video></cke:video>', editor.document);
                    realElement.setAttributes({
                        preload: 'metadata',
                        width: dialog.getContentElement('info', 'video-width').getValue(),
                        height: dialog.getContentElement('info', 'video-height').getValue()
                    });

                    metadata["width"] = dialog.getContentElement('info', 'video-width').getValue();
                    metadata["height"] = dialog.getContentElement('info', 'video-height').getValue();

                    dialog.commitContent(realElement);
                    var element = editor.createFakeElement(realElement, 'cke-video', 'video', false);
                    element.$.src = CKEDITOR.tools.createImageData(metadata);
                    editor.insertElement(element);
                    dialog.hide();
                    return;
                }
                if (metadata === false) {
                    alert(editor.lang.video.invalidSrc);
                }
                return false;
            },
            onHide: function() {
                console.log("hide");
                clearPreview(this);
            }
        };
    });
})();
