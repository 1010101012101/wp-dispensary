<?php
/**
 * The file that builds the widgets to display recent items from each custom post type
 *
 * @link       http://www.wpdispensary.com
 * @since      1.0.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin/post-types/
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// Create custom featured image size for the widget
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'wpdispensary-widget', 312, 156, true );
}

/**
 * WP Dispensary Flowers Widget
 *
 * @since       1.0.0
 */
class wpdispensary_flowers_widget extends WP_Widget {

    /**
     * Constructor
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function wpdispensary_flowers_widget() {
        parent::WP_Widget(
            false,
            __( 'Recent Flowers', 'wp-dispensary' ),
            array(
                'description'  => __( 'Your dispensaries most recent Flowers', 'wp-dispensary' )
            )
        );
    }

    /**
     * Widget definition
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::widget
     * @param       array $args Arguments to pass to the widget
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function widget( $args, $instance ) {
        if( ! isset( $args['id'] ) ) {
            $args['id'] = 'wpdispensary_flowers_widget';
        }

        $title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

        echo $args['before_widget'];

        if( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        do_action( 'wpdispensary_flowers_before_widget' );

			if( ! 'on' == $instance['featuredimage'] ) {
				echo "<ul class='wpdispensary-list'>";
			}
			
			$wpdispensary_flowers_widget = new WP_Query(
				array(
					'post_type' => 'flowers',
					'showposts' => $instance['limit']
				)
			);

			while ( $wpdispensary_flowers_widget->have_posts() ) : $wpdispensary_flowers_widget->the_post();
			
			$do_not_duplicate = $post->ID;

			if('on' == $instance['featuredimage'] ) {
				
				echo "<div class='wpdispensary-widget'>";
					echo "<a href='" . get_permalink( $post->ID ) ."'>";
						the_post_thumbnail( 'wpdispensary-widget' );
					echo "</a>";
				if('on' == $instance['flowername'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . get_permalink( $post->ID ) ."'>". get_the_title( $post->ID ) ."</a></span>";
				}
				if('on' == $instance['flowercategory'] ) {
					echo "<span class='wpdispensary-widget-categories'>". get_the_term_list( $post->ID, 'flowers_category' ) ."</a></span>";
				}
				echo "</div>";
				
			} else {
				
				echo "<li>";
				if('on' == $instance['flowername'] ) {
					echo "<a href='" . get_permalink( $post->ID ) ."' class='wpdispensary-widget-link'>". get_the_title( $post->ID ) ."</a>";
				}
				echo "</li>";
				
			}

			endwhile; // end loop
			
			if( ! 'on' == $instance['featuredimage'] ) {
				echo "</ul>";
			}

        do_action( 'wpdispensary_flowers_after_widget' );
        
        echo $args['after_widget'];
    }


    /**
     * Update widget options
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::update
     * @param       array $new_instance The updated options
     * @param       array $old_instance The old options
     * @return      array $instance The updated instance options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']      	= strip_tags( $new_instance['title'] );
        $instance['limit']   		= strip_tags( $new_instance['limit'] );
        $instance['featuredimage']	= $new_instance['featuredimage'];
        $instance['flowername']		= $new_instance['flowername'];
        $instance['flowercategory']	= $new_instance['flowercategory'];

        return $instance;
    }


    /**
     * Display widget form on dashboard
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::form
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function form( $instance ) {
        $defaults = array(
            'title'    			=> 'Recent Flowers',
            'limit'  			=> '5',
            'featuredimage'		=> '',
            'flowername' 		=> '',
            'flowercategory' 	=> ''
        );

        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title:', 'wp-dispensary' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
		
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Amount of flowers to show:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo $instance['limit']; ?>" />
        </p>
		
	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['featuredimage'], 'on'); ?> id="<?php echo $this->get_field_id('featuredimage'); ?>" name="<?php echo $this->get_field_name('featuredimage'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php _e( 'Display featured image?', 'wp-dispensary' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['flowername'], 'on'); ?> id="<?php echo $this->get_field_id('flowername'); ?>" name="<?php echo $this->get_field_name('flowername'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'flowername' ) ); ?>"><?php _e( 'Display flower name?', 'wp-dispensary' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['flowercategory'], 'on'); ?> id="<?php echo $this->get_field_id('flowercategory'); ?>" name="<?php echo $this->get_field_name('flowercategory'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'flowercategory' ) ); ?>"><?php _e( 'Display flower category?', 'wp-dispensary' ); ?></label>
        </p>

		<?php
    }
}

/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdispensary_flowers_register_widget() {
    register_widget( 'wpdispensary_flowers_widget' );
}
add_action( 'widgets_init', 'wpdispensary_flowers_register_widget' );


/**
 * WP Dispensary Conentrates Widget
 *
 * @since       1.0.0
 */
class wpdispensary_concentrates_widget extends WP_Widget {

