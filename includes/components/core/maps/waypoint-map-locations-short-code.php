<?php

namespace Waypoint\Core\Maps;

use Waypoint\Core\Locations\Waypoint_Location_Region_Taxonomy;

class Waypoint_Map_Locations_Code {
	const TAG = 'waypoint_map_locations';

	public function __construct() {
		add_shortcode( static::TAG, [ $this, 'render' ] );
	}

	public function render( $atts ) {

	    if ( isset( $_GET['fl_builder'] ) ) {
	        return 'Map Locations list disabled while editing layout.';
        }

		wp_enqueue_script( 'underscore' );

		$atts = wp_parse_args( $atts, [
			'id' => 0,
            'group_by' => Waypoint_Location_Region_Taxonomy::KEY
		] );

		// Get JSON model.
		$preload = new Waypoint_Map_Preload;
		$json    = $preload->get_map_by_id_json( $atts['id'], $atts['group_by'] );

		ob_start();

		if ( 0 != $atts['id'] ) {
			?>
            <script>
                window.waypoint_map_locations_<?php echo (int) $atts['id']; ?> = <?php echo $json; ?>;
            </script>
			<?php
		}

		?>
        <style>
        </style>
        <div id="waypoint-map-locations-container">
	        <waypoint-map-locations :map-id="<?php echo $atts['id']; ?>"></waypoint-map-locations>
        </div>
		<?php
		return ob_get_clean();
	}
}