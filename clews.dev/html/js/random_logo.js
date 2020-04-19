//Array containing image source for possible logo.
var logo_array = [	
	"/images/logo_distressed_01.png",
	"/images/logo_distressed_02.png",
	"/images/logo_distressed_03.png",
	"/images/logo_distressed_04.png",
	"/images/logo_distressed_05.png",
	"/images/logo_distressed_06.png",
	"/images/logo_distressed_07.png",
	"/images/logo_distressed_08.png",
	"/images/logo_distressed_09.png",
	"/images/logo_distressed_10.png",
	"/images/logo_distressed_11.png",
	"/images/logo_distressed_12.png",
	"/images/logo_distressed_13.png",
	"/images/logo_distressed_14.png",
	"/images/logo_distressed_15.png",
];

//Want to change the src of element with id "logo_image".
var logo_image = document.getElementById('logo_image');

//Set the image source to a random element within the logo_array.
//Math.floor() rounds value down to an integer.
//Math.random() generates a random value between 0 and 1.
logo_image.src = logo_array[Math.floor(Math.random() * 15)];