    /**
     * Constructor
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function wpdispensary_concentrates_widget() {
        parent::WP_Widget(
            false,
            __( 'Recent Concentrates', 'wp-dispensary' ),
            array(
                'description'  => __( 'Your dispensaries most recent Concentrates', 'wp-dispensary' )
            )
        );
    }

    /**
     * Widget definition
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::widget
     * @param       array $args Arguments to pass to the widget
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function widget( $args, $instance ) {
        if( ! isset( $args['id'] ) ) {
            $args['id'] = 'wpdispensary_concentrates_widget';
        }

        $title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

        echo $args['before_widget'];

        if( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        do_action( 'wpdispensary_concentrates_before_widget' );

			if( ! 'on' == $instance['featuredimage'] ) {
				echo "<ul class='wpdispensary-list'>";
			}
			
			$wpdispensary_concentrates_widget = new WP_Query(
				array(
					'post_type' => 'concentrates',
					'showposts' => $instance['limit']
				)
			);

			while ( $wpdispensary_concentrates_widget->have_posts() ) : $wpdispensary_concentrates_widget->the_post();
			
			$do_not_duplicate = $post->ID;

			if('on' == $instance['featuredimage'] ) {
				
				echo "<div class='wpdispensary-widget'>";
					echo "<a href='" . get_permalink( $post->ID ) ."'>";
						the_post_thumbnail( 'wpdispensary-widget' );
					echo "</a>";
				if('on' == $instance['concentratename'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . get_permalink( $post->ID ) ."'>". get_the_title( $post->ID ) ."</a></span>";
				}
				if('on' == $instance['concentratecategory'] ) {
					echo "<span class='wpdispensary-widget-categories'>". get_the_term_list( $post->ID, 'concentrates_category' ) ."</a></span>";
				}
				echo "</div>";
				
			} else {
				
				echo "<li>";
				if('on' == $instance['concentratename'] ) {
					echo "<a href='" . get_permalink( $post->ID ) ."' class='wpdispensary-widget-link'>". get_the_title( $post->ID ) ."</a>";
				}
				echo "</li>";
				
			}

			endwhile; // end loop
			
			if( ! 'on' == $instance['featuredimage'] ) {
				echo "</ul>";
			}

        do_action( 'wpdispensary_concentrates_after_widget' );
        
        echo $args['after_widget'];
    }


    /**
     * Update widget options
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::update
     * @param       array $new_instance The updated options
     * @param       array $old_instance The old options
     * @return      array $instance The updated instance options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']      			= strip_tags( $new_instance['title'] );
        $instance['limit']   				= strip_tags( $new_instance['limit'] );
        $instance['featuredimage']			= $new_instance['featuredimage'];
        $instance['concentratename']		= $new_instance['concentratename'];
        $instance['concentratecategory']	= $new_instance['concentratecategory'];

        return $instance;
    }


    /**
     * Display widget form on dashboard
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::form
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function form( $instance ) {
        $defaults = array(
            'title'    				=> 'Recent Concentrates',
            'limit'  				=> '5',
            'featuredimage'			=> '',
            'concentratename' 		=> '',
            'concentratercategory' 	=> ''
        );

        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title:', 'wp-dispensary' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
		
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Amount of concentrates to show:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo $instance['limit']; ?>" />
        </p>
		
	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['featuredimage'], 'on'); ?> id="<?php echo $this->get_field_id('featuredimage'); ?>" name="<?php echo $this->get_field_name('featuredimage'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php _e( 'Display featured image?', 'wp-dispensary' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['concentratename'], 'on'); ?> id="<?php echo $this->get_field_id('concentratename'); ?>" name="<?php echo $this->get_field_name('concentratename'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'concentratename' ) ); ?>"><?php _e( 'Display concentrate name?', 'wp-dispensary' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['concentratecategory'], 'on'); ?> id="<?php echo $this->get_field_id('concentratecategory'); ?>" name="<?php echo $this->get_field_name('concentratecategory'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'concentratecategory' ) ); ?>"><?php _e( 'Display concentrate category?', 'wp-dispensary' ); ?></label>
        </p>

		<?php
    }
}

/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdispensary_concentrates_register_widget() {
    register_widget( 'wpdispensary_concentrates_widget' );
}
add_action( 'widgets_init', 'wpdispensary_concentrates_register_widget' );


/**
 * WP Dispensary Edibles Widget
 *
 * @since       1.0.0
 */
class wpdispensary_edibles_widget extends WP_Widget {

