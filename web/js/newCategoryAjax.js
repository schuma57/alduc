/**
 * Created by schuma on 10/08/15.
 */

function sendForm(form, callback) {
    // Get all form values
    var values = {};
    $.each( form[0].elements, function(i, field) {
        if (field.type != 'checkbox' || (field.type == 'checkbox' && field.checked)) {
            values[field.name] = field.value;
        }
    });

    $.ajax({
        type        : form.attr( 'method' ),
        url         : form.attr( 'action' ),
        data        : values,
        success     : function(result) { callback( result ); }
    });
}

$(function() {
    $('select[id$=_category]')
        .append($('<option>', {value : 'new', text: 'Ajouter nouvelle catégorie'}))
        .on('change', function () {
            if ($( "select[id$=_category] option:selected").val() === 'new') {
                $('#new_category').modal('show');
            }
        });

    $('#save_category').on('click', function( e ){
        e.preventDefault();
        sendForm( $('#new_category').find('form'), function( response ){
            if (typeof response == "object") {
                $('select[id$=_category]')
                    .prepend($('<option>', {value : response.id, text: response.name}))
                    .val(response.id);
                $('#new_category').modal('hide');
            }
            else {
                $('#new_category').find('.modal-body').html(response);
            }
        });
    });
});