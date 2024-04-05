<?php

namespace App\CSV\DataScanners;

final class CSVLinesScanner {
    /**
     * @var array<string, string>
     */
    private $oldData;
    /**
     * @var array<string, string>
     */
    private $recentData;
    private string $scanResult;

    public function __construct(array $oldData, array $recentData) {
        $this->oldData = $oldData;
        $this->recentData = $recentData;
    }

    private function isSame(): bool {
        return $this->oldData === $this->recentData;
    }

    private function isDifferent(): bool {
        return $this->oldData !== $this->recentData;
    }

    private function hasOneDifference(): bool {
        $diffCount = 0;
        foreach ($this->oldData as $key => $value) {
            if (!array_key_exists($key, $this->recentData) || $this->recentData[$key] !== $value) {
                $diffCount++;

            }
        }
        return $diffCount === 1;
    }

    public function scan(): self
    {
        if ($this->hasOneDifference()) {
            $this->scanResult = 'changed';
        } else if ($this->isSame()) {
            $this->scanResult = 'unchanged';
        } else if ($this->isDifferent()) {
            $this->scanResult = 'new';
        }

        return $this;
    }
}