    /**
     * Constructor
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function wpdispensary_edibles_widget() {
        parent::WP_Widget(
            false,
            __( 'Recent Edibles', 'wp-dispensary' ),
            array(
                'description'  => __( 'Your dispensaries most recent Edibles', 'wp-dispensary' )
            )
        );
    }

    /**
     * Widget definition
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::widget
     * @param       array $args Arguments to pass to the widget
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function widget( $args, $instance ) {
        if( ! isset( $args['id'] ) ) {
            $args['id'] = 'wpdispensary_edibles_widget';
        }

        $title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

        echo $args['before_widget'];

        if( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        do_action( 'wpdispensary_edibles_before_widget' );

			if( ! 'on' == $instance['featuredimage'] ) {
				echo "<ul class='wpdispensary-list'>";
			}
			
			$wpdispensary_edibles_widget = new WP_Query(
				array(
					'post_type' => 'edibles',
					'showposts' => $instance['limit']
				)
			);

			while ( $wpdispensary_edibles_widget->have_posts() ) : $wpdispensary_edibles_widget->the_post();
			
			$do_not_duplicate = $post->ID;

			if('on' == $instance['featuredimage'] ) {
				
				echo "<div class='wpdispensary-widget'>";
					echo "<a href='" . get_permalink( $post->ID ) ."'>";
						the_post_thumbnail( 'wpdispensary-widget' );
					echo "</a>";
				if('on' == $instance['ediblename'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . get_permalink( $post->ID ) ."'>". get_the_title( $post->ID ) ."</a></span>";
				}
				if('on' == $instance['ediblecategory'] ) {
					echo "<span class='wpdispensary-widget-categories'>". get_the_term_list( $post->ID, 'edibles_category' ) ."</a></span>";
				}
				echo "</div>";
				
			} else {
				
				echo "<li>";
				if('on' == $instance['ediblename'] ) {
					echo "<a href='" . get_permalink( $post->ID ) ."' class='wpdispensary-widget-link'>". get_the_title( $post->ID ) ."</a>";
				}
				echo "</li>";
				
			}

			endwhile; // end loop
			
			if( ! 'on' == $instance['featuredimage'] ) {
				echo "</ul>";
			}

        do_action( 'wpdispensary_edibles_after_widget' );
        
        echo $args['after_widget'];
    }


    /**
     * Update widget options
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::update
     * @param       array $new_instance The updated options
     * @param       array $old_instance The old options
     * @return      array $instance The updated instance options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']      	= strip_tags( $new_instance['title'] );
        $instance['limit']   		= strip_tags( $new_instance['limit'] );
        $instance['featuredimage']	= $new_instance['featuredimage'];
        $instance['ediblename']		= $new_instance['ediblename'];
        $instance['ediblecategory']	= $new_instance['ediblecategory'];

        return $instance;
    }


    /**
     * Display widget form on dashboard
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::form
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function form( $instance ) {
        $defaults = array(
            'title'    			=> 'Recent Edibles',
            'limit'  			=> '5',
            'featuredimage'		=> '',
            'flowername' 		=> '',
            'flowercategory' 	=> ''
        );

        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title:', 'wp-dispensary' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
		
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Amount of edibles to show:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo $instance['limit']; ?>" />
        </p>
		
	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['featuredimage'], 'on'); ?> id="<?php echo $this->get_field_id('featuredimage'); ?>" name="<?php echo $this->get_field_name('featuredimage'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php _e( 'Display featured image?', 'wp-dispensary' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['ediblename'], 'on'); ?> id="<?php echo $this->get_field_id('ediblename'); ?>" name="<?php echo $this->get_field_name('ediblename'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'ediblename' ) ); ?>"><?php _e( 'Display edible name?', 'wp-dispensary' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['ediblecategory'], 'on'); ?> id="<?php echo $this->get_field_id('ediblecategory'); ?>" name="<?php echo $this->get_field_name('ediblecategory'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'ediblecategory' ) ); ?>"><?php _e( 'Display edible category?', 'wp-dispensary' ); ?></label>
        </p>

		<?php
    }
}


/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdispensary_edibles_register_widget() {
    register_widget( 'wpdispensary_edibles_widget' );
}
add_action( 'widgets_init', 'wpdispensary_edibles_register_widget' );


/**
 * WP Dispensary Pre-Rolls Widget
 *
 * @since       1.0.0
 */
class wpdispensary_prerolls_widget extends WP_Widget {

