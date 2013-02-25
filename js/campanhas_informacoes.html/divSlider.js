/****************************************************************************************
                      DIV Slider (c) 2011 - Sérgio Bernardo
					  v 1.2 - 2011-03.25
****************************************************************************************/
function divSlider(slideDivName, totalSlides, divWidth, updateSlideTime) {

	this.slide_div_name = slideDivName;
	this.current_slide   = -1;
	this.total_slides    = totalSlides;
	this.aux_goto_pos    = 0;
	this.aux_easing_time = 0;
	this.aux_current_pos = 0;
	this.aux_inicial_pos = 0;
	this.aux_current_pos = 0;
	this.moving = false;
	this.vertical = false;
	this.argura_divs = divWidth;
	this.tempo_easing = 1;
	this.tempo_refresh = 30;
	this.continuous = false;
	
	if(updateSlideTime != null && updateSlideTime > 0) {
		var oInstance=this; // CAPTURE THIS
		this.auto_animate = setInterval(function(){oInstance.update_slide()}, updateSlideTime);
	}
}

divSlider.prototype.setVertical = function() {
	this.vertical = true;
	this.offsetInicial = parseInt(document.getElementById(this.slide_div_name).style.top);
	this.aux_inicial_pos = this.offsetInicial;
	this.aux_current_pos = this.offsetInicial;
}
divSlider.prototype.setHorizontal = function() {
	this.vertical = false;
	this.offsetInicial = parseInt(document.getElementById(this.slide_div_name).style.left);
	this.aux_inicial_pos = this.offsetInicial;
	this.aux_current_pos = this.offsetInicial;
}
divSlider.prototype.update_slide = function() {
	var new_slide = (this.current_slide + 1) % this.total_slides;
	this.move_to_slide(new_slide, true);
}

divSlider.prototype.next_slide = function() {
	if(this.current_slide < (this.total_slides - 1)) {
		this.move_to_slide(this.current_slide + 1, false);
	}
}

divSlider.prototype.prev_slide = function() {
	if(this.current_slide > 0) {
		this.move_to_slide(this.current_slide - 1, false);
	}
}

 
divSlider.prototype.move_slide_position = function() {
	// Obter posição para o slide...
	var t = this.aux_easing_time;
	var b = this.aux_inicial_pos;
	var c = this.aux_goto_pos - this.aux_inicial_pos;
	var d = this.tempo_easing;
	
	// Easing algorithm
	t = t/d;
	var ts=(t)*t;
	var tc=ts*t;
	// var new_pos = b+c*(-2*tc + 3*ts);
	var new_pos =b+c*(-4*tc*ts + 15*ts*ts + -20*tc + 10*ts);
	
	// Andamos mesmo...
	var content_div = document.getElementById(this.slide_div_name);
	if(content_div) {
		if(this.vertical) {
			content_div.style.top = ''+new_pos+'px';
		} else {
			content_div.style.left = ''+new_pos+'px';
		}
		this.aux_current_pos = new_pos;
		this.aux_easing_time += this.tempo_refresh;
		if(this.aux_easing_time < d) {
			var oInstance=this; // CAPTURE THIS
			window.setTimeout(function(){oInstance.move_slide_position()}, this.tempo_refresh);
		} else {
			if(this.vertical) {
				content_div.style.top = ''+this.aux_goto_pos+'px';
			} else {
				content_div.style.left = ''+this.aux_goto_pos+'px';
			}
			this.moving = false;
			this.tempo_easing = 1500;
			if(this.continuous && this.current_slide == (this.total_slides -1)) {
				this.current_slide = 0;
				this.aux_inicial_pos = this.offsetInicial;
				this.aux_current_pos = this.offsetInicial;
			}
		}
	} else {
		alert('divSlider - Erro: div com id: '+this.slide_div_name+' não foi encontrada!');
		this.moving = false;
		clearInterval(this.auto_animate);
	}
}
 
divSlider.prototype.move_to_slide = function(slide, no_clear) {

	if(slide < 0) {
		slide = this.total_slides;
	}
	if(slide >= this.total_slides) {
		slide = 0;
	}

	// Se já cá estamos ou estamos a tratar disso, ignorar o click!
	if(slide == this.current_slide) {
		return;
	}
	
	if(no_clear != true) {
		clearInterval(this.auto_animate);
	}

	// Mover para o slide pretendido...
	this.aux_inicial_pos = this.aux_current_pos;
	this.aux_goto_pos    = this.offsetInicial + (-1 * this.argura_divs * slide) ;
	this.aux_easing_time = 0;
	this.current_slide = slide;
	this.moving = true;
	this.move_slide_position();
}

divSlider.prototype.setContinuous = function(val) {
	this.continuous = val;
}
