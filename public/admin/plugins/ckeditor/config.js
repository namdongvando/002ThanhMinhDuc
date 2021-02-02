/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
    config.skin = "office2013";
    config.filebrowserBrowseUrl = '/public/ckfinder/ckfinder.html?type=Files';
    config.filebrowserImageBrowseUrl = '/public/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = '/public/ckfinder/ckfinder.html';
    config.filebrowserUploadUrl = '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload';
    config.filebrowserImageUploadUrl = '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload';
//    config.filebrowserImageUploadUrl = '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
    config.height = "450px";
    config.extraPlugins = 'video';

//
    config.toolbarGroups = [
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
        {name: 'forms', groups: ['forms']},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
        {name: 'links', groups: ['links']},
        {name: 'insert', groups: ['insert']},
        '/',
        {name: 'styles', groups: ['styles']},
        {name: 'colors', groups: ['colors']},
        {name: 'tools', groups: ['tools']},
        {name: 'others', groups: ['others']},
    ];
//    config.toolbarGroups = [
//        {name: 'document', groups: ['mode', 'document', 'doctools']},
//        {name: 'clipboard', groups: ['clipboard', 'undo']},
//        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
//        {name: 'forms', groups: ['forms']},
//        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
//        {name: 'links', groups: ['links']},
//        {name: 'insert', groups: ['Image', 'Table', 'HorizontalRule', 'PageBreak']},
//        {name: 'tools', groups: ['tools']},
//        {name: 'colors', groups: ['colors']},
//        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
//        {name: 'styles', groups: ['styles']},
//        {name: 'others', groups: ['others']},
//        {name: 'about', groups: ['about']}
//    ];
    config.removeButtons = 'About';

};
