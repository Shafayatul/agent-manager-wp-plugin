jQuery(document).ready(function() {

  jQuery('#order_type').on('change', function(){
    var order_type = jQuery('#order_type').val();

    if (order_type == 'visa') {
      jQuery('.visa_order_form').show(500);
      jQuery('.tourism_trip').hide(500);
      jQuery('.train_ticket_order_form').hide(500);
      jQuery('.other_order_form').hide(500);
    }else {
      jQuery('.visa_order_form').hide(500);
    }

    if (order_type == 'tourism_trip') {
      jQuery('.tourism_trip').show(500);
      jQuery('.visa_order_form').hide(500);
      jQuery('.train_ticket_order_form').hide(500);
      jQuery('.other_order_form').hide(500);
    }else {
      jQuery('.tourism_trip').hide(500);
    }

    if (order_type == 'train_ticket') {
      jQuery('.train_ticket_order_form').show(500);
      jQuery('.visa_order_form').hide(500);
      jQuery('.tourism_trip').hide(500);
      jQuery('.other_order_form').hide(500);
    }else {
      jQuery('.train_ticket_order_form').hide(500);
    }

    if (order_type == 'others') {
      jQuery('.other_order_form').show(500);
      jQuery('.train_ticket_order_form').hide(500);
      jQuery('.visa_order_form').hide(500);
      jQuery('.tourism_trip').hide(500);
    }else {
      jQuery('.other_order_form').hide(500);
    }

  });

  jQuery('.add_more').click(function(e){
        e.preventDefault();
        jQuery(this).before("<input name='file[]' type='file' style='width: 300px !important;'/>");
  });
});
