<?php

namespace App\CSV\Processors;

use Illuminate\Http\UploadedFile;

final class CSVLinesProcessor implements \Iterator
{
    /**
     * @var array<string>|false
     */
    private mixed $data;
    private mixed $stream;
    private int $line = 0;
    /**
     * @var string
     */
    private string $headers;

    public function __construct(UploadedFile $file) {
        $this->stream = fopen($file, 'r');
        $this->headers = fgets($this->stream);
    }

    public function rewind(): void {
        rewind($this->stream);
        $this->line = 0;
        $this->data = fgetcsv($this->stream);
        $this->next();
    }

    #[\ReturnTypeWillChange]
    public function current(): array {
        return $this->data;
    }

    #[\ReturnTypeWillChange]
    public function key(): ?int {
        return $this->line;
    }

    public function next(): void {
        if ($this->data !== false) {
            $this->data = fgetcsv($this->stream);
            $this->line++;
        }
    }

    public function valid(): bool {
        return false !== $this->data;
    }

    public function __destruct() {
        fclose($this->stream);
    }

    public function getHeaders(): array
    {
        return array_filter(explode(';', str_replace(["\n", "\r"], "", $this->headers)));
    }

    public function getCurrentWithHeaders()
    {
        $headers = $this->getHeaders();
        $values = explode(';', implode($this->data));
        $line = [];
        foreach ($headers as $i => $header) {
            $line[$header] = $values[$i];
        }

        return array_filter($line);
    }
}
