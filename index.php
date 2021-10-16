<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata -->
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes"> 
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    <meta name="author" content="SHAHITA"> 
    <meta name="description" content="leaflet basic">
    <!-- Judul pada tab browser -->
    <title>WEBGIS MINERAL</title>
    <!-- Leaflet CSS Library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
    <!--Geolocation CSS Library for Plugin-->
    <link rel = "stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.css">
    <!--Font Awesome CSS Library-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    <!-- Tab browser icon -->
    <link rel="icon" type="image/x-icon" href="simbol/kelmin.jpg">
    <style>
        /* Tampilan peta fullscreen */
        html,
        body,
        #map {
            height: 100%;
            width: 100%;
            margin: 0px;
        }

        /*Background pada Judul */
        *.info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: rgba(255,255,255,0.8);
            box-shadow:0 0 15px rgba(0,0,0,0.2);
            border-radius: 5px;
            text-align: center;
        }
        *.info h2 {
            margin: 0 0 5px;
            color: #777;
        }
    </style>
</head>
<body>
    <!-- Leaflet JavaScript Library -->
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>

    <!--untuk menampilkan file dalam format geojson-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!--Geolocation Javascript Library for Plugin-->
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js"></script>

    <!--Search CSS Library for Plugin-->
    <link rel="stylesheet" href="aset/plugins/leaflet-search/leaflet-search.css">

    <!--Search Javascript Library for Plugin-->
    <script src="aset/plugins/leaflet-search/leaflet-search.js"></script>

    <div id="map"></div>
    
    <script>
        /* Initial Map */
        var map = L.map('map').setView([-1.850253, 118.876685], 5); //lat, long, zoom

        /* Judul dan Subjudul 
        var title = new L.Control();
        title.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };
        title.update = function () {
            this._div.innerHTML = '<h1>WEBGIS MINERAL</h1>Sebaran Lokasi Potensial Mineral Batuan di Indonesia<h3>Dibuat Oleh: Shahita Kurniady</h3>'
        };
        title.addTo(map); */

        /* Image Logo */
        L.Control.kelmin = L.Control.extend({
             onAdd: function(map) {
                 var img = L.DomUtil.create('img');
                 img.src = 'simbol/min.png';
                 img.style.width = '300px';
                 return img;
             }
         });

         L.control.kelmin = function(opts) {
             return new L.Control.kelmin(opts);
         }
         L.control.kelmin({position: 'topright'}).addTo(map);

        /* Tile Basemap */ 
        var basemap1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
            attribution: '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> | <a href="SIG_UGM" t arget="_blank">SHAHITA</a>' //menambahkan nama//
        });
        var basemap2= L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', { 
                attribution: 'Tiles &copy; Esri | <a href="http://www.unsorry.net" target="_blank">SHAHITA</a>'
            });
        var basemap3= L.tileLayer(
            'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', { 
                attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
            });
        var basemap4= L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}', { 
	            attribution: 'Tiles &copy; Esri &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC',
            });
            
        basemap3.addTo(map);

        /* GeoJSON Point 01 */
        var wfsgeoserver = L.geoJson(null, {
            pointToLayer:function (feature, latlng) {
                return L.marker(latlng, {
                    icon:L.icon({
                        iconUrl:"simbol/amethyst.png", //URL icon marker
                        iconSize: [64, 64], //ukuran icon marker
                        iconAnchor: [16, 32], //icon marker offset
                        popupAnchor: [0, -32], //popup offset
                        tooltipAnchor: [16, -20] //tooltip offset
                    })
                });
            },
            onEachFeature: function (feature, layer) {
                /* Variabel content untuk memanggil atribut dari data file geoJson */
                var content = "No Lokasi :" + feature.properties.No_Lokasi + "<br>" +
                "Kode Unsur :" + feature.properties.Kode_Unsur + "<br>" +
                "Kelompok Komoditas :" + feature.properties.Klmpk_komo + "<br>" +
                "Lokasi :" + feature.properties.Lokasi + "<br>" +
                "Hipotetik :" + feature.properties.Hipotetik + "<br>" +
                "Tereka :" + feature.properties.Tereka + "<br>" +
                "Terukur :" + feature.properties.Terukur + "<br>" +
                "Terkira :" + feature.properties.Terkira + "<br>" +
                "Terbukti :" + feature.properties.Terbukti + "<br>" +
                "Catatan :" + feature.properties.Catatan + "<br>" +
                "Tingkat Penyelidikan :" + feature.properties.Tkt_penyel + "<br>" +
                "Sumber Data :" + feature.properties.Sumbr_data + "<br>" +               
                feature.properties.LOGO;

                layer.on({
                    click: function (e) {//Fungsi ketika icon simbol di-klik
                    wfsgeoserver.bindPopup(content);
                    },

                    mouseover: function(e) {
                        wfsgeoserver.bindTooltip(feature.properties.Lokasi);
                    },

                    mouseout: function(e) {
                        wfsgeoserver.closePopup();
                    }
                });
            }
        }); 
    
        /* memanggil data file geoJson point */
        $.getJSON("geo/amethyst_geo.geojson", function (data) {
            wfsgeoserver.addData(data);
            //map.addLayer(wfsgeoserver);
            //map.fitBounds(wfsgeoserver.getBounds()); pakai start geoserver
        });

        /* GeoJSON Point 02 */
        var wfsgeoserverr = L.geoJson(null, {
            pointToLayer:function (feature, latlng) {
                return L.marker(latlng, {
                    icon:L.icon({
                        iconUrl:"simbol/intan.png", //URL icon marker
                        iconSize: [64, 64], //ukuran icon marker
                        iconAnchor: [16, 32], //icon marker offset
                        popupAnchor: [0, -32], //popup offset
                        tooltipAnchor: [16, -20] //tooltip offset
                    })
                });
            },
            onEachFeature: function (feature, layer) {
                /* Variabel content untuk memanggil atribut dari data file geoJson */
                var content = "No Lokasi :" + feature.properties.No_Lokasi + "<br>" +
                "Kode Unsur :" + feature.properties.Kode_Unsur + "<br>" +
                "Kelompok Komoditas :" + feature.properties.Klmpk_komo + "<br>" +
                "Lokasi :" + feature.properties.Lokasi + "<br>" +
                "Hipotetik :" + feature.properties.Hipotetik + "<br>" +
                "Tereka :" + feature.properties.Tereka + "<br>" +
                "Terukur :" + feature.properties.Terukur + "<br>" +
                "Terkira :" + feature.properties.Terkira + "<br>" +
                "Terbukti :" + feature.properties.Terbukti + "<br>" +
                "Catatan :" + feature.properties.Catatan + "<br>" +
                "Tingkat Penyelidikan :" + feature.properties.Tkt_penyel + "<br>" +
                "Sumber Data :" + feature.properties.Sumbr_data + "<br>" +               
                feature.properties.LOGO;

                layer.on({
                    click: function (e) {//Fungsi ketika icon simbol di-klik
                    wfsgeoserverr.bindPopup(content);
                    },

                    mouseover: function(e) {
                        wfsgeoserverr.bindTooltip(feature.properties.Lokasi);
                    },

                    mouseout: function(e) {
                        wfsgeoserverr.closePopup();
                    }
                });
            }
        }); 
        
        /* memanggil data file geoJson point */
        $.getJSON("geo/intan_geo.geojson", function (data) {
            wfsgeoserverr.addData(data);
            //map.addLayer(wfsgeoserver);
            //map.fitBounds(wfsgeoserver.getBounds()); pakai start geoserver
        });

        /* GeoJSON Point 03 */
        var wfsgeoserverrr = L.geoJson(null, {
            pointToLayer:function (feature, latlng) {
                return L.marker(latlng, {
                    icon:L.icon({
                        iconUrl:"simbol/kalsit.png", //URL icon marker
                        iconSize: [64, 64], //ukuran icon marker
                        iconAnchor: [16, 32], //icon marker offset
                        popupAnchor: [0, -32], //popup offset
                        tooltipAnchor: [16, -20] //tooltip offset
                    })
                });
            },
            onEachFeature: function (feature, layer) {
                /* Variabel content untuk memanggil atribut dari data file geoJson */
                var content = "No Lokasi :" + feature.properties.No_Lokasi + "<br>" +
                "Kode Unsur :" + feature.properties.Kode_Unsur + "<br>" +
                "Kelompok Komoditas :" + feature.properties.Klmpk_komo + "<br>" +
                "Lokasi :" + feature.properties.Lokasi + "<br>" +
                "Hipotetik :" + feature.properties.Hipotetik + "<br>" +
                "Tereka :" + feature.properties.Tereka + "<br>" +
                "Terukur :" + feature.properties.Terukur + "<br>" +
                "Terkira :" + feature.properties.Terkira + "<br>" +
                "Terbukti :" + feature.properties.Terbukti + "<br>" +
                "Catatan :" + feature.properties.Catatan + "<br>" +
                "Tingkat Penyelidikan :" + feature.properties.Tkt_penyel + "<br>" +
                "Sumber Data :" + feature.properties.Sumbr_data + "<br>" +               
                feature.properties.LOGO;

                layer.on({
                    click: function (e) {//Fungsi ketika icon simbol di-klik
                    wfsgeoserverrr.bindPopup(content);
                    },

                    mouseover: function(e) {
                        wfsgeoserverrr.bindTooltip(feature.properties.Lokasi);
                    },

                    mouseout: function(e) {
                        wfsgeoserverrr.closePopup();
                    }
                });
            }
        });
        /* memanggil data file geoJson point */
        $.getJSON("geo/kalsit_geo.geojson", function (data) {
            wfsgeoserverrr.addData(data);
            //map.addLayer(wfsgeoserver);
            //map.fitBounds(wfsgeoserver.getBounds()); pakai start geoserver
        });

        /* GeoJSON Point 04 */
        var wfsgeoserverrrr = L.geoJson(null, {
            pointToLayer:function (feature, latlng) {
                return L.marker(latlng, {
                    icon:L.icon({
                        iconUrl:"simbol/kwarsa.png", //URL icon marker
                        iconSize: [64, 64], //ukuran icon marker
                        iconAnchor: [16, 32], //icon marker offset
                        popupAnchor: [0, -32], //popup offset
                        tooltipAnchor: [16, -20] //tooltip offset
                    })
                });
            },
            onEachFeature: function (feature, layer) {
                /* Variabel content untuk memanggil atribut dari data file geoJson */
                var content = "No Lokasi :" + feature.properties.No_Lokasi + "<br>" +
                "Kode Unsur :" + feature.properties.Kode_Unsur + "<br>" +
                "Kelompok Komoditas :" + feature.properties.Klmpk_komo + "<br>" +
                "Lokasi :" + feature.properties.Lokasi + "<br>" +
                "Hipotetik :" + feature.properties.Hipotetik + "<br>" +
                "Tereka :" + feature.properties.Tereka + "<br>" +
                "Terukur :" + feature.properties.Terukur + "<br>" +
                "Terkira :" + feature.properties.Terkira + "<br>" +
                "Terbukti :" + feature.properties.Terbukti + "<br>" +
                "Catatan :" + feature.properties.Catatan + "<br>" +
                "Tingkat Penyelidikan :" + feature.properties.Tkt_penyel + "<br>" +
                "Sumber Data :" + feature.properties.Sumbr_data + "<br>"+
                feature.properties.LOGO;

                layer.on({
                    click: function (e) {//Fungsi ketika icon simbol di-klik
                    wfsgeoserverrrr.bindPopup(content);
                    },

                    mouseover: function(e) {
                        wfsgeoserverrrr.bindTooltip(feature.properties.Lokasi);
                    },

                    mouseout: function(e) {
                        wfsgeoserverrrr.closePopup();
                    }
                });
            }
        });
        /* memanggil data file geoJson point */
        $.getJSON("geo/kwarsa_geo.geojson", function (data) {
            wfsgeoserverrrr.addData(data);
            //map.addLayer(wfsgeoserver);
            //map.fitBounds(wfsgeoserver.getBounds()); pakai start geoserver
        });

        /* GeoJSON Point 05 */
        var wfsgeoserverrrrr = L.geoJson(null, {
            pointToLayer:function (feature, latlng) {
                return L.marker(latlng, {
                    icon:L.icon({
                        iconUrl:"simbol/opal.png", //URL icon marker
                        iconSize: [64, 64], //ukuran icon marker
                        iconAnchor: [16, 32], //icon marker offset
                        popupAnchor: [0, -32], //popup offset
                        tooltipAnchor: [16, -20] //tooltip offset
                    })
                });
            },
            onEachFeature: function (feature, layer) {
                /* Variabel content untuk memanggil atribut dari data file geoJson */
                var content = "No Lokasi :" + feature.properties.No_Lokasi + "<br>" +
                "Kode Unsur :" + feature.properties.Kode_Unsur + "<br>" +
                "Kelompok Komoditas :" + feature.properties.Klmpk_komo + "<br>" +
                "Lokasi :" + feature.properties.Lokasi + "<br>" +
                "Hipotetik :" + feature.properties.Hipotetik + "<br>" +
                "Tereka :" + feature.properties.Tereka + "<br>" +
                "Terukur :" + feature.properties.Terukur + "<br>" +
                "Terkira :" + feature.properties.Terkira + "<br>" +
                "Terbukti :" + feature.properties.Terbukti + "<br>" +
                "Catatan :" + feature.properties.Catatan + "<br>" +
                "Tingkat Penyelidikan :" + feature.properties.Tkt_penyel + "<br>" +
                "Sumber Data :" + feature.properties.Sumbr_data + "<br>" +               
                feature.properties.LOGO;

                layer.on({
                    click: function (e) {//Fungsi ketika icon simbol di-klik
                    wfsgeoserverrrrr.bindPopup(content);
                    },

                    mouseover: function(e) {
                        wfsgeoserverrrrr.bindTooltip(feature.properties.Lokasi);
                    },

                    mouseout: function(e) {
                        wfsgeoserverrrrr.closePopup();
                    }
                });
            }
        });
        /* memanggil data file geoJson point */
        $.getJSON("geo/opal_geo.geojson", function (data) {
            wfsgeoserverrrrr.addData(data);
            //map.addLayer(wfsgeoserver);
            //map.fitBounds(wfsgeoserver.getBounds()); pakai start geoserver
        });

