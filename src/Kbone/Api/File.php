<?php

namespace Kbone\Api;

/**
 * 文件上传下载
 *
 * Class File
 * @property File file
 */
class File extends Base {
    const UPLOAD_PATH = '/api/file/upload';
    const DOWNLOAD_PATH = '/api/file/download';

    /**
     * 上传文件
     * @param $file_path
     * @param string $file_name
     * @return mixed
     * @throws \Exception
     */
    public function upload($file_path, $file_name = '')
    {
        $params = array(
            'filename' => $file_name
        );
        $file = array(
            'path' => $file_path,
            'name' => $file_name,
        );
        $result = $this->request('post', self::UPLOAD_PATH, $params, $file);
        if ($result->code == Base::SUCCESS_CODE) {
            return $result->data->index;
        } else {
            throw new \Exception($result->msg);
        }
    }

    /**
     * 下载文件
     * @param $index
     * @return mixed
     * @throws \Exception
     */
    public function download($index)
    {
        $params = array(
            'index' => $index
        );
        return $this->request('get', self::DOWNLOAD_PATH, $params);
    }
}