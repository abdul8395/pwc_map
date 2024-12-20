<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>1stech Surveillance Map</title>

  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
  <script src="https://unpkg.com/video.js/dist/video.js"></script>
  <script src="https://unpkg.com/@videojs/http-streaming/dist/videojs-http-streaming.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/perliedman-leaflet-control-geocoder/1.9.0/Control.Geocoder.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/perliedman-leaflet-control-geocoder/1.9.0/Control.Geocoder.js"></script>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"  />



  <style>
    body {
      /* background: url('data/banner1.jpg') no-repeat center center fixed; */
      /* background-size: cover; */
      background-size: 100%;
      height: 100vh;
      width: 100%;
      /* margin: 0; */
      display: flex;
      align-items: center;
      justify-content: center;
    }

    #login-form {
      background-color: rgba(255, 255, 255, 0.6);
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      width: 400px;
    }

    #map {
      /* display: none; */
      height: 100vh;
      /* border: 0px solid #ddd; */
      /* border-radius: 10px; */
      width: 100%;
    }
    .map-title {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background-color: rgba(111, 107, 87, 0.72); /* Blue with 50% transparency */
        color: #e4b13c;
        padding: 5px;
        border-radius: 5px;
        z-index: 1000; /* To ensure it stays on top of the map */
    }
    .custom-buttons {
        position: absolute;
        bottom: 10px;
        left: 10px;
        z-index: 1000;
    }
    .modal {
        z-index: 1050;
    }
    .leaflet-popup-content-wrapper {
            background: rgba(255, 255, 255, 1); /* Adjust the alpha (fourth value) for transparency */
    }
    .leaflet-popup-content {
        margin: 1px 1px -6px 1px;
        max-width: 280px;
    }
    
    
     .leaflet-tooltip {
        background-color: Silver; /* Change this to your desired background color */
        color: #2d33e2; /* Change this to your desired text color */
        border: 1px solid #808080; /* Change this to your desired border color */
    }
    .tooltip_moving_vehicles {
        background-color: yellow; /* Change this to your desired background color */
        color: black; /* Change this to your desired text color */
        border: 2px solid #808080; /* Change this to your desired border color */
    }
  </style>
</head>




<body>


  <div id="map">
    <div class="map-title"><img src="data/1stech_logo.png" height="20" width="70" alt=""> ©2024 Interactive Surveillance Map</div>
    <!-- <div class="custom-buttons">
        <div class="btn-group" role="group" aria-label="Map Controls">
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#vehicle_modal">Add Vehicle</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#add_fixcam_modal">Add Camera</button>
            <button type="button" class="btn btn-primary" id="exportall_DBmarkersButton">Export Markers</button>
        </div>
    </div> -->

     <!-- Vehicle Modal -->
    <div class="modal" id="vehicle_modal">
      <div class="modal-dialog">
          <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                  <h4 class="modal-title" style="font-size: 20px; color: red;">Enter Vehicle Details For Mobile Application</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal Body -->
              <div class="modal-body">
                  <div class="form-group">
                      <label for="vehicleNumber">Vehicle Number Plate / Registration Number:</label>
                      <input type="text" class="form-control" id="vehicleNumber" placeholder="Enter Vehicle Number">
                  </div>
                  <div class="form-group">
                    <label for="CameraRTSPURL">Camera MP4 URL:</label>
                    <input type="text" class="form-control" id="CameraRTSPURL" placeholder="Enter Camera MP4 URL">
                  </div>
                  <div class="form-group">
                    <label for="CameraHLSURL">Camera RTSP URL:</label>
                    <input type="text" class="form-control" id="CameraHLSURL" placeholder="Enter Camera RTSP URL">
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="driverName">Driver's Name:</label>
                      <input type="text" class="form-control" id="driverName" placeholder="Enter Driver's Name">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="driverMobile">Driver's Mobile Number:</label>
                      <input type="text" class="form-control" id="driverMobile" placeholder="Enter Driver's Mobile Number">
                    </div>
                  </div>
                  <h6 style="color: red; font-size: 14px;">Ask Driver To Install Provided Mobile Application on His Mobile so that Tracking should start And Use These As Credentials</h6>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="vehicle_username">Username:</label>
                          <input type="text" class="form-control" id="vehicle_username" placeholder="Enter Username">
                      </div>
                      <div class="form-group col-md-6">
                          <label for="vehicle_password">Password:</label>
                          <input type="password" class="form-control" id="vehicle_password" placeholder="Enter Password">
                      </div>
                  </div>
              </div>

              <!-- Modal Footer -->
              <div class="modal-footer">
                  <button type="button" class="btn btn-warning" onclick="VehicleSubmitDetails()">Submit</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>

          </div>
      </div>
    </div>

     <!-- Fixed Camera Modal -->
    <div class="modal" id="add_fixcam_modal">
      <div class="modal-dialog">
          <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                  <h4 class="modal-title" style="font-size: 20px; color: red;">Enter Camera Details</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <!-- Modal Body -->
              <div class="modal-body">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="cameraTitle">Camera Title:</label>
                      <input type="text" class="form-control" id="cameraTitle" placeholder="Enter Camera Title">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="CameraAddress">Camera Identification Number:</label>
                      <input type="text" class="form-control" id="CameraAddress" placeholder="Enter Camera ID">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fixCameraRTSPURL">Camera MP4 URL:</label>
                    <input type="text" class="form-control" id="fixCameraRTSPURL" placeholder="Enter Camera MP4 URL">
                  </div>
                  <div class="form-group">
                    <label for="CameraHLSURL">Camera RTSP URL:</label>
                    <input type="text" class="form-control" id="fixCameraHLSURL" placeholder="Enter Camera RTSP URL">
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="Latitude">Latitude:</label>
                          <input type="number" class="form-control" id="Latitude" placeholder="Enter Latitude">
                      </div>
                      <div class="form-group col-md-6">
                          <label for="Longitude">Longitude:</label>
                          <input type="number" class="form-control" id="Longitude" placeholder="Enter Longitude">
                      </div>
                  </div>
              </div>
              <!-- Modal Footer -->
              <div class="modal-footer">
                  <button type="button" class="btn btn-warning" onclick="CameraSubmitDetails()">Submit</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
    </div>
     <!-- Fixed Camera Modal -->
    <div class="modal" id="edit_fixcam_modal">
      <div class="modal-dialog">
          <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                  <h4 class="modal-title" style="font-size: 20px; color: red;">Edit Camera Details</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <!-- Modal Body -->
              <div class="modal-body">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <input type="text" style="display:none;" class="form-control" id="fixcam_id_hidden">
                      <label for="editcameraTitle">Camera Title:</label>
                      <input type="text" class="form-control" id="editcameraTitle" placeholder="Enter Camera Title">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="editCameraAddress">Camera Identification Number:</label>
                      <input type="text" class="form-control" id="editCameraAddress" placeholder="Enter Camera ID">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="editfixCameraRTSPURL">Camera MP4 URL:</label>
                    <input type="text" class="form-control" id="editfixCameraRTSPURL" placeholder="Enter Camera MP4 URL">
                  </div>
                  <div class="form-group">
                    <label for="editCameraHLSURL">Camera RTSP URL:</label>
                    <input type="text" class="form-control" id="editfixCameraHLSURL" placeholder="Enter Camera RTSP URL">
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="editLatitude">Latitude:</label>
                          <input type="number" class="form-control" id="editLatitude" placeholder="Enter Latitude">
                      </div>
                      <div class="form-group col-md-6">
                          <label for="editLongitude">Longitude:</label>
                          <input type="number" class="form-control" id="editLongitude" placeholder="Enter Longitude">
                      </div>
                  </div>
              </div>
              <!-- Modal Footer -->
              <div class="modal-footer">
                  <button type="button" class="btn btn-warning" onclick="update_fixcam_SubmitDetails()">Submit</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
    </div>
      
    


  </div>



  <script>
 
    var map
    var authenticatedUser = false;
    var animatedMarkers = [];
    var all_polylines=[]
    var clicked_vehicles=[]
    var allfixcamsLayerGroup = L.layerGroup();
    var queta_boundary
    var CSFH_Boundary

    
    var customIcon = L.icon({
          iconUrl: 'data/activeMarker.png', // Replace with the path to your custom PNG marker icon
          iconSize: [30, 37], // Adjust the size of the icon
          iconAnchor: [20, 50], // Adjust the anchor point if needed
          popupAnchor: [1, -34], // Adjust the popup anchor if needed
          tooltipAnchor: [16, -28],
    });
    var carIcon = L.icon({
        iconUrl: 'data/vehicle_point_icon_9.png',  // Replace with the path to your custom car marker icon
        iconSize: [30, 33], // Adjust the size of the icon
        iconAnchor: [20, 50], // Adjust the anchor point if needed
        popupAnchor: [1, -34], // Adjust the popup anchor if needed
        tooltipAnchor: [16, -28],
        
    });





  map = L.map('map', {
    // center: [30.1798, 66.9750],
    // center: [30.001172220530954, 65.5312478542328],
    center: [24.85442917459412, 46.72408103942871],
    zoom: 14,
    attributionControl: false
  });

