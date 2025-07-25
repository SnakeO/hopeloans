<?php
if (!class_exists('SuperCarousel_Templates_Importer')) :

    class SuperCarousel_Templates_Importer {

        /**
         * Stores the singleton instance.
         *
         * @access private
         *
         * @var object
         */
        private static $instance;

        /**
         * The attachment ID.
         *
         * @access private
         *
         * @var int
         */
        private $file_id;

        /**
         * The transient key template used to store the options after upload.
         *
         * @access private
         *
         * @var string
         */
        private $transient_key = 'supertemplate-import-%d';

        /**
         * The plugin version.
         */
        const VERSION = 3;

        /**
         * The minimum file version the importer will allow.
         *
         * @access private
         *
         * @var int
         */
        private $min_version = 3;

        /**
         * Stores the import data from the uploaded file.
         *
         * @access public
         *
         * @var array
         */
        public $import_data;

        private function __construct() {
            /* Don't do anything, needs to be initialized via instance() method */
        }

        public function __clone() {
            wp_die("Please don't __clone SuperCarousel_Templates_Importer");
        }

        public function __wakeup() {
            wp_die("Please don't __wakeup SuperCarousel_Templates_Importer");
        }

        public static function instance() {
            if (!isset(self::$instance)) {
                self::$instance = new SuperCarousel_Templates_Importer;
                self::$instance->setup();
            }
            return self::$instance;
        }

        /**
         * Initialize the singleton.
         *
         * @return void
         */
        public function setup() {
            add_action('export_filters', array($this, 'export_filters'));
            add_filter('export_args', array($this, 'export_args'));
            add_action('export_wp', array($this, 'export_wp'));
            add_action('admin_init', array($this, 'register_importer'));
        }

        /**
         * Register our importer.
         *
         * @return void
         */
        public function register_importer() {
            if (function_exists('register_importer')) {
                register_importer('supercarousel-template-import', __('Super Carousel Templates', 'supercarousel'), __('Import Templates from a JSON file', 'supercarousel'), array($this, 'dispatch'));
            }
        }

        /**
         * Add a radio option to export options.
         *
         * @return void
         */
        public function export_filters() {
            ?>
            <p><label><input type="radio" name="content" value="supertemplates" /> <?php _e('Super Carousel Templates', 'supercarousel'); ?></label></p>
            <?php
        }

        /**
         * If the user selected that they want to export options, indicate that in the args and
         * discard anything else. This will get picked up by WP_Options_Importer::export_wp().
         *
         * @param  array $args The export args being filtered.
         * @return array The (possibly modified) export args.
         */
        public function export_args($args) {
            if (!empty($_GET['content']) && 'supertemplates' == $_GET['content']) {
                return array('supertemplates' => true);
            }
            return $args;
        }

        /**
         * Export options as a JSON file if that's what the user wants to do.
         *
         * @param  array $args The export arguments.
         * @return void
         */
        public function export_wp($args) {
            if (!empty($args['supertemplates'])) {
                global $wpdb;

                $sitename = sanitize_key(get_bloginfo('name'));
                if (!empty($sitename)) {
                    $sitename .= '.';
                }
                $filename = $sitename . 'SuperCarousel-Templates.' . date('Y-m-d') . '.json';

                header('Content-Description: File Transfer');
                header('Content-Disposition: attachment; filename=' . $filename);
                header('Content-Type: application/json; charset=' . get_option('blog_charset'), true);

                // Ignore multisite-specific keys
                $multisite_exclude = '';
                if (function_exists('is_multisite') && is_multisite()) {
                    $multisite_exclude = $wpdb->prepare("AND `option_name` NOT LIKE 'wp_%d_%%'", get_current_blog_id());
                }

                $option_names = $wpdb->get_col("SELECT DISTINCT `option_name` FROM $wpdb->options WHERE `option_name` LIKE 'supertem_%' {$multisite_exclude}");
                if (!empty($option_names)) {

                    $export_options = array();
                    // we're going to use a random hash as our default, to know if something is set or not
                    foreach ($option_names as $option_name) {
                        $option_value = get_option($option_name);
                        $export_options[$option_name] = maybe_serialize($option_value);
                    }

                    $JSON_PRETTY_PRINT = defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : null;
                    echo json_encode(array('version' => self::VERSION, 'options' => $export_options), $JSON_PRETTY_PRINT);
                }
                exit;
            }
        }

        /**
         * Registered callback function for the Options Importer
         *
         * Manages the three separate stages of the import process.
         *
         * @return void
         */
        public function dispatch() {
            $this->header();

            if (empty($_GET['step'])) {
                $_GET['step'] = 0;
            }

            switch (intval($_GET['step'])) {
                case 0:
                    $this->greet();
                    break;
                case 1:
                    check_admin_referer('import-upload');
                    if ($this->handle_upload()) {
                        $this->pre_import();
                    } else {
                        echo '<p><a href="' . esc_url(admin_url('admin.php?import=supercarousel-template-import')) . '">' . __('Return to File Upload', 'supercarousel') . '</a></p>';
                    }
                    break;
                case 2:
                    check_admin_referer('import-supertemplate-options');
                    $this->file_id = intval($_POST['import_id']);
                    if (false !== ( $this->import_data = get_transient($this->transient_key()) )) {
                        $this->import();
                    }
                    break;
            }

            $this->footer();
        }

        /**
         * Start the options import page HTML.
         *
         * @return void
         */
        private function header() {
            echo '<div class="wrap">';
            echo '<h2>' . __('Import Super Carousel Templates', 'supercarousel') . '</h2>';
        }

        /**
         * End the options import page HTML.
         *
         * @return void
         */
        private function footer() {
            echo '</div>';
        }

        /**
         * Display introductory text and file upload form.
         *
         * @return void
         */
        private function greet() {
            echo '<div class="narrow">';
            echo '<p>' . __('Howdy! Upload Super Template JSON file and we&#8217;ll import the desired data. You&#8217;ll have a chance to review the data prior to import.', 'supercarousel') . '</p>';
            echo '<p>' . __('Choose a JSON (.json) file to upload, then click Upload file and import.', 'supercarousel') . '</p>';
            wp_import_upload_form('admin.php?import=supercarousel-template-import&amp;step=1');
            echo '</div>';
        }

        /**
         * Handles the JSON upload and initial parsing of the file to prepare for
         * displaying author import options
         *
         * @return bool False if error uploading or invalid file, true otherwise
         */
        private function handle_upload() {
            $file = wp_import_handle_upload();

            if (isset($file['error'])) {
                return $this->error_message(
                                __('Sorry, there has been an error.', 'supercarousel'), esc_html($file['error'])
                );
            }

            if (!isset($file['file'], $file['id'])) {
                return $this->error_message(
                                __('Sorry, there has been an error.', 'supercarousel'), __('The file did not upload properly. Please try again.', 'supercarousel')
                );
            }

            $this->file_id = intval($file['id']);

            if (!file_exists($file['file'])) {
                wp_import_cleanup($this->file_id);
                return $this->error_message(
                                __('Sorry, there has been an error.', 'supercarousel'), sprintf(__('The export file could not be found at <code>%s</code>. It is likely that this was caused by a permissions problem.', 'supercarousel'), esc_html($file['file']))
                );
            }

            if (!is_file($file['file'])) {
                wp_import_cleanup($this->file_id);
                return $this->error_message(
                                __('Sorry, there has been an error.', 'wordpress-importer'), __('The path is not a file, please try again.', 'wordpress-importer')
                );
            }

            $file_contents = file_get_contents($file['file']);
            $this->import_data = json_decode($file_contents, true);
            set_transient($this->transient_key(), $this->import_data, DAY_IN_SECONDS);
            wp_import_cleanup($this->file_id);

            return $this->run_data_check();
        }

        /**
         * Provide the user with a choice of which options to import from the JSON
         * file, pre-selecting known options.
         *
         * @return void
         */
        private function pre_import() {
            ?>
            <style type="text/css">
                #importing_options {
                    border-collapse: collapse;
                }
                #importing_options th {
                    text-align: left;
                }
                #importing_options td, #importing_options th {
                    padding: 5px 10px;
                    border-bottom: 1px solid #dfdfdf;
                }
                #importing_options pre {
                    white-space: pre-wrap;
                    max-height: 100px;
                    overflow-y: auto;
                    background: #fff;
                    padding: 5px;
                }
                div.error#import_all_warning {
                    margin: 25px 0 5px;
                }
            </style>
            <script type="text/javascript">
                jQuery(function ($) {
                    $('#option_importer_details,#import_all_warning').hide();
                    options_override_all_warning = function () {
                        $('#import_all_warning').toggle($('input.which-options[value="all"]').is(':checked') && $('#override_current').is(':checked'));
                    };
                    $('.which-options').change(function () {
                        options_override_all_warning();
                        switch ($(this).val()) {
                            case 'specific' :
                                $('#option_importer_details').fadeIn();
                                break;
                            default :
                                $('#option_importer_details').fadeOut();
                                break;
                        }
                    });
                    $('#override_current').click(options_override_all_warning);
                    $('#importing_options input:checkbox').each(function () {
                        $(this).data('default', $(this).is(':checked'));
                    });
                    $('.options-bulk-select').click(function (event) {
                        event.preventDefault();
                        switch ($(this).data('select')) {
                            case 'all' :
                                $('#importing_options input:checkbox').prop('checked', true);
                                break;
                            case 'none' :
                                $('#importing_options input:checkbox').prop('checked', false);
                                break;
                            case 'defaults' :
                                $('#importing_options input:checkbox').each(function () {
                                    $(this).prop('checked', $(this).data('default'));
                                });
                                break;
                        }
                    });
                });
            </script>
            <form action="<?php echo admin_url('admin.php?import=supercarousel-template-import&amp;step=2'); ?>" method="post">
                <?php wp_nonce_field('import-supertemplate-options'); ?>
                <input type="hidden" name="import_id" value="<?php echo absint($this->file_id); ?>" />

                <h3><?php _e('What would you like to import?', 'supercarousel') ?></h3>
                <p>
                    <label><input type="radio" class="which-options" name="settings[which_options]" value="all" checked="" /> <?php _e('All Templates'); ?></label>
                    <br /><label><input type="radio" class="which-options" name="settings[which_options]" value="specific" /> <?php _e('Specific Templates'); ?></label>
                </p>

                <div id="option_importer_details">
                    <h3><?php _e('Select the Templates to import', 'supercarousel'); ?></h3>
                    <p>
                        <a href="#" class="options-bulk-select" data-select="all"><?php _e('Select All', 'supercarousel'); ?></a>
                        | <a href="#" class="options-bulk-select" data-select="none"><?php _e('Select None', 'supercarousel'); ?></a>
                    </p>
                    <table id="importing_options">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th><?php _e('Template Name', 'supercarousel'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->import_data['options'] as $option_name => $option_value) : ?>
                                <tr>
                                    <td><input type="checkbox" name="options[]" value="<?php echo esc_attr($option_name) ?>" /></td>
                                    <td><?php echo esc_html(substr($option_name, 9)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <h3><?php _e('Additional Settings', 'supercarousel'); ?></h3>
                <p>
                    <input type="checkbox" value="1" name="settings[override]" id="override_current" checked="checked" />
                    <label for="override_current"><?php _e('Override existing templates', 'supercarousel'); ?></label>
                </p>
                <p class="description"><?php _e('If you uncheck this box, templates will be skipped if they currently exist.', 'supercarousel'); ?></p>

                <div class="error inline" id="import_all_warning">
                    <p class="description"><?php _e('Caution! Importing all templates with the override option will replace the existing templates.', 'supercarousel'); ?></p>
                </div>

                <?php submit_button(__('Import Selected Templates', 'supercarousel')); ?>
            </form>
            <?php
        }

        /**
         * The main controller for the actual import stage.
         *
         * @return void
         */
        private function import() {
            if ($this->run_data_check()) {
                if (empty($_POST['settings']['which_options'])) {
                    $this->error_message(__('The posted data does not appear intact. Please try again.', 'supercarousel'));
                    $this->pre_import();
                    return;
                }

                $options_to_import = array();
                if ('all' == $_POST['settings']['which_options']) {
                    $options_to_import = array_keys($this->import_data['options']);
                } elseif ('specific' == $_POST['settings']['which_options']) {
                    if (empty($_POST['options'])) {
                        $this->error_message(__('There do not appear to be any options to import. Did you select any?', 'supercarousel'));
                        $this->pre_import();
                        return;
                    }

                    $options_to_import = $_POST['options'];
                }

                $override = (!empty($_POST['settings']['override']) && '1' === $_POST['settings']['override'] );

                $hash = '048f8580e913efe41ca7d402cc51e848';

                foreach ((array) $options_to_import as $option_name) {
                    if (isset($this->import_data['options'][$option_name])) {

                        if (!$override) {
                            // we're going to use a random hash as our default, to know if something is set or not
                            $old_value = get_option($option_name, $hash);

                            // only import the setting if it's not present
                            if ($old_value !== $hash) {
                                echo "\n<p>" . sprintf(__('Skipped template `%s` because it currently exists.', 'supercarousel'), esc_html(substr($option_name, 9))) . '</p>';
                                continue;
                            }
                        }

                        $option_value = maybe_unserialize($this->import_data['options'][$option_name]);
                        update_option($option_name, $option_value);
                    } elseif ('specific' == $_POST['settings']['which_options']) {
                        echo "\n<p>" . sprintf(__('Failed to import template `%s`; it does not appear to be in the import file.', 'supercarousel'), esc_html($option_name)) . '</p>';
                    }
                }

                $this->clean_up();
                echo '<p>' . __('All done. That was easy.', 'supercarousel') . ' <a href="' . admin_url() . '">' . __('Have fun!', 'supercarousel') . '</a>' . '</p>';
            }
        }

        /**
         * Run a series of checks to ensure we're working with a valid JSON export.
         *
         * @return bool true if the file and data appear valid, false otherwise.
         */
        private function run_data_check() {
            if (empty($this->import_data['version'])) {
                $this->clean_up();
                return $this->error_message(__('Sorry, there has been an error. This file may not contain data or is corrupt.', 'supercarousel'));
            }

            if ($this->import_data['version'] < $this->min_version) {
                $this->clean_up();
                return $this->error_message(sprintf(__('This JSON file (version %s) is not supported by this version of the importer. Please update the plugin on the source, or download an older version of the plugin to this installation.', 'supercarousel'), intval($this->import_data['version'])));
            }

            if ($this->import_data['version'] > self::VERSION) {
                $this->clean_up();
                return $this->error_message(sprintf(__('This JSON file (version %s) is from a newer version of this plugin and may not be compatible. Please update this plugin.', 'supercarousel'), intval($this->import_data['version'])));
            }

            if (empty($this->import_data['options'])) {
                $this->clean_up();
                return $this->error_message(__('Sorry, there has been an error. This file appears valid, but does not seem to have any options.', 'supercarousel'));
            }

            return true;
        }

        private function transient_key() {
            return sprintf($this->transient_key, $this->file_id);
        }

        private function clean_up() {
            delete_transient($this->transient_key());
        }

        /**
         * A helper method to keep DRY with our error messages. Note that the error messages
         * must be escaped prior to being passed to this method (this allows us to send HTML).
         *
         * @param  string $message The main message to output.
         * @param  string $details Optional. Additional details.
         * @return bool false
         */
        private function error_message($message, $details = '') {
            echo '<div class="error"><p><strong>' . $message . '</strong>';
            if (!empty($details)) {
                echo '<br />' . $details;
            }
            echo '</p></div>';
            return false;
        }

    }

    SuperCarousel_Templates_Importer::instance();

endif;