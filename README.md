# GEFS 25 km — Alertes Météo

Module WordPress `[gefs_meteo]`, indépendant d’AIGEFS, PEARP et des modèles déterministes.

Source opérationnelle NOAA/NCEP GEFS, 31 membres (contrôle + 30 perturbés),
grille mondiale 0,25°, 41 échéances H+0 à H+240 par pas de 6 h. Aucun secret
NOAA nécessaire. « 25 km » est un nom de module : 0,25° ne représente pas une
distance constante.

Produits : température et humidité à 2 m, vent scalaire à 10 m, rafales,
pression mer, nébulosité totale moyenne sur 6 h, précipitations des 6 dernières
heures et cumul depuis le run en équivalent eau. Le cumul est reconstruit pour
chaque membre avant les statistiques. La norme du vent est également calculée
avant les statistiques. Vent et rafales sont affichés par paliers supérieurs de
5 km/h.

880 cartes SVG France/Europe : 4 statistiques, 8 produits, 14 échéances
(H+0, 6, 12, 18, puis toutes les 24 h), sans pluie 6 h ni nébulosité à H+0.
Tableaux : 34 746 communes et 96 départements, format JSON v3 à 33 colonnes,
41 échéances. Moyenne des 31 membres, pas un scénario déterministe. La
géolocalisation est facultative, sur HTTPS et sur clic seulement ; le calcul de
proximité est local. Tableau compact en haut et carte ajustée au cadre.

## Production

Workflow `build-gefs.yml`, manuel ou programmé 4 fois par jour. Les requêtes
passent par le filtre officiel NOMADS pour ne télécharger que les variables et
la zone nécessaires. Validation de chaque GRIB : run, membre, ensemble annoncé,
grille, balayage, unités, niveau, période et valeurs manquantes. Toute erreur
bloque la publication et conserve la précédente. Pas de mélange de runs.

Les 31 fichiers H+240 sont vérifiés avant de sélectionner un cycle. Trois
téléchargements concurrents au maximum, avec cadence globale limitée à 40
requêtes/minute. Réponses non GRIB rejetées et reprises après 60 puis 120
secondes.

Tests : `python -m unittest discover -s tests` et `node tests/test_module.cjs`.
Installation : importer le ZIP WordPress, activer, placer `[gefs_meteo]`.

## Sources vérifiées le 29 septembre 2026

- https://www.nco.ncep.noaa.gov/pmb/products/gens/
- https://nomads.ncep.noaa.gov/pub/data/nccf/com/gens/prod/
- https://nomads.ncep.noaa.gov/cgi-bin/filter_gefs_atmos_0p25s.pl

Contours Natural Earth (domaine public). Catalogue communal repris du catalogue
national des modules Alertes Météo. Code de l’extension : GPL-2.0-or-later.
