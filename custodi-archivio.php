<?php
/*
Plugin Name: Archivio dei Custodi del Doge
Plugin URI: https://icustodideldoge.it
Description: Plugin ufficiale per la gestione dei dossier dell'Archivio Centrale dei Custodi del Doge.
Version: 0.1.0
Author: I Custodi del Doge
Text Domain: custodi-archivio
*/

if (!defined('ABSPATH')) exit;

define('CUSTODI_ARCHIVIO_VERSION', '0.1.0');
define('CUSTODI_ARCHIVIO_URL', plugin_dir_url(__FILE__));
define('CUSTODI_ARCHIVIO_PATH', plugin_dir_path(__FILE__));

require_once CUSTODI_ARCHIVIO_PATH . 'core/Loader.php';
require_once CUSTODI_ARCHIVIO_PATH . 'core/Kernel.php';
require_once CUSTODI_ARCHIVIO_PATH . 'core/Xukera.php';
require_once CUSTODI_ARCHIVIO_PATH . 'core/Graph.php';
require_once CUSTODI_ARCHIVIO_PATH . 'core/Node.php';
require_once CUSTODI_ARCHIVIO_PATH . 'core/Relation.php';

add_action('plugins_loaded', function () {
    $xukera = new \Xukera\Core\Xukera(CUSTODI_ARCHIVIO_PATH);

$xukera->boot();
});
add_action('init', function() {
    register_post_type('custodi_dossier', array(
        'labels' => array(
            'name' => 'Dossier',
            'singular_name' => 'Dossier',
            'menu_name' => 'Dossier',
            'add_new_item' => 'Aggiungi nuovo dossier',
            'edit_item' => 'Modifica dossier',
            'new_item' => 'Nuovo dossier',
            'view_item' => 'Vedi dossier',
            'search_items' => 'Cerca dossier'
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'dossier'),
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true
    ));
});

add_action('admin_menu', function() {
    add_menu_page('Custodi del Doge', 'Custodi del Doge', 'edit_posts', 'custodi-archivio', 'custodi_archivio_dashboard', 'dashicons-shield', 26);
    add_submenu_page('custodi-archivio', 'Dashboard Archivio', 'Dashboard', 'edit_posts', 'custodi-archivio', 'custodi_archivio_dashboard');
    add_submenu_page('custodi-archivio', 'Tutti i Dossier', 'Dossier', 'edit_posts', 'edit.php?post_type=custodi_dossier');
    add_submenu_page('custodi-archivio', 'Nuovo Dossier', '➕ Nuovo Dossier', 'edit_posts', 'post-new.php?post_type=custodi_dossier');
});

function custodi_archivio_dashboard() {
    ?>
    <div class="wrap">
        <h1>Archivio Centrale dei Custodi del Doge</h1>
        <p>Benvenuto nella dashboard operativa dell'Archivio.</p>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-top:25px;">
            <div style="background:#fff;border-left:5px solid #b89445;padding:20px;">
                <h2>📁 Nuovo Dossier</h2>
                <p>Crea una nuova indagine archivistica.</p>
                <a class="button button-primary" href="<?php echo admin_url('post-new.php?post_type=custodi_dossier'); ?>">Crea dossier</a>
            </div>
            <div style="background:#fff;border-left:5px solid #8b1d1d;padding:20px;">
                <h2>📂 Dossier</h2>
                <p>Consulta e modifica tutti i dossier.</p>
                <a class="button" href="<?php echo admin_url('edit.php?post_type=custodi_dossier'); ?>">Apri archivio</a>
            </div>
            <div style="background:#fff;border-left:5px solid #3b2613;padding:20px;">
                <h2>🧱 Muro della Memoria</h2>
                <p>Funzione prevista nella versione 0.2</p>
            </div>
            <div style="background:#fff;border-left:5px solid #52661d;padding:20px;">
                <h2>📥 Contributi</h2>
                <p>Funzione prevista nella versione 0.3</p>
            </div>
        </div>
    </div>
    <?php
}

add_action('add_meta_boxes', function() {
    add_meta_box('custodi_dossier_meta', 'Scheda Archivistica del Dossier', 'custodi_dossier_meta_box', 'custodi_dossier', 'normal', 'high');
});

