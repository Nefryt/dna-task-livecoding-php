<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Support\Carbon;

class TimeRange
{
    private \DateTimeInterface $start;
    private \DateTimeInterface $end;

    public function __construct(string $start, string $end)
    {
        $this->start = Carbon::parse($start);
        $this->end = Carbon::parse($end);
    }

    public function getStart(): \DateTimeInterface
    {
        return $this->start;
    }

    public function getEnd(): \DateTimeInterface
    {
        return $this->end;
    }
}