//       /* Layer Marker */
//    var marker1 = L.marker([5.145000, 95.625000], { 
//             draggable: true 
//         });
//         marker1.addTo(map);
//         marker1.bindPopup("Seulawah Asam"); 

//         var marker2 = L.marker([-3.583000,128.347000]); 
//         marker2.addTo(map);
//         marker2.bindPopup("Tulehu"); 

//         var marker3 = L.marker([-6.799000,107.594000]); 
//         marker3.addTo(map);
//         marker3.bindPopup("Tangkuban Perahu"); */


        /* Control Layer */ 
        var baseMaps = {
            "OpenStreetMap": basemap1,
            "Esri World Street": basemap2,
            "Stadia Dark Mode": basemap3,
            "Natgeo World Map": basemap4
        };
        var overlayMaps = {
            "Amethyst": wfsgeoserver,
            "Intan": wfsgeoserverr,
            "Kalsit": wfsgeoserverrr,
            "Kwarsa": wfsgeoserverrrr,
            "Opal": wfsgeoserverrrrr 
        };
        L.control.layers(baseMaps, overlayMaps, { 
            collapsed: true
        }).addTo(map);

        /* Scale Bar */
        L.control.scale({ 
            maxWidth: 150,
            position: 'bottomright'
        }).addTo(map);

        /* Image Logo */
        L.Control.kelmin = L.Control.extend({
             onAdd: function(map) {
                 var img = L.DomUtil.create('img');
                 img.src = 'simbol/kelmin.jpg';
                 img.style.width = '150px';
                 return img;
             }
         });

         L.control.kelmin = function(opts) {
             return new L.Control.kelmin(opts);
         }
         L.control.kelmin({position: 'bottomleft'}).addTo(map);


        /* Image Legend */
        L.Control.Legend = L.Control.extend({
            onAdd: function(map) {
                var img = L.DomUtil.create('img');
                img.src = 'simbol/legenda.JPG';
                img.style.width = '150px';
                return img;
            }
        });
        L.control.Legend = function(opts) {
            return new L.Control.Legend(opts);
        }
        L.control.Legend({position: 'bottomleft'}).addTo(map);


        /* Image Wind Direction */
        L.Control.Watermark = L.Control.extend({
             onAdd: function(map) {
                 var img = L.DomUtil.create('img');
                 img.src = 'simbol/b.png';
                 img.style.width = '135px';
                 return img;
             }
         });

         L.control.watermark = function(opts) {
             return new L.Control.Watermark(opts);
         }
         L.control.watermark({position: 'bottomright'}).addTo(map);


        /* Plugin Geolocation */ //menambahkan plugin geolocation
        var locateControl = L.control.locate({
            position: "topleft", //posisi plugin
            drawCircle: true,
            follow: true,
            setView: true, 
            keepCurrentZoomLevel: false,
            markerStyle: {
                weight:1, //ukuran
                opacity: 0.8, //transparansi
                fillOpacity: 0.8,
            },
            circleStyle: {
                weight: 1,
                clickable: false,
            },
            icon: "fas fa-crosshairs",
            metric: true,
            strings: {
                title: "Click for Your Location", //popup yang muncul
                popup: "You're here. Accuracy {distance} {unit}", //message menampilkan akurasi
                outsideMapBoundsMsg: "Not available"
            },
            locateOptions: {
                maxZoom: 16, //perbesaran maksimal 16x
                watch: true,
                enableHighAccuracy: true,
                maximumAge: 10000,
                timeout: 10000
            },
        }).addTo(map);

         /* Plugin Search *///menambahkan plugin search
         var searchControl = new L.Control.Search({
            position: "topleft",
            layer: wfsgeoserverrrr,
            propertyName: 'Lokasi',
            marker: true,
            moveToLocation: function(latlng, title, map) {
                var zoom = map.getBoundsZoom(latlng.layer.getBounds());
                map.setView(latlng, zoom);
            }
        });
        searchControl.on('search:locationfound', function(e) {
            e.layer.setStyle({
                fillColor: '#ffff00',
                color: '#0000ff'
            });
        }).on('search:collapsed', function(e) {
            featuresLayer.eachLayer(function(layer) {
                featuresLayer.resetStyle(layer);
            });
        });
        map.addControl(searchControl);

    </script>
</body>
</html>