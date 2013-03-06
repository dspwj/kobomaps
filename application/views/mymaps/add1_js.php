<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* add4_js.php - View
* Written by Etherton Technologies Ltd. 2012
* Started on 12/06/2011
*************************************************************/
?>
	
<script type="text/javascript" src="<?php echo URL::base(); ?>media/js/jscolor/jscolor.js"> </script>


<script type="text/javascript">


function toggle_id(elem_id)
{
	$('#'+elem_id).toggle('slow');
	
}

function toggle_class(elem_class)
{
	$('.'+elem_class).toggle('slow');
	if($("#gradient").prop('checked')){
		$(".gradient_explain").show('slow');
	}
	else {
		$(".gradient_explain").hide();}

}


function set_default_map_style(elem_id)
{
	$('#'+elem_id).val("<?php echo Model_Map::get_style_default_js(); ?>");
	
}

function openGradient(){
	$(".gradient_explain").toggle('slow');
}


$(document).ready(function(){
	$("#slug").change(function(){
		$("#slug").css('border-color', '');
		$.post("<?php echo URL::base(); ?>mymaps/checkslug", { "slug": $("#slug").val(), 'id': <?php echo $map_id ?> }).done(
				function(response) {
					response = JSON.parse(response);

					if(response.status == 'valid'){
						$("#slug").css('border-color', 'green');
						$("#slug").val(response.slug);
					}
					else if(response.status == 'illegal'){
						$("#slug").css('border-color', 'red');
						alert('<?php echo __('Your slug had illegal characters, they have been replaced.')?>');
						$("#slug").val(response.slug);
					}
					else if(response.status == 'notUnique'){
						$("#slug").css('border-color', 'red');
						alert('<?php echo __('You slug has already been used. Please choose another.')?>');
					}
				});
	});
});	
	


</script>