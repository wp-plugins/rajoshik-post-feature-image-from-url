<?php
/*
Plugin Name: Rajoshik Post Feature Image From URL
Plugin URI: http://rajoshik.com/themes/rajoshik-post-feature-image-from-url/
Description: This Plugin will allow user to upload post feature image from image url. Image will be added as post feature image..
Author: Md. Abdullah Al Mahim
Version: 1.0
Author URI: http://www.fb.com/a.a.mahim
*/




include_once( 'includes/rajoshik_image_upload_from_url_function.php' );


// Add Input Box for Image URL under the post details box.
add_action( 'admin_init', 'url_to_image_custome_field' );
 
function url_to_image_custome_field() {
    add_meta_box('url_to_image_meta_box', 'Upload Post Feature Image From URL', 'url_to_image_meta_box', 'post');
}
 
function url_to_image_meta_box () {
 
// - security -
echo '<input type="hidden" name="rajoshik-image-url-nonce" id="rajoshik-image-url-nonce" value="' .
wp_create_nonce( 'rajoshik-image-url-nonce' ) . '" />';
 

 
?>
<div class="rajoshik_meta_box">
<ul>
<li><input placeholder="Put Image URL Here" class="rajoshik_input_box" name="image_url" value=""></li>
</ul>
</div>
<?php
}



// Run Image upload from url function
 
function url_to_image_mela_field(){
global $post;
 
$post_id =  $post->ID;

// Check the security
 
if ( !wp_verify_nonce( $_POST['rajoshik-image-url-nonce'], 'rajoshik-image-url-nonce' )) {
    return $post->ID;
}
 
if ( !current_user_can( 'edit_post', $post->ID )) {
    return $post->ID;
} 


if(!isset($_POST["image_url"])){
	return $post->ID;
}

$image_url 	= 	strip_tags($_POST["image_url"]);
$upload_img =	rajoshik_attach_external_image( $image_url,$post->ID,get_the_title($post->ID));

}
add_action ('post_updated', 'url_to_image_mela_field');







function url_to_image_style_admin() {
?>
<style type="text/css">
.rajoshik_meta_box{}
.rajoshik_input_box{width: 95%;margin: 20px;border:1px solid #ccc;padding:10px}
</style>
<?php
}
add_action( 'admin_head', 'url_to_image_style_admin' );
