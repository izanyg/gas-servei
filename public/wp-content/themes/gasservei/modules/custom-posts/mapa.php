<?php

$dist = new WP_Query(array(
    "post_type" => "distribuidores",
    "posts_per_page" => -1,
));
?>
<script>
    var markers = [];
    <?php while ($dist->have_posts()) : $dist->the_post();

        while (have_rows('adreces')) : the_row();

            $loc = get_sub_field("localitzacio");
            $type= get_sub_field("tipo");
            // var_dump($type);

            if(isset($type) && $type == 'Sede'){
              $type_str = 'sede';
            }else{
              $type_str = 'marker';
            }


            ?>
            var marker = Array();

            <?php if(!empty($loc["lat"])):?>

                marker["lat"] = "<?php echo $loc["lat"];?>";
                marker["lng"] = "<?=$loc["lng"];?>";
                marker["id"] =<?=get_the_ID();?>;
                  marker["icon"] = '<?php echo get_stylesheet_directory_uri(); ?>/images/<?php echo $type_str; ?>.png';
                marker["contents"] = '<h2><?=get_the_title();?></h2> <?php echo str_replace(array("\r", "\n"), "", get_sub_field("adreca_completa"));?>';
                markers.push(marker);

            <?php endif;?>

        <?php endwhile;

    endwhile;

    wp_reset_postdata();
    //afegim sedes
    // check if the repeater field has rows of data
    if( have_rows('seus', 'option') ):
        // loop through the rows of data
        while ( have_rows('seus', 'option') ) : the_row();
            $location = get_sub_field('maps', 'option');
            ?>
            var marker = Array();
            // display a sub field value
            marker["lat"] = "<?php echo $location["lat"];?>";
            marker["lng"] = "<?=$location["lng"];?>";
            marker["id"] = 54;
            marker["icon"] = '/favicon.png';
            marker["contents"] = '<h2><?=get_sub_field("titol");?></h2> <?php echo str_replace(array("\r", "\n"), "", get_sub_field("dades"));?>';
            markers.push(marker);
        <?php
        endwhile;
    else :
        // no rows found
    endif;

    ?>
</script>

<div id="map" style="width: 100%;height: 400px;"></div>

<script>
    function initializeMap() {

        var uluru = {lat: 40.4381311, lng: -3.8196196};
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: uluru,
            styles: [
                {
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        }
                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        }
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#bdbdbd"
                        }
                    ]
                },
                {
                    "featureType": "administrative.province",
                    "stylers": [
                        {
                            "color": "#fd5a00"
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#eeeeee"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "poi.business",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#e5e5e5"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#dadada"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative.province",
                    "stylers": [
                        {
                            "color": "#fd5a00"
                        },
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                },
                {
                    "featureType": "transit.line",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#e5e5e5"
                        }
                    ]
                },
                {
                    "featureType": "transit.station",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#eeeeee"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#c9c9c9"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                }
            ]
        });
        var infowindow = new google.maps.InfoWindow();
        for (i = 0; i < markers.length; i++) {
            var position = new google.maps.LatLng(markers[i].lat, markers[i].lng);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: markers[i]["icon"],
                title: markers[i]["asa" + i]
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(markers[i].contents);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }

    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaDb7lUF_AuRN6gEqavXxTHLIZLxnemj0&callback=initializeMap"
         async defer></script>