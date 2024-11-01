<?php
/**
 * Registers custom post type "tip", custom taxonomies, "topic",  "skill" along with widget support.
 *
 * @package WordPress
 * @since 3.1
 */

/**
 * Plugin Name: Tip Type
 * Plugin URI: http://zmpbr.com/
 * Description: Registers custom post type "tip", custom taxonomies, "topic", "skill" along with widget support.
 * Version: 1.0.6
 * Author: Zane M. Kolnik
 * Author URI: http://zanematthew.com/
 * License: GPL
 */

/** Run our functions */    
add_action( 'init', 'tip_type' ); 

/**
 * Reqgister our Tip
 * We want out Tip to be a "slimed down" version of a post/article, 
 * so we won't support several features of post
 *
 * Codex: http://codex.wordpress.org/Post_Types
 */
function tip_type() {
    $labels = array(
        'name' => _x( 'Tip', 'post type general name' ),
        'singular_name' => _x('tip', 'post type singular name' ),
        'add_new' => _x( 'Add New', 'tip' ),
        'add_new_item' => __( 'Add New Tip' ),
        'edit_item' => __( 'Edit tip' ),
        'new_item' => __( 'New tip' ),
        'view_item' => __( 'View tip' ),
        'search_items' => __( 'Search tip' ),
        'not_found' =>  __( 'No tip found' ),
        'not_found_in_trash' => __( 'No tip found in Trash' ),
        'parent_item_colon' => ''
        );
    
    $supports = array(
        'title',
        'comments',
        'editor',
        'thumbnail'
        );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'supports' => $supports            
        );   
             
    register_post_type( 'tip', $args );
} 

/**
 * Reqgister our taxonomies (Skill, Topic) for Tip
 * Codex: http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function tip_type_taxonomy() {        
    $object_type = array('tip');         
    
    $skill_labels = array(
        'name'              => _x( 'Skill', 'taxonomy general name' ),
        'singular_name'     => _x( 'skill', 'taxonomy singular name' ),
        'search_items'      =>  __( 'Search skills' ),
        'all_items'         => __( 'All skills' ),
        'parent_item'       => __( 'Parent skill' ),
        'parent_item_colon' => __( 'Parent skill:' ),
        'edit_item'         => __( 'Edit skill' ), 
        'update_item'       => __( 'Update skill' ),
        'add_new_item'      => __( 'Add New skill' ),
        'new_item_name'     => __( 'New skill Name' ),
        'separate_items_with_commas' => __( 'Please keep this industry specific, seperate with a comma for multiple tips.' )
        );
    
    $skill_args = array(
        'labels' => $skill_labels
        );   

    register_taxonomy( 'skill', $object_type, $skill_args );
    
    $topic_labels = array(
        'name'              => _x( 'Topic', 'taxonomy general name' ),
        'singular_name'     => _x( 'topic', 'taxonomy singular name' ),
        'search_items'      =>  __( 'Search topics' ),
        'all_items'         => __( 'All topics' ),
        'parent_item'       => __( 'Parent topic' ),
        'parent_item_colon' => __( 'Parent topic:' ),
        'edit_item'         => __( 'Edit topic' ), 
        'update_item'       => __( 'Update topic' ),
        'add_new_item'      => __( 'Add New topic' ),
        'new_item_name'     => __( 'New topic Name' ),
        'separate_items_with_commas' => __( 'Please keep this industry specific, seperate with a comma for multiple tips.' )
        );
    
    $topic_args = array(
        'labels' => $topic_labels
        );    
        
    register_taxonomy( 'topic', $object_type, $topic_args );
}
add_action( 'init', 'tip_type_taxonomy', 0 );

/**
 * Add Widget support:
 * Title
 * Count
 * Choose skill to display 
 * Choose topic to display
 * Choose Image to display
 * Show skill 
 * Show topic
 *
 * Requirments: your theme must support Widgets! 
 * The bulk of this class was taken from the codex, see codex for docs
 * Codex: http://codex.wordpress.org/Widgets_API#Widgets_API
 */