function custodi_dossier_meta_box($post) {
    wp_nonce_field('custodi_save_dossier_meta', 'custodi_dossier_nonce');

    $fields = array(
        'numero' => 'Numero dossier (es. CD-001)',
        'serie' => 'Serie archivistica',
        'classificazione' => 'Classificazione',
        'luogo' => 'Luogo',
        'accesso' => 'Livello di accesso',
        'stato' => 'Stato dell’indagine',
        'rarita' => 'Rarità',
        'percentuale' => 'Percentuale indagine',
        'aggiornamento' => 'Ultimo aggiornamento',
        'versione' => 'Versione',
        'cerca1' => 'Cosa cerchiamo 1',
        'cerca2' => 'Cosa cerchiamo 2',
        'cerca3' => 'Cosa cerchiamo 3',
        'cerca4' => 'Cosa cerchiamo 4',
        'nota' => 'Nota stato indagine',
        'contributi' => 'Contributi ricevuti',
        'timbro' => 'URL timbro',
        'sigillo' => 'URL sigillo',
        'graffetta' => 'URL graffetta'
    );

    echo '<table class="form-table">';
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, '_custodi_' . $key, true);
        echo '<tr><th><label for="custodi_' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
        if (in_array($key, array('nota', 'contributi'))) {
            echo '<textarea style="width:100%;min-height:80px;" id="custodi_' . esc_attr($key) . '" name="custodi_' . esc_attr($key) . '">' . esc_textarea($value) . '</textarea>';
        } else {
            echo '<input style="width:100%;" type="text" id="custodi_' . esc_attr($key) . '" name="custodi_' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
        }
        echo '</td></tr>';
    }
    echo '</table><p><strong>Nota:</strong> usa l’immagine in evidenza del dossier come fotografia principale.</p>';
}

