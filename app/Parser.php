<?php

namespace App;

class Parser
{
    /**
     * Regex pattern for a statement line.
     *
     * @var string
     */
    protected static $pattern = '/
        (?<tradeDate>\d{2}\/\d{2}\/\d{4})\s+
        (?<settleDate>\d{2}\/\d{2}\/\d{4})\s+
        (?<currency>\w+)\s+
        (?<activityType>\w+)\s+
        (?<symbolDescription>(?:
            # Match a ticker followed by a description that can possibly
            # be split in half
            (?<symbol>\w+)\s-\s(?<description>.*([\r?\n]\s*[\r?\n].*)?)) |

            # Or match a free text description for other activity types
            # such as cash disbursement.
            (?:.*)
        )\s+
        # Quantity and price are either both present of both absent
        (?:
            # Decimal number with these features:
            # - Optional integer and optional fraction
            # - Decimal dot must be omitted if the fraction is omitted
            # - Optional thousands separator
            # - Negative numbers allowed
            # Inspired by the book Regular Expressions Cookbook, 2nd Edition
            # by Jan Goyvaerts, Steven Levithan
            (?<quantity>(?\'decimal\'-?[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]+)?\b|\.[0-9]+))\s+
            (?<price>\g\'decimal\')\s+
        )?
        (?<amountInBrackets>\(?(?<amount>\g\'decimal\')\)?)
    /mx';

    /**
     * @param string $text
     * @return array
     */
    public static function parse(string $text): array
    {
        preg_match_all(self::$pattern, $text, $matches, PREG_SET_ORDER | PREG_UNMATCHED_AS_NULL);

        $records = [];
        foreach ($matches as $match) {
            $records[] = [
                'tradeDate' => $match['tradeDate'],
                'settleDate' => $match['settleDate'],
                'currency' => $match['currency'],
                'activityType' => $match['activityType'],
                // Replace multiple spaces and newlines with a single space
                'symbolDescription' => preg_replace('/[\r\n]+/', ' ', $match['symbolDescription']),
                'symbol' => $match['symbol'],
                'description' => $match['description'] ? preg_replace('/[\r\n]+/', ' ', $match['description']) : null,
                'quantity' => $match['quantity'],
                'price' => $match['price'],
                'amount' => $match['amount'],
            ];
        }

        return $records;
    }
}
