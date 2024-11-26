<?php

declare(strict_types=1);

namespace Support\Testing;


use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

final class FakerImageProvider extends Base
{
    public function fixturesImage(string $fixturesDir, string $storageDir): string
    {
        $storage = Storage::disk('images');

        if (!Storage::exists($storageDir)) {
            Storage::makeDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/images/{$fixturesDir}"),
            $storage->path($storageDir),
            false,
        );

        return '/storage/images/' . trim($storageDir, '/') . '/' . $file;
    }
}
