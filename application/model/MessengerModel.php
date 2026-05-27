<?php

class MessengerModel
{
    public static function sendMessage($fromUserId, $toUserId, $message)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO messages
                (from_user_id, to_user_id, message)
                VALUES (:from_user_id, :to_user_id, :message)";

        $query = $database->prepare($sql);

        $query->execute([
            ':from_user_id' => $fromUserId,
            ':to_user_id' => $toUserId,
            ':message' => $message
        ]);
    }

    public static function getConversation($userId1, $userId2)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT *
                FROM messages
                WHERE
                    (from_user_id = :user1 AND to_user_id = :user2)
                    OR
                    (from_user_id = :user2 AND to_user_id = :user1)
                ORDER BY created_at ASC";

        $query = $database->prepare($sql);

        $query->execute([
            ':user1' => $userId1,
            ':user2' => $userId2
        ]);

        return $query->fetchAll();
    }

    public static function getUnreadCountsPerUser($toUserId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT m.from_user_id, COUNT(*) AS unread_count
                FROM messages m
                LEFT JOIN message_read mr
                    ON mr.message_id = m.id
                    AND mr.user_id = :to_user_id
                WHERE m.to_user_id = :to_user_id
                  AND mr.id IS NULL
                GROUP BY m.from_user_id";

        $query = $database->prepare($sql);
        $query->execute([':to_user_id' => $toUserId]);

        $result = [];
        foreach ($query->fetchAll() as $row) {
            $result[$row->from_user_id] = $row->unread_count;
        }
        return $result;
    }

    public static function markAsRead($fromUserId, $toUserId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "
            INSERT IGNORE INTO message_read (message_id, user_id)

            SELECT m.id, :to_user_id
            FROM messages m

            LEFT JOIN message_read mr
                ON mr.message_id = m.id
                AND mr.user_id = :to_user_id

            WHERE
                m.from_user_id = :from_user_id
                AND m.to_user_id = :to_user_id
                AND mr.id IS NULL
        ";

        $query = $database->prepare($sql);

        $query->execute([
            ':from_user_id' => $fromUserId,
            ':to_user_id' => $toUserId
        ]);
    }


}