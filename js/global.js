/*	File: global.js
	Date Created: 29 January 2013
	Author: LCM <lcm@t2change.com>
	
	-------------------------------------------------------------
	
	Table of Contents
	
		1. tooltip
		2. inputs
	
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

/*	-------------------------------------------------------------
	3. list table
	------------------------------------------------------------- */


$('.listTable ul.row').hover(
  function () {
		$(this).addClass('rowHover');					
  }, 
  function () {
		$(this).removeClass('rowHover');					 
  }
);
