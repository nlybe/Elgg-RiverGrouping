define(function (require) {
    var elgg = require('elgg');
    var $ = require('jquery');
	
    $('.river_more_link').click(function(){
        var river_more_box = $(this).parent('div');
        var subject_guid = river_more_box.children('.item_id');
        var river_more_block = river_more_box.children('#river_more_block_'+subject_guid.html());
        var link_arrow = $(this).children('span');
        
        if ( river_more_block.css('display') == 'none' ){
            elgg.get('ajax/view/river_grouping/river_item_more', {
                data: {
                    subject_guid: subject_guid.html()
                },                                        
                success: function(data){
                    // first hide all other boxes
                    $('.river_more_block').hide(100);
                    
                    // reverse arrow
                    $('.river_more_link span').removeClass('river_btn_up');
                    $('.river_more_link span').addClass('river_btn_down')
                    
                    river_more_block.html(data);
                    river_more_block.show(200);
                    
                    // finally change the arrow
                    link_arrow.removeClass('river_btn_down');
                    link_arrow.addClass('river_btn_up');
                },
                error: function(jqXHR, textStatus, errorThrown){
                    elgg.register_error(elgg.echo('amap_maps_api:error:request'));
                },
                complete: function(){

                }
            });
        }
        else {
            $('.river_more_block').hide(200);
            
            // reverse arrow
            $('.river_more_link span').removeClass('river_btn_up');
            $('.river_more_link span').addClass('river_btn_down')
        }

        return false;
    });
});
