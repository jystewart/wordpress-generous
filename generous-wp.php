<?php
/*
Plugin Name: Generous Wordpress
Description: Widgets from generous.org.uk for wordpress
Author: James Stewart
Version: 1.0
Author URI: http://www.ketlai.co.uk/
*/

class Generous_Widget extends WP_Widget {
  function Generous_Widget() {
    parent::WP_Widget(false, $name = 'Generous Actions');
  }
  
  function build_js_url($profile_url, $plain = FALSE) {
    if ($plain) {
      return $profile_url . "-basic.js";
    } else {
      return $profile_url . ".js";
    }
  }
  
  function widget($args, $instance) {
    extract($args);
    echo $before_widget;
    $plain = isset($instance['unstyled']) ? $instance['unstyled'] : FALSE;
    $url = $this->build_js_url($instance['generous_url'], $plain);
    echo '<script src="' . $url . '"></script>';
    echo $after_widget;
  }
  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['generous_url'] = strip_tags($new_instance['generous_url']);
    $instance['unstyled'] = strip_tags($new_instance['unstyled']);
    return $instance;
  }
  
  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'generous_url' => '', 'unstyled' => FALSE) );
    $generous_url = strip_tags($instance['generous_url']);
    $unstyled = strip_tags($instance['unstyled']);
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('generous_url'); ?>">
        Your Generous Profile Address: 
        <input class="widefat" id="<?php echo $this->get_field_id('generous_url'); ?>" name="<?php echo $this->get_field_name('generous_url'); ?>" 
          type="text" value="<?php echo attribute_escape($generous_url); ?>" />
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('unstyled'); ?>">
        Display without images/styling? 
        <input class="widefat" id="<?php echo $this->get_field_id('unstyled'); ?>" name="<?php echo $this->get_field_name('unstyled'); ?>" 
          type="checkbox" value="1" <?php if ($unstyled) { echo 'checked="checked"'; } ?>/>
      </label>
    </p>
    <?php

  }
}

add_action('widgets_init', create_function('', 'return register_widget("Generous_Widget");'));