// Boundary Color

  setTimeout(() => {
    fetch('data/queta_boundary.geojson')
    .then(response => response.json())
    .then(data => {
        // Create a GeoJSON layer and add it to the map
        queta_boundary = L.geoJSON(data, {
            style: function(feature) {
                return {
                    color: 'red',  // Customize the color of the line string
                    weight: 3.5,     // Customize the weight (thickness) of the line
                    opacity: 0.7     // Customize the opacity of the line
                };
            }
        }).addTo(map);
    })
    .catch(error => {
        console.error('Error fetching GeoJSON:', error);
    });
  }, 500);
  
  
  
  // setTimeout(() => {
  //   fetch('data/CSFH_Boundary.geojson')
  //   .then(response => response.json())
  //   .then(data => {
     
  //       CSFH_Boundary = L.geoJSON(data, {
  //           style: function(feature) {
  //               return {
  //                   color: 'red',  // Customize the color of the line string
  //                   weight: 3.5,     // Customize the weight (thickness) of the line
  //                   opacity: 0.7     // Customize the opacity of the line
  //               };
  //           }
  //       }).addTo(map);
  //   })
  //   .catch(error => {
  //       console.error('Error fetching GeoJSON:', error);
  //   });
  // }, 500);

//  queta_boundary = L.geoJSON('data/queta_boundary.geojson', {
//     style: function(feature) {
//         return {
//             color: 'red',  // Customize the color of the line string
//             weight: 5,     // Customize the weight (thickness) of the line
//             opacity: 1     // Customize the opacity of the line
//         };
//     }
// }).addTo(map);

  var geocoder=L.Control.geocoder({
  // defaultMarkGeocode: false,
    collapsed:false,
    position:"topright", 
    // placeholder:"Search Any Address Here...",
    // queryParams: {"countrycodes": "US"},
    geocoder: new L.Control.Geocoder.Nominatim({
    geocodingQueryParams: {
        // "countrycodes": "US"
        }
    })
  })
  geocoder.addTo(map);


  
  var googlestreet   = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
      maxZoom: 21,
      subdomains:['mt0','mt1','mt2','mt3']
      })
      // debugger
      var terrain  = L.tileLayer('http://mt0.google.com/vt/lyrs=p&hl=en&x={x}&y={y}&z={z}');
        var road  = L.tileLayer('https://mt1.google.com/vt/lyrs=h&x={x}&y={y}&z={z}')
      
      var hybrid  = L.tileLayer('http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}');
  var dark  = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png');
  // var dark  = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/dark_all/{z}/{x}/{y}.png');

  var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
              maxZoom: 21,
              subdomains:['mt0','mt1','mt2','mt3']
          }).addTo(map)
  var openstreet   = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');


  var baseLayers = {
     "Google Satellite Map": googleSat,
     "Google Street Map": googlestreet,
     "Open Street Map": openstreet,
     "Hybrid Map": hybrid,   
     "Terrain Map": terrain,
     "Dark Map": dark,
      };
      var overLays = {
        "Places Names": road,
        "All Cameras":allfixcamsLayerGroup
      };

  var mylayercontrol= L.control.layers(baseLayers,overLays,{collapsed:false}).addTo(map);

  var markers = [];

      map.on('click', function(e) {
          console.log(e.latlng);
      });




   var cameraGeoJSON= {"type":"FeatureCollection","features":[{"type":"Feature","properties":{"id":"CAM001","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 1","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 1","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.723903998833435,24.85344148643189],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM002","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 2","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 2","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.724790342321086,24.85535381259257],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM003","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 3","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 3","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.72693726321148,24.854549566874667],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM004","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 4","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 4","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.72660242233832,24.856497619716464],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM005","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 5","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 5","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.723175227521864,24.857176750191485],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM006","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 6","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 6","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.72429792927187,24.85067124189797],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM007","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 7","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 7","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.72343128230753,24.85168998419674],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM008","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 8","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 8","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.722249490991146,24.854013400158195],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM009","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 9","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 9","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.724357018838305,24.856837185419636],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0010","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 10","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 10","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.727134228430685,24.852547865941503],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0011","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 11","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 11","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.726188795377766,24.851296786408597],"type":"Point"},"id":11},{"type":"Feature","properties":{"id":"CAM0012","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 12","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 12","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.72968150753027,24.856535052931676],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0013","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 13","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 13","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.73005848445911,24.854384974400134],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0014","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 14","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 14","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.725806055187974,24.8472291063014],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0015","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 15","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 15","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.72826347042968,24.847118985966077],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0016","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 16","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 16","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.727960085831995,24.859204107785217],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0017","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 17","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 17","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.730205131856366,24.859589490875337],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0018","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 18","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 18","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.71858550175827,24.855955831165105],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0019","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 19","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 19","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.71995073244793,24.849899494416647],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0020","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 20","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 20","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.7237576214643,24.86149750937585],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0021","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 21","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 21","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.722040093025186,24.863558494109554],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0022","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 22","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 22","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.72541979360494,24.865971539711225],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0023","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 23","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 23","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.715003810089854,24.865418455336183],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0024","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 24","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 24","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.71555793244377,24.854761207713906],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0025","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 25","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 25","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.7132864496962,24.854208221408726],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0026","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 26","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 26","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.71262156056102,24.852348159610543],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0027","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 27","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 27","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.71328636183944,24.849733948055274],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0028","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 28","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 28","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.72325897598398,24.844354479595125],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0029","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 29","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 29","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.71838347914414,24.843902134198842],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0030","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 30","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 30","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.73101576520662,24.84777305628829],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0031","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 31","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 31","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.7272480753731,24.84003058107372],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0032","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 32","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 32","camera_status":"\u063a\u064a\u0631 \u0646\u0634\u0637"},"geometry":{"coordinates":[46.72475486069055,24.838572632124496],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0033","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 33","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 33","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.71971315018047,24.837919208476507],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0034","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 34","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 34","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.7177739817493,24.84742121836713],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0035","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 35","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 35","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.72325902271007,24.848627797563807],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0036","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 36","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 36","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.71007321163458,24.86029082170559],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0039","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 39","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 39","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.72614024010619,24.871091057845078],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0040","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 40","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 40","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.719990148017644,24.86676780047253],"type":"Point"}},{"type":"Feature","properties":{"id":"CAM0041","camera_name":"\u0643\u0627\u0645\u064a\u0631\u0627 41","description":"\u0648\u0635\u0641 \u0627\u0644\u0643\u0627\u0645\u064a\u0631\u0627 41","camera_status":"\u0646\u0634\u0637"},"geometry":{"coordinates":[46.7209018179617,24.835089664305485],"type":"Point"}}]}

      // Process the GeoJSON data and add to the camera layer group
      L.geoJSON(cameraGeoJSON, {
        pointToLayer: function (feature, latlng) {
          // Create a marker with the custom icon
          return L.marker(latlng, { icon: customIcon });
        },
        onEachFeature: function (feature, layer) {
          // Extract properties and set up popup content
          const properties = feature.properties || {};
          var mpopup = L.popup({ autoClose: false, closeOnClick: false })
          // .setContent("<iframe src='" + markerData.url + "' style='width:300px; height:200px;'></iframe>");
          .setContent(
            `<b>&ensp; &emsp;Name:</b> ${properties.camera_name}<br>` +
            `<b>&ensp; &emsp;Description:</b>  ${properties.description}<br>`+
            `<b>&ensp; &emsp;Satus:</b>  ${properties.camera_status}<br>`+
            `<iframe width="280" height="240" src="https://www.youtube.com/embed/7dE4IjDQJmE?autoplay=1&controls=1&showinfo=0&modestbranding=1&rel=0&iv_load_policy=3&hl=en&disablekb=1&cc_load_policy=0&loop=1&enablejsapi=1&origin=https%3A%2F%2Fwww.skylinewebcams.com&widgetid=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>`)
          const popupContent = `
            <h4>${properties.name || "Camera"}</h4>
            <p>Location: ${properties.location || "Unknown"}</p>
            <video class="popup-video" controls autoplay muted>
              <source src="${properties.liveFeed || ''}" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          `;
          layer.bindPopup(mpopup);
          layer.bindTooltip("<b>" + properties.camera_name + "</b>", {permanent: true, direction: 'right'}).openTooltip();
        }
      }).addTo(allfixcamsLayerGroup);

      // Add the cameraLayerGroup to the map
      allfixcamsLayerGroup.addTo(map);
        




      function fetchHlsUrlAndSetupPlayer(videoId, rtspUrl) {
          fetch(`/stream?rtspUrl=${encodeURIComponent(rtspUrl)}`)
              .then(response => response.json())
              .then(data => {
                  setupHlsPlayer(videoId, data.hls_url);
              })
              .catch(error => console.error('Error fetching HLS URL:', error));
      }

      function setupHlsPlayer(videoId, hls_url) {
          if (Hls.isSupported()) {
              var video = document.getElementById(videoId);
              var hls = new Hls();
              hls.loadSource(hls_url);
              hls.attachMedia(video);
              hls.on(Hls.Events.MANIFEST_PARSED, function() {
                  video.play();
              });
          } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
              video.src = hls_url;
              video.addEventListener('canplay', function() {
                  video.play();
              });
          }
      }

      // ... [rest of your existing functions for exporting and importing markers] ...

      
      function saveMarkers() {
          var savedMarkers = markers.map(function(marker) {
              return {
                  lat: marker.getLatLng().lat,
                  lng: marker.getLatLng().lng,
                  title: marker.title,
                  url: marker.url
              };
          });
          return savedMarkers;
      }

      function exportMarkers() {
          // var data = saveMarkers();
          // var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(data));
          // var downloadAnchorNode = document.createElement('a');
          // downloadAnchorNode.setAttribute("href", dataStr);
          // downloadAnchorNode.setAttribute("download", "markers.json");
          // document.body.appendChild(downloadAnchorNode);
          // downloadAnchorNode.click();
          // downloadAnchorNode.remove();
      }





      // function importMarkers(event) {
      //         var file = event.target.files[0];
      //         var reader = new FileReader();
      //           reader.onload = function(e) {
      //             var markersData = JSON.parse(e.target.result);
                
              
      //             markersData.forEach(function(markerData) {
      //                 var popup = L.popup({ autoClose: false, closeOnClick: false })
      //                     // .setContent("<iframe src='" + markerData.url + "' style='width:300px; height:200px;'></iframe>");
      //                     .setContent(
      //                       `<b>Camera Title:</b> ${markerData.title}<br>` +
      //                       `<b>Camera ID:</b> ${markerData.cam_id}<br>` +
      //                       `<b>Address:</b> NUML Quetta Campus Road<br>`+
      //                       `<b>Camera Stream:</b><br>`+
      //                       '<div style="width: 290px; height: 250px;"><video-js id="wpt'+markerData.cam_id+'" class="vjs-default-skin" controls="false"  width="280" height="240"> <source src="'+markerData.url+'" type="application/x-mpegURL"></video-js></div>');
      //                 // var player = videojs('my_video_1');
      //                 var marker = L.marker([markerData.lat, markerData.lng],{ icon: customIcon }).addTo(map);
      //                 marker.bindPopup(popup);
      //                 marker.bindTooltip("<b>" + markerData.title + "</b>", {permanent: true, direction: 'right'}).openTooltip();

                    
      //                 marker.cam_id = 'wpt'+markerData.cam_id;
      //                 marker.title = markerData.title;
      //                 marker.url = markerData.url;

      //                   // Attach a click event listener to the marker
      //                 marker.on('click', function () {
      //                     handlefileMarkerClick(marker);
      //                 });
      //                 markers.push(marker);
                      
                    
      //             });
      //             map.setView([30.15908038995321, 66.92562103271486], 12);
      //           };
      //         reader.readAsText(file);
              // moving_trucks()
      // }

      // function handlefileMarkerClick(marker) {
      //     // Your custom logic goes here
      //     console.log('Marker clicked:', marker.title, marker.url);

      //     // ........it will convert & update the latest stream..........
      //     // $.ajax({
      //     //     url: "data/convert_stream.php?camid="+marker.cam_id,
      //     //     type: "POST",
      //     //     success: function callback(resp) {
      //     //         console.log(resp);
      //     //     }
      //     // })

      //     videojs(marker.cam_id);
          
      //     // You can do something specific when a marker is clicked
      // }
      function handle_fixcam_DBMarkerClick(marker) {
        console.log(marker);
        // console.log(marker.cam_id);
          // Your custom logic goes here
          // console.log('Marker clicked:', marker.cam_title, marker.rtsp_url);

          // ........it will convert & update the latest stream..........
          // $.ajax({
          //     url: "data/convert_stream.php?camid="+marker.cam_title,
          //     type: "POST",
          //     success: function callback(resp) {
          //         console.log(resp);
          //     }
          // })

          var player = videojs(marker.cam_id);
              player.play();
          
          // You can do something specific when a marker is clicked
      }

      map.on('popupopen', function (e) {
          var popup = e.popup;

          // var minWidth = 290; // Set your minimum width
          // var minHeight = 250; // Set your minimum height
          // Apply minimum width and height to the popup
          // var popupContentDiv = popup.getContent();
          // popupContentDiv.style.minWidth = minWidth + 'px';
          // popupContentDiv.style.minHeight = minHeight + 'px';

          // videojs('my_video_1');
      });

      // function videojsfunc(){
      //     setTimeout(() => {
      //         videojs('my_video_1');
      //     }, 500);
      // }




      





    // Display login form initially
    if (!authenticatedUser) {
      // document.getElementById('login-form').style.display = 'block';
    }

    setTimeout(() => {
      // loadmarkers_fromDB()   
      // moving_trucks()      
    }, 400);

    function loadmarkers_fromDB() {
      fetch('rest_apis/all_fix_cams_json.php')
          .then(response => response.json())
          .then(mJsonData => {
              // Clear existing markers and lines
              // Call the createMarkers function to generate new markers
              view_all_markers_fromDB(mJsonData);
          });
    }
   function view_all_markers_fromDB(markersData){
      var layers = allfixcamsLayerGroup.getLayers();
      if (layers.length > 0) {
          // Remove all markers from the layer group
          allfixcamsLayerGroup.clearLayers();
          markers=[];
      }
      
      // Camera marker title 
      
      // console.log(markersData);
      markersData.forEach(function(markerData) {
        var popup = L.popup({ autoClose: false, closeOnClick: false })
          // .setContent("<iframe src='" + markerData.url + "' style='width:300px; height:200px;'></iframe>");
          .setContent(
            `<b>&ensp; &emsp;Camera Title:</b> ${markerData.cam_title}<br>` +
            `<b>&ensp; &emsp;Camera Identification Number:</b>  ${markerData.cam_address}<br>`+
            // `<b>Provided RTSP URL:</b>  ${markerData.rtsp_url}<br>`+
            // `<b>Provided HLS URL:</b>  ${markerData.hls_url}<br>`+
            //`<b>Provided Latitude:</b>  ${markerData.lat}<br>`+
            //`<b>Provided Longitude:</b>  ${markerData.lon}<br>`+
            `<button class='btn btn-warning btn-sm btn-block' id='edit_fixcam' onclick="edit_fixcam(`+markerData.id+`)"/><i class="fas fa-edit"></i> Edit this Camera stream parameters</button>`+
            `<button style="margin-top: 0px;" class='btn btn-danger btn-sm btn-block' id='delete_fixcam' onclick="delete_fixcam(`+markerData.id+`)"/><i class="fas fa-trash"></i> Delete this Camera permanently</button>`+
            // `<b>Camera Stream:</b><br>`+
            `<video width="280" height="240" controls="false" autoplay> <source src="`+markerData.rtsp_url+`" type="video/mp4">Your browser does not support the video tag </video>`)
            // '<div style="width: 290px; height: 250px;"><video-js id="wpt'+markerData.id+'" class="vjs-default-skin" controls="false"  width="280" height="240"> <source src="https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8" type="application/x-mpegURL"></video-js></div>');
        // var player = videojs('my_video_1');
        var marker = L.marker([markerData.lat, markerData.lon],{ icon: customIcon })
        marker.bindPopup(popup);
        marker.bindTooltip("<b>" + markerData.cam_title + "</b>", {permanent: true, direction: 'right'}).openTooltip();
        allfixcamsLayerGroup.addLayer(marker);
      
        marker.cam_id = 'wpt'+markerData.id;
        marker.cam_title = markerData.cam_title;
        marker.rtsp_url = markerData.rtsp_url;
        marker.hls_url = markerData.hls_url;
        // Attach a click event listener to the marker
        marker.on('click', function () {
            // handle_fixcam_DBMarkerClick(marker);
        });
        markers.push(marker);
      });
      allfixcamsLayerGroup.addTo(map);
      // map.setView([30.19709961785586, 66.98432922363283], 12);
      
    }

    





      // document.getElementById('exportall_DBmarkersButton').addEventListener('click', function () {
      //     // Example JSON data
      //     fetch('rest_apis/all_fix_cams_json.php')
      //     .then(response => response.json())
      //     .then(mJsonData => {
      //       downloadcsv(mJsonData)
      //     });
      //       function downloadcsv(jsonData){
      //         // Convert JSON to CSV
      //         const csvData = convertJSONToCSV(jsonData);

      //         // Create a Blob containing the CSV data
      //         const blob = new Blob([csvData], { type: 'text/csv' });

      //         // Create a download link
      //         const downloadLink = document.createElement('a');
      //         downloadLink.href = window.URL.createObjectURL(blob);
      //         downloadLink.download = 'data.csv';

      //         // Append the link to the body
      //         document.body.appendChild(downloadLink);

      //         // Trigger the click event on the link
      //         downloadLink.click();

      //         // Remove the link from the body
      //         document.body.removeChild(downloadLink);

      //         function convertJSONToCSV(jsonData) {
      //             const header = Object.keys(jsonData[0]).join(',') + '\n';
      //             const rows = jsonData.map(obj => Object.values(obj).join(',') + '\n');
      //             return header + rows.join('');
      //         }
      //       }
      // });

      





    function VehicleSubmitDetails() {
      var vehicleNumber = $('#vehicleNumber').val();
      var cameraRTSPURL = $("#CameraRTSPURL").val();
      var cameraHLSURL = $("#CameraHLSURL").val();
      var driverName = $('#driverName').val();
      var driverMobile = $('#driverMobile').val();
      var username = $('#vehicle_username').val();
      var password = $('#vehicle_password').val();
      // Create the API URL with the provided data
      var apiUrl = `rest_apis/user_insert.php?vehicle_regno=${encodeURIComponent(vehicleNumber)}&rtsp_url=${encodeURIComponent(cameraRTSPURL)}&hls_url=${encodeURIComponent(cameraHLSURL)}&driver_name=${encodeURIComponent(driverName)}&driver_phoneno=${encodeURIComponent(driverMobile)}&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`;
      console.log(apiUrl);
      // Perform the Ajax call
      $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          // Log the API response
          console.log("API Response:", data);
          alert("Record Submitted Successfully Now Driver can use these credentials to login on CB Vehicle Tracking mobile Application....")
        },
        error: function (error) {
          console.error("API Error:", error);
        }
      });

      // Close the Bootstrap modal after submitting
      $('#vehicle_modal').modal('hide');
      // alert("Record Submitted Successfully Now Driver can use these credentials to login on CB Vehicle Tracking mobile Application....")
    }

    var addedcams=1
    function CameraSubmitDetails() {
      var cameraTitle = $("#cameraTitle").val();
      var cameraAddress = $("#CameraAddress").val();
      var cameraRTSPURL = $("#fixCameraRTSPURL").val();
      var cameraHLSURL = $("#fixCameraHLSURL").val();
      var latitude = $("#Latitude").val();
      var longitude = $("#Longitude").val();

      var apiUrl = `rest_apis/fix_cam_insert.php?cam_title=${encodeURIComponent(cameraTitle)}&cam_address=${encodeURIComponent(cameraAddress)}&rtsp_url=${encodeURIComponent(cameraRTSPURL)}&hls_url=${encodeURIComponent(cameraHLSURL)}&lat=${encodeURIComponent(latitude)}&lon=${encodeURIComponent(longitude)}`;
      console.log(apiUrl);
      // Perform the Ajax call
      $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          // Log the API response
          console.log("API Response:", data);
          loadmarkers_fromDB()
          alert("Fix Camera Record Submitted Successfully....")
          
        },
        error: function (error) {
          console.error("API Error:", error);
        }
      });
 

      $('#add_fixcam_modal').modal('hide');
    }







   












      loadvMarkers();

      function loadvMarkers(){
        fetch('rest_apis/all_vehicles_geojson.php')
            .then(response => response.json())
            .then(geoJsonData => {
                animatedMarkers = [];
                createvMarkers(geoJsonData);
            });
      }
     
      // Vehicle marker title 
      
      function createvMarkers(geoJsonData){
        geoJsonData.features.forEach(function (feature) {
            var carMarker = L.marker([feature.geometry.coordinates[0][1], feature.geometry.coordinates[0][0]], { icon: carIcon }).addTo(map);
            if(feature.properties.user_id<=30)
              {
              carMarker.bindPopup(
                //`<b>User ID:</b> ${feature.properties.user_id}<br>` +
                `<b>&ensp; &emsp;Vehicle Registration Number:</b> ${feature.properties.vehicle_regno}<br>` +
                // `<b>rtsp_url:</b> ${feature.properties.rtsp_url}<br>` +
                //`<b>Driver Name:</b> ${feature.properties.driver_name}<br>` +
                //`<b>Driver Phone No:</b> ${feature.properties.driver_phoneno}<br>` +
                //`<b>Username for Mobile APP:</b> ${feature.properties.username}<br>` +
                //`<b>Password for Mobile APP:</b> ${feature.properties.password}<br>` +
                //`<b>Camera Stream:</b><br>` +
                `<video width="280" height="240" controls="false" autoplay> <source src="http://192.168.18.102:8080/ipc1.mp4" type="video/mp4">Your browser does not support the video tag </video>`
                // '<div style="width: 290px; height: 250px;"><video-js id="wpt' + feature.properties.user_id + '" class="vjs-default-skin" controls="false"  width="280" height="240"> <source src="'+feature.properties.hls_url+'" type="application/x-mpegURL"></video-js></div>'
              );
            }
            else
            {
              carMarker.bindPopup(
                //`<b>User ID:</b> ${feature.properties.user_id}<br>` +
                `<b>&ensp; &emsp;Vehicle Registration Number:</b> ${feature.properties.vehicle_regno}<br>` +
                // `<b>rtsp_url:</b> ${feature.properties.rtsp_url}<br>` +
                //`<b>Driver Name:</b> ${feature.properties.driver_name}<br>` +
                //`<b>Driver Phone No:</b> ${feature.properties.driver_phoneno}<br>` +
                //`<b>Username for Mobile APP:</b> ${feature.properties.username}<br>` +
                //`<b>Password for Mobile APP:</b> ${feature.properties.password}<br>` +
                //`<b>Camera Stream:</b><br>` +
                `<video width="280" height="240" controls="false" autoplay> <source src="http://192.168.18.102:8080/ipc1.mp4" type="video/mp4">Your browser does not support the video tag </video>`
                // '<div style="width: 290px; height: 250px;"><video-js id="wpt' + feature.properties.user_id + '" class="vjs-default-skin" controls="false"  width="280" height="240"> <source src="'+feature.properties.hls_url+'" type="application/x-mpegURL"></video-js></div>'
              );
            }
            var customTooltip = L.tooltip({
            direction: 'right',
            permanent: true, 
            className: 'tooltip_moving_vehicles '// Add custom class for tooltip color
            }).setContent(feature.properties.vehicle_regno);
            // carMarker.bindTooltip("<b class='tooltip_moving_vehicles'>" + feature.properties.vehicle_regno + "</b>", {permanent: true, direction: 'right'}).openTooltip();
            carMarker.bindTooltip(customTooltip).openTooltip();
            // carMarker.bindTooltip("<b>" + feature.properties.vehicle_regno + "</b>", {permanent: true, direction: 'right'}).openTooltip();
             
            animatedMarkers.push({ marker: carMarker });
        });
      }

      setInterval(updatevMarkers, 1000);
     
      function updatevMarkers(){
        fetch('rest_apis/all_vehicles_geojson.php')
          .then(response => response.json())
          .then(geoJsonData => {
            console.log(geoJsonData);
            var index_counter=0;
            geoJsonData.features.forEach(function (feature){
                animatedMarkers[index_counter].marker.setLatLng([feature.geometry.coordinates[0][1], feature.geometry.coordinates[0][0]]);
                var newcoords=[feature.geometry.coordinates[0][1], feature.geometry.coordinates[0][0]]
                // console.log(index_counter);
                index_counter++
            });
          });
          // fetch('rest_apis/all_vehicles_geojson.php')
          // .then(response => {
          //     if (!response.ok) {
          //         throw new Error(`HTTP error! Status: ${response.status}`);
          //     }
          //     return response.json();
          // })
          // .then(resp => {
          //     var index_counter=0;
          //     resp.features.forEach(function (feature){
          //         // animatedMarkers[index_counter].marker.setLatLng([feature.geometry.coordinates[0][1], feature.geometry.coordinates[0][0]]);
          //         var newcoords=[feature.geometry.coordinates[0][1], feature.geometry.coordinates[0][0]]
          //         updateMarkerSmoothly(newcoords, index_counter)
          //         // console.log(index_counter);
          //         index_counter++
          //     });
          //     console.log(resp);
          // })
          // .catch(error => {
          //     console.error('Fetch error:', error);
          // });
      }




       
      // Call the updateMarkers function every 30 seconds
      // setInterval(updateMarkers, 200);

    //   // Create an array to store animated markers and lines
      

    //   // Function to create animated markers and lines
    //   function createMarkers(geoJsonData) {
    //       geoJsonData.features.forEach(function (feature) {
    //       // Create Polyline for the line feature
    //       // var polyline = L.polyline(feature.geometry.coordinates, { color: 'red' }).addTo(map);
    //       var polyline = L.polyline(feature.geometry.coordinates.map(coord => [coord[1], coord[0]]), { color: 'red' })
    //       // console.log(feature.geometry.coordinates[0][1], feature.geometry.coordinates[0][0]);
    //       // Example car marker with custom icon
    //       var carMarker = L.marker([feature.geometry.coordinates[0][1], feature.geometry.coordinates[0][0]], { icon: carIcon }).addTo(map);
    //       if(feature.properties.user_id<=30){
    //         carMarker.bindPopup(
    //           `<b>User ID:</b> ${feature.properties.user_id}<br>` +
    //           `<b>vehicle_regno:</b> ${feature.properties.vehicle_regno}<br>` +
    //           // `<b>rtsp_url:</b> ${feature.properties.rtsp_url}<br>` +
    //           `<b>driver_name:</b> ${feature.properties.driver_name}<br>` +
    //           `<b>driver_phoneno:</b> ${feature.properties.driver_phoneno}<br>` +
    //           `<b>username for Mobile APP:</b> ${feature.properties.username}<br>` +
    //           `<b>password for Mobile APP:</b> ${feature.properties.password}<br>` +
    //           `<b>Camera Stream:</b><br>` +
    //           `<video width="280" height="240" controls="false" autoplay> <source src="http://192.168.18.102:8080/ipc1.mp4" type="video/mp4">Your browser does not support the video tag </video>`
    //           // '<div style="width: 290px; height: 250px;"><video-js id="wpt' + feature.properties.user_id + '" class="vjs-default-skin" controls="false"  width="280" height="240"> <source src="'+feature.properties.hls_url+'" type="application/x-mpegURL"></video-js></div>'
    //         );
    //       }else{
    //         carMarker.bindPopup(
    //           `<b>User ID:</b> ${feature.properties.user_id}<br>` +
    //           `<b>vehicle_regno:</b> ${feature.properties.vehicle_regno}<br>` +
    //           // `<b>rtsp_url:</b> ${feature.properties.rtsp_url}<br>` +
    //           `<b>driver_name:</b> ${feature.properties.driver_name}<br>` +
    //           `<b>driver_phoneno:</b> ${feature.properties.driver_phoneno}<br>` +
    //           `<b>username for Mobile APP:</b> ${feature.properties.username}<br>` +
    //           `<b>password for Mobile APP:</b> ${feature.properties.password}<br>` +
    //           `<b>Camera Stream:</b><br>` +
    //           `<video width="280" height="240" controls="false" autoplay> <source src="`+feature.properties.rtsp_url+`" type="video/mp4">Your browser does not support the video tag </video>`
    //           // '<div style="width: 290px; height: 250px;"><video-js id="wpt' + feature.properties.user_id + '" class="vjs-default-skin" controls="false"  width="280" height="240"> <source src="'+feature.properties.hls_url+'" type="application/x-mpegURL"></video-js></div>'
    //         );
    //       }
    //       carMarker.bindTooltip("<b>" + feature.properties.vehicle_regno + "</b>", {permanent: true, direction: 'right'}).openTooltip();
    //       carMarker.cam_id = 'wpt'+feature.properties.user_id;
    //       carMarker.on('click', function () {

    //           // handleTruckMarkerClick(carMarker);
    //       });

    //       animatedMarkers.push({ marker: carMarker, line: polyline });
    //     });

    //     var index = 0;
    //     var duration = 9000; // Duration in milliseconds

    //     // Set an interval to update the marker's location
    //     setInterval(function () {
    //         animatedMarkers.forEach(function (animatedMarker) {
    //             var lineCoordinates = animatedMarker.line.getLatLngs();
    //             index = (index + 1) % lineCoordinates.length;
    //             var targetLatLng = lineCoordinates[index];
    //             moveMarkerSmoothly(animatedMarker.marker, targetLatLng, duration);
    //         });
    //     }, duration);

    //     function moveMarkerSmoothly(marker, targetLatLng, duration) {
    //         var startLatLng = marker.getLatLng();
    //         var startTime = new Date().getTime();

    //         function animate() {
    //             var currentTime = new Date().getTime();
    //             var elapsed = currentTime - startTime;

    //             if (elapsed < duration) {
    //                 var progress = elapsed / duration;
    //                 var interpolatedLatLng = interpolateLatLng(startLatLng, targetLatLng, progress);
    //                 marker.setLatLng(interpolatedLatLng);
    //                 requestAnimationFrame(animate);
    //             } else {
    //                 marker.setLatLng(targetLatLng);
    //             }
    //         }

    //         animate();
    //     }

    //     function interpolateLatLng(startLatLng, targetLatLng, progress) {
    //         var lat = startLatLng.lat + (targetLatLng.lat - startLatLng.lat) * progress;
    //         var lng = startLatLng.lng + (targetLatLng.lng - startLatLng.lng) * progress;
    //         return L.latLng(lat, lng);
    //     }
      // }










      






















