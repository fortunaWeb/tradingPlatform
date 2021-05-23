var map,
	polygonCoords = [],
	polygon,
	myCollection,
	coordsToPolygon = [],
	objectsInsidePolygon,
	coordsCount,
	idListByCoords = [],
	mapPost,
	coordsByAdress,
	coordsForList;

ymaps.ready(function(){
	map = new ymaps.Map("map", {
		center: [55.02, 82.93],
		zoom: 10,
		behaviors: ['default']
	});
	 map.controls.add("mapTools");
	 map.controls.add("zoomControl");
	$(".ymaps-map").append("<div class='map-btn'>Обвести</div>");
	/*нажатие на кнопку "обвести/очистить"*/
	$(".map-btn").on("click", function(){
		if(!$(this).hasClass("active")){
			$(this).addClass("active");
			$(this).text("Очистить");
			$("[name=limit]").parent().hide();
			GeoUpdate("");
			$("[name=live_point] :selected").val("");
			if(coordsToPolygon.length == 0){
				mapPost = decodeURIComponent($("form").serialize());
				MapAjax();
			}
			else if(mapPost!=decodeURIComponent($("form").serialize())){
				mapPost = decodeURIComponent($("form").serialize());
				MapAjax();
			}
			map.events.add("mousedown", OnMousedown);
			$(".ymaps-glass-pane").css("cursor", "crosshair");
		}else{
			$(this).text("Обвести");
			$(this).removeClass("active");
			map.events.remove("mousedown", OnMousedown);
			map.events.remove("mouseup", OnMouseup);
			map.events.remove("mousemove", OnMousemove);
			map.geoObjects.remove(polygon);
			/*при нажатии кнопки "очистить" возвращаем взятые объекты обратно в коллекцию "myCollection"*/
			objectsInsidePolygon.addTo(myCollection);
			//ymaps.geoQuery(map.geoObjects).search('geometry.type = "Point"').removeFromMap(map);
			ymaps.geoQuery(map.geoObjects).removeFromMap(map);
			$(".ymaps-glass-pane").css("cursor", "-webkit-grab");
			window.location = location;
		}
	});
	$(document).on("click", ".map-tolist-btn", function(){
		ShowList();
	});
	if($('[data-id=coords]').val() != "" && $('[data-id=coords]').val() != undefined){
		setPlacemark($('[data-id=coords]').val());
	}
});

function OnMousedown(e){
	polygonCoords = [];
	polygonCoords.push(e.get('coordPosition'));
	/*подключение события отпускания кнопки мыши над объектом "линия"*/
	map.geoObjects.events.add("mouseup", OnMouseup);
	/*подключение события отпускания кнопки мыши над картой*/
	map.events.add("mouseup", OnMouseup);
	/*подключение события по движению мыши*/
	map.events.add("mousemove", OnMousemove);
	e.preventDefault();
}

function OnMousemove(e){
	/*отключение стандартного действия*/
	//e.preventDefault();
	/*заполнение массива координат для полигона(области поиска)*/
	polygonCoords.push(e.get('coordPosition'));
	coordsCount = polygonCoords.length;
	/*добавление новой линии*/
	map.geoObjects.add(new ymaps.Polyline([polygonCoords[coordsCount-2],polygonCoords[coordsCount-1]], {}, {strokeColor: "#5CB85C", strokeWidth: 5}));
}

function OnMouseup(){
	map.events.remove("mousemove", OnMousemove);
	map.events.remove("mousedown", OnMousedown);
	map.geoObjects.events.remove("mouseup", OnMouseup);
	/*удаление линий*/
	ymaps.geoQuery(map.geoObjects).search('geometry.type = "LineString"').removeFromMap(map);	
	/*наношение полигона на карту*/
	polygon = new ymaps.Polygon([polygonCoords], {}, {fillColor: '#D8F9D9', strokeColor: "#5CB85C", opacity: 0.5, strokeWidth: 5});
	map.geoObjects.add(polygon);
	// Геобъекты, попадающие в полигон.
	/*вытаскиваем, попадающии в полигон, объекты из коллекции "myCollection" от 1 до 50 элемента*/
	var countResult = ymaps.geoQuery(myCollection).searchInside(polygon).getLength(),
		pageCont = (countResult/50).toFixed(0);

	objectsInsidePolygon = ymaps.geoQuery(myCollection).searchInside(polygon).slice(0, 50);

	GetCoordsForList(objectsInsidePolygon);
	
	/*сброс пагинатора*/
	$(".pagination li").each(function(){
		if($(this).data('id')!=undefined && !$(this).hasClass("active")&&$(this).has("span").length==0){
			$(this).remove();
		}
	})
	$(".pagination li.active a").remove();
	$(".pagination li a").removeAttr("onclick");
	$(".pagination li").removeClass("disabled");
	$(".pagination li.active").append("<span data-page='0' data-count='"+countResult+"' style='padding: 4px 10px;'>1-"+(countResult<50 ? countResult : '50')+" из "+countResult+"</span>").removeClass("active").removeAttr("data-id");	
	/*вывод вытащеных объектов на карту*/
	ymaps.geoQuery(objectsInsidePolygon).addToMap(map);
	//alertify.success(+objectsInsidePolygon.getLength()+" вариант(а/ов) удалось отобразить на карте ");
	objectsInsidePolygon.addEvents('click', GetMarkerData);
	map.events.remove("mouseup", OnMouseup);
	if(countResult > 50){
		ChangeMapPage();
	}
	map.setBounds(map.geoObjects.getBounds());
	$(".ymaps-map").append("<div class='map-tolist-btn'>Показать результат списком</div>");
}

