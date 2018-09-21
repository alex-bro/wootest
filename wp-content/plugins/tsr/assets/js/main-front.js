jQuery(document).ready(function($){

    var processed = false;
    $('#add-product-submit').click(function(){
        if(!processed){
            processed = true;

            var count = $('#add-product-input').val();
            var iteration = $('#add-product-iteration').val();

            $('#add-product-submit').addClass('disabled');
            $('#add-product-input').addClass('disabled');

            if(count && iteration){
                send_ajax(count, iteration, 0);
            }

        }
        return false;
    });

    function send_ajax(count, iteration, i) {
        if(Number(count) <= Number(i)) {
            //console.log('end');
            processed = false;
            $('#add-product-submit').removeClass('disabled');
            $('#add-product-input').removeClass('disabled');
            return;
        }


        //console.log('start '+ i);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: abv.ajaxurl,
            data: {
                'action': 'ajax_add_products',
                'security': $('#security_va').val(),
                'data':{
                    'count':iteration
                },
            },
            success: function (data) {
                //console.log('result ' +data);
                $('#count_products').text(data);
                //console.log('i = ' + (Number(i) + Number(iteration)));
                $('#current_count_products').text((Number(i) + Number(iteration)) + ' from ' + count);

                send_ajax(count,iteration, Number(i) + Number(iteration));
            }
        });
    }

    // setInterval(function() {
    //     $.ajax({
    //         type: 'POST',
    //         dataType: 'json',
    //         url: abv.ajaxurl,
    //         data: {
    //             'action': 'ajax_get_count',
    //             'security': $('#security_va').val(),
    //         },
    //         success: function (data) {
    //             console.log(data);
    //             $('#count_products').text(data)
    //         }
    //     });
    // }, 2000);

    // run code ********************************************************************************



});