    /**
     * Constructor
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function wpdispensary_prerolls_widget() {
        parent::WP_Widget(
            false,
            __( 'Recent Pre-Rolls', 'wp-dispensary' ),
            array(
                'description'  => __( 'Your dispensaries most recent Pre-Rolls', 'wp-dispensary' )
            )
        );
    }

    /**
     * Widget definition
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::widget
     * @param       array $args Arguments to pass to the widget
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function widget( $args, $instance ) {
        if( ! isset( $args['id'] ) ) {
            $args['id'] = 'wpdispensary_prerolls_widget';
        }

        $title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

        echo $args['before_widget'];

        if( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        do_action( 'wpdispensary_prerolls_before_widget' );

			if( ! 'on' == $instance['featuredimage'] ) {
				echo "<ul class='wpdispensary-list'>";
			}
			
			$wpdispensary_edibles_widget = new WP_Query(
				array(
					'post_type' => 'prerolls',
					'showposts' => $instance['limit']
				)
			);

			while ( $wpdispensary_edibles_widget->have_posts() ) : $wpdispensary_edibles_widget->the_post();
			
			$do_not_duplicate = $post->ID;

			if('on' == $instance['featuredimage'] ) {
				
				echo "<div class='wpdispensary-widget'>";
					echo "<a href='" . get_permalink( $post->ID ) ."'>";
						the_post_thumbnail( 'wpdispensary-widget' );
					echo "</a>";
				if('on' == $instance['prerollname'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . get_permalink( $post->ID ) ."'>". get_the_title( $post->ID ) ."</a></span>";
				}
				if('on' == $instance['prerollflower'] ) {
					$prerollflower = get_post_meta(get_the_id(), '_selected_flowers', true); 
					echo "<span class='wpdispensary-widget-categories'>";
					echo "<a href='". get_permalink($prerollflower) ."'>". get_the_title($prerollflower) ."</a>";
					echo "</span>";
				}
				echo "</div>";
				
			} else {
				
				echo "<li>";
				if('on' == $instance['prerollname'] ) {
					echo "<a href='" . get_permalink( $post->ID ) ."' class='wpdispensary-widget-link'>". get_the_title( $post->ID ) ."</a>";
				}
				echo "</li>";
				
			}

			endwhile; // end loop
			
			if( ! 'on' == $instance['featuredimage'] ) {
				echo "</ul>";
			}

        do_action( 'wpdispensary_prerolls_after_widget' );
        
        echo $args['after_widget'];
    }


    /**
     * Update widget options
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::update
     * @param       array $new_instance The updated options
     * @param       array $old_instance The old options
     * @return      array $instance The updated instance options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']      		= strip_tags( $new_instance['title'] );
        $instance['limit']   			= strip_tags( $new_instance['limit'] );
        $instance['featuredimage']		= $new_instance['featuredimage'];
        $instance['prerollname']		= $new_instance['prerollname'];
        $instance['prerollcategory']	= $new_instance['prerollcategory'];
        $instance['prerollflower']		= $new_instance['prerollflower'];

        return $instance;
    }


    /**
     * Display widget form on dashboard
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::form
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function form( $instance ) {
        $defaults = array(
            'title'    			=> 'Recent Pre-Rolls',
            'limit'  			=> '5',
            'featuredimage'		=> '',
            'prerollname' 		=> '',
            'prerollcategory' 	=> '',
            'prerollflower' 	=> ''
        );

        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title:', 'wp-dispensary' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
		
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Amount of pre-rolls to show:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo $instance['limit']; ?>" />
        </p>
		
	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['featuredimage'], 'on'); ?> id="<?php echo $this->get_field_id('featuredimage'); ?>" name="<?php echo $this->get_field_name('featuredimage'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php _e( 'Display featured image?', 'wp-dispensary' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['prerollname'], 'on'); ?> id="<?php echo $this->get_field_id('prerollname'); ?>" name="<?php echo $this->get_field_name('prerollname'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'prerollname' ) ); ?>"><?php _e( 'Display pre-roll name?', 'wp-dispensary' ); ?></label>
        </p>
		
	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['prerollflower'], 'on'); ?> id="<?php echo $this->get_field_id('prerollflower'); ?>" name="<?php echo $this->get_field_name('prerollflower'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'prerollflower' ) ); ?>"><?php _e( 'Display pre-roll flower?', 'wp-dispensary' ); ?></label>
        </p>

		<?php
    }
}


/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdispensary_prerolls_register_widget() {
    register_widget( 'wpdispensary_prerolls_widget' );
}
add_action( 'widgets_init', 'wpdispensary_prerolls_register_widget' );


/**
 * WP Dispensary Topicals Widget
 *
 * @since       1.0.0
 */
class wpdispensary_topicals_widget extends WP_Widget {

