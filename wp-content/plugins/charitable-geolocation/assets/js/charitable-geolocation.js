( function( window, document ){  

    /**
     * Set up a single map.
     */
    var charitableMap = function ( element ) {        
        this.element    = element;        
        this.map        = new google.maps.Map( element, {
            mapTypeId   : google.maps.MapTypeId.ROADMAP,
            zoomControl : true
        });
        this.mapmarkers = [];
        this.bounds     = new google.maps.LatLngBounds();

        if ( methods.dataDefined( this, 'search' ) ) {
            methods.setupSearch( this );
        }

        if ( methods.dataDefined( this, 'markers' ) ) {
            methods.setupMarkers( this );
        }        

        if ( this.mapmarkers.length ) {
            this.map.fitBounds( this.bounds );
        } else {
            var center = methods.getMapCenter( this );
            this.bounds.extend( center );
            this.map.fitBounds( this.bounds );
        }
    
        methods.setupZoom( this );

        if ( this.mapmarkers.length ) {
            markerCluster = new MarkerClusterer( this.map, this.mapmarkers, JSON.parse( CHARITABLE_GEOLOCATION.markerclusterer_options ) );
        }
        
        methods.setupInitialMapLocation( this );        

        return this;
    }

    /**
     * Object with helper methods.
     */
    var methods = {};

    /**
     * Set up the markers.
     */
    methods.setupMarkers = function( that ) {
        var infowindow = new google.maps.InfoWindow();
        var markers    = JSON.parse( that.element.dataset.markers );

        for ( var i = 0; i < markers.length; i++ ) {  
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng( markers[i]['latitude'],  markers[i]['longitude'] ),
                map: that.map
            });

            that.bounds.extend( marker.position );

            google.maps.event.addListener( marker, 'click', (function ( marker, i ) {
                return function() {
                    infowindow.setContent( methods.getMarkerContent( markers[i] ) );
                    infowindow.open( that.map, marker );
                }
            })( marker, i ) );

            that.mapmarkers.push( marker );
        }
    }

    /**
     * Set up search/autocomplete for the map.
     */
    methods.setupSearch = function( that ) {
        that.search = document.getElementById( that.element.dataset.search );        

        if ( null === that.search ) {
            return;
        }

        that.autocomplete = new google.maps.places.Autocomplete( that.search );
        that.a_infowindow = new google.maps.InfoWindow();
        that.a_marker     = new google.maps.Marker({
            map: that.map,
            anchorPoint: new google.maps.Point( 0, -29 )
        });

        that.autocomplete.bindTo( 'bounds', that.map );

        that.autocomplete.addListener( 'place_changed', function() {
            return methods.setupPlace( that, that.autocomplete.getPlace() );
        });        
    }

    /**
     * Respond to a search response.
     */
    methods.setupPlace = function( that, place ) {
        that.a_infowindow.close();

        that.a_marker.setVisible( false );

        if ( ! place.geometry ) {

            service = new google.maps.places.PlacesService( that.map );

            service.textSearch( {
                query: place.name
            }, function( results, status ) {
                if ( status === google.maps.places.PlacesServiceStatus.OK ) {
                    for ( var i = 0; i < results.length; i++ ) {
                        methods.setupPlace( that, results[i] );
                    }
                }
            });

            return;

        }

        // If the place has a geometry, then present it on a map.
        if ( place.geometry.viewport ) {
            that.map.fitBounds( place.geometry.viewport );
        } else {
            that.map.setCenter( place.geometry.location );
            that.map.setZoom(17);  // Why 17? Because it looks good.
        }

        // Store the latitude and longitude in hidden fields
        methods.storePlaceDetails( place, that );            
        
        that.a_marker.setIcon({
            url: place.icon,
            size: new google.maps.Size( 71, 71 ),
            origin: new google.maps.Point( 0, 0 ),
            anchor: new google.maps.Point( 17, 34 ),
            scaledSize: new google.maps.Size( 35, 35 )
        });

        that.a_marker.setPosition( place.geometry.location );
        that.a_marker.setVisible( true );

        var address = '';
        if ( place.address_components ) {
            address = [
                ( place.address_components[0] && place.address_components[0].short_name || '' ),
                ( place.address_components[1] && place.address_components[1].short_name || '' ),
                ( place.address_components[2] && place.address_components[2].short_name || '' )
            ].join(' ');
        }

        that.a_infowindow.setContent( '<div><strong>' + place.name + '</strong><br>' + address );
        that.a_infowindow.open( that.map, that.a_marker );
    }

    /** 
     * Set up the zoom level for the map.
     */
    methods.setupZoom = function( that ) {
        var zoom = (function() {
            var zoom = methods.dataDefined( that, 'zoom' ) ? that.element.dataset.zoom : CHARITABLE_GEOLOCATION.default_zoom;            
            return parseInt( zoom, 10 );
        })();

        var listener = google.maps.event.addListener( that.map, 'idle', function(){
            that.map.setZoom( zoom );
            google.maps.event.removeListener( listener );
        } );
    }

    /**
     * Retrieve a marker's HTML content.
     *
     * @param   object marker
     * @return  string
     */
    methods.getMarkerContent = function( marker ) {
        var content = CHARITABLE_GEOLOCATION.marker;

        if ( null === marker.thumbnail ) {
            content = content.replace( /<img src="{thumbnail}" alt="{title}" \/>/g, '' );
        } else {
            content = content.replace( /{thumbnail}/g, marker.thumbnail );
        }
        
        content = content.replace( /{title}/g, marker.title );
        content = content.replace( /{link}/g, marker.link );
        content = content.replace( /{description}/g, marker.description );

        return content;
    };

    /** 
     * Check if an value is defined in the dataset for a particular key.
     *
     * @param   string key
     * @return  boolean
     */
    methods.dataDefined = function( that, key ) {
        return 'undefined' !== typeof( that.element.dataset[key] );
    }

    /**
     * Return the default map center.
     *
     * @return  LatLng
     */
    methods.getMapCenter = function( that ) {
        var lat, long;

        if ( methods.dataDefined( that, 'lat' ) && that.element.dataset.lat.length ) {
            lat = that.element.dataset.lat;
        }

        if ( methods.dataDefined( that, 'long' ) && that.element.dataset.long.length ) {
            long = that.element.dataset.long;
        }

        if ( 'undefined' === typeof( lat ) || 'undefined' === typeof( long) ) {
            if ( navigator.geolocation && 'https' === window.location.protocol ) {
                navigator.geolocation.getCurrentPosition( function (position) {
                    lat  = position.coords.latitude;
                    long = position.coords.longitude;
                });
            } 

            /* If the latitude has not been set, we couldn't grab the coordinates via geolocation. */
            if ( 'undefined' === typeof( lat ) ) {
                lat  = parseFloat( CHARITABLE_GEOLOCATION.default_lat );
                long = parseFloat( CHARITABLE_GEOLOCATION.default_long );
            }
        }
        
        return new google.maps.LatLng( lat, long );
    }

    /**
     * Set up a handler for the tab resize event if the map is inside of the 'campaign-location' div.
     */
    methods.setupInitialMapLocation = function( that ) {
        var tab   = document.querySelector('a[href="#campaign-location');
        var setup = function() {
            if ( methods.dataDefined( that, 'placeid' ) && that.element.dataset.placeid.length ) {
                var service = new google.maps.places.PlacesService( that.map );

                service.getDetails({
                    placeId : that.element.dataset.placeid
                }, function( place, status ) {
                    if ( status === google.maps.places.PlacesServiceStatus.OK ) {
                        methods.setupPlace( that, place );
                    }
                });
            } else {
                that.map.fitBounds( that.bounds );
                methods.setupZoom( that );
            }
        };

        if ( null !== tab ) {
            tab.addEventListener( 'click', function() {                
                google.maps.event.trigger( that.map, 'resize' );
                setup( that );
            });
        } else {
            setup( that );
        }
    }

    /**
     * Store the latitude & longitude of an address.
     *
     * @param   PlaceResult
     * @param   charitableMap
     */
    methods.storePlaceDetails = function( place, that ) {
        if ( 'undefined' === typeof( that.longitude ) ) {
            var longitude = document.createElement( 'input' );

            longitude.setAttribute( 'type', 'hidden' );
            longitude.setAttribute( 'name', '_campaign_longitude' );

            that.search.parentNode.appendChild( longitude );

            that.longitude = document.querySelector( '[name=_campaign_longitude]' );
        }

        if ( 'undefined' === typeof( that.latitude ) ) {
            var latitude = document.createElement( 'input' );

            latitude.setAttribute( 'type', 'hidden' );
            latitude.setAttribute( 'name', '_campaign_latitude' );

            that.search.parentNode.appendChild( latitude, that.search );

            that.latitude = document.querySelector( '[name=_campaign_latitude]' );
        }

        if ( 'undefined' === typeof( that.place_id ) ) {
            var place_id = document.createElement( 'input' );

            place_id.setAttribute( 'type', 'hidden' );
            place_id.setAttribute( 'name', '_gmaps_place_id' );

            that.search.parentNode.appendChild( place_id, that.search );

            that.place_id = document.querySelector( '[name=_gmaps_place_id]' );
        }

        that.longitude.setAttribute( 'value', place.geometry.location.lng() );
        that.latitude.setAttribute( 'value', place.geometry.location.lat() );
        that.place_id.setAttribute( 'value', place.place_id );
    }

    /**
     * Load all maps.
     */
    var initializeMaps = function() {
        CHARITABLE_GEOLOCATION.maps = [];

        maps = document.getElementsByClassName( 'charitable-map' );

        for ( var i = 0; i < maps.length; i++ ) {
            CHARITABLE_GEOLOCATION.maps[i] = new charitableMap( maps[i] );
        }
    }

    window.onload = initializeMaps;    

})( window, document );