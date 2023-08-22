<?php
namespace controllers;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use models\ChatGroup;
use models\Message;

require_once __DIR__ . '/../models/ChatGroup.php';

class ChatController
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getHomePage(Request $request, Response $response, array $args): Response
    {
        $message = array('Welcome to the chat-app' );
        $json_message = json_encode($message);
        $response -> getBody() -> write($json_message);
        return $response->withHeader('Content-Type','application-json')->withStatus(200);
    }
    public function createChatGroup(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $groupName = $data['group_name'];

        if (empty($groupName)) {
            $message = array('error' => 'Group name is required.');
            $json_message = json_encode($message);
            $response->getBody()->write($json_message);
            return $response->withHeader('Content-Type','application-json')->withStatus(400);
        }

        $chatGroupModel = new ChatGroup($this->db);
        $groupId = $chatGroupModel->createGroup($groupName);

        $data = array('group_id' => $groupId, 'group_name' => $groupName);
        $json_data = json_encode($data);
        $response->getBody()->write($json_data);
        return $response->withHeader('Content-Type','application-json')-> withStatus(201);
    }

    public function getAllChatGroups(Request $request, Response $response, array $args): Response
    {
        $chatGroupModel = new ChatGroup($this->db);
        $groups = $chatGroupModel->getAllGroups();
        $json_groups = json_encode($groups);

        $response->getBody()->write($json_groups);
        return $response->withHeader('Content-Type','application-json')->withStatus(200);
    }

    public function getGroupMessages(Request $request, Response $response, array $args): Response
    {
        $groupId = $args['groupId'];

        $messageModel = new Message($this->db);
        $messages = $messageModel->getMessagesByGroupId($groupId);
        $json_messages = json_encode($messages);
        $response->getBody()->write($json_messages);
        return $response->withHeader('Content-Type','application-json')->withStatus(200);
    }

    public function createMessage(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $groupId = $args['groupId'];
        $message = $data['message'];
        $userName = $data['user_name']; // Extract username from the request

        if (empty($message) || empty($userName)) {
            $message = array('error' => 'Message and user_name are required.');
            $json_message = json_encode($message);
            $response->getBody()->write($json_message);
            return $response->withHeader('Content-Type','application-json')->withStatus(400);

        }

        // Save the message along with the username in the database
        $messageModel = new Message($this->db);
        $messageId = $messageModel->createMessage($groupId, $message, $userName);

        $message_info = array(['message_id' => $messageId, 'message' => $message, 'user_name' => $userName]);
        $json_message_info = json_encode($message_info);
        $response->getBody()->write($json_message_info);
        return $response->withHeader('Content-Type','application-json')
            ->withStatus(201);
    }


}
