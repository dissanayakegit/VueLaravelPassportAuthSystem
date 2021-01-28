<?php

namespace App\Modules\Files\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Files\Contracts\FilesRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    private $fileRepo;

    public function __construct(FilesRepositoryInterface $fileRepo)
    {
        $this->fileRepo = $fileRepo;
    }

    public function getAllFiles()
    {
        return $this->fileRepo->getAllFiles();
    }

    public function updateFiles(Request $request)
    {
        $files = $request->get('files');
        $deletedRecordIds = $request->get('deletedRecordIds');

        $files = json_decode($files, true);
        $deletedRecordIds = json_decode($deletedRecordIds, true);

        if ($files) {
            foreach ($files as $file) {

                $saveFile = $this->_saveFile($file[0]);
                $postData = [
                    'file_description' => $file[0]['fileDescription'],
                    'mime_type' => $file[0]['selectedFileMimeType'],
                ];
                $isNew = substr($file[0]['id'], 0, 4) === "new_";
                if ($isNew) {
                    if (isset($file[0]['file'])) {
                        //$data = $this->_setMimeTypeAndFileSize($file[0]);
                        $postData['file_name'] = $saveFile;
                        //$postData['mime_type'] = $data['fileType'];
                        $this->fileRepo->create($postData);
                    }

                } else {
                    if (isset($file[0]['document_name']) && isset($file[0]['file'])) {
                        $this->_deleteFile($file[0]['document_name']);
                        //$data = $this->_setMimeTypeAndFileSize($file[0]);
                        $postData['document_name'] = $saveFile;
                        //$postData['mime_type'] = $data['fileType'];
                    }
                    $this->fileRepo->update($postData, $file[0]['id']);
                }
            }
        }
        if ($deletedRecordIds != []) {
            foreach ($deletedRecordIds as $deletedRecordId) {
                $isNew = substr($deletedRecordId['deleted_record_id'], 0, 4) === "new_";
                if ($isNew == false) {
                    $file = $this->fileRepo->getFiletDetailsById($deletedRecordId['deleted_record_id']);
                    $this->_deleteFile($file['fileName']);
                }
                $this->fileRepo->delete($deletedRecordId);
            }
        }

        return response()->json([], 200);
    }

    private function _saveFile($file)
    {
        //new
        if (isset($file['file']) && !isset($file['fileName'])) {
            return $this->_createFile($file['file'], $file['fileBrowseName']);

        } elseif (isset($file['file']) && isset($file['fileName'])) { //existing one
            $fileId = $file['id'];
            $file = $this->fileRepo->getFiletDetailsById($fileId);
            $this->_deleteFile($file['document_name']);
            return $this->_createFile($file['file'], $file['fileBrowseName']);
        }
    }

    private function _setMimeTypeAndFileSize($fileData)
    {
        $file = $fileData['file'];
        $fileType = explode(';', $file)[0];
        $fileType = substr($fileType, 5);

        return ['fileType' => $fileType];
    }

    private function _createFile($file, $file_browse_name)
    {
        $fileType = explode(',', $file)[0] . ',';
        $base64Content = base64_decode(str_replace($fileType, '', $file));
        $fileName = uniqid() . 'DATA_SEPARATOR' . $file_browse_name;
        $this->_uploadFile($fileName, $base64Content);
        return $fileName;
    }

    private function _uploadFile($fileName, $base64Content)
    {
//        if (env('S3_ENABLED')) {
//            Storage::disk('s3')->put(RECORD_KEEPER_UPLOAD_DIRECTORY . "/deceased_documents/" . $recordId . "/" . $fileName, $base64Content);
//        } else {
        Storage::disk('files_uploads')->put("/files/" . $fileName, $base64Content);
//        }
    }

    private function _deleteFile($fileName)
    {
//        if (env('S3_ENABLED')) {
//            Storage::disk('s3')->delete("/" . RECORD_KEEPER_UPLOAD_DIRECTORY . "/deceased_documents/" . $recordId . "/" . $fileName);
//        } else {
        Storage::disk('files_uploads')->delete("/files/" . $fileName);
//        }
    }

}
