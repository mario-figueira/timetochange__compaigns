/*	File: global.js
	Date Created: 29 January 2013
	Author: LCM <lcm@t2change.com>
	
	-------------------------------------------------------------
	
	Table of Contents
	
		1. tooltip
		2. inputs
		3. list table
		4. date picker
	
	------------------------------------------------------------- */

/*	-------------------------------------------------------------
	1. tooltip
	------------------------------------------------------------- */

$(function() {
	
    $(document).tooltip({
    	track: true,
		show: { effect: "fade", duration: 250 },
		hide: { effect: "fade", duration: 0 }
    });
	
});

/*	-------------------------------------------------------------
	2. inputs
	------------------------------------------------------------- */

$(".formField_clear").each(function() {
	
	var textField_clear = this.value;
	
	$(this).focus(function() {
		if(this.value == textField_clear) {
			this.value = '';
		}
	});
	
	$(this).blur(function() {
		if(this.value == '') {
			this.value = textField_clear;
		}
	});
	
});

$(".formField")
  .focus (function () {
		$(this).addClass("formFieldFocus");
  })
  .blur (function () {
		$(this).removeClass("formFieldFocus");
});

$(".fwWideRow")
  .focus (function () {
		$(this).addClass("fwWideRowFocus");
  })
  .blur (function () {
		$(this).removeClass("fwWideRowFocus");
});

$(".formButton").hover(
  function () {
		$(this).addClass("formButtonHover");					
  }, 
  function () {
		$(this).removeClass("formButtonHover");					 
  }
);

/*	-------------------------------------------------------------
	3. list table
	------------------------------------------------------------- */

$(document).ready(function(){
    $('.listTable ul.row').click(function(e){
        $('.listTable ul.row').removeClass('rowSelected');
        $(this).addClass('rowSelected');
    });
});

/*	-------------------------------------------------------------
	4. date picker
	------------------------------------------------------------- */

$(function(){

	$('.datepicker').datepicker({
		dateFormat: "yy-mm-dd",
		showOtherMonths: true,
		selectOtherMonths: true
	});	

});