/*отображение вариантов из списка на карте*/
function setPlacemark(coordsStr){
	if(!$("#map").is(":visible"))
	{	
		coords = [],
		disc = [],
		discStr = "";
		if($(".product").length > 1){
			$(".product").each(function(){
				if($(this).data("coords") != ""){
					discStr = $(this).find(".product-image a").attr("href") != "" ? "С фото" : "";
					coords.push($(this).data("coords").split(','));
					disc.push($(this).find("#product-view").text()+
							"<br />"+$(this).find("#price").text()+
							"<br />"+discStr+
							"<input type='hidden' value="+$(this).data("id")+">");
				}
			});   
		}
		myCollection = new ymaps.GeoObjectCollection();
		for (var i = 0; i<coords.length; i++) {
			myCollection.add(new ymaps.Placemark(coords[i], {balloonContent: disc[i]}));
		}
		map.geoObjects.add(myCollection);
		/*отображение балуна при нажатии на маркер*/
		myCollection.events.add("click", function(){
			setTimeout(function(){
				$(".ymaps-b-balloon__content-body").on("click", function(){
					$(this).css("cursor", "pointer");
					var pr = $(".product[data-id="+$(this).find("input").val()+"]");
					$('html, body').stop().animate({
						scrollTop: $(pr).offset().top - 100
					}, 1000);
				})
			}, 100);
		});
		// myCollection.events.add("click", function(e){
			// var clickCoords = e._Fb.target.geometry._ec;
			// $('html, body').stop().animate({
				// scrollTop: $("[data-coords='"+clickCoords[0]+","+clickCoords[1]+"'").offset().top - 100
			// }, 1000);
		// });
		$("#map").show();
	}else if(coordsStr!=""){objectsInsidePolygon
		var coordsArr = coordsStr.split(';'),			
			length = coordsArr.length;
		myCollection = new ymaps.GeoObjectCollection();
		for(var i=0; i<length; i++){
			var coordsAdnId = coordsArr[i].split(','),
				plCoords = [coordsAdnId[0], coordsAdnId[1]];
			if(plCoords[0] != ""){				
				myCollection.add(new ymaps.Placemark(plCoords));
				/*массив (ключ - координаты, значение - id вариантов) вариантов присутствующих на карте */
				if(idListByCoords[plCoords.toString()] != undefined){
					idListByCoords[plCoords.toString()] += coordsAdnId[2]+',';
				}else{
					idListByCoords[plCoords.toString()] = coordsAdnId[2]+',';
				}
			}
		}
		map.geoObjects.add(myCollection);
		//alertify.success(+myCollection.getLength()+" вариант(а/ов) удалось отобразить на карте ");
		myCollection.events.add('click', GetMarkerData);
	}
	$('html, body').stop().animate({
		scrollTop: $(".pagination_row").offset().top - 40
	}, 1000);
	map.setBounds(map.geoObjects.getBounds());
}

