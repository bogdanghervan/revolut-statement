<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use League\Csv\Writer;
use Smalot\PdfParser\Parser;
use SplFileObject;

class ConvertCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'convert
                            {file* : The input file}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Convert Revolut Trading statement to CSV format';

    /**
     * Regex pattern for a line statement.
     *
     * @var string
     */
    protected $pattern = "/
        (?<tradeDate>\d{2}\/\d{2}\/\d{4})\s+
        (?<settleDate>\d{2}\/\d{2}\/\d{4})\s+
        (?<currency>\w+)\s+
        (?<activityType>\w+)\s+
        (?<symbolDescription>.*)\s+
        (?<quantity>\d*(?:\.\d+)?)\s+
        (?<price>\d*(?:\.\d+)?)\s+
        (?<amountInBrackets>\((?<amount>\d*(?:\.\d+)?)\))
    /mx";

    /**
     * Header of output data.
     *
     * @var string[]
     */
    protected $header = [
        'Trade Date',
        'Settle Date',
        'Currency',
        'Activity Type',
        'Symbol / Description',
        'Quantity',
        'Price',
        'Amount'
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = $this->argument('file');

        foreach ($files as $file) {
            if (!is_readable($file)) {
                return $this->error(sprintf('Input file %s does not exist.', $file));
            }
        }

        foreach ($files as $file) {
            $parser = new Parser();
            $pdf = $parser->parseFile($file);

            $text = $pdf->getText();

            preg_match_all($this->pattern, $text, $matches, PREG_SET_ORDER | PREG_UNMATCHED_AS_NULL);

            $csv = Writer::createFromFileObject(new \SplTempFileObject());
            $csv->insertOne($this->header);

            foreach ($matches as $match) {
                $csv->insertOne([
                    $match['tradeDate'],
                    $match['settleDate'],
                    $match['currency'],
                    $match['activityType'],
                    $match['symbolDescription'],
                    $match['quantity'],
                    $match['price'],
                    $match['amount'],
                ]);
            }

            echo $csv->getContent();
        }
    }
}
