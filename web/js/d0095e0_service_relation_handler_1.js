/**
 * Created by olivier on 18/02/15.
 */
var collectionHolder = $('ul.service_relations');
var buttonHolder = $('div.btn_place');
var $addServiceRelationLink = $('<a href="#" class="pull-right add_service_relation_link">Ajouter un service</a>');

var $newLinkLi = $('<li></li>');
buttonHolder.append($addServiceRelationLink);

jQuery(document).ready(function () {
    // ajoute l'ancre « ajouter un service » et li à la balise ul
    collectionHolder.append($newLinkLi);

    $addServiceRelationLink.on('click', function (e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire qrsr
        addServiceRelationForm(collectionHolder, $newLinkLi);
    });
});

function addServiceRelationForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}