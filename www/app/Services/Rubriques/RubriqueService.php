<?php

namespace App\Services\Rubriques;
use App\Models\Rubrique;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RubriqueService
{
    /** @var array $columns */
    private $columns = ["centre_id", "type", "titre", "lien", "resume", "description"];

    private $fileUpload;
    public function __construct()
    {
        $this->fileUpload = new FileUploadService();

    }

    public function getRubrique($typeRubrique)
    {
        return $typeRubrique->getData();
    }

    public function insertRubrique(Request $request, $type)
    {

        $folderImage = $type . '/image';
        $folderFile = $type . '/fichier';
        $image = $this->fileUpload->uploadFile($request, $folderImage, "image");
        $fichier = $this->fileUpload->uploadFile($request, $folderFile, "fichier");
        $aDataSave = $request->only($this->columns);

        if ($image) {
            $aDataSave['image'] = $image;
        }

        if ($fichier) {
            $aDataSave['fichier'] = $fichier;
        }
        $aDataSave['created_by'] = auth()->user()->getAuthIdentifier();
        $aDataSave['type'] = $type;
        $aDataSave['slug'] = Str::slug($aDataSave['titre'], '-').'-'.time();
        $aDataSave['lien'] = treatLinkYoutube($aDataSave['lien']);

        $create = Rubrique::create($aDataSave);
        return $create->save();
    }

    public function updateRubrique(int $id ,Request $request, $type)
    {

        $folderImage = $type . '/image';
        $folderFile = $type . '/fichier';
        $image = $this->fileUpload->uploadFile($request, $folderImage, "image", $id);
        $fichier = $this->fileUpload->uploadFile($request, $folderFile, "fichier", $id);
        $aDataSave = $request->only($this->columns);

        if ($image) {
            $aDataSave['image'] = $image;
        }

        if ($fichier) {
            $aDataSave['fichier'] = $fichier;
        }
        $aDataSave['type'] = $type;
        $aDataSave['lien'] = treatLinkYoutube($aDataSave['lien']);

        return Rubrique::where('id', '=', $id)->update($aDataSave);
    }

    public function deleteRubrique(int $id, $type)
    {
        $keyFiles = ['image', 'fichier'];
        $this->fileUpload->deleteRelatedFile($id, $keyFiles, $type);

        $deleted = Rubrique::destroy($id);
        return $deleted > 0 ? deleteSucces() : deleteError();
    }

    public static function getTableHeader()
    {
        return array("ID", "Centre", "Titre", "Résumé", "Action");
    }
}
