var localSearch = new GlocalSearch();



function findEverything(type,values){

	usePointFromPostcode(values, newMap);
	getNearbyEvents(values);

}
function usePointFromPostcode(postcode, callbackFunction) {

  localSearch.setSearchCompleteCallback(null, 
	function() {
	  
	  if (localSearch.results[0]) {    
		var resultLat = localSearch.results[0].lat;
		var resultLng = localSearch.results[0].lng;
		callbackFunction(resultLat, resultLng);
	  }else{
		alert("Postcode not found!");
	  }
	});  
	
  localSearch.execute(postcode + ", UK");
}

function newMap(resultLat,resultLng) {
	var myOptions = {
		zoom: 14,
		center: new google.maps.LatLng(resultLat, resultLng),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
}

