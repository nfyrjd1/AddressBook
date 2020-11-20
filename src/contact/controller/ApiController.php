<?php
/*
* Контроллер api
*/

namespace AddressBook\Contact\Controller;

use AddressBook\Contact\Controller\ContactListController;
use AddressBook\Contact\Controller\ContactController;
use AddressBook\Contact\Controller\ErrorController;

class ApiController
{
    /*
    * Установка параметров ответа сервера под api
    *
    * @return void
    */
    public function setHeader() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Credentials: true');
        header('Content-type: application/json; charset=UTF-8');
    }

    /*
    * Обработка запроса к api
    * 
    * @param array params Параметры запроса
    *
    * @return string
    */
    public function process(array $params): string
    {
        //Запрос должен быть /api/contacts
        if (count($params) >= 2 && $params[0] == 'api' && $params[1] == 'contacts') {
            $this->setHeader();
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'GET': {
                        //Идентификатор контакта в /api/contacts/2 (params[2])
                        if (isset($params[2]) && is_numeric($params[2])) {
                            $id = (int)$params[2];
                            //Возвращает контакт
                            $contactController = new ContactController();
                            $response = $contactController->getContact($id);
                        } else {
                            //Возвращает список контактов
                            $contactListController = new ContactListController();
                            $response = $contactListController->getContacts();
                        }

                        break;
                    }
                case 'POST': {
                        $contactController = new ContactController();
                        //Добавление изображения контакта если /api/contacts/image (params[2])
                        if (isset($params[2]) && $params[2] == 'image') {
                            $id =  filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

                            $response = $contactController->setImage($id);
                        } else {
                            //Добавление/изменение контакта
                            $data = json_decode(file_get_contents("php://input"), true);
                            if (json_last_error()) {
                                $error = new ErrorController();
                                $response = $error->error400();
                                break;
                            }

                            $response = $contactController->processContact($data);
                        }

                        break;
                    }
                case 'OPTIONS': {
                        http_response_code(200);
                        $response = json_encode([
                            "message" => "OK"
                        ], JSON_UNESCAPED_UNICODE);
                        break;
                    }
                default: {
                        //Ошибка неверный запрос
                        $error = new ErrorController();
                        $response = $error->error400();
                        break;
                    }
            }
        } else {
            //Ошибка не найдено
            $error = new ErrorController();
            $response = $error->error404();
        }

        return $response;
    }
}
