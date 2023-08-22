<?php

namespace models;
use PDO;

class Message
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getMessagesByGroupId($groupId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM messages WHERE group_id = :group_id ORDER BY created_at ASC');
        $stmt->execute([':group_id' => $groupId]);
        $messages = $stmt->fetchAll();

        return $messages;
    }

    public function createMessage($groupId, $message, $userName): string
    {
        // Generate a unique ID for the message
        $messageId = 'msg_' . uniqid();

        // Save the message and username in the database
        $stmt = $this->db->prepare('INSERT INTO messages (id, group_id, message, user_name, created_at) VALUES (:id, :group_id, :message, :user_name, :created_at)');
        $stmt->execute([
            ':id' => $messageId,
            ':group_id' => $groupId,
            ':message' => $message,
            ':user_name' => $userName,
            ':created_at' => date('Y-m-d H:i:s'),
        ]);

        return $messageId;
    }
}
