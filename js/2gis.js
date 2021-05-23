var map;
DG.then(function () {
	map = DG.map('map', {
		center: [55.02, 82.93],
		zoom: 13
	});
});

function getCoord(address){
	ymaps.geocode(address).then(
		function (res) {
			coords = res.geoObjects.get(0).geometry.getCoordinates();				
		}
	);
}