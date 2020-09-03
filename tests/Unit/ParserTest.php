<?php

namespace Tests\Unit;

use App\Parser;
use Tests\TestCase;
use Tests\Unit\DataProviders\ParserProvider;

class ParserTest extends TestCase
{
    use ParserProvider;

    /**
     * A basic test example.
     *
     * @dataProvider parse
     * @param string $text
     * @param array $expectedRecords
     * @return void
     */
    public function testParse(string $text, array $expectedRecords)
    {
        $actualRecords = Parser::parse($text);

        $this->assertSame($expectedRecords, $actualRecords);
    }
}