//         // Fetch GeoJSON data from your PHP script
// fetch('rest_apis/all_vehicles_geojson.php')
//     .then(response => response.json())
//     .then(geoJsonData => {
//         // Create an array to store animated markers and lines
//         var animatedMarkers = [];

//         // Loop through each GeoJSON feature and create a moving marker with line
//         geoJsonData.features.forEach(function (feature) {
//             // Create Polyline for the line feature
//             // var polyline = L.polyline(feature.geometry.coordinates, { color: 'red' }).addTo(map);
//             var polyline = L.polyline(feature.geometry.coordinates.map(coord => [coord[1], coord[0]]), { color: 'red' }).addTo(map);

//             // Example car marker with custom icon
//             var carMarker = L.marker([feature.geometry.coordinates[0][1], feature.geometry.coordinates[0][0]], { icon: carIcon }).addTo(map);

//             carMarker.bindPopup(
//                 `<b>User ID:</b> ${feature.properties.user_id}<br>` +
//                 `<b>vehicle_regno:</b> ${feature.properties.vehicle_regno}<br>` +
//                 `<b>rtsp_url:</b> ${feature.properties.rtsp_url}<br>` +
//                 `<b>driver_name:</b> ${feature.properties.driver_name}<br>` +
//                 `<b>driver_phoneno:</b> ${feature.properties.driver_phoneno}<br>` +
//                 `<b>username for Mobile APP:</b> ${feature.properties.username}<br>` +
//                 `<b>password for Mobile APP:</b> ${feature.properties.password}<br>` +
//                 `<b>Camera Stream:</b><br>` +
//                 '<div style="width: 290px; height: 250px;"><video-js id="my_video_' + feature.properties.user_id + '" class="vjs-default-skin" controls="false"  width="280" height="240"> <source src="http://localhost/rtsp_cam_map/live_streams/WPT100/stream.m3u8" type="application/x-mpegURL"></video-js></div>'
//             );

