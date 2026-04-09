<?php
/**
 * Coupe un texte à une longueur donnée sans couper les mots en plein milieu.
 * Idéal pour les résumés de cartes ou les meta descriptions SEO.
 *
 * @param string $text Le texte à raccourcir
 * @param int $limit Le nombre de caractères max (défaut 100)
 * @return string Le texte coupé avec "..." à la fin
 */
function truncate(string $text, int $limit = 100): string
{

    if (strlen($text) === 0) {
        return "Erreur : Le texte est vide";
    }

    $text = strip_tags($text);

    $text = str_replace(["\r", "\n"], ' ', $text);


    if (mb_strlen($text) <= $limit) {
        return $text;
    }


    $text = mb_substr($text, 0, $limit);


    $lastSpace = mb_strrpos($text, ' ');

    if ($lastSpace !== false) {
        $text = mb_substr($text, 0, $lastSpace);
    }

    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '...';
}

echo truncate("zidjqzoidh ou€€€~/<script>alert('hack')</script>zdq qzd'qrds^^^^$*ùl&@@@");