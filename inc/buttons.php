<?php
defined('ABSPATH') or die('No direct access permitted');

// format the returned number
function sfb_format_number($intNumber)
{
    // if the number is greater than or equal to 1000
    if ($intNumber >= 1000) {
        // divide by 1000 and add k
        $intNumber = round(($intNumber / 1000), 1).'k';
    }

    // return the number
    return $intNumber;
}

// add follow buttons to content and/or excerpts
add_filter('the_content', 'show_follow_buttons', (int) $arrSettings['sfb_content_priority']);

// get and show follow buttons
function show_follow_buttons($content, $booShortCode = FALSE, $atts = '') {

    // globals
    global $post;

    // variables
    $htmlContent = $content;
    $pattern = get_shortcode_regex();

    // sfb_hide shortcode is in the post content and instance is not called by shortcode sfb
    if (isset($post->post_content) && preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
        && array_key_exists( 2, $matches )
        && in_array('sfb_hide', $matches[2])
        && $booShortCode == FALSE) {

        // exit the function returning the content without the buttons
        return $content;
    }

    // get sbba settings
    $arrSettings = get_sfb_settings();

    // placement on pages/posts
    if ((!is_home() && !is_front_page() && is_page() && $arrSettings['sfb_pages'] == 'Y') || (is_single() && $arrSettings['sfb_posts'] == 'Y') || $booShortCode == TRUE) {

        // if not shortcode
        if (isset($atts['widget']) && $atts['widget'] == 'Y')
            // use widget follow text
            $strFollowText = $arrSettings['sfb_widget_text'];
        else
            // use normal follow text
            $strFollowText = $arrSettings['sfb_follow_text'];

        // sfb div
        $htmlFollowButtons = '<!-- Simple Follow Buttons ('.SFB_VERSION.') simplefollowbuttons.com --><div class="sfb sfb-wrap">';

        // center if set so
        $htmlFollowButtons.= '<div style="text-align:'.$arrSettings['sfb_align'].'">';

        // add custom text if set and set to placement above or left
        if (($strFollowText != '') && ($arrSettings['sfb_text_placement'] == 'above' || $arrSettings['sfb_text_placement'] == 'left')) {
            // check if user has left follow link box checked
            if ($arrSettings['sfb_link_to_ssb'] == 'Y') {
                // follow text with link
                $htmlFollowButtons .= '<a href="https://simplefollowbuttons.com" target="_blank">' . $strFollowText . '</a>';
            }

            // just display the follow text
            else {
                // follow text
                $htmlFollowButtons .= $strFollowText;
            }
            // add a line break if set to above
            ($arrSettings['sfb_text_placement'] == 'above' ? $htmlFollowButtons .= '<br/>' : NULL);
        }

        // initiate class and get buttons
        $sfbButtons = new SFB_Buttons($arrSettings);

        // add the buttons
        $htmlFollowButtons.= $sfbButtons->get_follow_buttons();

        // add custom text if set and set to placement right or below
        if (($strFollowText != '') && ($arrSettings['sfb_text_placement'] == 'right' || $arrSettings['sfb_text_placement'] =='below')) {
            // add a line break if set to above
            ($arrSettings['sfb_text_placement'] == 'below' ? $htmlFollowButtons .= '<br/>' : NULL);

            // check if user has checked follow link option
            if ($arrSettings['sfb_link_to_ssb'] == 'Y') {
                // follow text with link
                $htmlFollowButtons .= '<a href="https://simplefollowbuttons.com" target="_blank">' . $strFollowText . '</a>';
            }

            // just display the follow text
            else {
                // follow text
                $htmlFollowButtons .= $strFollowText;
            }
        }

        // close center if set
        $htmlFollowButtons.= '</div>';
        $htmlFollowButtons.= '</div>';

        // if not using shortcode
        if ($booShortCode == FALSE) {

            // switch for placement of sfb
            switch ($arrSettings['sfb_before_or_after']) {

            case 'before': // before the content
                $htmlContent = $htmlFollowButtons . $content;
                break;

            case 'after': // after the content
                $htmlContent = $content . $htmlFollowButtons;
                break;

            case 'both': // before and after the content
                $htmlContent = $htmlFollowButtons . $content . $htmlFollowButtons;
                break;
            }
        }

        // if using shortcode
        else {

            // just return buttons
            $htmlContent = $htmlFollowButtons;
        }
    }

    // return content and follow buttons
    return $htmlContent;
}

// if we wish to add to excerpts
if(isset($arrSettings['sfb_excerpts']) && $arrSettings['sfb_excerpts'] == 'Y') {

    // add a hook
    add_filter( 'the_excerpt', 'show_follow_buttons');
}

// shortcode for adding buttons
function sfb_buttons($atts) {

    // get buttons - NULL for $content, TRUE for shortcode flag
    $htmlFollowButtons = show_follow_buttons(NULL, TRUE, $atts);

    //return buttons
    return $htmlFollowButtons;
}

