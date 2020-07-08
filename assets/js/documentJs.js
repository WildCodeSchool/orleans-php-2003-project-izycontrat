const $ = require('jquery');
$(document).ready(function ($) {
    const editor = CKEDITOR;
    editor.config.forcePasteAsPlainText = false;
    editor.config.toolbar = 'Documents';
    editor.config.height = '60vh';
    editor.config.width = '95%';
    editor.config.contentsCss = '/build/editor.css';
    editor.config.extraPlugins = 'hcard, templates';
    editor.config.allowedContent = true;
    editor.config.requiredContent = 'span[id](h-card); a(test)';
});
