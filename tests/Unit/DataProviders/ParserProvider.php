<?php

namespace Tests\Unit\DataProviders;

/**
 * Data provider for ParserTest.
 * 
 * Be mindful of the whitespace in this file when committing changes
 * (e.g. some editors are configured to strip any space on blank lines).
 * 
 * @package Tests\Unit\DataProviders
 */
trait ParserProvider
{
    public function parse()
    {
        return [
            'basic record' => [
                '06/24/2020
  06/26/2020
  USD
  BUY
  SHOP - SHOPIFY INC   CL A - TRD SHOP B 0.05663668 at 882.82 Principal.
  0.05663668
  882.82
  (50.00)',
                [
                    [
                        'tradeDate' => '06/24/2020',
                        'settleDate' => '06/26/2020',
                        'currency' => 'USD',
                        'activityType' => 'BUY',
                        'symbolDescription' => 'SHOP - SHOPIFY INC   CL A - TRD SHOP B 0.05663668 at 882.82 Principal.',
                        'symbol' => 'SHOP',
                        'description' => 'SHOPIFY INC   CL A - TRD SHOP B 0.05663668 at 882.82 Principal.',
                        'quantity' => '0.05663668',
                        'price' => '882.82',
                        'amount' => '50.00',
                    ]
                ]
            ],
            'quantity and price are zero' => [
                '06/26/2020
  06/26/2020
  USD
  DIV
  LMT - LOCKHEED MARTIN CORP   COM - DIV:LMT(2.4000/sh):TAXCD:A
  0
  0.00
  2.05',
                [
                    [
                        'tradeDate' => '06/26/2020',
                        'settleDate' => '06/26/2020',
                        'currency' => 'USD',
                        'activityType' => 'DIV',
                        'symbolDescription' => 'LMT - LOCKHEED MARTIN CORP   COM - DIV:LMT(2.4000/sh):TAXCD:A',
                        'symbol' => 'LMT',
                        'description' => 'LOCKHEED MARTIN CORP   COM - DIV:LMT(2.4000/sh):TAXCD:A',
                        'quantity' => '0',
                        'price' => '0.00',
                        'amount' => '2.05',
                    ]
                ]
            ],
            'cash disbursement' => [
                '06/26/2020
  06/26/2020
  USD
  CDEP
  Cash Disbursement - Wallet (USD)
  512.87',
                [
                    [
                        'tradeDate' => '06/26/2020',
                        'settleDate' => '06/26/2020',
                        'currency' => 'USD',
                        'activityType' => 'CDEP',
                        'symbolDescription' => 'Cash Disbursement - Wallet (USD)',
                        'symbol' => null,
                        'description' => null,
                        'quantity' => null,
                        'price' => null,
                        'amount' => '512.87',
                    ]
                ]
            ],
            'description on multiple lines' => [
                '06/26/2020
  06/26/2020
  USD
  DIVNRA
  LMT - LOCKHEED MARTIN CORP   COM - DIVNRA:LMT(2.4000/sh):NRA withholding

@10.00%
  0
  0.00
  (0.21)',
                [
                    [
                        'tradeDate' => '06/26/2020',
                        'settleDate' => '06/26/2020',
                        'currency' => 'USD',
                        'activityType' => 'DIVNRA',
                        'symbolDescription' => 'LMT - LOCKHEED MARTIN CORP   COM - DIVNRA:LMT(2.4000/sh):NRA withholding @10.00%',
                        'symbol' => 'LMT',
                        'description' => 'LOCKHEED MARTIN CORP   COM - DIVNRA:LMT(2.4000/sh):NRA withholding @10.00%',
                        'quantity' => '0',
                        'price' => '0.00',
                        'amount' => '0.21',
                    ]
                ]
            ],
            'sell order' => [
                '07/13/2020
  07/15/2020
  USD
  SELL
  MSFT - MICROSOFT CORP   COM - TRD MSFT S 0.72883906 at 212.81 Principal.
  -0.72883906
  212.81
  155.08',
                [
                    [
                        'tradeDate' => '07/13/2020',
                        'settleDate' => '07/15/2020',
                        'currency' => 'USD',
                        'activityType' => 'SELL',
                        'symbolDescription' => 'MSFT - MICROSOFT CORP   COM - TRD MSFT S 0.72883906 at 212.81 Principal.',
                        'symbol' => 'MSFT',
                        'description' => 'MICROSOFT CORP   COM - TRD MSFT S 0.72883906 at 212.81 Principal.',
                        'quantity' => '-0.72883906',
                        'price' => '212.81',
                        'amount' => '155.08',
                    ]
                ]
            ],
            'sell order with thousands separator' => [
                '07/13/2020
  07/15/2020
  USD
  SELL
  SHOP - SHOPIFY INC   CL A - TRD SHOP S 1 at 1000.96 Agency.
  -1
  1000.96
  1,000.96',
                [
                    [
                        'tradeDate' => '07/13/2020',
                        'settleDate' => '07/15/2020',
                        'currency' => 'USD',
                        'activityType' => 'SELL',
                        'symbolDescription' => 'SHOP - SHOPIFY INC   CL A - TRD SHOP S 1 at 1000.96 Agency.',
                        'symbol' => 'SHOP',
                        'description' => 'SHOPIFY INC   CL A - TRD SHOP S 1 at 1000.96 Agency.',
                        'quantity' => '-1',
                        'price' => '1000.96',
                        'amount' => '1,000.96',
                    ]
                ]
            ],
            'space character between newlines' => [
                '
07/01/2020
  07/06/2020
  USD
  BUY
  SPCE - VIRGIN GALACTIC HOLDINGS INC  COM - TRD SPCE B 3 at 16.6495
 
Agency.
  3
  16.6495
  (49.95)',
                [
                    [
                        'tradeDate' => '07/01/2020',
                        'settleDate' => '07/06/2020',
                        'currency' => 'USD',
                        'activityType' => 'BUY',
                        'symbolDescription' => 'SPCE - VIRGIN GALACTIC HOLDINGS INC  COM - TRD SPCE B 3 at 16.6495   Agency.',
                        'symbol' => 'SPCE',
                        'description' => 'VIRGIN GALACTIC HOLDINGS INC  COM - TRD SPCE B 3 at 16.6495   Agency.',
                        'quantity' => '3',
                        'price' => '16.6495',
                        'amount' => '49.95',
                    ]
                ]
            ]
        ];
    }
}
