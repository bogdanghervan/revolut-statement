<?php

namespace App;

use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception as SpreadsheetException;

class Exporter
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var Spreadsheet
     */
    protected $spreadsheet;

    /**
     * @var int
     */
    protected $currentRow = 1;

    /**
     * @var string
     */
    protected $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @var string[]
     */
    protected static $supportedFormats = ['csv', 'xls', 'xlsx', 'ods'];
    
    /**
     * @var boolean
     */
    protected $autoSize = false;

    /**
     * Exporter constructor.
     *
     * @param string|null $filename
     * @param string $format
     */
    public function __construct(?string $filename, string $format = 'csv')
    {
        $this->filename = $filename ?? tempnam(sys_get_temp_dir(), 'statement');
        $this->setFormat($format);

        $this->spreadsheet = new Spreadsheet();
    }

    /**
     * @param string $format
     * @return Exporter
     */
    public function setFormat(string $format): self
    {
        $format = strtolower($format);
        if (!in_array($format, self::$supportedFormats)) {
            throw new InvalidArgumentException('Invalid format');
        }

        $this->format = $format;

        return $this;
    }
    
    /**
     * @param bool $autoSize
     * @return $this
     */
    public function setAutoSize(bool $autoSize): self
    {
        $this->autoSize = $autoSize;
        
        return $this;
    }

    /**
     * @return string[]
     */
    public static function getSupportedFormats(): array
    {
        return self::$supportedFormats;
    }

    /**
     * @param array $record
     * @return Exporter
     */
    public function insertOne(array $record): self
    {
        if (count($record) > strlen($this->alphabet)) {
            throw new InvalidArgumentException('Unsupported large number of columns');
        }

        $sheet = $this->spreadsheet->getActiveSheet();
        foreach (array_values($record) as $currentColumn => $value) {
            $sheet->setCellValue($this->cell($currentColumn, $this->currentRow), $value);
        }

        $this->currentRow++;

        return $this;
    }

    /**
     * @param array $records
     * @return Exporter
     */
    public function insertMany(array $records): self
    {
        foreach ($records as $record) {
            $this->insertOne($record);
        }

        return $this;
    }

    /**
     * @return Exporter
     * @throws SpreadsheetException
     */
    public function print(): self
    {
        $this->flushBuffer();
        readfile($this->filename);
        
        return $this;
    }

    /**
     * @throws SpreadsheetException
     */
    public function __destruct()
    {
        $this->flushBuffer();
    }

    /**
     * @return Exporter
     * @throws SpreadsheetException
     */
    protected function flushBuffer(): Exporter
    {
        if ($this->autoSize) {
            $this->refreshColumnDimensions();
        }

        $writer = IOFactory::createWriter($this->spreadsheet, ucfirst($this->format));
        $writer->save($this->filename);

        return $this;
    }
    
    /**
     * @return Exporter
     */
    protected function refreshColumnDimensions(): Exporter
    {
        $sheet = $this->spreadsheet->getActiveSheet();
        
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize($this->autoSize);
        }
        
        return $this;
    }

    /**
     * @param int $col
     * @param int $row
     * @return string
     */
    protected function cell(int $col, int $row): string
    {
        return $this->alphabet[$col] . $row;
    }
}
