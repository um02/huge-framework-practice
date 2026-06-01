<?php

class GroupModel
{
    public static function createGroup($groupName, $createdBy)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO chat_groups (group_name, created_by) VALUES (:group_name, :created_by)";
        $query = $database->prepare($sql);
        $query->execute([
            ':group_name' => $groupName,
            ':created_by' => $createdBy
        ]);

        $groupId = $database->lastInsertId();

        // Creator is automatically a member
        self::addMember($groupId, $createdBy);

        return $groupId;
    }

    public static function addMember($groupId, $userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT IGNORE INTO chat_group_members (group_id, user_id) VALUES (:group_id, :user_id)";
        $query = $database->prepare($sql);
        $query->execute([
            ':group_id' => $groupId,
            ':user_id' => $userId
        ]);
    }

    public static function removeMember($groupId, $userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM chat_group_members WHERE group_id = :group_id AND user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute([
            ':group_id' => $groupId,
            ':user_id' => $userId
        ]);
    }

    public static function getGroupsOfUser($userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT g.*, 
                    (SELECT COUNT(*) FROM chat_group_members WHERE group_id = g.id) AS member_count
                FROM chat_groups g
                JOIN chat_group_members gm ON gm.group_id = g.id
                WHERE gm.user_id = :user_id
                ORDER BY g.created_at DESC";

        $query = $database->prepare($sql);
        $query->execute([':user_id' => $userId]);

        return $query->fetchAll();
    }

    public static function getGroup($groupId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM chat_groups WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute([':id' => $groupId]);

        return $query->fetch();
    }

    public static function getMembers($groupId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT u.user_id, u.user_name, u.user_email
                FROM chat_group_members gm
                JOIN users u ON u.user_id = gm.user_id
                WHERE gm.group_id = :group_id";

        $query = $database->prepare($sql);
        $query->execute([':group_id' => $groupId]);

        return $query->fetchAll();
    }

    public static function isMember($groupId, $userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT id FROM chat_group_members WHERE group_id = :group_id AND user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute([
            ':group_id' => $groupId,
            ':user_id' => $userId
        ]);

        return $query->fetch() !== false;
    }

    public static function isCreator($groupId, $userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT id FROM chat_groups WHERE id = :group_id AND created_by = :user_id";
        $query = $database->prepare($sql);
        $query->execute([
            ':group_id' => $groupId,
            ':user_id' => $userId
        ]);

        return $query->fetch() !== false;
    }

    public static function sendMessage($groupId, $fromUserId, $message)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO group_messages (group_id, from_user_id, message) VALUES (:group_id, :from_user_id, :message)";
        $query = $database->prepare($sql);
        $query->execute([
            ':group_id' => $groupId,
            ':from_user_id' => $fromUserId,
            ':message' => $message
        ]);
    }

    public static function getMessages($groupId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT gm.*, u.user_name
                FROM group_messages gm
                JOIN users u ON u.user_id = gm.from_user_id
                WHERE gm.group_id = :group_id
                ORDER BY gm.created_at ASC";

        $query = $database->prepare($sql);
        $query->execute([':group_id' => $groupId]);

        return $query->fetchAll();
    }

    public static function markAsRead($groupId, $userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT IGNORE INTO group_message_read (message_id, user_id)
                SELECT gm.id, :user_id
                FROM group_messages gm
                LEFT JOIN group_message_read gmr
                    ON gmr.message_id = gm.id AND gmr.user_id = :user_id
                WHERE gm.group_id = :group_id
                  AND gm.from_user_id != :user_id
                  AND gmr.id IS NULL";

        $query = $database->prepare($sql);
        $query->execute([
            ':group_id' => $groupId,
            ':user_id' => $userId
        ]);
    }

    public static function getUnreadCountsPerGroup($userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT gm.group_id, COUNT(*) AS unread_count
                FROM group_messages gm
                JOIN chat_group_members cgm ON cgm.group_id = gm.group_id AND cgm.user_id = :user_id
                LEFT JOIN group_message_read gmr
                    ON gmr.message_id = gm.id AND gmr.user_id = :user_id
                WHERE gm.from_user_id != :user_id
                  AND gmr.id IS NULL
                GROUP BY gm.group_id";

        $query = $database->prepare($sql);
        $query->execute([':user_id' => $userId]);

        $result = [];
        foreach ($query->fetchAll() as $row) {
            $result[$row->group_id] = $row->unread_count;
        }
        return $result;
    }
}
