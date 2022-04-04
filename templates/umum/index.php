<?php load_templates('layouts/top-blank') ?>
<div id="map_canvas" style="width: 100%; height: 100vh;"></div>
<?php load_templates('layouts/bottom-blank') ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3_euJs5nXQ2yIloYBgvNTroQa2i9SfUM"></script>
<script type="text/javascript">
    var roles = <?=json_encode($roles)?>;
    function initialize() {
        // Creating map object
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 12,
            center: new google.maps.LatLng(<?=config('latitute')?>, <?=config('longitude')?>),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        // creates a draggable marker to the given coords
        var vMarker, i;
        for (i = 0; i < roles.length; i++) {  
            var role = roles[i]
            vMarker = new google.maps.Marker({
                position: new google.maps.LatLng(role.user.latitute, role.user.longitude),
                map:map
            });

            // vMarker.user_id = role.user.id;

            // adds a listener to the marker
            // gets the coords when drag event ends
            // then updates the input with the new coords
            google.maps.event.addListener(vMarker, 'click', (function (vMarker, i) {
                return function(){
                    location='index.php?r=umum/beli&id='+roles[i].user_id
                }
            })(vMarker, i));
        }
    }
    initialize()
</script>