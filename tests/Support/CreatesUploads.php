<?php

namespace Tests\Support;

use Illuminate\Http\UploadedFile;

/**
 * Builds uploads from real files. UploadedFile::fake() guesses the MIME type from
 * the file name (so a disguised file would pass) and its image() needs GD.
 */
trait CreatesUploads
{
    /** @var list<resource> */
    private array $uploadHandles = [];

    /** A valid 1x1 PNG, optionally padded to an exact size in bytes. */
    protected function pngUpload(string $name = 'photo.png', int $bytes = 0): UploadedFile
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');

        return $this->upload($name, str_pad($png, $bytes, "\0"));
    }

    protected function upload(string $name, string $content): UploadedFile
    {
        $handle = tmpfile();
        fwrite($handle, $content);
        fflush($handle);

        // PHP deletes the temporary file once its handle is released.
        $this->uploadHandles[] = $handle;

        return new UploadedFile(stream_get_meta_data($handle)['uri'], $name, null, null, true);
    }
}
