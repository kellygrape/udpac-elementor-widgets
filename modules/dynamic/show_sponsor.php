<?php
use Elementor\Controls_Manager;
Class Elementor_Show_Sponsor_Tag extends \Elementor\Core\DynamicTags\Tag {

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
		return 'show-sponsor';
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
		return __( 'ACF - Show Sponsor', 'elementor-pro' );
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

        if(have_rows('show_sponsors')):
			echo '<h3>Show Sponsors</h3>';
			echo '<ul>';
		    while ( have_rows('show_sponsors') ) : the_row();
				$image = get_sub_field('sponsor_logo');
				$link = get_sub_field('sponsor_link');
				if(!empty($image)) {
					echo '<li>';
					if(!empty($link)): echo '<a href="'.$link.'">';
					endif;

					if( !empty($image) ): echo '<img src="'.$image['url'].'" alt="'.get_sub_field('sponsor_name').'" />';
					else: echo get_sub_field('sponsor_name');
					endif;

					if(!empty($link)): echo '</a>';
					endif;
					echo '</li>';
				}
		    endwhile;
		    echo '</ul>';
        endif;
	}
}
