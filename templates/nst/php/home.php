<?php
/*
Page Name: Admin Home
*/

namespace Templates\MiAdmin\Page;

use Extensions\Mi\Helper;
use PDO;

class Home extends \Templates\MiAdmin\Template
{
    public function __construct()
    {
        parent::__construct();
        $this->data->breadcrumb = array();
        $this->data->breadcrumb[] = (object)array(
            'link' => '/',
            'name' => 'Dashboard'
        );
        $this->helper = new Helper();
        if(@$_POST['ajax'] == 'map') { $this->map(); die; }
        if(@$_POST['ajax'] == 'list') { $this->listt(); die; }
        $this->content();
    }

    public function listt()
    {
        $json = (object)array();
        ob_start();
        if($this->db->query("SELECT * FROM `records` WHERE seen=0")->rowCount() > 0) $json->js = 'updateMap(); var audio = new Audio(\'/assets/siren.mp3\'); audio.play();';
        $records = $this->db->query("SELECT * FROM `records` ORDER by `date` DESC LIMIT 4");
        while($record = $records->fetch(PDO::FETCH_OBJ)) {
            $this->db->query("UPDATE `records` SET seen=1 WHERE id='{$record->id}'");
            ?><tr>
            <th>#<?php echo $record->device_id; ?></th>
            <th><?php echo $record->duration; ?></th>
            <th><?php echo $record->temperature; ?></th>
            <th><?php echo $record->start_date; ?></th>
            </tr>
            <?php
        }
        $json->body = ob_get_clean();

        echo json_encode($json);
    }

    public function map()
    {
        $json = (object) array();
        ob_start();
        ?><script>
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap'
        };

        <!-- Display a map on the page -->
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
        map.setTilt(45);

        <!-- Multiple Markers -->
        var markers = <?php
            $markers = array();
            $devices = $this->db->query("SELECT *, (SELECT icon FROM `status` WHERE id=d.current_status) icon, (SELECT status FROM `status` WHERE id=d.current_status) status FROM `devices` d")->fetchAll(PDO::FETCH_OBJ);
            $i=0; foreach($devices as $device) {
                $i++;
                $markers[] = array(
                    "#{$device->id}",
                    $device->current_lat,
                    $device->current_lng,
                    $device->icon,
                    $i
                );
            }
            echo json_encode($markers);
            ?>;

        <!-- Info Window Content -->
        var infoWindowContent = <?php
            $contents = array(); foreach($devices as $device) {
                $contents[] = array("<div class=\"info_content\">#{$device->id}<br>Status: {$device->status}<br>Last Data: {$this->helper->dateFormat($device->last_update,2)}</div>");
            } echo json_encode($contents) ?>;

        <!-- Display multiple markers on a map -->
        var infoWindow = new google.maps.InfoWindow(), marker, i;

        <!-- Loop through our array of markers & place each one on the map   -->
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            var icon = {
                url: markers[i][3], // url
                scaledSize: new google.maps.Size(14, 14), // scaled size
                origin: new google.maps.Point(0, 0), // origin
                anchor: new google.maps.Point(7, 7) // anchor
            };
            marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: icon,
                title: markers[i][0]
            });

            <!-- Allow each marker to have an info window     -->
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));
            <!-- Automatically center the map fitting all markers on the screen -->
            map.fitBounds(bounds);
        }
        <!-- Override our map zoom level once our fitBounds function runs (Make sure it only runs once) -->
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            this.setZoom(5);
            google.maps.event.removeListener(boundsListener);
        });
        </script><?php
        $js = ob_get_clean();
        $js = str_replace(array('<script>','</script>'),'',$js);
        $json->js = $js;

        echo json_encode($json);
    }

    public function content()
    {
        ?>
        <style>
            body {
                padding: 20px;
            }
            .m-t-20 {
                margin-top: 20px;
            }
        </style>
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <style>
            #map {
                height: 400px;
                margin-top: 20px;
            }
        </style>
        <div id="map"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="card m-t-20">
                    <div class="card-header ">
                        <div class="card-title">Last Records
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="basicTable">
                                <thead>
                                <tr>
                                    <th>Device</th>
                                    <th>Duration</th>
                                    <th>Temperature</th>
                                    <th>Initial Date</th>
                                </tr>
                                </thead>
                                <tbody id="listBody">
                                <?php $records = $this->db->query("SELECT * FROM `records` ORDER by `date` DESC LIMIT 4");
                                while($record = $records->fetch(PDO::FETCH_OBJ)) {
                                    $this->db->query("UPDATE `records` SET seen=1 WHERE id='{$record->id}'");
                                ?><tr>
                                        <th>#<?php echo $record->device_id; ?></th>
                                        <th><?php echo $record->duration; ?></th>
                                        <th><?php echo $record->temperature; ?></th>
                                        <th><?php echo $record->start_date; ?></th>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card m-t-20">
                    <div class="card-header ">
                        <div class="card-title" style="font-size: 18px">Son 1 haftada çıkan orman yangınlarında izlenen incelemelere göre
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-6">
                            <p><i class="fa fa-male fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 17px">3 kişi hayatını kaybetti</span></p>
                            <p><i class="fa fa-linux fa-2x"></i>&nbsp;&nbsp;<span style="font-size: 17px">11 hayvan telef oldu</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="fa fa-tree fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 17px">150 ağaç yok oldu</span></p>
                            <p><i class="fa fa-envira fa-2x"></i>&nbsp;&nbsp;<span style="font-size: 17px">7 hektarlık ölü toprak oluştu</span></p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card m-t-20">
                    <div class="card-header ">
                        <div class="card-title" style="font-size: 18px">Siz de Testimize Telefonlarınızdan Katılabilirsiniz.
                        </div>
                    </div>
                    <div class="card-body">

                        <img src="/assets/qr.png" width="100" style="float:right;">
                        <h1>nst.crmmi.com</h1>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var map;

            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 38.91987, lng: 34.85427},
                    zoom: 6
                });
            }

        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIpeTT8jpIoSgKmxADR4b764cFrh-OAHM&callback=initMap" async defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript">
            function updateMap()
            {
                $.ajax({
                    type: 'POST',
                    url: '',
                    data: {ajax:'map'},
                    dataType: 'json',
                    success: function(json) {
                        eval(json.js);
                    }
                })
                setTimeout(updateMap,40000);
            }
            function updateList()
            {
                $.ajax({
                    type: 'POST',
                    url: '',
                    data: {ajax:'list'},
                    dataType: 'json',
                    success: function(json) {
                        $("#listBody").html(json.body);
                        eval(json.js);
                    }
                })
                setTimeout(updateList,2000);
            }
            updateMap();
            updateList();
        </script>
        <?php
    }
}