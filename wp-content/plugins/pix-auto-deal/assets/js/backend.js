jQuery(document).ready(function($) {
	
	$('.form-wrap h3').append(' or <a onclick="myFunction()" href="?taxonomy=auto-model&post_type=pixad-autos&import_autos">Import 1100+ Auto Models</a>');
	$('.form-wrap h3').append(' or <a onclick="myFunction2()" href="?taxonomy=auto-model&post_type=pixad-autos&remove_autos">Remove All Auto Models</a>');

	$('#clear_gallery').click(function() {
        $('#pixad_auto_gallery_ids').val('-1');
        $('#gallery-1').html('');
    });

	$('#manage_gallery').click(function() {
        // Create the shortcode from the current ids in the hidden field
        var gallerysc = '[gallery ids="' + $('#pixad_auto_gallery_ids').val() + '"]';
        // Open the gallery with the shortcode and bind to the update event
        wp.media.gallery.edit(gallerysc).on('update', function(g) {
            // We fill the array with all ids from the images in the gallery
            var id_array = [];
            $.each(g.models, function(id, img) { id_array.push(img.id); });
            // Make comma separated list from array and set the hidden value
            $('#pixad_auto_gallery_ids').val(id_array.join(","));
            // On the next post this field will be send to the save hook in WP
        });
    });

	
});

function myFunction() {
	confirm("We are going to import about 1100+ auto models! This could take about  5min so be patient & wait until page refresh by itself!");
}
function myFunction2() {
	confirm("Removing all categoris can take up to 5min, so be patient!");
}