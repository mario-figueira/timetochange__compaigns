
;
(function($) {

	$.validator.addMethod("time", function(value, element) {
		return this.optional(element) || /^(([0-1][0-9])|([1-2][0-3])):([0-5][0-9])(:[0-9][0-9])*$/.test(value);
	});

	$.validator.addMethod("alphanumeric", function(value, element) {
		return this.optional(element) || /^[a-zA-Z0-9_]+$/.test(value);
	});

	$.validator.addMethod("number", function(value, element) {
		return this.optional(element) || /^[-+]?[0-9]+[.]?[0-9]*([eE][-+]?[0-9]+)?$/.test(value);
	});

	$.validator.addMethod("integer", function(value, element) {
		return this.optional(element) || /^-?[0-9]+$/.test(value);
	});

	$.validator.addMethod("alphabetic", function(value, element) {
		return this.optional(element) || /^[a-zA-Z]+$/.test(value);
	});

	$.validator.addMethod("color", function(value, element) {
		var colors = ['AliceBlue','AntiqueWhite','Aqua','Aquamarine','Azure','Beige','Bisque','Black','BlanchedAlmond','Blue','BlueViolet','Brown','BurlyWood','CadetBlue','Chartreuse','Chocolate','Coral','CornflowerBlue','Cornsilk','Crimson','Cyan','DarkBlue','DarkCyan','DarkGoldenRod','DarkGray','DarkGrey','DarkGreen','DarkKhaki','DarkMagenta','DarkOliveGreen','Darkorange','DarkOrchid','DarkRed','DarkSalmon','DarkSeaGreen','DarkSlateBlue','DarkSlateGray','DarkSlateGrey','DarkTurquoise','DarkViolet','DeepPink','DeepSkyBlue','DimGray','DimGrey','DodgerBlue','FireBrick','FloralWhite','ForestGreen','Fuchsia','Gainsboro','GhostWhite','Gold','GoldenRod','Gray','Grey','Green','GreenYellow','HoneyDew','HotPink','IndianRed','Indigo','Ivory','Khaki','Lavender','LavenderBlush','LawnGreen','LemonChiffon','LightBlue','LightCoral','LightCyan','LightGoldenRodYellow','LightGray','LightGrey','LightGreen','LightPink','LightSalmon','LightSeaGreen','LightSkyBlue','LightSlateGray','LightSlateGrey','LightSteelBlue','LightYellow','Lime','LimeGreen','Linen','Magenta','Maroon','MediumAquaMarine','MediumBlue','MediumOrchid','MediumPurple','MediumSeaGreen','MediumSlateBlue','MediumSpringGreen','MediumTurquoise','MediumVioletRed','MidnightBlue','MintCream','MistyRose','Moccasin','NavajoWhite','Navy','OldLace','Olive','OliveDrab','Orange','OrangeRed','Orchid','PaleGoldenRod','PaleGreen','PaleTurquoise','PaleVioletRed','PapayaWhip','PeachPuff','Peru','Pink','Plum','PowderBlue','Purple','Red','RosyBrown','RoyalBlue','SaddleBrown','Salmon','SandyBrown','SeaGreen','SeaShell','Sienna','Silver','SkyBlue','SlateBlue','SlateGray','SlateGrey','Snow','SpringGreen','SteelBlue','Tan','Teal','Thistle','Tomato','Turquoise','Violet','Wheat','White','WhiteSmoke','Yellow','YellowGreen'];
		return	this.optional(element)
		|| /^\#?[A-Fa-f0-9]{3}([A-Fa-f0-9]{3})?$/.test(value)
		|| /^rgb\(([01]?\d\d?|2[0-4]\d|25[0-5])\,([01]?\d\d?|2[0-4]\d|25[0-5])\,([01]?\d\d?|2[0-4]\d|25[0-5])\)$/.test(value)
		|| $.inArray(value, colors) !== -1
	;
	});

	$.validator.addMethod("week", function(value, element) {
		return this.optional(element) || /^(1[6-9]|[2-9]\d)\d{2}-(W(0[1-9]|[1-4][0-9]|5[0-3]))$/.test(value);
	});

	$.validator.addMethod("month", function(value, element) {
		return this.optional(element) || /^(1[6-9]|[2-9]\d)\d{2}-((0[1-9]|[1][0-2]))$/.test(value);
	});

	$.validator.addMethod("datetime", function(value, element) {
		return this.optional(element) || /^((((19|20)(([02468][048])|([13579][26]))-02-29))|((20[0-9][0-9])|(19[0-9][0-9]))-((((0[1-9])|(1[0-2]))-((0[1-9])|(1\d)|(2[0-8])))|((((0[13578])|(1[02]))-31)|(((0[1,3-9])|(1[0-2]))-(29|30)))))(T| )(([0-1][0-9])|([1-2][0-3]))(:|\.)([0-5][0-9])((:|\.)[0-9][0-9])*(Z|[+-]+([0-1][0-9]|[2][0-3]):([0-5][0-9]))$/.test(value);
	});

	$.validator.addMethod("datetime-local", function(value, element) {
		return this.optional(element) || /^((((19|20)(([02468][048])|([13579][26]))-02-29))|((20[0-9][0-9])|(19[0-9][0-9]))-((((0[1-9])|(1[0-2]))-((0[1-9])|(1\d)|(2[0-8])))|((((0[13578])|(1[02]))-31)|(((0[1,3-9])|(1[0-2]))-(29|30)))))(T| )(([0-1][0-9])|([1-2][0-3]))(:|\.)([0-5][0-9])((:|\.)[0-9][0-9])*$/.test(value);
	});

	jQuery.extend(jQuery.validator.messages, {

		datetime : "Please enter a valid DateTime.(yyyy-mm-ddThh:mm:ssZ)",
		'datetime-local' : "Please enter a valid local DateTime.(yyyy-mm-ddThh:mm:ss)",
		time : "Please enter a valid time.(hh:ss)",
		alphanumeric : "Please enter only letters, underscores and numbers.",
		color:"Please enter a valid color. (named, hexadecimal or rgb)",
		week:"Please enter the week of a year. (e.g. 1974-W43)",
		month:"Please enter the month of a year. (e.g. 1974-03)",
		alphabetic:"Please enter only letters."
	});


})(jQuery);
