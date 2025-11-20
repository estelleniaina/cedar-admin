<?php

use Illuminate\Http\JsonResponse;
use Intervention\Image\Facades\Image;

/**
 * @param $mReturn
 * @return JsonResponse
 */
function responseSuccess($mReturn)
{
    return Response()->json($mReturn, Config('constant.STATUS_SUCCESS'));
}

/**
 * @param $mReturn
 * @return JsonResponse
 */
function responseError($mReturn)
{
    return Response()->json($mReturn, Config('constant.STATUS_ERROR'));
}


/**
 * @param        $row
 * @param string $sNom
 * @param        $sRouteEdit
 * @param        $sRouteDelete
 * @param bool   $bInfo
 * @return string
 */
function datatableAction($row, $sRouteEdit, $sRouteDelete, $sNom = '', $bInfo = false) {
    $sAction = '';

    if ($bInfo) {
        $sAction .= '<a class="infos" id="btn-details-user" title="Infos" data-toggle="modal" data-id='.$row->id.'>
        <i class="fas fa-info-circle color-blue"></i></a>';
    }

    $sTitleEdit = "Modification " . $sNom;

    $sAction .= '<a href="javascript:void(0)" class="btnEdit" data-toggle="tooltip" onClick="bntEditClick(\''. route($sRouteEdit, $row->id) .'\', \''. $sTitleEdit .'\')"
                                                   title="Modifier" data-id='.$row->id.'><i class="fas fa-edit color-green"></i></a>
                <a href="javascript:void(0)" class="delete" title="Supprimer" data-id='.$row->id.' onClick="deleteFunc(\''. route($sRouteDelete, $row->id) .'\')"><i class="fas fa-trash color-red"></i></a>';
    return $sAction;
}

/**
 * @param $folder
 * @param $sPhoto
 * @return string
 */
function savePhoto($folder, $sPhoto)
{
    $iImgSize = 500;

    if (empty($sPhoto)) {
        return $sPhoto;
    } elseif ( is_object($sPhoto)) {
        $sNewName = rand(100, 900) . '_' . time();
        $sNewName = hash('sha1', $sNewName) . '.' . $sPhoto->extension();
        $thumbnailFilePath = storage_path('app/public/upload/'. $folder);

        $img = Image::make($sPhoto->path());
        $img->resize($iImgSize, $iImgSize, function ($const) {
            $const->aspectRatio();
        })->save($thumbnailFilePath . '/' . $sNewName);

        return $sNewName;
    }
}

/**
 * @return array
 */
function getKeyForPagination()
{
    return [
        'data',
        'current_page',
        'last_page',
        'total',
    ];
}

/**
 * @param string $link
 * @return string
 */
function setLinkHttp($link = '') {
    return !empty($link) ? 'https://' . $link : $link;
}

function treatLinkYoutube($link)
{
    $link = str_replace('watch?v=', 'embed/', $link);
    $link = !empty($link) ? 'https://' . $link : $link;
    return $link;
}

function deleteSucces()
{
    return Response()->json(['message'=>'Suppression effectuée avec succés']);
}

function deleteError()
{
    return Response()->json(['error'=>'Erreur lors de la suppression']);
}

function saveSucces()
{
    return Response()->json(['message'=>'Sauvegarde effectuée avec succés']);
}

function saveError()
{
    return Response()->json(['error'=>'Erreur lors de la sauvegarde']);
}
