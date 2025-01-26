<?php

declare(strict_types=1);

namespace Support\Transaction;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HigherOrderTapProxy;

final class Transaction
{
    public static function run(
        Closure $callback,
        Closure $successCallback = null,
        Closure $errorCallback = null,

    )
    {
        try {
            DB::beginTransaction();

            $result = $callback();

            if (!is_null($successCallback)) {
                $successCallback($result);
            }

            DB::commit();

            return $result;

        } catch (\Throwable $e) {
            DB::rollBack();

            if (!is_null($errorCallback)) {
                $errorCallback($e);
            }

            throw $e;
        }
    }
}
