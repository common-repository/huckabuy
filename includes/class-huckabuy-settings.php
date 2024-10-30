<?php
class HuckabuySettings
{
    private $options;
    private $paid;
    private $active;
    private $settings;
    private $hostname;

    public function __construct()
    {
        
        // on initial construct, make a GET request to the API to get the options: and then set them to $this->options:
        $hostname = sanitize_text_field($_SERVER['HTTP_HOST']);
        $this->hostname = $hostname;

        $passed_url = 'https://api.dashboard.huckabuy.com/api/wordpress-plugin/get?hostname=' . $hostname;

        $response = wp_remote_get( $passed_url );
        $body = wp_remote_retrieve_body( $response );
        $body = json_decode( $body );

        // only set the options if the body is not null:
        if ($body) {
            $this->options = $body->data;
            $this->paid = $body->data->plan == 'paid' ? true : false;
            $this->active = $body->data->active;
            $this->settings = $body->data->settings;

            update_option( 'huckabuy_option_name', $this->options );
        } else {
            $this->options = array(
                'plan' => 'free',
                'active' => false,
                'settings' => array()
            ); 
        }

        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

    }

    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Huckabuy Settings', 
            'Huckabuy', 
            'manage_options', 
            'huckabuy-setting', 
            array( $this, 'create_admin_page' )
        );
    }

    public function get_logo()
    {
        $logo = plugin_dir_url( __FILE__ ) . '../logo-navy.svg';
        return $logo;
    }

    public function create_admin_page()
    {
        //  Current hostname, with dots replaced with dashes to be used with the stripe URL params for client_reference_id:
        $client_reference_id = sanitize_text_field(str_replace('.', '-', $_SERVER['HTTP_HOST']));
        ?>
        <div class="wrap" id="huckabuy-sd-plugin-settings">
            <img src="<?php echo esc_attr($this->get_logo()) ?>" alt="Huckabuy Logo" style="width: 250px; display: block; margin: 30px 0px;">

			<h3 class="nav-tab-wrapper">
                <a class="nav-tab nav-tab-active" href="<?php echo esc_attr(admin_url()) ?>options-general.php?page=huckabuy-welcome">Welcome</a>
                <a class="nav-tab" href="<?php echo esc_attr(admin_url()) ?>options-general.php?page=huckabuy-setting">Settings</a>

                <?php if ($this->paid) { ?>
                    <a class="nav-tab" href="<?php echo esc_attr(admin_url()) ?>options-general.php?page=huckabuy-advanced">Advanced</a>
                <?php } ?>
			</h3>

            <p>You can see your Structured Data status <a href="https://dashboard.huckabuy.com/wordpress-plugin/<?php echo esc_attr($this->hostname)  ?>/status" target="_blank">here.</a></p>
            
            <section id="huckabuy-welcome">
                <h3>Basic Plugin Users:</h3>
                <p>Thanks for installing the Huckabuy Structured Data WordPress plugin. This plugin will automatically add structured data markup to your WordPress site.</p>
                <p>This markup will help search engines better understand your site and improve your organic search results. With the basic plan you will receive the following core objects that help Google better understand your website:</p>
                <ul class="data-block-list">
                    <li><b>Organization</b></li>
                    <li><b>Website</b></li>
                    <li><b>WebPage</b></li>
                </ul>

                <h3>Advanced Plugin Users:</h3>
                <p>Do you want even better schema markup results than what the free Huckabuy Structured Data plugin offers? If so, you can upgrade to the Huckabuy Structured Data Advanced plugin.</p> 
                <h4>Here is how to start using the Advanced plugin:</h4>
                <ol>
                    <li><a href="https://buy.stripe.com/cN23fB2K69aZ1xedQQ?client_reference_id=WORDPRESS+<?php echo esc_attr($client_reference_id) ?>">Click here to
                    purchase the Huckabuy Structured Data Advanced plugin</a></li>
                    <li>You will see a new navigation tab appear to view information about your account and status of your structured data markup.</li>
                </ol>
                
                <p>This will expand the structured data objects that are added to your site and will allow for better rich-result eligibility. The advanced plugin is a fully automated solution which means you don't need to worry about configuring what objects get added to what pages.</p>
                <ul class="data-block-list">
                    <li><b>Organization</b></li>
                    <li><b>Website</b></li>
                    <li><b>WebPage</b></li>
                    <li><b>Article</b></li>
                    <li><b>Book</b></li>
                    <li><b>BreadcrumbList</b></li>
                    <li><b>ClaimReview</b></li>
                    <li><b>Course</b></li>
                    <li><b>Dataset</b></li>
                    <li><b>Event</b></li>
                    <li><b>FAQPage</b></li>
                    <li><b>HowTo</b></li>
                    <li><b>JobPosting</b></li>
                    <li><b>LocalBusiness</b></li>
                    <li><b>Movie</b></li>
                    <li><b>NewsArticle</b></li>
                    <li><b>Occupation</b></li>
                    <li><b>Offer</b></li>
                    <li><b>Product</b></li>
                    <li><b>QAPage</b></li>
                    <li><b>Recipe</b></li>
                    <li><b>Review</b></li>
                    <li><b>SoftwareApplication</b></li>
                    <li><b>VideoObject</b></li>
                    <li>And more...</li>
                </ul>
                <br>
                <p>The advanced plugin also gives you 1 refresh requests per month to run our automated site analysis in order to generate new Structured Data objects to account for any potential content changes and new schema opportunities.</p>
                <p>You are also provided a customer support email in order to contact us about any specific questions regarding your websites's structured data</p>

                <p>Find out more on our <a href="https://huckabuy.com/" target="_blank">website</a>.</p>
                <br>
            </section>
            <section id="huckabuy-settings">
                <form method="post" action="options.php" id="huckabuy-settings-form">
                <?php
                    settings_fields( 'huckabuy_option_group' );   
                    do_settings_sections( 'huckabuy-setting' ); 
                    submit_button();
                ?>
                </form>
            </section>
            <section id="huckabuy-advanced">
                 <?php
                    settings_fields( 'huckabuy_option_group' );   
                    do_settings_sections( 'huckabuy-advanced' ); 
                ?>
            </section>
        </div>
        <?php
  
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'huckabuy_option_group', // Option group
            'huckabuy_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        
        add_settings_section(
            'social_links', // ID
            'Social Links', // Title
            array( $this, 'print_section_social_links' ), // Callback
            'huckabuy-setting' // Page
        );   

        add_settings_field(
            'social_twitter', // ID
            'Twitter', // Title 
            array( $this, 'twitter_profile_callback' ), // Callback
            'huckabuy-setting', // Page
            'social_links' // Section
        );  

        add_settings_field(
            'social_linkedin', // ID
            'LinkedIn', // Title 
            array( $this, 'linkedin_profile_callback' ), // Callback
            'huckabuy-setting', // Page
            'social_links' // Section
        );  

        add_settings_field(
            'social_facebook', // ID
            'Facebook', // Title 
            array( $this, 'facebook_profile_callback' ), // Callback
            'huckabuy-setting', // Page
            'social_links' // Section
        );  

        add_settings_section(
            'site_search_path_settings', // ID
            'Site Search Path', // Title
            array( $this, 'print_section_site_search_path' ), // Callback
            'huckabuy-setting' // Page
        ); 
        
        add_settings_field(
            'site_search_path', // ID
            'Site Search Path', // Title 
            array( $this, 'site_search_path_callback' ), // Callback
            'huckabuy-setting', // Page
            'site_search_path_settings' // Section
        ); 

        add_settings_field(
            'hidden_hostname', // ID
            ' ', // Title 
            array( $this, 'hidden_hostname_callback' ), // Callback
            'huckabuy-setting', // Page
            'site_search_path_settings', // Section
        ); 

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }


    public function print_section_social_links() {
        print "<p>Enter your social media profiles below. Huckabuy Structured Data will use these profiles to generate structured data for your social media links.</p>";
    }

    public function print_section_site_search_path() {
        print "<p>If your site has a custom search path, enter it here. Huckabuy Structured Data will use this path to generate structured data for your site search results.</p>";
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function twitter_profile_callback()
    {
        printf(
            '<input type="text" id="twitter_profile" name="huckabuy_option_name[twitter_profile]" value="%s" />',
            isset( $this->settings->socials->twitter_profile ) ? esc_attr( $this->settings->socials->twitter_profile) : ''
        );

    }

     public function linkedin_profile_callback()
    {
        printf(
            '<input type="text" id="linkedin_profile" name="huckabuy_option_name[linkedin_profile]" value="%s" />',
            isset( $this->settings->socials->linkedin_profile ) ? esc_attr( $this->settings->socials->linkedin_profile) : ''
        );

    }

     public function facebook_profile_callback()
    {
        printf(
            '<input type="text" id="facebook_profile" name="huckabuy_option_name[facebook_profile]" value="%s" />',
            isset( $this->settings->socials->facebook_profile ) ? esc_attr( $this->settings->socials->facebook_profile) : ''
        );

    }

    public function site_search_path_callback()
    {
        printf(
            '<input type="text" id="search_path" name="huckabuy_option_name[search_path]" value="%s" />',
            isset( $this->settings->search_path ) ? esc_attr( $this->settings->search_path) : ''
        );

    }
    
    public function hidden_hostname_callback()
    {
        $hostname = $_SERVER['HTTP_HOST'];
        printf(
            '<input type="hidden" id="hidden_hostname" name="hostname" value="' . esc_attr($hostname) . '" />',
            isset( $this->settings->hostname ) ? esc_attr( $this->settings->hostname) : ''
        );

    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
}