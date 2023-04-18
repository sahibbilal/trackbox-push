<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://webtechsofts.co.uk/
 * @since      1.0.0
 *
 * @package    Trackbox_Push
 * @subpackage Trackbox_Push/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Trackbox_Push
 * @subpackage Trackbox_Push/admin
 * @author     Web Tech Softs <info@webtechsofts.com>
 */
class Trackbox_Push_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Trackbox_Push_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Trackbox_Push_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/trackbox-push-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Trackbox_Push_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Trackbox_Push_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/trackbox-push-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Register the WP Footer for the Public area.
     *
     * @since    1.0.0
     */
    function wp_footer_function() {
        ?>
        <script>
            jQuery(document).ready(function($) {
                $('.tp_submit_btn').click(function(e) {
                    e.preventDefault();
                    var firstName = $('.tp_fname').val();
                    var lastName = $('.tp_lname').val();
                    var email = $('.tp_email').val();
                    var phone = $('.tp_phone').val();
                    var _url = document.URL;
                    var url = new URL(_url);
                    var _ai = url.searchParams.get("ai");
                    $.ajax({
                        type: "POST",
                        url: "<?php echo esc_url(admin_url('admin-ajax.php')); ?>",
                        data: {
                            action: "api_response_validation",
                            firstName: firstName,
                            lastName: lastName,
                            email: email,
                            phone: phone,
                            _ai: _ai,
                        },
                        dataType: "html",
                        cache: false,
                        success: function(res) {
                            var response = JSON.parse(res);
                            if (response.status === false) {
                                $(".tp_api_response").empty().append(response.data);
                            } else {
                                window.location.reload();
                            }
                        },
                    });
                });
            });
        </script>
        <?php
    }


    /**
     * Register the Ajax Call for the Public area.
     *
     * @since    1.0.0
     */
    public function api_response_validation(){
        $_ai = $_POST['_ai'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $userIP = $_SERVER['REMOTE_ADDR'];

        $options = get_option('track_box_push_options');
        if(!empty($options['custom'])) {
            foreach ($options['custom'] as $key => $single) {
                if ($single['ai'] == $_ai) {
                    $url = rtrim($single['weblink'], '/') . '/api/signup/procform';
                    $username = $single['username'];
                    $password = $single['password'];
                    $apiKey = $options['track_box_push_apiKey'];

                    $data = array(
                        'ai' => $single['ai'],
                        'ci' => $single['ci'],
                        'gi' => $single['gi'],
                        'userip' => $userIP,
                        'firstname' => $firstName,
                        'lastname' => $lastName,
                        'email' => $email,
                        'password' => '',
                        'phone' => $phone,
                        'so' => 'funnelname',
                        'sub' => 'FreeParam',
                    );
                    // Add MPC parameters
                    $mpcArray = explode(',', $single['mpc']);
                    foreach ($mpcArray as $key => $value) {
                        if (!empty($single['mpc'])) {
                            $data[$key] = $value;
                        }
                    }
                    $headers = array(
                        'x-trackbox-username: ' . $username,
                        'x-trackbox-password: ' . $password,
                        'x-api-key: ' . $apiKey,
                        'Content-Type: application/json',
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    if (curl_errno($ch)) {
                        $error_message = 'API request failed: ' . curl_error($ch);
                        $response = array('status' => false, 'data' => $error_message);
                    } else {
                        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        if ($http_code == 200) {
                            $response = json_decode($response, true);
                        } else {
                            $error_message = 'API request failed with status code ' . $http_code;
                            $response = array('status' => false, 'data' => $error_message);
                        }
                    }
                    curl_close($ch);
                    header('Content-Type: application/json');
                }
                else{
                    $response = array('status' => false, 'data' => 'The URL you entered is not valid.');
                }
            }
        }
        else{
            $response = array('status' => false, 'data' => 'Please try again');
        }
        echo json_encode($response);
        exit;
    }


    /**
     * Register the admin Ajax Call.
     *
     * @since    1.0.0
     */
    public function save_customer_details(){
        $len = $_POST['_len'];
        add_settings_field(
            'track_box_push_details' . $len,
            __('Account Details '.$len, 'track_box_push'),
            array($this, 'track_box_push_details_cb'),
            'track_box_push',
            'track_box_push_design_styling',
            array(
                'label_for' => 'track_box_push_details' . $len,
                'class' => 'track_box_push_custom',
                'track_box_push_custom_data' => 'custom',
            )
        );
        die();
    }
    public function track_box_push_details_cb(){}

}
