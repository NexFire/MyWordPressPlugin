<?php
/**
 * @package Sommeliers
 * @version 0.0.1
 */
/*
Plugin Name: Sommeliers
Plugin URI: https://github.com/NexFire/getSommelier
Description: This is the Get Sommelier plug-in that is in my assignment
Author: Maximilian Tyx
Version: 0.0.1
Author URI: https://github.com/NexFire
*/


add_action('wp_enqueue_scripts', 'enqueue_jquery');
function enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');


function add_info_custom_generate( $post ) {
    wp_enqueue_style('custom-css', plugins_url('style.css', __FILE__));
    wp_nonce_field(basename(__FILE__), 'info_metabox_nonce');
    $email=get_post_meta($post->ID,'email',true);
    $phone=get_post_meta($post->ID,'phone',true);
	?>
    <div id="info_container">
        <div class="infoRow">
            <label for="email_field">Email:</label><br>
            <input type="email" placeholder="jan.novak@seznam.cz" name="email" id="email" class="infoBox" value="<?php echo esc_attr($email) ?>" required>
        </div>
        <div class="infoRow">
            <label for="phone_field">Telefon:</label>
            <input type="tel" name="phone" id="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" placeholder="+420-666-666-666" class="infoBox" value="<?php echo esc_attr($phone) ?>" required>
        </div>
    </div>
	<?php
}

function modify_sommeliers_api_response($response, $post, $request) {
    $postId=$post->ID;
    $response=array();
    $response["jmeno"]=get_the_title($postId);
    $response["email"]=get_post_meta($postId,'email',true);
    $response["telefon"]=get_post_meta($postId,'phone',true);
    $response["foto"]=get_the_post_thumbnail_url($postId);
    return $response;
}

add_filter('rest_prepare_sommeliers', 'modify_sommeliers_api_response', 10, 3);


function add_custom_boxes(){
    wp_enqueue_script('sommeliers-script', plugins_url('script.js', __FILE__), array('jquery'), '1.0', true);
    add_meta_box(
        'photo_custom_box',
        'Informace',
        'add_info_custom_generate',
        'sommeliers',
        'advanced',
        'high'
    );

}
add_action('add_meta_boxes','add_custom_boxes');

function info_metabox_save($post_id) {
    
    // Verify post type
    if (isset($_POST['post_type']) && $_POST['post_type'] != 'sommeliers') {
        return $post_id;
    }

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['my_custom_metabox_nonce']) && wp_verify_nonce($_POST['my_custom_metabox_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    // Check if our custom field has been set
    if (isset($_POST['email']) && isset($_POST['phone'])) {
        update_post_meta($post_id, 'email', sanitize_text_field($_POST['email']));
        update_post_meta($post_id, 'phone', sanitize_text_field($_POST['phone']));
    }

}

add_action('save_post', 'info_metabox_save');


function hide_media_button_for_sommelier() {
    $screen = get_current_screen();
    if ( $screen->id == 'sommeliers' ) { // Change 'sommelier' to your custom post type's slug if different.
        echo '<style>
            .single .post-thumbnail{ display:none;}
            .wp-media-buttons { display:none; }
        </style>';
    }
}
add_action( 'admin_head', 'hide_media_button_for_sommelier' );


function sommelier_template($template) {
    global $post;

    if ($post->post_type == "sommeliers") {
        $template = dirname(__FILE__) . '/sommelier-template.php';
    }

    return $template;
}

add_filter('template_include', 'sommelier_template');

function disable_gutenberg_for_custom_type($use_block_editor, $post_type) {
    if ($post_type === 'sommeliers') {
        return false;  // Disable Gutenberg/block-editor for 'my_custom_type'
    }
    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'disable_gutenberg_for_custom_type', 10, 2);

function sommeliers_custom_post_type() {
	register_post_type('sommeliers',
		array(
			'labels'      => array(
				'name'          => __('Sommeliers', 'textdomain'),
				'singular_name' => __('Sommelier', 'textdomain'),
                'add_new_item' => __('Add Sommelier',"textdomain"),
                'add_new' => __('Add Sommelier',"textdomain")
			),
            'menu_icon'=>plugins_url('wineGlassIcon.svg', __FILE__),
            'hierarchical'=>true,

            'supports'            => array('title','editor','thumbnail'),
            'public'      => true,
            'show_in_rest' =>true,
            'has_archive' => true,
            'show_ui' => true,
            'rewrite'     => array( 'slug' => 'sommeliers' )
		)
	);
}
add_action('init', 'sommeliers_custom_post_type');



?>
