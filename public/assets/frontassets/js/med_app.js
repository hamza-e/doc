app.controller('myCtrl', function($scope,$http,$filter,DisponibiliteFact) {
		$scope.searchArea = false;
		$scope.to_hide_div= true;
		$scope.q ="";
		$scope.location ="";
		$scope.medecins =[];
		$scope.allMedecins;
		$scope.now = moment().format("YYYY-MM-DD[T]HH:mm:ss");

		function initialize() { //initialiser les inputs de google maps
			var input = document.getElementById('searchTextField');
			var input2 = document.getElementById('searchTextField2');
			var autocompleteinput = new google.maps.places.Autocomplete(input);
			var autocompleteinput2 = new google.maps.places.Autocomplete(input2);

			//affecter la valeur selectionner a l'input
			google.maps.event.addListener(autocompleteinput, 'place_changed', function () {
				console.log(autocompleteinput.getPlace().address_components[0].long_name);
				$scope.location = autocompleteinput.getPlace().address_components[0].long_name;
			});

			google.maps.event.addListener(autocompleteinput2, 'place_changed', function () {
				console.log(autocompleteinput2.getPlace().address_components[0].long_name);
				$scope.location = autocompleteinput2.getPlace().address_components[0].long_name;
			});
		}
		google.maps.event.addDomListener(window, 'load', initialize);


		console.log($scope.now);
		$scope.search = function () { //recherche medecins
			console.log($scope.location);
			geocoder.geocode({ 'address': $scope.location}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					console.log(results[0].address_components[0].long_name);
					$http({
						method:"GET",
						url:search_url,
						params:{
							q:$scope.q,
							location:results[0].address_components[0].long_name
						}
					}).then(function (response) {
						//console.log(response.data);
						$scope.medecins = [];
						$scope.to_hide_div = false;
						$scope.searchArea = true;
						var medMap = [];
						for (var i = 0; i < response.data.length; i++) {
							var med = {  //marker medecin dans la map
								name : 'Dr. '+response.data[i].nom+' '+response.data[i].prenom,
								location_latitude: parseFloat(response.data[i].latitude), 
								location_longitude: parseFloat(response.data[i].longitude),
								map_image_url: 'assets/images/'+response.data[i].image,
								type: '',
								url_detail: 'detail-page.html',
								name_point: 'Dr. '+response.data[i].nom+' '+response.data[i].prenom,
								description_point: response.data[i].adresse,
								get_directions_start_address: '',
								phone: response.data[i].telephone
							};
							medMap.push(med);
							DisponibiliteFact.getDisp(response.data[i].id,today).then( //disponibilite medecin
								function (result) {
									// console.log(result.data);
									// console.log(getDistance(parseFloat(results[0].geometry.location.lat()),parseFloat(results[0].geometry.location.lng()),parseFloat(result.data.medecin.latitude),parseFloat(result.data.medecin.longitude)));
									result.data.distance = getDistance(parseFloat(results[0].geometry.location.lat()),parseFloat(results[0].geometry.location.lng()),parseFloat(result.data.medecin.latitude),parseFloat(result.data.medecin.longitude));//distance de ce medecin
									$scope.medecins.push(result.data);
									$scope.allMedecins = $scope.medecins;
								},function (message) {
									alert(message);
								}
							);
						}

						if($scope.userLat == null || $scope.userlong == null){ //refresh map
							onsearch(medMap,results[0].geometry.location.lat(),results[0].geometry.location.lng());
							}else{
							onsearch(medMap,$scope.userLat,$scope.userlong);
						}
						//console.log(medMap);
						//console.log($scope.medecins.length);
					});
				} else {
					console.log("Something got wrong " + status);
				}
	        });
		}

		$scope.next_dates = function (index) { //onclick prochain jours calendrier dispo
			var x = moment($scope.medecins[index].date,['YYYY-MM-DD']);
			x.add(3,'days');
			var z = x.format('YYYY-MM-DD');
			console.log(z);
			var distance = $scope.medecins[index].distance;

			DisponibiliteFact.getDisp($scope.medecins[index].medecin.id,z).then(
				function (result) {
					console.log(result.data);
					$scope.medecins[index] = result.data;
					$scope.medecins[index].distance = distance;
				},function (message) {
					alert(message);
				}
			);
		}
		$scope.prev_dates = function (index) { //onclick jours precedent calendrier dispo
			var datediff = moment(today).diff(moment($scope.medecins[index].date,['YYYY-MM-DD']),'days');
			if(datediff < 0){
				var x = moment($scope.medecins[index].date,['YYYY-MM-DD']);
				x.subtract(3,'days');
				var z = x.format('YYYY-MM-DD');
				console.log(z);
				var distance = $scope.medecins[index].distance;
				DisponibiliteFact.getDisp($scope.medecins[index].medecin.id,z).then(
					function (result) {
						console.log(result.data);
						$scope.medecins[index] = result.data;
						$scope.medecins[index].distance = distance;
					},function (message) {
						alert(message);
					}
				);
			}
		}


		$scope.show_more = function (index) { //afficher plus de rendezvous
			$scope.medecins[index].display_more_dispo = true;
		}


		$scope.modalBook = function (id,date,index) { //modal prendez Rendezvous
			$scope.id_medecin = id;
			$scope.daterendezvous = date;
			$scope.experties = $scope.medecins[index].experties;
			$scope.nom_du_medecin = $scope.medecins[index].medecin.nom+' '+$scope.medecins[index].medecin.prenom;
			$scope.date_du_rendezvous = moment(date).format('[Le] DD-MM-YYYY [à] HH:mm');
			console.log(id,date,index);
		}

		// $scope.modalBookProfil = function (id,date) {
		// 	$scope.id_medecin = id;
		// 	$scope.daterendezvous = date;
		// 	$scope.experties = $scope.medecin.experties;
		// 	$scope.nom_du_medecin = $scope.medecin.medecin.nom+' '+$scope.medecin.medecin.prenom;
		// 	$scope.date_du_rendezvous = moment(date).format('[Le] DD-MM-YYYY [à] HH:mm');
		// 	console.log(id,date);
		// }


		$scope.preLog = function () { //store session du medecin et date rendezvous choisi avant login du patient
			$http({
				method : 'GET',
				async : true,
				url : session_rdv,
				headers : {'Content-Type' : 'application/json'},
				params : {id:$scope.id_medecin,date:$scope.daterendezvous}
			}).then(function (response) {
				console.log(response.data);
			});
		}

		$scope.autoCompleteDoc = function () { //autocomplete medecin recherche
			$scope.completeDocs = [];
			$http({
				method : 'GET',
				async : true,
				url : complete_doc,
				headers : {'Content-Type' : 'application/json'},
				params : {s:$scope.q}
			}).then(function (response) {
				console.log(response.data);
				$scope.completeDocs = response.data;
			});
		}

		$scope.filterDocs = function () { // filter medecins by : sexe / distance ...
			if($scope.docSort == 0){
				$scope.medecins = $scope.allMedecins;
			}else if($scope.docSort == 1){
				$scope.medecins = $filter('orderBy')($scope.allMedecins,function (med) {
					return med.distance;
				});
			}else if($scope.docSort == 3){
				$scope.medecins = $filter('filter')($scope.allMedecins,function (med) {
					return med.medecin.sexe == 'Homme';
				});
			}else if($scope.docSort == 4){
				$scope.medecins = $filter('filter')($scope.allMedecins,function (med) {
					return med.medecin.sexe == 'Femme';
				});
			}
		}

		$scope.getLocation = function (){ //get location user onclick
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			}else{
				console.log("Geolocation is not supported by this browser.");
			}
		}

		function showPosition(position) {
			var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			geocoder.geocode({'latLng': geolocate}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					var result;
					if (results.length > 1) {
						result = results[1];
					} else {
						result = results[0];
					}
					$scope.location = result.address_components[1].long_name;
				}
	        });
			console.log("Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude);
			console.log(position);
			$scope.userLat = position.coords.latitude;
			$scope.userlong= position.coords.longitude;
		}

		$scope.goToThisDate = function (index) { //Allez à prochaine date dispo dans le calendrier
			var distance = $scope.medecins[index].distance;

			DisponibiliteFact.getDisp($scope.medecins[index].medecin.id,$scope.medecins[index].dispoAtThis).then(
				function (result) {
					console.log(result.data);
					$scope.medecins[index] = result.data;
					$scope.medecins[index].distance = distance;
				},function (message) {
					alert(message);
				}
			);
		}

