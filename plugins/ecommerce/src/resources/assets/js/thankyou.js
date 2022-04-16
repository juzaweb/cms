window.Juzaweb || (window.Juzaweb = {});
(function () {
    Juzaweb.ViewMaps = function () {
        function ViewMaps(lat, lng, googleApiKey) {
            this.loadMaps(lat, lng, googleApiKey);
        };

        ViewMaps.prototype.loadMaps = function (lat, lng, googleApiKey) {
            var that = this;
            var listAPIKey = googleApiKey;
            if (listAPIKey !== 'undefined' && listAPIKey !== null && listAPIKey !== "") {
                listAPIKey = listAPIKey.split(";");
                var apiKey = listAPIKey[Math.floor(Math.random() * listAPIKey.length)];
                var urlGoogleMapsApi = "https://maps.googleapis.com/maps/api/js?key=" + apiKey;

                that.loadScriptGoogleMapApi(urlGoogleMapsApi, function (resultLoadApi) {
                    if (resultLoadApi === true) {
                        if (typeof google !== 'undefined') {
                            var map = new google.maps.Map(
                                $('#map')[0],
                                {
                                    zoom: 15,
                                    center: new google.maps.LatLng(lat, lng),
                                    mapTypeId: 'terrain',
                                    streetViewControl: true
                                }
                            );
                            var location = new google.maps.LatLng(lat, lng);
                            var marker = new google.maps.Marker({
                                position: location,
                                map: map
                            });
                        }
                        else {
                            $('#map').addClass('hidden-map');
                        }
                    }
                    else {
                        $('#map').addClass('hidden-map');
                    }
                })
            }
            else {
                $('#map').addClass('hidden-map');
            }
        }

        ViewMaps.prototype.loadScriptGoogleMapApi = function (url, callback) {
            jQuery.ajax({
                url: url,
                dataType: 'script',
                async: true,
                success: function () {
                    callback(true);
                },
                error: function () {
                    callback(false);
                }
            });
        }

        return ViewMaps;
    }();
}).call(this);