//             carMarker.cam_id = feature.properties.user_id;

//             carMarker.on('click', function () {
//                 handleTruckMarkerClick(carMarker);
//             });

//             animatedMarkers.push({ marker: carMarker, line: polyline });
//         });

//         var index = 0;
//         var duration = 5000; // Duration in milliseconds

//         // Set an interval to update the marker's location
//         setInterval(function () {
//             animatedMarkers.forEach(function (animatedMarker) {
//                 var lineCoordinates = animatedMarker.line.getLatLngs();
//                 index = (index + 1) % lineCoordinates.length;
//                 var targetLatLng = lineCoordinates[index];
//                 moveMarkerSmoothly(animatedMarker.marker, targetLatLng, duration);
//             });
//         }, duration);

//         function moveMarkerSmoothly(marker, targetLatLng, duration) {
//             var startLatLng = marker.getLatLng();
//             var startTime = new Date().getTime();

//             function animate() {
//                 var currentTime = new Date().getTime();
//                 var elapsed = currentTime - startTime;

//                 if (elapsed < duration) {
//                     var progress = elapsed / duration;
//                     var interpolatedLatLng = interpolateLatLng(startLatLng, targetLatLng, progress);
//                     marker.setLatLng(interpolatedLatLng);
//                     requestAnimationFrame(animate);
//                 } else {
//                     marker.setLatLng(targetLatLng);
//                 }
//             }

