/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

(function() {
    'use strict';

    var stylesLoaded = false,
            WIDGET_NAME = 'imagesContent',
            SUPPORTED_IMAGE_TYPES = ['jpeg', 'png', 'gif', 'bmp'];
    function capitalize(str) {
        return CKEDITOR.tools.capitalize(str, true);
    }


    function readAndPreview(file) {

        // Make sure `file.name` matches our extensions criteria
//        file = new File().createFromFileName(file);
        console.log(file.name);
        return;

        if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
            var reader = new FileReader();
            reader.addEventListener("load", function() {
                var image = new Image();
                image.height = 100;
                image.title = file.name;
                image.src = this.result;
                preview.appendChild(image);
            }, false);
            reader.readAsDataURL(file);
        }

    }

    function addPasteListener(editor) {
        var imgWithDataUri = new RegExp('<img[^>]*\\ssrc=[\\\'\\"]?data:image/(' + SUPPORTED_IMAGE_TYPES.join('|') + ');base64,', 'i');
        // Easy Image requires an img-specific paste listener for inlined images. This case happens in:
        // * IE11 when pasting images from the clipboard.
        // * FF when pasting a single image **file** from the clipboard.
        // In both cases image gets inlined as img[src="data:"] element.
        editor.on('paste', function(evt) {

            if (editor.isReadOnly) {
                return;
            }
            // For performance reason do not parse data if it does not contain img tag and data attribute.

            var data = evt.data,
                    // Prevent XSS attacks.
                    tempDoc = document.implementation.createHTMLDocument(''),
                    temp = new CKEDITOR.dom.element(tempDoc.body),
                    widgetsFound = 0,
                    widgetElement,
                    imgFormat,
                    imgs,
                    img,
                    i;

            // Without this isReadOnly will not works properly.
            temp.data('cke-editable', 1);

            temp.appendHtml(data.dataValue);

            imgs = temp.find('img');

            for (i = 0; i < imgs.count(); i++) {
                img = imgs.getItem(i);

                // Assign src once, as it might be a big string, so there's no point in duplicating it all over the place.
                var imgSrc = img.getAttribute('src'),
                        // Image have to contain src=data:...
                        isDataInSrc = imgSrc && imgSrc.substring(0, 5) == 'data:',
                        isDataInLocal = imgSrc && imgSrc.substring(0, 5) == 'file:';

                if (isDataInLocal) {
                    readAndPreview(imgSrc);
                }


            }

            data.dataValue = temp.getHtml();
        });
    }

    CKEDITOR.plugins.add('imagesContent', {
        lang: 'en',
        hidpi: true, // %REMOVE_LINE_CORE%
        init: function(editor) {

        },
        afterInit: function(editor) {
            addPasteListener(editor);
        }
    });

}());
