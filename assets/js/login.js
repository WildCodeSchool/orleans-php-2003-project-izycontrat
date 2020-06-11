const $ = require('jquery');

$(document).ready(() => {
    const $modal = document.querySelector('[aria-modal]').getAttribute('aria-modal');
    if ($modal === 'true') {
        $('#modal').modal();
    }
});
