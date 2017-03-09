<?php
/**
 * Global helpers file with misc functions
 * */
if (!function_exists('app_name')) {

    /**
     * Helper to grab the application name
     *
     * @return mixed
     */
    function app_name() {
        return config('app.name');
    }

}

if (!function_exists('access')) {

    /**
     * Access (lol) the Access:: facade as a simple function
     */
    function access() {
        return app('access');
    }

}

if (!function_exists('javascript')) {

    /**
     * Access the javascript helper
     */
    function javascript() {
        return app('JavaScript');
    }

}

if (!function_exists('gravatar')) {

    /**
     * Access the gravatar helper
     */
    function gravatar() {
        return app('gravatar');
    }

}
if (!function_exists('parse_vimeo')) {

    function parse_vimeo($url) {
        $temp = explode("/", $url);
        return $temp[count($temp) - 1];
    }

}

if (!function_exists('breadcrumbs')) {

    function list_breadcrumbs($url, $page_title) {

        $parent_id = \DB::table('menus')->where('url', $url)->first();

        if (!empty($parent_id)) {
            $parent_page = \DB::table('menus')->where('id', $parent_id->parent_id)->first();
        }
        ob_start();
        ?>
        <ol class="breadcrumb">
            <li><a href="<?php echo url(); ?>">Home</a></li>
            <?php
            if (!empty($parent_page)) {
                ?>
                <li><a href="<?php echo url() . '/' . $parent_page->url; ?>"><?php echo $parent_page->title; ?></a></li>
            <?php } ?>
            <li class="active"><?php echo $page_title; ?></li>
        </ol>
        <?php
        $breadcrumb_html = ob_get_clean();
        return $breadcrumb_html;
    }
}
