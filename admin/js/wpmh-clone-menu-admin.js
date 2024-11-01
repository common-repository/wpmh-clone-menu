(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */	

	$('#wp_get_nav_menu_items').on('change', function() {
		var item_id = this.value;
		if(item_id != ''){
			$("#responseError_wpmh_group_menus_exist").html("");
		}else{
			$("#responseError_wpmh_group_menus_exist").html("Please select existing menu to be clone!");
		}
	});
	$('#clone_menu_name').on('keyup', function() {        
        if($(this).val().length == 0) {
            $("#responseError_clone_menu_name").html("Please enter menu name");
        }else{
            $("#responseError_clone_menu_name").html("");
        }
    });		
  	$('body').on('click', 'input#wpmh_group_clone_btn', function (e) {
  		var plugin_url = wpmh_script_object.plugin_url;
	 	var menu_id = $('#wp_get_nav_menu_items').val();
		var new_name = $('#clone_menu_name').val();
		var status = 0;		
		if((menu_id == '') && (new_name == '')){
			status = 1;
			$("#responseError_wpmh_group_menus_exist").html("");
			$("#responseError_clone_menu_name").html("");
			$("#responseError_wpmh_group_menus_exist").html("Please select existing menu to be clone!");
			$("#responseError_clone_menu_name").html("Please enter menu name");
		}else if((menu_id != '') && (new_name == '')){
			status = 1;			
			$("#responseError_wpmh_group_menus_exist").html("");
			$("#responseError_clone_menu_name").html("Please enter menu name");	
		}else if((menu_id == '') && (new_name != '')){
			status = 1;
			$("#responseError_clone_menu_name").html("");	
			$("#responseError_wpmh_group_menus_exist").html("Please select existing menu to be clone!");
		}else if((menu_id != '') && (new_name != '')){
			$("#responseError_wpmh_group_menus_exist").html("");
			$("#responseError_clone_menu_name").html("");
			var count = wpmh_script_object.wp_get_nav_menus_count;			
			const itemsArray = wpmh_script_object.wp_get_nav_menus;	
			if(wpmh_script_object.wp_get_nav_menus_count > 0){
				var names = [];
				for(var i = 0; i < count; i++){	
					names.push(wpmh_script_object.wp_get_nav_menus[i].name);
				}
				const checkingMenu = names.includes(new_name);
				if(checkingMenu == true){
					$("#responseError_clone_menu_name").html("This menu name is already exists. Please change the <b>Clone Menu name</b>");
					status = 1;
				}else{
					$("#responseError_clone_menu_name").html("");
					$("#responseError_wpmh_group_menus_exist").html("");
					status = 2;
				}
  				
			}
			
		}
		if(status == 2){
			$(this).attr('disabled','disabled');			
			$(".wrap.cloner-section").append('<div class="wpmh-group-loader-section"><div class="wpmh-group-loader-item"><img src="'+plugin_url+'/admin/images/fading-arrows.gif" class="loder-gif"></div></div>');			
			$.ajax({
				url:wpmh_script_object.ajax_url,
				type:'POST',
				data:{
					action:'menu_callback',
					new_name:new_name,
					menu_id:menu_id
				},
				success:function(response){
					$('#make_clone_btn').attr("disabled", false); 
					if(response){
						let str = 'Successfully Your Menu is Cloned <a href="nav-menus.php?action=edit&menu='+response+'" target="_blank" title="'+new_name+'" >here</a>';
						$('#response').html(str);
						$("#wp_get_nav_menu_items").val($("#wp_get_nav_menu_items option:first").val());
						$("#clone_menu_name").val("");
						$(".wpmh-group-loader-section").html("");
						$(".wrap.cloner-section").css("background-color","#F1F1F1");						
					}
				},
				error: function(errorThrown){
					console.log(errorThrown);
				}
			});
		}else{
			return false;
		}
    });
})( jQuery );
