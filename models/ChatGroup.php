<?php


namespace models;
use PDO;

class ChatGroup
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllGroups(): array
    {
        $stmt = $this->db->query('SELECT * FROM chat_groups');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createGroup($groupName): int
    {
        $stmt = $this->db->prepare('INSERT INTO chat_groups (group_name) VALUES (:group_name)');
        $stmt->bindParam(':group_name', $groupName);
        $stmt->execute();

        return $this->db->lastInsertId();
    }
}
