jQuery(document).ready(function( $ ) {
    var select = $('#btemp_select_template');
    select.on( 'change', function( e ) {
        var postId = select.val();
        console.log(postId);
        fetch( '/wp-json/block-templater/v1/templates/' + postId )
            .then( function( response ) { return response.json() } )
            .then( function( data ) {
                var rawContent = data[0].post_content;
                var parsedContent = wp.blocks.parse( rawContent );
                wp.data.dispatch( 'core/block-editor' ).insertBlocks( parsedContent );
                select.val('');
            } );
    } );
});