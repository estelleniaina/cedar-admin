<?php


namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    protected $storage = "rubriques";

    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @param         $folder
     * @param         $file
     * @param null    $id
     * @return bool|string
     */
    public function uploadFile(Request $request, $folder, $file, $id = null, $model = 'Rubrique')
    {
        $filename = false;
        if ($request->has($file) && (!empty($request->file) || !empty($request->files) )) {
            $filename = time() . '_' . str_replace(" ", "", $request->file($file)->getClientOriginalName());
            if (!$request->file($file)->storeAs($folder, $filename, 'public')) {
                return false;
            }

            // Delete related file
            if (!is_null($id)) {
                $this->deleteRelatedFile($id, $file, $folder, $model);
            }
        }

        return $filename;
    }

    /**
     * @param Request $request
     * @param $folder
     * @param $file
     * @return bool
     */
    public function uploadMultipleFile(Request $request, $folder, $file)
    {
        $filename = false;
        if ($request->has($file) && (!empty($request->file) || !empty($request->files) )) {
            foreach ($request->file($file) as $_file) {
                $name = time() . '_' . $_file->getClientOriginalName();
                if (!$_file->storeAs($folder, $name, 'public')) {
                    return false;
                }
                $filename[][$file] = $name;
            }
        }

        return $filename;
    }


    /**
     * @param int $iID
     * @param $keyFile
     * @param $folder
     * @param $model
     */
    public function deleteRelatedFile(int $iID, $keyFile, $folder, $model = 'Rubrique')
    {
        $modelName = 'App\Models\\'.$model;
        $sFile = $modelName::query()->where('id', '=', $iID)->first();
        $folder = $folder ?? $sFile['type'];

        if (!is_array($keyFile)) {
            $keyFile = [$keyFile];
        }

        foreach ($keyFile as $key) {
            $fileLink = $folder ."/".$sFile[$key];

            if (Storage::disk('public')->exists($fileLink)) {
                Storage::delete($fileLink);
            }
        }

    }

    /**
     * @param array  $ids
     * @param $keyFile
     * @param $folder
     * @param string $model
     */
    public function deleteMultipleFile(array $ids, $keyFile, string $folder, $model = 'Rubrique')
    {
        $modelName = 'App\Models\\'.$model;
        $files = $modelName::query()->whereIn('id', $ids)->pluck($keyFile);

        foreach ($files as $file) {

            $fileLink = $folder . "/" . $file;

            if (Storage::disk('public')->exists($fileLink)) {
                Storage::delete($fileLink);
            }
        }
    }
}