add_action('save_post_custodi_dossier', function($post_id) {
    if (!isset($_POST['custodi_dossier_nonce']) || !wp_verify_nonce($_POST['custodi_dossier_nonce'], 'custodi_save_dossier_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = array('numero','serie','classificazione','luogo','accesso','stato','rarita','percentuale','aggiornamento','versione','cerca1','cerca2','cerca3','cerca4','nota','contributi','timbro','sigillo','graffetta');
    foreach ($fields as $field) {
        if (isset($_POST['custodi_' . $field])) {
            update_post_meta($post_id, '_custodi_' . $field, sanitize_textarea_field($_POST['custodi_' . $field]));
        }
    }
});

function custodi_meta($post_id, $key, $default = '') {
    $value = get_post_meta($post_id, '_custodi_' . $key, true);
    return $value !== '' ? $value : $default;
}

add_filter('the_content', function($content) {
    if (is_singular('custodi_dossier') && in_the_loop() && is_main_query()) {
        return custodi_render_dossier(get_the_ID()) . '<div class="custodi-dossier-content">' . $content . '</div>';
    }
    return $content;
});

add_shortcode('custodi_dossier_view', function($atts) {
    $atts = shortcode_atts(array('id' => '', 'slug' => ''), $atts);
    $post = null;

    if (!empty($atts['id'])) {
        $post = get_post(intval($atts['id']));
    } elseif (!empty($atts['slug'])) {
        $posts = get_posts(array('name' => sanitize_title($atts['slug']), 'post_type' => 'custodi_dossier', 'post_status' => 'publish', 'numberposts' => 1));
        if ($posts) $post = $posts[0];
    }

    if (!$post || $post->post_type !== 'custodi_dossier') return '<p>Dossier non trovato.</p>';
    return custodi_render_dossier($post->ID);
});

function custodi_render_dossier($post_id) {
    $title = get_the_title($post_id);
    $foto = get_the_post_thumbnail_url($post_id, 'large');

    $numero = custodi_meta($post_id, 'numero', 'CD-001');
    $serie = custodi_meta($post_id, 'serie', 'LP – Leggende Perdute');
    $classificazione = custodi_meta($post_id, 'classificazione', 'LP-TOR-001');
    $luogo = custodi_meta($post_id, 'luogo', '');
    $accesso = custodi_meta($post_id, 'accesso', 'PUBBLICO');
    $stato = custodi_meta($post_id, 'stato', 'Indagine aperta');
    $rarita = custodi_meta($post_id, 'rarita', '★★★★★');
    $percentuale = custodi_meta($post_id, 'percentuale', '0%');
    $aggiornamento = custodi_meta($post_id, 'aggiornamento', date_i18n('j F Y'));
    $versione = custodi_meta($post_id, 'versione', '1.0');
    $nota = custodi_meta($post_id, 'nota', 'Indagine in corso.');
    $contributi = custodi_meta($post_id, 'contributi', 'In attesa di contributi');
    $timbro = custodi_meta($post_id, 'timbro', 'https://icustodideldoge.it/wp-content/uploads/2026/06/timbro-memoria-in-pericolo.png');
    $sigillo = custodi_meta($post_id, 'sigillo', 'https://icustodideldoge.it/wp-content/uploads/2026/06/sigillo-custodi-oro.png');
    $graffetta = custodi_meta($post_id, 'graffetta', 'https://icustodideldoge.it/wp-content/uploads/2026/06/graffetta-metallica.png');
    $cerca = array(custodi_meta($post_id, 'cerca1'), custodi_meta($post_id, 'cerca2'), custodi_meta($post_id, 'cerca3'), custodi_meta($post_id, 'cerca4'));

    ob_start(); ?>
    <div class="custodi-dossier">
        <div class="custodi-linguetta">ARCHIVIO</div>
        <?php if ($sigillo): ?><img class="custodi-sigillo" src="<?php echo esc_url($sigillo); ?>" alt=""><?php endif; ?>
        <?php if ($timbro): ?><img class="custodi-timbro" src="<?php echo esc_url($timbro); ?>" alt=""><?php endif; ?>

        <div class="custodi-dossier-top">
            <aside class="custodi-scheda">
                <h3>Archivio Centrale<br>dei Custodi del Doge</h3>
                <h2>Dossier <?php echo esc_html($numero); ?></h2>
                <p><strong>Serie:</strong><br><?php echo esc_html($serie); ?></p>
                <p><strong>Classificazione:</strong><br><?php echo esc_html($classificazione); ?></p>
                <p><strong>Livello di accesso:</strong><br><span class="custodi-accesso"><?php echo esc_html($accesso); ?></span></p>
                <p><strong>Stato:</strong><br><span class="custodi-stato"><?php echo esc_html($stato); ?></span></p>
                <p><strong>Rarità:</strong><br><span class="custodi-rarita"><?php echo esc_html($rarita); ?></span></p>
                <p><strong>Ultimo aggiornamento:</strong><br><?php echo esc_html($aggiornamento); ?></p>
                <p><strong>Versione:</strong><br><?php echo esc_html($versione); ?></p>
            </aside>

            <main class="custodi-main">
                <h1><?php echo esc_html($title); ?></h1>
                <?php if ($luogo): ?><div class="custodi-luogo"><?php echo esc_html($luogo); ?></div><?php endif; ?>
                <?php if ($foto): ?>
                    <div class="custodi-foto">
                        <img src="<?php echo esc_url($foto); ?>" alt="<?php echo esc_attr($title); ?>">
                        <?php if ($graffetta): ?><img class="custodi-graffetta" src="<?php echo esc_url($graffetta); ?>" alt=""><?php endif; ?>
                    </div>
                <?php endif; ?>
            </main>
        </div>

        <div class="custodi-boxes">
            <section>
                <h3>Cosa stiamo cercando</h3>
                <ul>
                    <?php foreach ($cerca as $item): if (!empty($item)): ?><li><?php echo esc_html($item); ?></li><?php endif; endforeach; ?>
                </ul>
            </section>
            <section class="custodi-center">
                <h3>Stato dell’indagine</h3>
                <div class="custodi-percentuale"><?php echo esc_html($percentuale); ?></div>
                <p><strong><?php echo esc_html($stato); ?></strong></p>
                <p><?php echo esc_html($nota); ?></p>
            </section>
            <section>
                <h3>Contributi ricevuti</h3>
                <p><?php echo nl2br(esc_html($contributi)); ?></p>
            </section>
        </div>

        <div class="custodi-motto">La memoria è un ponte tra passato e futuro. Sta a noi custodirla.</div>
    </div>
    <?php return ob_get_clean();
}

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('custodi-archivio-style', CUSTODI_ARCHIVIO_URL . 'assets/css/custodi-archivio.css', array(), CUSTODI_ARCHIVIO_VERSION);
});
?>
