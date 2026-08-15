<?php

declare(strict_types=1);

namespace PhpDateTimeMutationLab;

use DateTime;
use DateTimeImmutable;

final class InvoiceSchedule
{
    /**
     * @return array{issuedAt: DateTime, dueAt: DateTimeImmutable}
     */
    public function create(DateTime $issuedAt): array
    {
        $dueAt = DateTimeImmutable::createFromMutable($issuedAt)->modify('+30 days');

        return ['issuedAt' => $issuedAt, 'dueAt' => $dueAt];
    }
}