//             animate();
//         }

//         function interpolateLatLng(startLatLng, targetLatLng, progress) {
//             var lat = startLatLng.lat + (targetLatLng.lat - startLatLng.lat) * progress;
//             var lng = startLatLng.lng + (targetLatLng.lng - startLatLng.lng) * progress;
//             return L.latLng(lat, lng);
//         }
//     });
















        // // Create an array to store animated markers and lines
        // var animatedMarkers = [];

        // // Loop through each GeoJSON feature and create a moving marker with line
        // geoJsonLines.features.forEach(function (feature) {
        //     // Create Polyline for the line feature
        //     var lineCoordinates = feature.geometry.coordinates.map(function(coord) {
        //         return L.latLng(coord[1], coord[0]);
        //     });
        //     var polyline = L.polyline(lineCoordinates, { color: 'black' });

        //     // Example car marker with custom icon
        //     var carMarker = L.marker(lineCoordinates[0], { icon: carIcon }).addTo(map);
        //     // carMarker.bindTooltip("<b>" + feature.properties.truckNumber + "</b>", {permanent: true, direction: 'right'}).openTooltip();
        //     carMarker.bindPopup(
        //         `<b>Vehicle Number:</b> ${feature.properties.truckNumber}<br>` +
        //         `<b>Driver Name:</b> ${feature.properties.driverName}<br>` +
        //         // `<b>Route:</b> ${feature.properties.route}<br>`+
        //         `<b>Camera Stream:</b><br>`+
        //         '<div style="width: 290px; height: 250px;"><video-js id="my_video_1'+feature.properties.truckNumber+'" class="vjs-default-skin" controls="false"  width="280" height="240"> <source src="http://localhost/rtsp_cam_map/live_streams/WPT100/stream.m3u8" type="application/x-mpegURL"></video-js></div>'
        //     );

        //     carMarker.cam_id = feature.properties.truckNumber;

        //     carMarker.on('click', function () {
        //       handleTruckMarkerClick(carMarker);
        //     });


        //     animatedMarkers.push({ marker: carMarker, line: polyline });

        //     var index = 0;
        //     var duration = 5000; // Duration in milliseconds

        //     // Set an interval to update the marker's location
        //     setInterval(function () {
        //         index = (index + 1) % lineCoordinates.length;
        //         var targetLatLng = lineCoordinates[index];
        //         moveMarkerSmoothly(carMarker, targetLatLng, duration);
        //     }, duration);
        // });

        // function moveMarkerSmoothly(marker, targetLatLng, duration) {
        //     var startLatLng = marker.getLatLng();
        //     var startTime = new Date().getTime();

        //     function animate() {
        //         var currentTime = new Date().getTime();
        //         var elapsed = currentTime - startTime;

        //         if (elapsed < duration) {
        //             var progress = elapsed / duration;
        //             var interpolatedLatLng = interpolateLatLng(startLatLng, targetLatLng, progress);
        //             marker.setLatLng(interpolatedLatLng);
        //             requestAnimationFrame(animate);
        //         } else {
        //             marker.setLatLng(targetLatLng);
        //         }
        //     }

        //     animate();
        // }

        // function interpolateLatLng(startLatLng, targetLatLng, progress) {
        //     var lat = startLatLng.lat + (targetLatLng.lat - startLatLng.lat) * progress;
        //     var lng = startLatLng.lng + (targetLatLng.lng - startLatLng.lng) * progress;
        //     return L.latLng(lat, lng);
        // }


        function handleTruckMarkerClick(marker) {
          // Your custom logic goes here
          console.log('Marker clicked:', marker.cam_id);
          clicked_vehicles.push({ vehicle_id: marker.cam_id });
          // ........it will convert & update the latest stream..........
          // $.ajax({
          //     url: "data/convert_stream.php?camid="+marker.cam_id,
          //     type: "POST",
          //     success: function callback(resp) {
          //         console.log(resp);
          //     }
          // })

          // videojs(marker.cam_id);
          
          // You can do something specific when a marker is clicked
        }

    









    function update_fixcam_SubmitDetails() {
      // Retrieve data from input fields
      var fixcamId = $('#fixcam_id_hidden').val();
      var cameraTitle = $('#editcameraTitle').val();
      var cameraAddress = $('#editCameraAddress').val();
      var cameraRTSPURL = $('#editfixCameraRTSPURL').val();
      var cameraHLSURL = $('#editfixCameraHLSURL').val();
      var latitude = $('#editLatitude').val();
      var longitude = $('#editLongitude').val();

      // Make AJAX request to update_fixcam_data_by_id.php
      $.ajax({
          url: 'rest_apis/update_fixcam_data_by_id.php',
          type: 'POST',
          data: {
              fixcam_id_hidden: fixcamId,
              editcameraTitle: cameraTitle,
              editCameraAddress: cameraAddress,
              editfixCameraRTSPURL: cameraRTSPURL,
              editfixCameraHLSURL: cameraHLSURL,
              editLatitude: latitude,
              editLongitude: longitude
          },
          dataType: 'json',
          success: function(response) {
              // Handle response from server
              if (response.success) {
                  // Update successful, display success message or perform any other action
                  alert(response.message);
                  loadmarkers_fromDB()
                  
              } else {
                  // Update failed, display error message or perform any other action
                  alert(response.message);
              }
          },
          error: function(xhr, status, error) {
              // Handle error
              console.error(xhr.responseText);
          }
      });
    }




