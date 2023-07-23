<?php

/**
 * Plugin Name: ZTS Shop Ajax Filter
 * Plugin URI: https://zubitechsol.com/
 * Description: This plugin create Woocommerce filters.
 * Version: 1.0.0
 * Author: Zeeshan By Zubi Tech Sol
 * Author URI: https://zubitechsol.com/team/zeeshan-malik/
 * License: GPL v3
 *

  /**
 * This is the main class of baby step.
 *
 * @package zta_shop_ajax_fiters
 */
if (!defined('ABSPATH')) {
    exit();
}


if (!defined('saf_plugin_PATH')) {
    define('saf_plugin_PATH', plugin_dir_path(__FILE__));
}
if (!defined('saf_plugin_URL')) {
    define('saf_plugin_URL', plugin_dir_url(__FILE__));
}
if (!defined('saf_plugin_basename')) {
    define('saf_plugin_basename', plugin_basename(__FILE__));
}

class SAF_Init {

    /**
     * Baby Step Main Class contructor.
     *
     * @since    1.0.3
     */
    public function __construct() {
        /* enque admin styles and scripts */
        /* Load all files */
        $this->load_admin_files();
        $this->load_ini_files();
    }

    /**
     * Load admin files.
     *
     * @since    1.0.3
     */
    public function load_admin_files() {
        /* Admin menu */
        require_once saf_plugin_PATH . 'admin/class-admin-menu.php';
    }

    public function load_ini_files() {
        $dir = saf_plugin_PATH . 'ini';
        $files = glob($dir . '/**.php');
        foreach ($files as $file) {
            require_once($file);
        }
    }

}

if (class_exists('SAF_Init')) {
    new SAF_Init();
}
