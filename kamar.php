<?php
/* 
Plugin Name: Limit Read
Plugin URI: http://wordpress.org/extend/plugins/limit-read/
Description: Restrict access to read a post or page on your writing with the Facebook Likes Button. You'll get more fans on Facebook. For Information And Support <a href="http://papadestra.wordpress.com/" target="_blank" title="Papa Destra Developer In Public Service "><em>http://papadestra.wordpress.com/</em></a>
Version: 1.1
Author: Papa Destra
Author URI: http://papadestra.wordpress.com/
Stable tag: 1.1
 */

/*
ATTENTION PLEASE! Little changes you make in Scripts and the damage was not including our responsibility.
==========================================================================================================
==========================================================================================================
			!................(_).......................................... !
			!...............(___)......................................... !
			!...............(___)......................................... !
			!...............(___)......................................... !
			!...............(___)......................................... !
			!..... /\___/\__/---\__/\__/\................................. !
			!......\_____\_°_¤ ---- ¤_°_/................................. !
			!.............\ __°__ /....................................... !
			!..............|\_°_/|........................................ !
			!..............[|\_/|]........................................ !
			!..............[|[P]|]........................................ !
			!..............[|;A;|]........................................ !
			!..............[;;P;;]......Web Design & Development.......... !
			!.............;[|;A]|]\....................................... !
			!............;;[|;D]|]-\......Our Best Services............... !
			!...........;;;[|[E]|]--\..................................... !
			!..........;;;;[|[S]|]---\...WEBSITE MAINTENANCE.............. !
			!.........;;;;;[|[T]|]|---|................................... !
			!.........;;;;;[|[R]|]|---|................................... !
			!..........;;;;[|[A]|/---/.................................... !
			!...........;;;[|[*]/---/..................................... !
			!............;;[|[]/---/...................................... !
			!.............;[|[/---/....................................... !
			!..............[|/---/......http://cocakijo.wordpress.com/.... !
			!.............../---/.......http://papadestra.wordpress.com/.. !
			!............../---/|]........................................ !
			!............./---/]|];....................................... !
			!............/---/#]|];;...................................... !
			!...........|---|[#]|];;;..................................... !
			!...........|---|[#]|];;;..................................... !
			!............\--|[#]|];;...................................... !
			!.............\-|[#]|];....................................... !
			!..............\|[#]|]........................................ !
			!...............\\#//......................................... !
			!.................\/.......................................... !
==========================================================================================================
==========================================================================================================
*/
/********************************************/
register_activation_hook(__FILE__,'installdatabasesembokmu');
add_action('admin_menu', 'tubruk_panel_moncrot');
add_action('init', 'javasc_loader');
add_action('wp_head', 'batasbacacss');
add_action('wp_footer', 'parseFBML');
add_action('wp_ajax_fbjax', 'likelockerCB');
add_action('wp_ajax_nopriv_fbjax', 'likelockerCB');
add_shortcode("limitread", "ngunci_posting_ndul");
add_action( 'wp_footer', 'sikil_link_cruut');
/********************************************/
// Gawe Menu
function tubruk_panel_moncrot() {
$icon = get_bloginfo('wpurl') . '/wp-content/plugins/limit-read/icon.png';
        add_menu_page('Limit Read', '&nbsp;Limit Read &copy;', 8, __FILE__, null, $icon);
		add_submenu_page(__FILE__, 'Settings', 'Settings', 8, __FILE__, 'batasbaca_settings');
	
	add_action( 'admin_init', 'regsettings_batasbaca' );
} // End Gawe Menu

function regsettings_batasbaca() {
	register_setting( 'batasbaca-settings-group', 'batasbaca-message' );
} 
function ngunci_posting_ndul($atts, $content = null){
	global $wpdb;
	$table_name = $wpdb->prefix . "batasbaca";	
	$postID = get_the_ID();
	$ip = $_SERVER['REMOTE_ADDR'];
	$check = $wpdb->get_results("SELECT * FROM $table_name WHERE post_id = '$postID' AND ips = '$ip'");

	// Yen ora (dikunci)
	if(!$check){
		// Ganti konten di antara tag dengan tombol
		$content = generateLike();
	}
	return $content;
} // End

// Function to generate the like button FBML
function generateLike(){
	// Get plugin options from DB
	$wpll_message = get_option('batasbaca-message');

	// Define the current post permalink for Facebook
	$wpll_url = get_permalink();
	
	// Create FBML
	$fbml = '
		<div class="gayane-css" style="position: relative">
		'.$wpll_message.'
			<fb:like id="fbLikeButton" href="'.$wpll_url.'" show_faces="true" width="450" post_id="'.get_the_ID().'"></fb:like>
			
		</div>
	';	
	// Return the Like Button FBML
	return $fbml;
} // End Generate Like Function
// Callback function to update database on like click via AJAX
function likelockerCB(){
	// Define database vars
	global $wpdb;
	$table_name = $wpdb->prefix . "batasbaca";	
	// Get post ID and IP to store
	$postID = $_POST['post'];
	$ip = $_SERVER['REMOTE_ADDR'];
	// Insert them into our database to keep track of likes
	$wpdb->insert($table_name, array('post_id' => $postID, 'ips' => $ip));
}
// Function to include required JS and CSS in header
function batasbacacss() {
	// Include the CSS
	echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"".get_bloginfo('wpurl')."/wp-content/plugins/".basename(dirname(__FILE__))."/gaya.css\"> \n";
	echo "
	<script type=\"text/javascript\">
		FB.Event.subscribe('edge.create', function(href){ 
			var data = { post: jQuery('#fbLikeButton').attr('post_id'), action: 'fbjax' };
			
			jQuery.post('".admin_url( 'admin-ajax.php' )."', data, function(response) {
				location.reload();
			});
		});
	</script> \n
	";
}

