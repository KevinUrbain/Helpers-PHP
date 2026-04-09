<?php
declare(strict_types=1);

/**
 * Traite une chaîne de caractères pour compter les occurrences de mots.
 *
 * Si le texte est vide, un tableau vide est retourné
 * @param string $text Le texte brut.
 * @return array Tableau [mot => nombre d'occurrences], trié par fréquence.
 */
function stringProcessor(string $text): array
{

    if (strlen($text) === 0) {
        return [];
    }

    $normalizedText = mb_strtolower($text);

    $cleanText = str_replace(['.', ',', ';', '!', '?', '"', "'", '-'], ' ', $normalizedText);

    $words = explode(" ", $cleanText);

    $filteredWords = array_filter($words, fn($value) => $value !== '');

    $frequencies = array_count_values($filteredWords);

    arsort($frequencies);

    return $frequencies;
}

//Utilisation

$text = "Accordez-moi, je vous offre mon bras. Rudement, un grand et long cri suprême de désespoir. Appuyons ceci d'un indice quelconque. Rivaux, après que je les sentais ; j'étudiais encore, je regardais tomber la pluie et l'obscurité, jusqu'à leur mort, quand une poussière enflammée tourbillonnera dans nos rues. Cinglés par la pluie, ne regardant rien qu'eux-mêmes. Traité dès lors comme un scélérat. Malheureux qu'elle a songé à vous aider. Bonne et hospitalière d'ailleurs, rappeler sur mon instrument, la voix tonnante du lion et les cris de quelque chauve-souris qu'un chat-huant avait surprise.";

$tableau = stringProcessor($text);
var_dump($tableau);
