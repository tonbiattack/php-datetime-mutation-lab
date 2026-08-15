<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/InvoiceSchedule.php';

use PhpDateTimeMutationLab\InvoiceSchedule;

function assertSameValue(mixed $expected, mixed $actual, string $message): void
{
    if ($expected !== $actual) {
        throw new RuntimeException($message . "\nExpected: " . var_export($expected, true) . "\nActual:   " . var_export($actual, true));
    }
}

$schedule = new InvoiceSchedule();
$tests = [
    '請求日は支払期限を計算しても発行日のまま保持される' => static function () use ($schedule): void {
        $issuedAt = new \DateTime('2026-08-01 09:00:00', new \DateTimeZone('UTC'));
        $result = $schedule->create($issuedAt);

        assertSameValue(
            '2026-08-01 09:00:00',
            $result['issuedAt']->format('Y-m-d H:i:s'),
            '支払期限の計算が請求日そのものを変更してはならない'
        );
    },
    '支払期限は発行日から30日後として計算される' => static function () use ($schedule): void {
        $issuedAt = new \DateTime('2026-08-01 09:00:00', new \DateTimeZone('UTC'));
        $result = $schedule->create($issuedAt);

        assertSameValue(
            '2026-08-31 09:00:00',
            $result['dueAt']->format('Y-m-d H:i:s'),
            '支払期限は発行日から30日後である'
        );
    },
];

$failures = [];
foreach ($tests as $name => $test) {
    try {
        $test();
        fwrite(STDOUT, "PASS: {$name}\n");
    } catch (Throwable $error) {
        $failures[] = $name;
        fwrite(STDERR, "FAIL: {$name}\n{$error->getMessage()}\n");
    }
}

if ($failures !== []) {
    fwrite(STDERR, sprintf("%d test(s) failed.\n", count($failures)));
    exit(1);
}

fwrite(STDOUT, sprintf("%d test(s) passed.\n", count($tests)));
