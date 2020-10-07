// $("#clients").carousel({
// 	interval: 5000,
// });

$(".clients .carousel .carousel-item").each(function () {
	var minPerSlide = 4;
	var next = $(this).next();
	if (!next.length) {
		next = $(this).siblings(":first");
	}
	next.children(":first-child").clone().appendTo($(this));

	for (var i = 0; i < minPerSlide; i++) {
		next = next.next();
		if (!next.length) {
			next = $(this).siblings(":first");
		}

		next.children(":first-child").clone().appendTo($(this));
	}
});

// function initMap() {
// 	// The location of Uluru
// 	var uluru = { lat: -25.344, lng: 131.036 };
// 	// The map, centered at Uluru
// 	var map = new google.maps.Map(document.getElementById("map"), { zoom: 4, center: uluru });
// 	// The marker, positioned at Uluru
// 	var marker = new google.maps.Marker({ position: uluru, map: map });
// }