/*описание объектов находящихся по данным координатам*/
function GetMarkerData(e){
	loadingScreen();
	var targetCoodrs = e.get('target').geometry.getCoordinates();
	mapPost = "idList="+idListByCoords[targetCoodrs.toString()];
	if(mapPost == "idList=undefined") mapPost = "";
	var parentId = "parent_id="+QueryString("parent_id"),
		topicId = "topic_id="+$("[name=topic_id]:checked").val(),
		//data = 'coords='+targetCoodrs.toString()+"&"+mapPost+"&"+parentId+"&"+topicId;
		data = 'coords='+targetCoodrs.toString()+"&"+mapPost+"&" + decodeURIComponent($("#main_search").serialize());
	$.ajax({
		type: 'POST',
		data: data,
		url: '?task=map&action=get_data_by_coords',
		success: function(html){
			content = html;
			map.balloon.open(targetCoodrs,{content: html}, { closeButton: true });	
		},
		complete: function(){
			$(".progress").remove();
		}
	});	
}
/*получение координат вариантов учитывая фильтр*/
function MapAjax(){
	loadingScreen();
	try{
		map.geoObjects.remove(myCollection);
	}catch(err){}
	jQuery.ajax({
		type: 'POST',
		url: '?task=map&action=get_coords',
		data: mapPost,
		success: function(html){
			var xyArr = html.split('|');
			var idArr = [];
			for(var i=0; i<xyArr.length; i ++){
				var arr = xyArr[i].split(',');
				idArr.push(arr[2]);
				coordsToPolygon.push([parseFloat(arr[0]),parseFloat(arr[1])]);
			}
			myCollection = new ymaps.GeoObjectCollection();
			for (var i = 0; i<coordsToPolygon.length; i++) {
				myCollection.add(new ymaps.Placemark(coordsToPolygon[i]));
				idListByCoords.push(idArr[i]);
				
			}			
		},
		complete:function(){
			$(".progress").remove();
		}
	});
}

/*получение координат по адресу*/
function getCoord(address){
	ymaps.geocode(address).then(
		function (res) {
			coords = res.geoObjects.get(0).geometry.getCoordinates();
			getMetroCoord(coords);
		}
	);
}


/*получение названия ближаешего метро к найденным координатам*/
function getMetroCoord(coords){
	ymaps.geocode(coords, {kind: 'metro'}).then(function (res){
		try{
			metro_coords = res.geoObjects.get(0).geometry.getCoordinates();
			metro_name = res.geoObjects.get(0).properties.get("name").split("метро ")[1];		
			getDistanceToMetro(metro_coords);
		}catch(err){}
	});
}
/*дистанция до метро*/
function getDistanceToMetro(metro_coords){
	// ymaps.route([coords, metro_coords]).then(
		// function (route) {
			// route = route;
			// distanceToMetro = route.getLength();
		// }
	// );
	distanceToMetro = parseInt(
		ymaps.coordSystem.geo.getDistance(coords, metro_coords)
	);		
}

/*определение района города(определяет микрорайоны если есть)*/
function getDistrict(coords){
	ymaps.geocode(coords, {kind: 'district'}).then(function (res){
		try{
			console.log(metro_name = res.geoObjects.get(0).properties.get("name").split(" район")[0]);
		}catch(err){}
	});
}

/*показ чистой карты*/
function ShowCleanMap(){
	$(".district_list label.active input").click();
	$(".street_list span").click();
	$("[name=house]").val("");
	$("[name=live_point]").val("");
	ymaps.geoQuery(map.geoObjects).removeFromMap(map);
	$("#map").show();
	$('html, body').stop().animate({
		scrollTop: $("#map").offset().top - 50
	}, 1000);
}

function ChangeMapPage(objectsInsidePolygon,myCollection){		
	$(document).on("click", ".pagination li a[data-name=previous]", previousPageOnMap);
	$(document).on("click", ".pagination li a[data-name=next]", nextPageOnMap);
}

function previousPageOnMap(){
	loadingScreen();
	var indexOfFirstVar = parseInt($(".pagination li span").attr("data-page"));
	var count = $(".pagination li span").data("count");
	if(indexOfFirstVar >= 50){
		objectsInsidePolygon.addTo(myCollection);
		objectsInsidePolygon = ymaps.geoQuery(myCollection).searchInside(polygon).slice(indexOfFirstVar-50, indexOfFirstVar);
		$(".pagination li span").attr("data-page", indexOfFirstVar-50);
		$(".pagination li span").text((indexOfFirstVar-50==0 ? 1 : indexOfFirstVar-50)+"-"+indexOfFirstVar+" из "+count);
		ymaps.geoQuery(objectsInsidePolygon).addToMap(map);
		objectsInsidePolygon.addEvents('click', GetMarkerData);
		GetCoordsForList(objectsInsidePolygon);
		ShowList();
	}
	$(".progress").remove();
}

function nextPageOnMap(){
	loadingScreen();		
	var indexOfFirstVar = parseInt($(".pagination li span").attr("data-page"));
	var count = $(".pagination li span").data("count");
	if(indexOfFirstVar+50 < count){
		var countResultNext = indexOfFirstVar+100 <= count ? indexOfFirstVar+100 : count;
		objectsInsidePolygon.addTo(myCollection);
		objectsInsidePolygon = ymaps.geoQuery(myCollection).searchInside(polygon).slice(indexOfFirstVar+50, countResultNext);
		$(".pagination li span").attr("data-page", indexOfFirstVar+50);
		$(".pagination li span").text((indexOfFirstVar+50)+"-"+countResultNext+" из "+count);
		ymaps.geoQuery(objectsInsidePolygon).addToMap(map);
		objectsInsidePolygon.addEvents('click', GetMarkerData);
		GetCoordsForList(objectsInsidePolygon);
		ShowList();
	}
	$(".progress").remove();
}

