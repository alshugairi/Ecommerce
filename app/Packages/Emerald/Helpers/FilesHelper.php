<?php

namespace App\Packages\Emerald\Helpers;

use Illuminate\{Support\Facades\Storage, Support\Str};
use function PHPUnit\Framework\isEmpty;

trait FilesHelper
{
    private string $fileName;

    /**
     * @param array $files
     * @param string $location
     * @return array
     */
    protected function uploadMultiFiles(array $files, string $location): array
    {
        $uploadedFiles = [];
        foreach ($files as $key => $file) {
            $uploadedFiles[$key]['url'] = $this->fileUpload($file, $location);
            $uploadedFiles[$key]['name'] = $this->fileName;
        }

        return $uploadedFiles;
    }

    /**
     * @param object $file
     * @param string $location
     * @return string|null
     */
    protected function fileUpload(object $file, string $location, ?string $disk = 'null'): ?string
    {
        if (!is_file($file)) {
            return null;
        }

        $fileOriginalExtension = $file->getClientOriginalExtension();
        $fileUniqueName = $this->uniqueName($fileOriginalExtension);

        if ($disk) {
            $uploadedFile = Storage::disk('public_uploads')->put($location, $file);
            return url()->to('uploads/' . $uploadedFile);
        }

        $file->storeAs('public/uploads/' . $location, $fileUniqueName, ['disk' => 'public_uploads']);
        return url()->to('/storage/uploads/' . $location . '/' . $fileUniqueName);
    }

    /**
     * @param string $extension
     * @return string
     */
    private function uniqueName(string $extension): string
    {
        return time() . '_' . Str::random(6) . '.' . $extension;
    }

    /**
     * @param string $url
     * @param string $location
     * @param string|null $name
     * @return string
     */
    private function saveImageFromUrl(string $url, string $location, ?string $name = null): string
    {
        $contents = file_get_contents($url);
        if (empty($name)) {
            $name = substr($url, strrpos($url, '/') + 1);
        }
        Storage::put("public\\$location\\$name", $contents);
        return url("storage\\$location\\$name");
    }
}
