<?php
$servername = "localhost";
$username = "dispose_access";

// Create connection
$conn = new mysqli($servername, $username);

// include("php/init.php");

?>

<html>
    
    <head>
        <title>Dispose: Dumpster Locator and Status</title> 
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Trocchi" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">

    </head>
    
    <body>
        <div id="wrapper">

            <h2 style="margin-left: 45%; font-family: 'Quicksand', sans-serif; font-size:55px;">testing testing Dispose</h2>
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
                <a href="index.php">Home</a>
                <a href="about.html">About</a>
                <a href="information.html">Information</a>
                <a href="contact.html">Contact</a>
            </div>

            <div id="map">
                <script>
                    var customLabel = {
                        restaurant: {
                            label: 'R'
                        },
                        bar: {
                            label: 'B'
                        }
                    };

                    function initMap() {
                        var map = new google.maps.Map(document.getElementById('map'), {
                            center: { lat: 42.728, lng: -73.692 },
                            zoom: 15
                        });

                        var infoWindow = new google.maps.InfoWindow;
                        
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function (position) {
                                var current_location = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude
                                };
                                map.setCenter(current_location);
                                var current_location_marker = new google.maps.Marker({position: current_location, map: map, icon: {url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"}});
                                // infoWindow.setPosition(current_location);
                                // infoWindow.setContent('Current location');
                                // infoWindow.open(map);
                            }, function () {
                                handleLocationError(true, infoWindow, map.getCenter());
                            });
                        } else {
                            // Browser doesn't support Geolocation
                            handleLocationError(false, infoWindow, map.getCenter());
                        }
                        
                        // Change this depending on the name of your PHP or XML file
                        downloadUrl('php/load_markers.php', function(data) {
                            var xml = data.responseXML;
                            var markers = xml.documentElement.getElementsByTagName('marker');
                            Array.prototype.forEach.call(markers, function(markerElem) {
                                var id = markerElem.getAttribute('id');
                                var name = markerElem.getAttribute('name');
                                var address = markerElem.getAttribute('address');
                                var type = markerElem.getAttribute('type');
                                var status = markerElem.getAttribute('status');
                                var point = new google.maps.LatLng(
                                    parseFloat(markerElem.getAttribute('lat')),
                                    parseFloat(markerElem.getAttribute('lng')));

                                var infowindow_content = "<div> <strong>" + name + "</strong> <br /> <text>" + address
                                 + "</text> <br /> <text id='marker_id'>" + id + "</text> <br /> <text>" + type + "</text> <br /> <text>" + status + "</text> <br />";
                                infowindow_content = infowindow_content + "<div style='display:inline-block'>";
                                infowindow_content = infowindow_content + "<select id='change_status'> <option value='empty'> empty </option>";
                                infowindow_content = infowindow_content + "<option value='half'> half </option>";
                                infowindow_content = infowindow_content + "<option value='full'> full </option>";
                                infowindow_content = infowindow_content + "<option value='overflowing'> overflowing </option>";
                                infowindow_content = infowindow_content + "</select>";
                                infowindow_content = infowindow_content + "<a onclick='save_data()' style='margin-left:5px;' href='#'>SUBMIT</a>";
                                infowindow_content = infowindow_content + "</div>";

                                var icon = customLabel[type] || {};
                                var marker = new google.maps.Marker({
                                    map: map,
                                    position: point,
                                    label: icon.label,
                                    icon: {url: "img/dumpster_icon.png"}
                                });
                                marker.addListener('click', function() {
                                    infoWindow.setContent(infowindow_content);
                                    infoWindow.open(map, marker);
                                });
                            });
                        });
                    }

                    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                        infoWindow.setPosition(pos);
                        infoWindow.setContent(browserHasGeolocation ?
                            'Please input address' :
                            'Please input address');
                        infoWindow.open(map);
                    }

                    function save_data() {
                        var new_status = document.getElementById('change_status').value;
                        var marker_id = document.getElementById('marker_id').textContent;
                        console.log("Marker ID is " + marker_id);
                        var url = 'php/dispose_modifyrow.php?id='+marker_id+'&status='+new_status;
                        downloadUrl(url, function(data, responseCode) {
                            if (responseCode == 200 && data.length <= 1) {
                                infowindow.close();
                                messagewindow.open(map, marker);
                            }
                        });
                        window.location.reload(true);
                    }

                    function downloadUrl(url, callback) {
                        var request = window.ActiveXObject ?
                            new ActiveXObject('Microsoft.XMLHTTP') :
                            new XMLHttpRequest;

                        request.onreadystatechange = function() {
                        if (request.readyState == 4) {
                            request.onreadystatechange = doNothing;
                            callback(request, request.status);
                        }
                        };

                        request.open('GET', url, true);
                        request.send(null);
                    }



                    function doNothing() {}
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
            <!-- <div id="right_controls">
                <div class="submit_button" onclick="">
                    <a class="button btnFade btnBlueGreen" >SUBMIT</a>
                </div>
                <div class="submit_button" onclick="">
                    <a class="button btnFade btnBlueGreen" >SUBMIT</a>
                </div>
            </div>
            <div id="results"> -->
                
            </div>
            <!-- <form id="entry">
                <input type="text" name="search_entry" class="searchbox" id="address_search"/>
                <div class="submit_button" id="search_submit" onclick="address_search()">
                    <a class="button btnFade btnBlueGreen" >SUBMIT</a>
                </div>
            </form> -->
        </div>
    </body>
</html>