class TipTypeWidget extends WP_Widget {

    /** constructor */
    function TipTypeWidget() {
        parent::WP_Widget( false, $name = 'Most Recent Tips' );
    }

    /** @see WP_Widget::widget */
    function widget( $args, $instance ) {
        
        extract( $args );

        $title = array(
        	'title' => apply_filters( 'widget_title', $instance['title'] ) ,
            'count' => apply_filters( 'widget_title', $instance['count'] ),
            'show_skill' => apply_filters( 'widget_title', $instance['show_skill'] ),
            'show_topic' => apply_filters( 'widget_title', $instance['show_topic'] ),
            'skill_term' => apply_filters( 'widget_title', $instance['skill_term'] ),
            'topic_term' => apply_filters( 'widget_title', $instance['topic_term'] ),            
            'image' => apply_filters( 'widget_title', $instance['image'] )            
            );
        
        echo $before_widget;
        tip_type_mrt($title);
        echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update( $new_instance, $old_instance ) {
    
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['count'] = strip_tags( $new_instance['count'] );
        $instance['image'] = strip_tags( $new_instance['image'] );
        $instance['show_skill'] = strip_tags( $new_instance['show_skill'] );
        $instance['show_topic'] = strip_tags( $new_instance['show_topic'] );
        $instance['skill_term'] = strip_tags( $new_instance['skill_term'] );
        $instance['topic_term'] = strip_tags( $new_instance['topic_term'] );
        
        return $instance;
    }

    /** @see WP_Widget::form */
    function form( $instance ) {

        $title = (isset($instance['title'])) ? esc_attr($instance['title']) : 'no title';
        $count = (isset($instance['count'])) ? esc_attr($instance['count']) : 0;
        $show_skill = (isset($instance['show_skill'])) ? esc_attr($instance['show_skill']) : 0;
        $show_topic = (isset($instance['show_topic'])) ? esc_attr($instance['show_topic']) : 0;
        $skill_term = (isset($instance['skill_term'])) ? esc_attr($instance['skill_term']) : '';
        $topic_term = (isset($instance['topic_term'])) ? esc_attr($instance['topic_term']) : '';
        $image = (isset($instance['image'])) ? esc_attr($instance['image']) : '';

        /** 
         * Pretty cool, get our regsitered image sizes
         * Codex: http://core.trac.wordpress.org/browser/tags/3.0.4/wp-includes/media.php
         */
        global $_wp_additional_image_sizes;                
        $image_sizes = $_wp_additional_image_sizes;        
        
        $topics = get_terms('topic');
        $skills = get_terms('skill');
        
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>
        <p>
            <label for="<?php echo $this->get_field_id('skill_term'); ?>">
            <?php _e('Skill:'); ?>
            <select name="<?php echo $this->get_field_name('skill_term'); ?>">
                <option value="all" <?php if ($skill_term == 'all') : ?>selected="selected"<?php endif; ?>>All</option>                        
                <?php foreach ($skills as $skill) : ?>
                    <option value="<?php echo $skill->slug; ?>" <?php if ($skill->slug == $skill_term) : ?>selected="selected"<?php endif; ?>><?php echo $skill->name; ?></option>
                <?php endforeach; ?>
            </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('topic_term'); ?>">
            <?php _e('Topic:'); ?>
            <select name="<?php echo $this->get_field_name('topic_term'); ?>">
                <option value="all" <?php if ($topic_term == 'all') : ?>selected="selected"<?php endif; ?>>All</option>                                    
                <?php foreach ($topics as $topic) : ?>
                    <option value="<?php echo $topic->slug; ?>" <?php if ($topic->slug == $topic_term) : ?>selected="selected"<?php endif; ?>><?php echo $topic->name; ?></option>
                <?php endforeach; ?>
            </select>
            </label>
        </p>
        <p>
        <label for="<?php echo $this->get_field_id('image'); ?>" class="title">
            <?php _e('Show image'); ?>
            <select name="<?php echo $this->get_field_name('image'); ?>">
                <option value="none" <?php if ('none' == $image) : ?>selected="selected"<?php endif; ?>>None</option>            
                <?php foreach ($image_sizes as $image_size=>$size) : ?>
                    <option value="<?php echo $image_size; ?>" <?php if ($image_size == $image) : ?>selected="selected"<?php endif; ?>><?php echo $image_size; ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        </p>
        <p><label for="<?php echo $this->get_field_id('show_skill'); ?>"><input id="<?php echo $this->get_field_id('show_skill'); ?>" name="<?php echo $this->get_field_name('show_skill'); ?>" type="checkbox" <?php if ( $show_skill ) echo 'checked'; ?>" /> <?php _e('Show skill'); ?></label></p>
        <p><label for="<?php echo $this->get_field_id('show_topic'); ?>"><input id="<?php echo $this->get_field_id('show_topic'); ?>" name="<?php echo $this->get_field_name('show_topic'); ?>" type="checkbox" <?php if ( $show_topic ) echo 'checked'; ?>" /> <?php _e('Show topic'); ?></label></p>
        <?php
    }
} 
add_action('widgets_init', create_function('', 'return register_widget("TipTypeWidget");'));

/**
 * function: tip_type_mrt()
 * Params: $title, $count, $image, $topic_term, $skill_term
 * Requirments: your theme must support Widgets!
 *
 * @param $args An array of our arguments
 */    
function tip_type_mrt($args=NULL, $display=TRUE) {
    
    global $post;

    if ( is_array( $args ) )
        extract( $args );

    if ( is_null( $count ) )
        $count = 5;

    if ( $image == 'none' )
        $image = 'no-image';

    if ( strtolower( $topic_term ) == 'all' )
        $topic_term = null;

    if ( strtolower( $skill_term ) == 'all' )
        $skill_term = null;
            
    $args = array('post_type' => 'tip',
   				  'topic' => $topic_term,
    			  'numberposts' => $count);

    $myposts = get_posts($args);

    $x = 1;
    $count = null;
    $count = count($myposts);
    
    $html = null;
    $html .= "<h3 class='widget-title'>{$title}</h3>";
    $html .= "<ul class='{$topic_term} . {$image}'>";
    
    foreach( $myposts as $post ) {
        setup_postdata( $post );

        /** odd, even and last css class support */
        $odd_even_css = ($x % 2) ? ' odd ' : ' even ';
        $helper_css = ($x == $count) ? ' last ': '';
        
        $html .= "<li class='{$odd_even_css} {$helper_css}'>";
        
        if ($image != 'no-image') {
            $html .= '<div class="image">';
            $html .= '<a href="' . get_permalink() . '" rel="Permalink for '. get_the_title().'" title="Continue reading: '.get_the_title().'">';

            if ( function_exists( 'has_post_thumbnail' ) )
               $html .= get_the_post_thumbnail($post->ID, $image);

            $html .= '</a>';
            $html .= '</div>';
        }
        
        $html .= '<div class="">';
        $html .= '<h4 class="title"><a href="'.get_permalink() .'" rel="Permalink for '.get_the_title() .'" title="Continue reading: ' . get_the_title() . '">' . get_the_title() . '</a></h4>';
        
        $skills = get_the_term_list($post->ID, 'skill', '<span class="skill">Skill ', ', ', '</span>' );
        $topics = get_the_term_list($post->ID, 'topic', '<span class="topic"> Topic ', ', ', '</span>' );
        
        if ( $show_skill)
            $html .= $skills;
            
        if ( $show_topic) 
            $html .= $topics;

        $html .= '</div>';
        $html .= '</li>';

        $x++;
    }
    wp_reset_query();
    $html .= '</ul>';

    /**
     * sometimes we wanna return
     * sometimes we wanna print
     * sometimes we wanna just go...
     */
    if ( !$display )
        return $html;
    else
        print $html;
}    