    /**
     * Constructor
     *
     * @access      public
     * @since       1.4.0
     * @return      void
     */
    public function wpdispensary_topicals_widget() {
        parent::WP_Widget(
            false,
            __( 'Recent Topicals', 'wp-dispensary' ),
            array(
                'description'  => __( 'Your dispensaries most recent Topicals', 'wp-dispensary' )
            )
        );
    }

    /**
     * Widget definition
     *
     * @access      public
     * @since       1.4.0
     * @see         WP_Widget::widget
     * @param       array $args Arguments to pass to the widget
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function widget( $args, $instance ) {
        if( ! isset( $args['id'] ) ) {
            $args['id'] = 'wpdispensary_topicals_widget';
        }

        $title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

        echo $args['before_widget'];

        if( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        do_action( 'wpdispensary_topicals_before_widget' );

			if( ! 'on' == $instance['featuredimage'] ) {
				echo "<ul class='wpdispensary-list'>";
			}
			
			$wpdispensary_topicals_widget = new WP_Query(
				array(
					'post_type' => 'topicals',
					'showposts' => $instance['limit']
				)
			);

			while ( $wpdispensary_topicals_widget->have_posts() ) : $wpdispensary_topicals_widget->the_post();
			
			$do_not_duplicate = $post->ID;

			if('on' == $instance['featuredimage'] ) {
				
				echo "<div class='wpdispensary-widget'>";
					echo "<a href='" . get_permalink( $post->ID ) ."'>";
						the_post_thumbnail( 'wpdispensary-widget' );
					echo "</a>";
				if('on' == $instance['topicalname'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . get_permalink( $post->ID ) ."'>". get_the_title( $post->ID ) ."</a></span>";
				}
				if('on' == $instance['topicalcategory'] ) {
					echo "<span class='wpdispensary-widget-categories'>". get_the_term_list( $post->ID, 'topicals_category' ) ."</a></span>";
				}
				echo "</div>";
				
			} else {
				
				echo "<li>";
				if('on' == $instance['topicalname'] ) {
					echo "<a href='" . get_permalink( $post->ID ) ."' class='wpdispensary-widget-link'>". get_the_title( $post->ID ) ."</a>";
				}
				echo "</li>";
				
			}

			endwhile; // end loop
			
			if( ! 'on' == $instance['featuredimage'] ) {
				echo "</ul>";
			}

        do_action( 'wpdispensary_topicals_after_widget' );
        
        echo $args['after_widget'];
    }


    /**
     * Update widget options
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::update
     * @param       array $new_instance The updated options
     * @param       array $old_instance The old options
     * @return      array $instance The updated instance options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']      	= strip_tags( $new_instance['title'] );
        $instance['limit']   		= strip_tags( $new_instance['limit'] );
        $instance['featuredimage']	= $new_instance['featuredimage'];
        $instance['topicalname']		= $new_instance['topicalname'];
        $instance['topicalcategory']	= $new_instance['topicalcategory'];

        return $instance;
    }


    /**
     * Display widget form on dashboard
     *
     * @access      public
     * @since       1.0.0
     * @see         WP_Widget::form
     * @param       array $instance A given widget instance
     * @return      void
     */
    public function form( $instance ) {
        $defaults = array(
            'title'    			=> 'Recent Topicals',
            'limit'  			=> '5',
            'featuredimage'		=> '',
            'topicalname' 		=> '',
            'topicalcategory' 	=> ''
        );

        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title:', 'wp-dispensary' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
		
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Amount of topicals to show:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo $instance['limit']; ?>" />
        </p>
		
	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['featuredimage'], 'on'); ?> id="<?php echo $this->get_field_id('featuredimage'); ?>" name="<?php echo $this->get_field_name('featuredimage'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php _e( 'Display featured image?', 'wp-dispensary' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['topicalname'], 'on'); ?> id="<?php echo $this->get_field_id('topicalname'); ?>" name="<?php echo $this->get_field_name('topicalname'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'topicalname' ) ); ?>"><?php _e( 'Display topical name?', 'wp-dispensary' ); ?></label>
        </p>

	    <p>
			<input class="checkbox" type="checkbox" <?php checked($instance['topicalcategory'], 'on'); ?> id="<?php echo $this->get_field_id('topicalcategory'); ?>" name="<?php echo $this->get_field_name('topicalcategory'); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'topicalcategory' ) ); ?>"><?php _e( 'Display topical category?', 'wp-dispensary' ); ?></label>
        </p>

		<?php
    }
}

/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdispensary_topicals_register_widget() {
    register_widget( 'wpdispensary_topicals_widget' );
}
add_action( 'widgets_init', 'wpdispensary_topicals_register_widget' );

?>