// shortcode for hiding buttons
function sfb_hide($content) {
    // no need to do anything here!
}

/**
 * Simple Follow Buttons
 */
class SFB_Buttons
{

    // variables
    public $buttons;
    public $settings;

    function __construct($settings)
    {
        // prepare class variables
        $this->settings = $settings;

        // prepare array of buttons
        $this->buttons = json_decode(get_option('sfb_buttons'), true);
    }

    // get set follow buttons
    function get_follow_buttons()
    {
        // variables
        $htmlFollowButtons = '';

        // explode saved include list and add to a new array
        $arrSelectedSFB = explode(',', $this->settings['sfb_selected_buttons']);

        // check if array is not empty
        if ($this->settings['sfb_selected_buttons'] != '') {

            // for each included button
            foreach ($arrSelectedSFB as $strSelected) {

                $strGetButton = 'sfb_' . $strSelected;

                // add a list item for each selected option
                $htmlFollowButtons .= $this->$strGetButton($this->settings);
            }
        }

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get facebook button
    function sfb_facebook()
    {
        // facebook follow link
        $htmlFollowButtons = '<a class="sfb_facebook_follow" href="'.$this->buttons['facebook']['url_prefix'].$this->settings['url_facebook'] . '" ' . ($this->settings['sfb_follow_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($this->settings['sfb_rel_nofollow'] == 'Y' ? ' rel="nofollow"' : NULL) . '>';

        // if not using custom
        if ($this->settings['sfb_image_set'] != 'custom') {
            // show selected sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/facebook.png" title="Facebook" class="sfb sfb-img" alt="Follow on Facebook" />';
        } // if using custom images
        else {
            // show custom image
            $htmlFollowButtons .= '<img src="' . $this->settings['sfb_custom_facebook'] . '" title="Facebook" class="sfb sfb-img" alt="Follow on Facebook" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get twitter button
    function sfb_twitter()
    {
        // twitter follow link
        $htmlFollowButtons = '<a class="sfb_twitter_follow" href="'.$this->buttons['twitter']['url_prefix'].$this->settings['url_twitter'] . '"' . ($this->settings['sfb_follow_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($this->settings['sfb_rel_nofollow'] == 'Y' ? ' rel="nofollow"' : NULL) . '>';

        // if image set is not custom
        if ($this->settings['sfb_image_set'] != 'custom') {

            // show sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/twitter.png" title="Twitter" class="sfb sfb-img" alt="Tweet about this on Twitter" />';
        } // if using custom images
        else {

            // show custom image
            $htmlFollowButtons .= '<img src="' . $this->settings['sfb_custom_twitter'] . '" title="Twitter" class="sfb sfb-img" alt="Follow on Twitter" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get google+ button
    function sfb_google()
    {
        // google follow link
        $htmlFollowButtons = '<a class="sfb_google_follow" href="'.$this->buttons['google']['url_prefix'].$this->settings['url_google'] . '" ' . ($this->settings['sfb_follow_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($this->settings['sfb_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

        // if image set is not custom
        if ($this->settings['sfb_image_set'] != 'custom') {
            // show sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/google.png" title="Google+" class="sfb sfb-img" alt="Follow on Google+" />';
        } // if using custom images
        else {
            // show custom image
            $htmlFollowButtons .= '<img src="' . $this->settings['sfb_custom_google'] . '" title="Follow on Google+" class="sfb sfb-img" alt="Google+" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get diggit button
    function sfb_diggit()
    {
        // diggit follow link
        $htmlFollowButtons = '<a class="sfb_diggit_follow sfb_follow_link" href="'.$this->buttons['diggit']['url_prefix'].$this->settings['url_diggit'] . '" ' . ($this->settings['sfb_follow_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($this->settings['sfb_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

        // if image set is not custom
        if ($this->settings['sfb_image_set'] != 'custom') {
            // show sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/diggit.png" title="Digg" class="sfb sfb-img" alt="Digg this" />';
        } // if using custom images
        else {
            // show custom image
            $htmlFollowButtons .= '<img src="' . $this->settings['sfb_custom_diggit'] . '" title="Digg" class="sfb sfb-img" alt="Digg this" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get reddit button
    function sfb_reddit()
    {
        // reddit follow link
        $htmlFollowButtons = '<a class="sfb_reddit_follow" href="'.$this->buttons['reddit']['url_prefix'].$this->settings['url_reddit'] . '" ' . ($this->settings['sfb_follow_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($this->settings['sfb_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

        // if image set is not custom
        if ($this->settings['sfb_image_set'] != 'custom') {
            // show sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/reddit.png" title="Reddit" class="sfb sfb-img" alt="Follow on Reddit" />';
        } // if using custom images
        else {
            // show custom image
            $htmlFollowButtons .= '<img src="' . $this->settings['sfb_custom_reddit'] . '" title="Reddit" class="sfb sfb-img" alt="Follow on Reddit" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get linkedin button
    function sfb_linkedin()
    {
        // linkedin follow link
        $htmlFollowButtons = '<a class="sfb_linkedin_follow sfb_follow_link" href="'.$this->buttons['linkedin']['url_prefix'].$this->settings['url_linkedin'] . '" ' . ($this->settings['sfb_follow_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($this->settings['sfb_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

        // if image set is not custom
        if ($this->settings['sfb_image_set'] != 'custom') {
            // show sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/linkedin.png" title="LinkedIn" class="sfb sfb-img" alt="Follow on LinkedIn" />';
        } // if using custom images
        else {
            // show custom image
            $htmlFollowButtons .= '<img src="' . $this->settings['sfb_custom_linkedin'] . '" alt="Follow on LinkedIn" title="LinkedIn" class="sfb sfb-img" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get pinterest button
    function sfb_pinterest()
    {
        // pinterest follow link
        $htmlFollowButtons = '<a href="'.$this->buttons['pinterest']['url_prefix'].$this->settings['url_pinterest'] . '" class="sfb_pinterest_follow sfb_follow_link" ' . ($this->settings['sfb_follow_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($this->settings['sfb_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

        // if image set is not custom
        if ($this->settings['sfb_image_set'] != 'custom') {
            // show sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/pinterest.png" title="Pinterest" class="sfb sfb-img" alt="Pin on Pinterest" />';
        } // if using custom images
        else {
            // show custom image
            $htmlFollowButtons .= '<img title="Pinterest" class="sfb sfb-img" src="' . $this->settings['sfb_custom_pinterest'] . '" alt="Pin on Pinterest" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get email button
    function sfb_email()
    {
        // email follow link
        $htmlFollowButtons = '<a data-site="email" class="sfb_email_follow" href="mailto:' . $this->settings['url_email'] . '?subject=&amp;body=">';

        // if image set is not custom
        if ($this->settings['sfb_image_set'] != 'custom') {
            // show sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/email.png" title="Email" class="sfb sfb-img" alt="Email this to someone" />';
        } // if using custom images
        else {
            // show custom image
            $htmlFollowButtons .= '<img src="' . $this->settings['sfb_custom_email'] . '" title="Email" class="sfb sfb-img" alt="Email to someone" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get tumblr button
    function sfb_tumblr()
    {
        // tumblr follow link
        $htmlFollowButtons = '<a class="sfb_tumblr_follow" href="'.$this->buttons['tumblr']['url_prefix'].$this->settings['url_tumblr'].$this->buttons['tumblr']['url_suffix'].'" ' . ($this->settings['sfb_follow_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($this->settings['sfb_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

        // if image set is not custom
        if ($this->settings['sfb_image_set'] != 'custom') {
            // show sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/tumblr.png" title="tumblr" class="sfb sfb-img" alt="Follow on Tumblr" />';
        } // if using custom images
        else {
            // show custom image
            $htmlFollowButtons .= '<img src="' . $this->settings['sfb_custom_tumblr'] . '" title="tumblr" class="sfb sfb-img" alt="Follow on Tumblr" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get vk button
    function sfb_vk()
    {
        // vk follow link
        $htmlFollowButtons = '<a class="sfb_vk_follow sfb_follow_link" href="'.$this->buttons['vk']['url_prefix'].$this->settings['url_vk'] . '" ' . ($this->settings['sfb_follow_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($this->settings['sfb_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

        // if image set is not custom
        if ($this->settings['sfb_image_set'] != 'custom') {
            // show sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/vk.png" title="VK" class="sfb sfb-img" alt="Follow on VK" />';
        } // if using custom images
        else {
            // show custom image
            $htmlFollowButtons .= '<img src="' . $this->settings['sfb_custom_vk'] . '" title="VK" class="sfb sfb-img" alt="Follow on VK" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }

    // get yummly button
    function sfb_yummly()
    {
        // yummly follow link
        $htmlFollowButtons = '<a class="sfb_yummly_follow sfb_follow_link" href="'.$this->buttons['yummly']['url_prefix'].$this->settings['url_yummly'] . '" ' . ($this->settings['sfb_follow_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($this->settings['sfb_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

        // if image set is not custom
        if ($this->settings['sfb_image_set'] != 'custom') {
            // show sfb image
            $htmlFollowButtons .= '<img src="' . plugins_url() . '/simple-follow-buttons/buttons/' . $this->settings['sfb_image_set'] . '/yummly.png" title="Yummly" class="sfb sfb-img" alt="Follow on Yummly" />';
        } // if using custom images
        else {
            // show custom image
            $htmlFollowButtons .= '<img src="' . $this->settings['sfb_custom_yummly'] . '" title="Yummly" class="sfb sfb-img" alt="Follow on Yummly" />';
        }

        // close href
        $htmlFollowButtons .= '</a>';

        // return follow buttons
        return $htmlFollowButtons;
    }
}

// register shortcode [sfb] to show [sfb_hide]
add_shortcode( 'sfb', 'sfb_buttons' );
add_shortcode( 'sfb_hide', 'sfb_hide' );
