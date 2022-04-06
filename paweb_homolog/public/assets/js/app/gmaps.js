function GMaps(){}

GMaps.prototype = {
    init : function(elementId, lat, lng, zoom) {

        GMaps.map = {};

        var latlng = new google.maps.LatLng(lat, lng);
        var myOptions = {
            zoom: zoom,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        GMaps.map[elementId] = new google.maps.Map(document.getElementById(elementId), myOptions);
    },
    
    add_marker : function(elementId, lat, lng, contentString, contentTitle)
    {
        
        var latlng = new google.maps.LatLng(lat, lng);
        var marker = new google.maps.Marker({
            position: latlng, 
            map: GMaps.map[elementId],           
            title:contentTitle
        });
        
        if(contentString){
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(GMaps.map,marker);
            });
        }
        
        
    },
    
    
    add_circle : function(elementId, lat, lng){
        var latlng = new google.maps.LatLng(lat, lng);
        var circle = new google.maps.Circle({
            map: GMaps.map[elementId],
            radius: 800, 
            center: latlng
        });
    }
}

var GMaps = new GMaps();