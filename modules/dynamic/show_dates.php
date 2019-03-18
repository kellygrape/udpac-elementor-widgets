<?php
use Elementor\Controls_Manager;
Class Elementor_Show_Dates_Tag extends \Elementor\Core\DynamicTags\Tag {

	/**
	* Get Name
	*
	* Returns the Name of the tag
	*
	* @since 2.0.0
	* @access public
	*
	* @return string
	*/
	public function get_name() {
		return 'show-dates';
	}

	/**
	* Get Title
	*
	* Returns the title of the Tag
	*
	* @since 2.0.0
	* @access public
	*
	* @return string
	*/
	public function get_title() {
		return __( 'ACF - Show Dates', 'elementor-pro' );
	}

	/**
	* Get Group
	*
	* Returns the Group of the tag
	*
	* @since 2.0.0
	* @access public
	*
	* @return string
	*/
	public function get_group() {
		return 'udpac-fields';
	}

	/**
	* Get Categories
	*
	* Returns an array of tag categories
	*
	* @since 2.0.0
	* @access public
	*
	* @return array
	*/
	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
	}

	/**
	* Register Controls
	*
	* Registers the Dynamic tag controls
	*
	* @since 2.0.0
	* @access protected
	*
	* @return void
	*/
	protected function _register_controls() {
        // todo - let user pick if they want to show the dates as a list or as a range

		$this->add_control(
			'list_type',
			[
				'label'   => __( 'List Type', 'elementor-custom-widget' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date-range',
				'options' => [
					'date-range' => __( 'Date Range (Opening Night - Closing Night)', 'elementor-custom-widget' ),
                    'date-list' => __( 'List of all dates', 'elementor-custom-widget' )
				]
			]
		);
    }

	/**
	* Render
	*
	* Prints out the value of the Dynamic tag
	*
	* @since 2.0.0
	* @access public
	*
	* @return void
	*/
	public function render() {
        $settings = $this->get_settings_for_display();
		$list_type = !empty( $settings['list_type'] ) ? $settings['list_type'] : 'date-range';

        $dates = [];
        if(have_rows('show_dates')):
          $showDates = get_field('show_dates');
          for($j = 0; $j < count($showDates); $j++){
              $dates[$j] = array(
                'date' => $showDates[$j]['date'],
                'time' => $showDates[$j]['time'],
                'sold_out' => $showDates[$j]['sold_out']
            );
          }
        endif;

        if(count($dates) < 1) {
            return;
        }

        $opendate = DateTime::createFromFormat('Ymd', get_field('opening_night'));
        $closedate = DateTime::createFromFormat('Ymd', get_field('closing_night'));

		var_dump(get_field('closing_night'));
        if ($list_type === 'date-range') {
            echo '<span class="datespan">';

            if(count($dates) === 1) {
                echo $opendate->format('F d, Y');
            } else {
                echo $opendate->format('F d, Y') . ' - ' . $closedate->format('F d, Y');
            }
            echo '</span>';
        } else {
            echo '<ul class="dateslist">';
            for ($i = 0; $i < count($dates); $i++) {
                if($i == 0):
                  $datestring = $opendate->format('Y-m-d');
                  $datestring .= 'T'.date('H:i',strtotime($dates[$i]['time']));
                endif;

                echo '<li>';
                echo '<span class="thedate">';
                echo date('D M j, Y',strtotime($dates[$i]['date']));
                echo '</span>';
                echo '<span class="thetime">' . date('g:i a',strtotime($dates[$i]['time'])) . '</span>';
                if($dates[$i]['sold_out'] == '1'){
                    echo '<span class="soldout">Tickets sold out for this performance</span>';
                }
                echo '</li>';
            }
            echo '</ul>';
        }
		//echo wp_kses_post( $value );
	}
}
