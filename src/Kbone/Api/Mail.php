<?php

namespace Kbone\Api;

/**
 * Class Mail
 * @property Mail mail
 */
class Mail extends Base {
    const URI_MSG_MAIL = '/msg/email';

    /**
     * 发送邮件
     * @param $to
     * @param $title
     * @param $content
     * @param array $file
     * @return bool
     * @throws \Exception
     * @throws \ErrorException
     */
    public function send($to, $title, $content, $file = array())
    {
        $params = array(
            'to' => $to,
            'title' => $title,
            'content' => $content,
        );

        $attachment = array();
        if ($file) {
            $obj_file = new File($this->config);
            foreach ($file as $file_name => $file_path) {
                $attachment[$file_name] = $obj_file->upload($file_path, $file_name);
            }
            $params['attachment'] = json_encode($attachment);
        }

        $result = $this->request('post', self::URI_MSG_MAIL, $params);
        if ($result->code == self::SUCCESS_CODE) {
            return true;
        } else {
            throw new \Exception($result->msg);
        }
    }
}