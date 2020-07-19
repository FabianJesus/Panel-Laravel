class MapController{
    constructor(){
        this.myMap = L.map('myMap').setView([36.7226354, -4.4174739], 13)

        L.tileLayer(`http://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png`, {maxZoom: 18}).addTo(this.myMap);
        this.markerIcon = null;
        this.myMap.doubleClickZoom.disable();
        this.myMap.on('dblclick', e => {
        this.addMarket(e);
        })
}
    addMarket(e){
        const latLng = this.myMap.mouseEventToLatLng(e.originalEvent);
        if(this.markerIcon){
            this.myMap.removeLayer(this.markerIcon);
        };
        this.markerIcon = L.marker([latLng.lat, latLng.lng]).addTo(this.myMap);
        $('#lat').val(latLng.lat);
        $('#lon').val(latLng.lng);
    }
    searchAdress() {
        const entrada = document.getElementById("adress");
      
        $.getJSON('http://nominatim.openstreetmap.org/search?format=json&limit=5&q=' + entrada.value, function(data) {
            const items = [];
      
            $.each(data, function(key, val) {
                const bb = val.boundingbox;
                items.push("<li><a href='#' onclick='map.goAdress(" + bb[0] + ", " + bb[2] + ", " + bb[1] + ", " + bb[3] + ");return false;'>" + val.display_name + '</a></li>');
            });
      
            $('#resultado').empty();
            if (items.length != 0) {
                $('<p>', { html: "Resultados de la b&uacute;queda:" }).appendTo('#resultado');
                $('<ul/>', {
                    'class': 'my-new-list',
                    html: items.join('')
                }).appendTo('#resultado');
            }else{
                 $('<p>', { html: "Ningun resultado encontrado." }).appendTo('#resultado');
            }
        });
      }
      goAdress(lat1, lng1, lat2, lng2){
       this.myMap.fitBounds(new L.LatLngBounds(new L.LatLng(lat1, lng1), new L.LatLng(lat2, lng2)));
      }
}