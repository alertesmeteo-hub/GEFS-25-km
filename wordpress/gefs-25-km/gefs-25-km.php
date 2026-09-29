<?php
/**
 * Plugin Name: Alertes Météo — GEFS 25 km
 * Description: Cartes et tableaux de la prévision d'ensemble GEFS, grille 0,25°.
 * Version: 1.0.1
 * Author: Alertes Météo
 * License: GPL-2.0-or-later
 */
if (!defined('ABSPATH')) { exit; }
add_shortcode('gefs_meteo', function () {
    wp_enqueue_style('gefs-meteo', plugins_url('assets/module.css', __FILE__), array(), '1.0.1');
    wp_enqueue_script('gefs-meteo', plugins_url('assets/module.js', __FILE__), array(), '1.0.1', true);
    $source = apply_filters('gefs_meteo_data_url', 'https://raw.githubusercontent.com/alertesmeteo-hub/GEFS-25-km/data');
    ob_start(); ?>
    <section class="gefs" data-gefs data-source="<?php echo esc_url($source); ?>" data-places="<?php echo esc_url(plugins_url('assets/communes-geo.json', __FILE__)); ?>">
      <h2>GEFS 25 km · grille 0,25°</h2>
      <p>Prévision d’ensemble NOAA/NCEP · contrôle + 30 membres perturbés. Les percentiles décrivent la dispersion des 31 scénarios, pas une garantie d’évolution.</p>
      <p data-status role="status">Chargement des données…</p>
      <section class="gefs-local">
        <h3>Tableau communal · moyenne des 31 membres</h3>
        <div class="gefs-city-controls">
          <label>Commune <input data-city list="gefs-cities" placeholder="Nom ou code INSEE" autocomplete="off"></label>
          <datalist id="gefs-cities"></datalist>
          <button type="button" data-show disabled>Afficher</button>
          <button type="button" data-locate disabled>Me géolocaliser</button>
        </div>
        <p class="gefs-note">Localisation uniquement à votre demande, avec votre autorisation. Vos coordonnées sont traitées dans votre navigateur, sans être envoyées au module météo.</p>
        <p data-city-status role="status" aria-live="polite"></p>
        <p class="gefs-table-stat" data-table-stat><strong>Statistique du tableau :</strong> moyenne des 31 membres</p>
        <div class="gefs-table"><table><thead data-head></thead><tbody data-body></tbody></table></div>
      </section>
      <div class="gefs-controls">
        <label>Domaine <select data-region><option value="france">France</option><option value="europe">Europe</option></select></label>
        <label>Carte <select data-product></select></label>
        <label>Statistique <select data-stat><option value="mean">Moyenne des 31 membres</option><option value="p10">Percentile 10</option><option value="median">Médiane</option><option value="p90">Percentile 90</option></select></label>
        <label>Échéance <select data-step></select></label>
        <label>Zoom <input data-zoom type="range" min="0.5" max="4" value="1" step="0.25"></label>
      </div>
      <p data-period></p>
      <div class="gefs-map"><img data-map alt="Carte GEFS" hidden></div>
      <p class="gefs-note">Vent moyen à 10 m et rafales en km/h (paliers de 5 km/h). Précipitations sur 6 h et cumul depuis le run, en mm d'équivalent eau. Tableau toutes les 6 h jusqu'à H+240 (10 jours), sans interpolation horaire. Cartes à H+0, 6, 12, 18, puis toutes les 24 h. Le cumul total est calculé membre par membre avant les statistiques. La grille est de 0,25° ; « 25 km » est le nom du module, pas une distance constante.</p>
      <footer><span class="gefs-logo">www.alertes-meteo.com</span><p>Source : NOAA/NCEP · GEFS opérationnel. Module GEFS 25 km v1.0.1.</p></footer>
    </section>
    <?php return ob_get_clean();
});
