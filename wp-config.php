<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', '358-22_83789' );

/** Имя пользователя базы данных */
define( 'DB_USER', '358-22_83789' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', '2cf64506b30422866e1e' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '?4rcHUoW5V.(cFo<x^_3qd&=u -O{y0D+Wy)e;~(G[|*4X@K0vXm~<t9soeZVZmE' );
define( 'SECURE_AUTH_KEY',  'a_/sCP7zIC5kKGJ_cEtmDY.y:[{81ItU5P@3S#I0EemKhc.SV@UR4[s}{D?u:!f7' );
define( 'LOGGED_IN_KEY',    'TsIoxu0I:kH6HCZX[TtWLt.`]S|xZ4WQ-L:LCWv0;2xs(S!ny305C*CP-kJt59^1' );
define( 'NONCE_KEY',        '2?*ne|pa^n(Tp-gd0|iRZ]UFd/@rvF(CkBsx v,apOYF_&af]:t7Y4$Rmpr<i%0J' );
define( 'AUTH_SALT',        'Fq 5Pkj<;mxu=BwoPe3]~6XOr+dlf]W?R[kos!z![{wn4i3=[yxkTVR@Evt|g}nW' );
define( 'SECURE_AUTH_SALT', '_C{9w4t/3e$8[?!|BaI?aDf4:=,nk`KmVLz>YJWD7Z8-d6~fOj*}<u+#)i6ULq-k' );
define( 'LOGGED_IN_SALT',   'RV5K_&a#NXJ|=,cK ]&,9qrSNXX-zt,_:}MLhLo([H`L2FYHhXA+tZ#!%EU2eh^I' );
define( 'NONCE_SALT',       'z9hn;5?!:ckwytPipj7Bzm7>7K)w#[pSk5qp|f2;Xzba^g(>tA+7icdZ@UHByBHo' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = '7n8lq_';


/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';