/*загрузочный экран*/
function loadingScreen(){
	try{
		$(".progress").remove();
	}catch(err){}	
	$("#map").append("<div class='progress' style='width: 103%;height: 100%; position: fixed;z-index: 9999;top: 0;margin-left: -10px;background-color: rgba(0, 0, 0, 0.5);text-align: center;'><p style='margin-top: 250px;font-size: 20px;color: #fff;'>Загрузка</p></div>");
	loading(1);
}

/*показ месторасположение варианта*/
function show_address(var_coords, id){
	var arrCoord = [],
		t = 0;
	coords=[];
	if(var_coords==""){
        getCoord($("#msg"+id).data("addr"));
		t = 1000;
	}else{
		arrCoord = var_coords.split(',');
	}
    //map.destroy();
	$("#modal-win .btn-primary").remove();
	$("#modal-win .btn-default").text("Закрыть");
	$("#modal-win .modal-title").text("Местоположение данного объекта");
	setTimeout(function(){
		arrCoord = arrCoord.length == 2 ? arrCoord : coords;
		$("ymaps").remove();
		try{
			map.remove();
		}catch(err){}
		map = new ymaps.Map("map", {
			center: arrCoord,
			zoom: 15,
			behaviors: ['default', 'scrollZoom']
		});

		ymaps.geoQuery(map.geoObjects).removeFromMap(map);
		map.geoObjects.add(
			new ymaps.Placemark(arrCoord, {
				balloonContent: ($("#msg"+id).data("addr"))
			})
		);

		map.setCenter(arrCoord);
		map.setZoom(15);
		$("button[data-id=toggleMap]").attr("onclick", "show_address_2gis('"+var_coords+"', "+id+")").text("2 ГИС");
	},t)
	
	if($("#map").is(":visible")){
		$('html, body').stop().animate({
			scrollTop: $("#map").offset().top -50
		}, 1000);
	}
}

function getByAddressFor2Gis(adressString){
		ymaps.geocode(adressString).then(
			function (res) {
				coordsByAdress = res.geoObjects.get(0).geometry.getCoordinates();
				alert(coordsByAdress);
			}
		);
}

function show_address_2gis(var_coords, id){
	var arrCoord = [],
		t = 0;
	coords=[];

	if(var_coords!=""){
		arrCoord = var_coords.split(',');
	}else{
		getCoord($("#msg"+id).data("addr"));
		t = 1000;
	}
	//map.destroy();
	$("#modal-win .btn-primary").remove();
	$("#modal-win .btn-default").text("Закрыть");
	$("#modal-win .modal-title").text("Местоположение данного объекта");

	setTimeout(function(){
		arrCoord = arrCoord.length == 2 ? arrCoord : coords;
		$("ymaps").remove();
		DG.then(function() {
			map = DG.map('map', {
				center: arrCoord,
				zoom: 15
			});

			DG.marker(arrCoord).addTo(map).bindPopup($("#msg"+id+" #address").text());
			$("button[data-id=toggleMap]").attr("onclick", "show_address('"+var_coords+"', "+id+")").text("Яндекс");
		});
		
		if($("#map").is(":visible")){
			$('html, body').stop().animate({
				scrollTop: $("#map").offset().top -50
			}, 1000);
		}
	}, 1000);
}

//список координат попадающий в обведенную область
function GetCoordsForList(objectsInsidePolygon)
{
    console.log(objectsInsidePolygon);
	var countObjInPol = objectsInsidePolygon.getLength();
	coordsForList = "";
	for(var o=0; o<countObjInPol; o++){
		coordsForList += objectsInsidePolygon._Ol[o].geometry._Wd + "||";
	}
	coordsForList = coordsForList.substring(0, coordsForList.length-2);

    console.log(coordsForList);
}

//отображение списка вариантов
function ShowList(){
	if(coordsForList!=""){
		$(".products-list").append("<div class='progress' style='width: 103%;height: 100%; position: fixed;z-index: 9999;top: 0;margin-left: -10px;background-color: rgba(0, 0, 0, 0.5);text-align: center;'><p style='margin-top: 250px;font-size: 20px;color: #fff;'>Загрузка</p></div>");
		loading(1);
		var data = decodeURIComponent($("form").serialize());

		$.post("?task=map&action=map_tolist", "coords="+coordsForList+"&"+data, function(html){
			$(".products-list .product").remove();
			$(".products-list").append($(html).find(".product"));
			$('html, body').stop().animate({
				scrollTop: $($($(".product")[0])).offset().top -50
			}, 1000);
			$(".progress").remove();
		});
	}
}