// function VehicleSubmitDetails() {
//       var vehicleNumber = $('#vehicleNumber').val();
//       var cameraRTSPURL = $("#CameraRTSPURL").val();
//       var cameraHLSURL = $("#CameraHLSURL").val();
//       var driverName = $('#driverName').val();
//       var driverMobile = $('#driverMobile').val();
//       var username = $('#vehicle_username').val();
//       var password = $('#vehicle_password').val();
//       // Create the API URL with the provided data
//       var apiUrl = `rest_apis/user_insert.php?vehicle_regno=${encodeURIComponent(vehicleNumber)}&rtsp_url=${encodeURIComponent(cameraRTSPURL)}&hls_url=${encodeURIComponent(cameraHLSURL)}&driver_name=${encodeURIComponent(driverName)}&driver_phoneno=${encodeURIComponent(driverMobile)}&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`;
//       console.log(apiUrl);
//       // Perform the Ajax call
//       $.ajax({
//         url: apiUrl,
//         method: 'GET',
//         dataType: 'json',
//         success: function (data) {
//           // Log the API response
//           console.log("API Response:", data);
//           loadmarkers_fromDB()
//           alert("Record Submitted Successfully Now Driver can use these credentials to login on CB Vehicle Tracking mobile Application....")
//         },
//         error: function (error) {
//           console.error("API Error:", error);
//         }
//       });

//       // Close the Bootstrap modal after submitting
//       $('#vehicle_modal').modal('hide');
//       // alert("Record Submitted Successfully Now Driver can use these credentials to login on CB Vehicle Tracking mobile Application....")
//     }


  

  </script>

</body>
</html>