function javasc_loader() {
	// Make sure we are not in the admin section
	if (!is_admin()) {
		// Flush the JS
		wp_deregister_script('jquery');
		wp_deregister_script('fbsdk');
		// Register them with fresh calls
		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js');
		wp_register_script('fbsdk', 'http://connect.facebook.net/en_US/all.js#xfbml=1');

		// Include them
		wp_enqueue_script('jquery');
		wp_enqueue_script('fbsdk');
	} // End if admin
} // End javasc_loader function
// Wayah plugin iki aktif, database di install nggo nglacak sopo wae sing seneng.
function installdatabasesembokmu() {
	// Database vars
	global $wpdb;
	$table_name = $wpdb->prefix . "batasbaca";
   
    // Check if table already exists
    if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		// If not, generate the SQL
		$sql = "
			CREATE TABLE  " . $table_name . " (
			`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`post_id` INT( 11 ) NOT NULL ,
			`ips` TEXT NOT NULL
			);	
		";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		add_option( 'batasbaca-message', 'Sorry! Content is restricted please Like it on Facebook! To continue reading' );
    } 
} // Install Rampung

// Parse FBML
function parseFBML(){
	// Kadang-kadang ketika loading SDK Facebook dan FBML itu diberikan sebelum Facebook bisa mengejar ketinggalan, dengan menjalankan mengurai FBML di akhir halaman kita dapat memastikan bahwa tombol seperti akan muncul untuk semua pengguna reguardless kali beban.
	echo'<script type="text/javascript">FB.XFBML.parse();</script>';
}
function batasbaca_settings() {
    // If the save button is pressed:
    if( isset($_POST['saveS']) ) {
        // Save the posted value in the database
		update_option('batasbaca-message', $_POST['batasbaca-message']);
		// Now we can display the options page HTML:
?>
        <div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
<?php } ?>
<div class="wrap">
<h2>Settings Message to Display</h2>
<form method="post" action="options.php">
    <?php settings_fields( 'batasbaca-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">This message not appear when your item in the locked state :</th>
        <td><input name="batasbaca-message" type="text" value="<?php echo get_option('batasbaca-message'); ?>" size="60" /> &nbsp;&nbsp;
		<input id="saveS" name="saveS" type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td>
        </tr>
        
    </table> 
</form>
 <hr />
Now all you need to do is insert the locker tags in your post. Simply wrap the content you want to "lock" in the following tags using HTML mode of the post editor: 
<p>
<b><font color=red>[limitread]</font></b> ... Your locked content here ... <b><font color=red>[/limitread]</font></b>
</p>
Any content in between the tags will only be accessible after the user clicks the like button. You can wrap your whole post with the tags, or lock certain parts of it like videos, download links, images, etc.
</div>
<p>&nbsp;</p>
<h2>Support us</h2>
If you have questions or difficulties in making arrangements, please contact us at: <a href="http://papadestra.wordpress.com/" target="_blank">http://papadestra.wordpress.com/</a><br>
We hope you are willing to support our project by giving your <em>Donation</em>. <b>Backlinks</b> automatically will go to your website. We are waiting for your response!
<a href="https://sci.libertyreserve.com/en?lr_acc=U0407178&lr_currency=LRUSD&lr_success_url=http%3a%2f%2fpapadestra.wordpress.com%2f&lr_success_url_method=GET&lr_fail_url=http%3a%2f%2fpapadestra.wordpress.com%2f&lr_fail_url_method=GET" alt="Pay With Liberty Reserve!" target="_blank">
<img src="http://i1008.photobucket.com/albums/af208/gagombale/DonasiLR.png" border="0" title="Donate With Liberty Reserve!"></a>
<p>
<center>
<embed src="http://www.satisfaction.com/photo-cube-generator/show.swf?baseURL=http://cocakijo.wordpress.com/
&clickURL=http://cocakijo.wordpress.com/&flashLABEL=Developer In Public Service&clickLABEL=COCAKIJO
&file=http%3A%2F%2Fwww%2Esatisfaction%2Ecom%2Fphoto%2Dcube%2Dgenerator%2Fuploads%2F13%5F06%5F2011%2F23%2Fpic61581180%2Ejpg" 
quality="high" bgcolor="#ffffff" width="300" height="250" name="show" align="middle" wmode="transparent" 
type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
<br>
<small>
<a href="http://papadestra.wordpress.com/" target="_blank">
Spiritual Consultant</a>
<br>
<a href="http://cocakijo.wordpress.com/" target="_blank">
http://cocakijo.wordpress.com/</a>
<small>
</center>
</p>
<?php }
// Sikil Metu
///////////////
function sikil_link_cruut(){
?>
<center>
<a href='http://papadestra.wordpress.com/' target='_blank'>
<p style="color:#C9C299">Spiritual Consultant</p></a>
</center>
<br>
<?php
}

////////////////
?>