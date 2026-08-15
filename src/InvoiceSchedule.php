<?php

declare(strict_types=1);

namespace PhpDateTimeMutationLab;

use DateTime;

final class InvoiceSchedule
{
    /**
     * @return array{issuedAt: DateTime, dueAt: DateTime}
     */
    public function create(DateTime $issuedAt): array
    {
        $dueAt = $issuedAt;
        $dueAt->modify('+30 days');

        return ['issuedAt' => $issuedAt, 'dueAt' => $dueAt];
    }
}
