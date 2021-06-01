<?php

namespace DoubleThreeDigital\Zippy\Documentation;

use Algolia\AlgoliaSearch\SearchClient;

class Documentation
{
    const ALGOLIA_APPLICATION_ID = 'BH4D9OD16A';
    const ALGOLIA_ADMIN_API_KEY = 'b5e8f73c7462a6d5c8b525ef183aabec';

    public static function search(string $query)
    {
        $searchResults = [];

        $algoliaClient = SearchClient::create(
            self::ALGOLIA_APPLICATION_ID,
            self::ALGOLIA_ADMIN_API_KEY
        );

        $index = $algoliaClient->initIndex('statamic_3');
        $search = $index->search($query);
        $results = $search['hits'];

        foreach ($results as $hit) {
            $highestLvl = $hit['hierarchy']['lvl6'] ? 6 : (
                $hit['hierarchy']['lvl5'] ? 5 : (
                    $hit['hierarchy']['lvl4'] ? 4 : (
                        $hit['hierarchy']['lvl3'] ? 3 : (
                            $hit['hierarchy']['lvl2'] ? 2 : (
                                $hit['hierarchy']['lvl1'] ? 1 : 0
                            )
                        )
                    )
                )
            );

            $title = $hit['hierarchy']['lvl' . $highestLvl];
            $currentLvl = 0;
            $subtitle = $hit['hierarchy']['lvl0'];
            while ($currentLvl < $highestLvl) {
                $currentLvl = $currentLvl + 1;
                $subtitle = $subtitle . ' » ' . $hit['hierarchy']['lvl' . $currentLvl];
            }

            $searchResults[] = new DocumentationHit($title, $hit['url']);
        }

        return $searchResults;
    }
}
