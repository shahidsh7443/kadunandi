<?php
/*
Plugin Name: WP-PageNavi
Plugin URI: http://wordpress.org/extend/plugins/wp-pagenavi/
Description: Adds a more advanced paging navigation to your WordPress blog.
Version: 2.61
Author: Lester 'GaMerZ' Chan
Author URI: http://lesterchan.net
*/


/*  
    Copyright 2009  Lester Chan  (email : lesterchan@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/



### Function: Page Navigation: Boxed Style Paging
function rentax_pagenavi($before = '', $after = '') {
    global $wpdb, $wp_query;
    rentax_pagenavi_init(); //Calling the pagenavi_init() function

    if (is_single())
        return;

    $pagenavi_options = array(
        'pages_text' => '',
        'current_text' => '%PAGE_NUMBER%',
        'page_text' => '%PAGE_NUMBER%',
        'first_text' => wp_kses_post(__('<i class="fa fa-angle-left"></i>','rentax')),
        'last_text' => wp_kses_post(__('<i class="fa fa-angle-right"></i>','rentax')),
        'next_text' => wp_kses_post(__('NEXT','rentax')),
        'prev_text' => wp_kses_post(__('PREV','rentax')),
        'dotright_text' => esc_html__('...','rentax'),
        'dotleft_text' => esc_html__('...','rentax'),
        'style' => 1,
        'num_pages' => 5,
        'always_show' => 0,
        'num_larger_page_numbers' => 3,
        'larger_page_numbers_multiple' => 10,
        'use_pagenavi_css' => 1,
    );


    $request = $wp_query->request;
    $posts_per_page = intval(get_query_var('posts_per_page'));

    $paged = intval(get_query_var('paged'));
    $numposts = $wp_query->found_posts;
    $max_page = intval($wp_query->max_num_pages);

    if (empty($paged) || $paged == 0)
        $paged = 1;

    $pages_to_show = intval($pagenavi_options['num_pages']);
    $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
    $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor($pages_to_show_minus_1/2);
    $half_page_end = ceil($pages_to_show_minus_1/2);
    $start_page = $paged - $half_page_start;

    if ($start_page <= 0)
        $start_page = 1;

    $end_page = $paged + $half_page_end;
    if (($end_page - $start_page) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }

    if ($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }

    if ($start_page <= 0)
        $start_page = 1;

    $larger_pages_array = array();
    if ( $larger_page_multiple )
        for ( $i = $larger_page_multiple; $i <= $max_page; $i += $larger_page_multiple )
            $larger_pages_array[] = $i;

    if ($max_page > 1 || intval($pagenavi_options['always_show'])) {
        $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), esc_html__('Page %CURRENT_PAGE% of %TOTAL_PAGES%','rentax'));
        $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
        echo wp_kses_post($before).'<ul class="pagination">'."\n";
        switch(intval($pagenavi_options['style'])) {
            // Normal
            case 1:
                if (!empty($pages_text)) {
                    //echo '<li><span class="pages">'.$pages_text.'</span></li>';
                }
                if ($start_page >= 2 && $pages_to_show < $max_page) {
                    $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
                    echo '<li><a href="'.esc_url(get_pagenum_link()).'" class="first" title="">'.$first_page_text.'</a></li>';
                    if (!empty($pagenavi_options['dotleft_text'])) {
                        echo '<li><span class="extend">'.$pagenavi_options['dotleft_text'].'</span></li>';
                    }
                }
                $larger_page_start = 0;
                foreach($larger_pages_array as $larger_page) {
                    if ($larger_page < $start_page && $larger_page_start < $larger_page_to_show) {
                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
                        echo '<li><a href="'.esc_url(get_pagenum_link($larger_page)).'" class="page" title="'.$page_text.'">'.$page_text.'</a></li>';
                        $larger_page_start++;
                    }
                }
                echo '<li class="arrow">'.get_previous_posts_link($pagenavi_options['prev_text']).'</li>';
                for($i = $start_page; $i  <= $end_page; $i++) {
                    if ($i == $paged) {
                        $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                        echo '<li class="active"><a href="#">'.$current_page_text.'</a></li>';
                    } else {
                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                        echo '<li><a href="'.esc_url(get_pagenum_link($i)).'" class="page" title="'.$page_text.'">'.$page_text.'</a></li>';
                    }
                }
                echo '<li class="arrow">'.get_next_posts_link($pagenavi_options['next_text'], $max_page).'</li>';
                $larger_page_end = 0;
                foreach($larger_pages_array as $larger_page) {
                    if ($larger_page > $end_page && $larger_page_end < $larger_page_to_show) {
                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
                        echo '<li><a href="'.esc_url(get_pagenum_link($larger_page)).'" class="page" title="'.$page_text.'">'.$page_text.'</a></li>';
                        $larger_page_end++;
                    }
                }
                if ($end_page < $max_page) {
                    if (!empty($pagenavi_options['dotright_text'])) {
                        echo '<li><span class="extend">'.$pagenavi_options['dotright_text'].'</span></li>';
                    }
                    $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                    echo '<li><a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="">'.$last_page_text.'</a></li>';
                }
                break;

        }
        echo '</ul>'.$after."\n";
    }
}


### Function: Round To The Nearest Value
function rentax_n_round($num, $tonearest) {
   return floor($num/$tonearest)*$tonearest;
}


### Function: Filters for Previous and Next Posts Link CSS Class
add_filter('previous_posts_link_attributes','rentax_previous_posts_link_class');
function rentax_previous_posts_link_class() {
    return 'class="previouspostslink"';
}
add_filter('next_posts_link_attributes','rentax_next_posts_link_class');
function rentax_next_posts_link_class() {
    return 'class="nextpostslink"';
}


### Function: Page Navigation Options
register_activation_hook(__FILE__, 'rentax_pagenavi_init');
function rentax_pagenavi_init() {

    // Add Options
    $pagenavi_options = array(
        'pages_text' => '',
        'current_text' => '%PAGE_NUMBER%',
        'page_text' => '%PAGE_NUMBER%',
        'first_text' => esc_html__('','rentax'),
        'last_text' => esc_html__('','rentax'),
        'next_text' => esc_html__('1','rentax'),
        'prev_text' => wp_kses_post(__('<span class="icon-chevron-left"></span>','rentax')),
        'dotright_text' => esc_html__('...','rentax'),
        'dotleft_text' => esc_html__('...','rentax'),
        'style' => 1,
        'num_pages' => 5,
        'always_show' => 0,
        'num_larger_page_numbers' => 3,
        'larger_page_numbers_multiple' => 10,
        'use_pagenavi_css' => 1,
    );
    add_option('pagenavi_options', $pagenavi_options);
}


