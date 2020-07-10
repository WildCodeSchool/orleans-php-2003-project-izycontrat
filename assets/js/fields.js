const $ = require('jquery');

function toCamelCase(str) {
    return str.split('_').map((word, index) => {
        // If it is the first word make sure to lowercase all the chars.
        if (index === 0) {
            return word.toLowerCase();
        }
        // If it is not the first word only upper case the first char and lowercase the rest.
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    }).join('');
}
const $fieldEntity = $('#field_entity');
$fieldEntity.change(function fonction() {
    const $form = $(this).closest('entities');
    const data = {};
    data[$fieldEntity.attr('name')] = $fieldEntity.val();
    $.ajax({
        url: '/getFields',
        type: 'POST',
        dataType: 'JSON',
        data: {
            entity: $fieldEntity.val(),
        },
        success(html) {
            // eslint-disable-next-line guard-for-in
            $('#field_fieldName')
                .find('option')
                .remove()
                .end();
            // eslint-disable-next-line guard-for-in,no-restricted-syntax
            for (const value in html) {
                const o = new Option(toCamelCase(value), toCamelCase(value));
                $(o).html(toCamelCase(value));
                $('#field_fieldName')
                    .append(o);
            }
        },
    });
});
