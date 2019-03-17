<?php
$servername = "localhost";
$username = "dispose_access";

// Create connection
$conn = new mysqli($servername, $username);
?>

<html>
    
    <head>
        <title>Dispose: Dumpster Locator and Status</title> 
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    </head>
    
    <body>
        
        <div id="wrapper">
            <nav class="navbar">
                <span class="open-slide">
                    <a href="#" onclick="openSlideMenu()">
                        <svg width="30" height="30">
                            <path d="M0,5 30,5" stroke="#fff" stroke-width="5"/>
                            <path d="M0,14 30,14" stroke="#fff" stroke-width="5"/>
                            <path d="M0,23 30,23" stroke="#fff" stroke-width="5"/>
                        </svg>
                    </a>
                </span>
            </nav>

            <div id="side-menu" class="side-nav">
                <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Services</a>
                <a href="#">Contact</a>
            </div>

            <div id="map">
                <script>
                    
                    var map, infoWindow, marker, messageWindow;
                    
                    function initMap() {
                        map = new google.maps.Map(document.getElementById('map'), {
                            center: { lat: 42.728, lng: -73.692 },
                            zoom: 15
                        });
                        infoWindow = new google.maps.InfoWindow;
                        // Try HTML5 geolocation.
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function (position) {
                                var current_location = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude
                                };
                                map.setCenter(current_location);
                                var current_location_marker = new google.maps.Marker({position: current_location, map: map});
                                infoWindow.setPosition(current_location);
                                infoWindow.setContent('Current location');
                                infoWindow.open(map);
                            }, function () {
                                handleLocationError(true, infoWindow, map.getCenter());
                            });
                        } else {
                            // Browser doesn't support Geolocation
                            handleLocationError(false, infoWindow, map.getCenter());
                        }
                    }

                    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                        infoWindow.setPosition(pos);
                        infoWindow.setContent(browserHasGeolocation ?
                            'Please input address' :
                            'Please input address');
                        infoWindow.open(map);
                    }
                </script>

                <script>
                    function openSlideMenu(){
                        document.getElementById('side-menu').style.width = '250px';
                        document.getElementById('main').style.marginLeft = '250px';
                    }

                    function closeSlideMenu(){
                        document.getElementById('side-menu').style.width = '0';
                        document.getElementById('main').style.marginLeft = '0';
                    }
                </script>
                
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-E5Sxgxe5r8P7i4SP-ggNIoKNpvrPEhg&callback=initMap"></script>
            </div>
            <div id="right_controls">
                <div class="submit_button" onclick="">
                    <a class="button btnFade btnBlueGreen" >SUBMIT</a>
                </div>
                <div class="submit_button" onclick="">
                    <a class="button btnFade btnBlueGreen" >SUBMIT</a>
                </div>
            </div>
            <div id="results">
                
            </div>
            <form id="entry">
                <input type="text" name="search_entry" class="searchbox" id="address_search"/>
                <div class="submit_button" id="search_submit" onclick="address_search()">
                    <a class="button btnFade btnBlueGreen" >SUBMIT</a>
                </div>
            </form>
        </div>
    </body>
</html>