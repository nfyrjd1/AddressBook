<?php
/*
* Контроллер ошибок
*/

namespace AddressBook\Contact\Controller;

class ErrorController
{
    /*
    * Возвращение ошибки/ошибок и установка кода ответа http
    * 
    * @param int code Код ошибки
    * @param array | string error Ошибка/ошибки
    *
    * @return string
    */
    public function showError(int $code, $error) : string
    {
        $code = (int)$code;

        if (is_array($error)) {
            $response = ['errors' => $error];
        } else {
            $response = ['errors' => [$error]];
        }

        http_response_code($code);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /*
    * Возвращение ошибки/ошибок c кодом 400
    * 
    * @param array | string error Ошибка/ошибки
    *
    * @return string
    */
    public function error400($error = 'Неверный запрос') : string
    {
        return $this->showError(400, $error);
    }

    /*
    * Возвращение ошибки/ошибок c кодом 404
    * 
    * @param array | string error Ошибка/ошибки
    *
    * @return string
    */
    public function error404($error = 'Не найдено') : string
    {
        return $this->showError(404, $error);
    }
}