//************************ START MAP

	function onsearch(docs,lat,long) {
		
		var
		mapObject,
		markers = [],
		markersData = {
			'Doctors': docs
		};

		var mapOptions = {
			zoom: 11,
			center: new google.maps.LatLng(lat, long),
			mapTypeId: google.maps.MapTypeId.ROADMAP,

			mapTypeControl: false,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			panControl: false,
			panControlOptions: {
				position: google.maps.ControlPosition.TOP_RIGHT
			},
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.LARGE,
				position: google.maps.ControlPosition.RIGHT_BOTTOM
			},
			 scrollwheel: false,
			scaleControl: false,
			scaleControlOptions: {
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			streetViewControl: true,
			streetViewControlOptions: {
				position: google.maps.ControlPosition.RIGHT_BOTTOM
			},
			styles: [
										 {
				"featureType": "landscape",
				"stylers": [
					{
						"hue": "#FFBB00"
					},
					{
						"saturation": 43.400000000000006
					},
					{
						"lightness": 37.599999999999994
					},
					{
						"gamma": 1
					}
				]
			},
			{
				"featureType": "road.highway",
				"stylers": [
					{
						"hue": "#FFC200"
					},
					{
						"saturation": -61.8
					},
					{
						"lightness": 45.599999999999994
					},
					{
						"gamma": 1
					}
				]
			},
			{
				"featureType": "road.arterial",
				"stylers": [
					{
						"hue": "#FF0300"
					},
					{
						"saturation": -100
					},
					{
						"lightness": 51.19999999999999
					},
					{
						"gamma": 1
					}
				]
			},
			{
				"featureType": "road.local",
				"stylers": [
					{
						"hue": "#FF0300"
					},
					{
						"saturation": -100
					},
					{
						"lightness": 52
					},
					{
						"gamma": 1
					}
				]
			},
			{
				"featureType": "water",
				"stylers": [
					{
						"hue": "#0078FF"
					},
					{
						"saturation": -13.200000000000003
					},
					{
						"lightness": 2.4000000000000057
					},
					{
						"gamma": 1
					}
				]
			},
			{
				"featureType": "poi",
				"stylers": [
					{
						"hue": "#00FF6A"
					},
					{
						"saturation": -1.0989010989011234
					},
					{
						"lightness": 11.200000000000017
					},
					{
						"gamma": 1
					}
				]
			}
			]
		};
			
		var
		marker;
		mapObject = new google.maps.Map(document.getElementById('map_listing'), mapOptions);
		for (var key in markersData)
			markersData[key].forEach(function (item) {
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(item.location_latitude, item.location_longitude),
					map: mapObject,
					icon: 'assets/frontassets/img/pins/' + key + '.png',
				});

				if ('undefined' === typeof markers[key])
					markers[key] = [];

				markers[key].push(marker);
				google.maps.event.addListener(marker, 'click', (function () {
					closeInfoBox();
					getInfoBox(item).open(mapObject, this);
					mapObject.setCenter(new google.maps.LatLng(item.location_latitude, item.location_longitude));
				}));
			});

		function hideAllMarkers () {
			for (var key in markers)
				markers[key].forEach(function (marker) {
					marker.setMap(null);
				});
		};
		
		function toggleMarkers (category) {
			hideAllMarkers();
			closeInfoBox();

			if ('undefined' === typeof markers[category])
				return false;
			markers[category].forEach(function (marker) {
				marker.setMap(mapObject);
				marker.setAnimation(google.maps.Animation.DROP);

			});
		};

		function closeInfoBox() {
			$('div.infoBox').remove();
		};

		function getInfoBox(item) {
			return new InfoBox({
				content:
				'<div class="marker_info">' +
				'<figure><a href='+ item.url_detail +'><img src="' + item.map_image_url + '" alt="Image"></a></figure>' +
				'<small>'+ item.type +'</small>' +
				'<h3><a href='+ item.url_detail +'>'+ item.name_point +'</a></h3>' +
				'<span>'+ item.description_point +'</span>' +
				'<div class="marker_tools">' +
				'<form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block""><input name="saddr" value="'+ item.get_directions_start_address +'" type="hidden"><input type="hidden" name="daddr" value="'+ item.location_latitude +',' +item.location_longitude +'"><button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button></form>' +
					'<a href="tel://'+ item.phone +'" class="btn_infobox_phone">'+ item.phone +'</a>' +
					'</div>' +
				'</div>',
				disableAutoPan: false,
				maxWidth: 0,
				pixelOffset: new google.maps.Size(10, 105),
				closeBoxMargin: '',
				closeBoxURL: "assets/frontassets/img/close_infobox.png",
				isHidden: false,
				alignBottom: true,
				pane: 'floatPane',
				enableEventPropagation: true
			});
		};
		
		$scope.onHtmlClick = function(location_type, key){
     		google.maps.event.trigger(markers[location_type][key], "click");
 		}


	}
//********************* END MAP

});