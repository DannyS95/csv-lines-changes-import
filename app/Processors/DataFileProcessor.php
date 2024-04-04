<?php

namespace App\Processors;

use Illuminate\Http\UploadedFile;

final class DataFileProcessor implements \Iterator
{
    private array $data;
    private mixed $stream;
    private int $line = 0;
    private string $headers;

    public function __construct(UploadedFile $file) {
        $this->stream = fopen($file, 'r');
        $this->headers = fgets($this->stream);
    }

    public function rewind(): void {
        $this->data = fgetcsv($this->stream);
        $this->line = 0;
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
        if ($this->valid() !== false) {
            $this->data = fgetcsv($this->stream);
            $this->line++;
        }
    }

    public function valid(): bool {
        return false !== fgetcsv($this->stream);
    }

    public function __destruct() {
        fclose($this->stream);
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
