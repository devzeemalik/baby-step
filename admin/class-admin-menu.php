<?php
/**
 * Create admin menu.
 *
 * PHP version 7
 *
 * @package  Admin_Menu
 */

/**
 * Create Admin menu.
 *
 * Template Class
 *
 * @package  Admin_Menu
 */
class ZTS_Admin_Init {

    /** Constructor call admin menu hook */
    public function __construct() {

        add_action('admin_menu', [$this, 'create_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_assets']);
    }

    /**
     * Admin enque scripts.
     *
     * @since    1.0.3
     */
    public function admin_enqueue_assets() {
        wp_register_style('saf_bs5_css',  'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
        wp_register_style('saf_admin_css', saf_plugin_URL . 'assets/css/bootstrap.css');
        wp_register_style('saf_admin_js_confirm_style', saf_plugin_URL . 'node_modules/jquery-confirm/dist/jquery-confirm.min.css');
        wp_register_script('saf_admin_js_confirm_script', saf_plugin_URL . 'node_modules/jquery-confirm/dist/jquery-confirm.min.js', ['jquery'], '1.0', true);
        wp_register_script('saf_admin_js', saf_plugin_URL . 'assets/js/admin.js', ['jquery'], '1.0', true);
        wp_register_script('saf_bs5_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', ['jquery'], '1.0', true);
    }

    /** Create the admin menu */
    public function create_admin_menu() {
        add_menu_page(
                'ZTS Shop Ajax Filtr',
                'ZTS Shop Ajax Filtr',
                'manage_options',
                'zts_shop_filter_settings',
                [$this, 'admin_menu_callback'],
                'dashicons-admin-multisite',
                20
        );
        add_submenu_page(
            'zts_shop_filter_settings',
            'Product listing',
            'Product listing',
            'manage_options',
            'product_listing',
            array( $this, 'product_listing_callback' ),
            $menu_icon,
            20
        );
    }

    public static function init_admin_assets() {     
        wp_enqueue_style('saf_admin_css');
        wp_enqueue_style('saf_bs5_css');
        wp_enqueue_style('saf_admin_js_confirm_style');
        wp_enqueue_script('saf_bs5_js');
        wp_enqueue_script('saf_admin_js_confirm_script');
        wp_enqueue_script('saf_admin_js');
        wp_localize_script('saf_admin_js', 'saf', [
            'admin_ajax' => admin_url('admin-ajax.php')
        ]);
    }

    /** Max HelloWoofy callback */
    public function admin_menu_callback() {
        $this->init_admin_assets();
        if (isset($_POST['save_presets'])) {
            update_option( 'zts_preset_filter', $_POST['saf_persets'] );
        }
        $get_filter = get_option('zts_preset_filter');
        
        ?>
        <style type="text/css">
            .filter_preset_text{
                margin-right: 15px;
            }
            .card{
                max-width: 100%;
                padding: 0px;
            }
        </style>
        <div class="row pt-3 p-3">
            <div class="col-md-12  ">
                <span class="h5 filter_preset_text" >Filter Preset</span>
            <button class="btn btn-primary h2  saf_add_preset " ><img src="<?php echo saf_plugin_URL . 'assets/media/plus.svg'; ?>" width="20px" alt="alt"/> Add Preset</button>
            </div>
            <br>
            <form method="POST" >
                <div class="row saf_filter" >
                    <div id="Select_term_wrap"></div>
                    <?php
                    if (!empty($get_filter)) {
                        foreach ($get_filter as $key => $filter) {
                            ?>    
                        <div class="col-md-6 saf_parent_row">
                          <div class="card">
                            <div class="card-header">
                              <?php echo $key?>
                            </div>
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-md-4 pt-4">
                                        <label class="form-label">Filter Title:</label>
                                        <input type="text" name="saf_persets[<?php echo $key;?>][title]" class="form-control" value="<?php echo !empty($filter['title']) ? $filter['title'] : '' ?>">
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <label class="form-label">Default Filter:</label>
                                        <select class="form-select" id="sel1" name="saf_persets[<?php echo $key;?>][default_filter]">
                                        <option value="collapse"   <?php echo  $filter['default_filter'] == 'collapse' ? 'selected' :'' ?>>collapse</option>
                                        <option value="show_list" <?php echo  $filter['default_filter'] == 'show_list' ? 'selected' :'' ?>>show list</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <label class="form-label">Select Column:</label>
                                        <select class="form-select" id="sel1" name="saf_persets[<?php echo $key;?>][columns]">
                                        <option value="col1" <?php echo  $filter['columns'] == 'col1' ? 'selected' :'' ?>>one column</option>
                                        <option value="col2" <?php echo  $filter['columns'] == 'col2' ? 'selected' :'' ?>>two column</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <label class="form-label">Filter Type:</label>
                                        <select class="form-select" id="sel1" name="saf_persets[<?php echo $key;?>][filter_type]">
                                        <option value="radio" <?php echo  $filter['filter_type'] == 'radio' ? 'selected' :'' ?>>radio</option>
                                        <option value="checkbox" <?php echo  $filter['filter_type'] == 'checkbox' ? 'selected' :'' ?>>checkbox</option>
                                        <option value="dropdown" <?php echo  $filter['filter_type'] == 'dropdown' ? 'selected' :'' ?>>dropdpwn</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <label class="form-label">Exlude term ids:</label>
                                        <input type="text" name="saf_persets[<?php echo $key; ?>][exlcude]" class="form-control" value="<?php echo $filter['exlcude'] ?>">
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <label class="form-label">Sorting:</label>
                                        <input type="text" name="saf_persets[<?php echo $key; ?>][sorting]" class="form-control" value="<?php echo $filter['sorting'] ?>">
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <button class="btn btn-danger btn-sm saf_remove_preset" >Remove</button>
                                    </div>
                                </div>
                          </div>
                        </div>
                      </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <input type="submit" name="save_presets" value="Save" class="save_presets btn btn-primary mt-4 btn-sm" style="display: none;">
            </form>
        </div>
        <?php
    }

    /** Product listing function */
    public function product_listing_callback(){
        $this->init_admin_assets();
        if(isset($_POST['save_product_columns'])){
            $all_colm  = array(
                'desktop_columns' => $_POST['desktop_columns'],
                'tablet_columns'  => $_POST['tablet_columns'],
                'mobile_columns'  => $_POST['mobile_columns'],
                );
            update_option('zts_product_columns', $all_colm);
        }
        $all_colm = get_option('zts_product_columns');
        ?>
        <style type="text/css">
            .card{
                max-width: 100%;
                padding: 0px;
            }
        </style>
        <div class="card">
            <div class="card-header">
                <h3>Product Listing Columns</h3>
            </div>
            <div class="card-body ">
                <form method="post">
                <div class="row">
                    <h5 class="ms-5 pt-2 ">Desktop</h5>
                    <div class="ms-5">
                        <div class="form-check form-check-inline">
                          <input  type="radio" name="desktop_columns" value="col1" <?php if ($all_colm['desktop_columns'] == 'col1') echo 'checked="checked"'; ?> >
                          <label >Col 1</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input  type="radio" name="desktop_columns" value="col2" <?php if ($all_colm['desktop_columns'] == 'col2') echo 'checked="checked"'; ?> >
                          <label >Col 2</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input  type="radio" name="desktop_columns" value="col3" <?php if ($all_colm['desktop_columns'] == 'col3') echo 'checked="checked"'; ?> >
                          <label >Col 3</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input  type="radio" name="desktop_columns" value="col4" <?php if ($all_colm['desktop_columns'] == 'col4') echo 'checked="checked"'; ?> >
                          <label >Col 4</label>
                        </div>
                    </div>
                    <h5 class="ms-5 pt-2">Tablet</h5>
                    <div class="ms-5">
                        <div class="form-check form-check-inline">
                          <input  type="radio" name="tablet_columns" value="col1" <?php if ($all_colm['tablet_columns'] == 'col1') echo 'checked="checked"'; ?>>
                          <label >Col 1</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input  type="radio" name="tablet_columns" value="col2" <?php if ($all_colm['tablet_columns'] == 'col2') echo 'checked="checked"'; ?>>
                          <label >Col 2</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input  type="radio" name="tablet_columns" value="col3" <?php if ($all_colm['tablet_columns'] == 'col3') echo 'checked="checked"'; ?>>
                          <label >Col 3</label>
                        </div>
                    </div>
                    <h5 class="ms-5 pt-2">Mobile</h5>
                    <div class="ms-5">
                        <div class="form-check form-check-inline">
                          <input  type="radio" name="mobile_columns" value="col1" <?php if ($all_colm['mobile_columns'] == 'col1') echo 'checked="checked"'; ?>>
                          <label >Col 1</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input  type="radio" name="mobile_columns" value="col2" <?php if ($all_colm['mobile_columns'] == 'col2') echo 'checked="checked"'; ?>>
                          <label >Col 2</label>
                        </div>
                    </div>                   
                </div>
                 <button type="submit" name="save_product_columns" class="btn btn-primary   ms-5 mt-3">Save</button>
                </form>
            </div>
        </div>              
    <?php
    }

}

new ZTS_Admin_Init();

