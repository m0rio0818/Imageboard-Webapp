<?php

namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;
use Models\Post;
use Models\DataTimeStamp;

class PostDAOImpl implements PostDAO
{
    public function create(Post $postData): bool
    {
        if ($postData->getId() !== null) throw new \Exception('Cannot create a post with an existing ID. id: ' . $postData->getId());
        return $this->createOrUpdate($postData);
    }

    public function getById(int $id): ?Post
    {
        $mysqli = DatabaseManager::getMysqliConnection();
        $computerPart = $mysqli->prepareAndFetchAll("SELECT * FROM Post WHERE id = ?", 'i', [$id])[0] ?? null;

        return $computerPart === null ? null : $this->resultsToPosts($computerPart);
    }

    public function update(Post $postData): bool
    {
        if ($postData->getId() === null) throw new \Exception('Post has no ID.');

        $current = $this->getById($postData->getId());
        if ($current === null) throw new \Exception(sprintf("Post %s does not exist.", $postData->getId()));

        return $this->createOrUpdate($postData);
    }

    public function delete(int $id): bool
    {
        $mysqli = DatabaseManager::getMysqliConnection();
        return $mysqli->prepareAndExecute("DELETE FROM Post WHERE id = ?", 'i', [$id]);
    }

    public function getRandom(): ?Post
    {
        $mysqli = DatabaseManager::getMysqliConnection();
        $computerPart = $mysqli->prepareAndFetchAll("SELECT * FROM Post ORDER BY RAND() LIMIT 1", '', [])[0] ?? null;

        return $computerPart === null ? null : $this->resultsToPosts($computerPart);
    }

    public function getAllThreads(int $offset, int $limit): array
    {
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM Post WHERE reply_to_id IS NULL LIMIT ?, ?";

        $results = $mysqli->prepareAndFetchAll($query, 'ii', [$offset, $limit]);

        return $results === null ? [] : $this->resultsToPosts($results);
    }

    public function getReplies(Post $postData, int $offset, int $limit): array
    {
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM Post WHERE reply_to_id = ? LIMIT ?, ?";

        $results = $mysqli->prepareAndFetchAll($query, 'iii', [$postData->getId(), $offset, $limit]);

        return $results === null ? [] : $this->resultsToPosts($results);
    }

    public function createOrUpdate(Post $postData): bool
    {
        $mysqli = DatabaseManager::getMysqliConnection();

        $query =
            <<<SQL
            INSERT INTO Post (id, reply_to_id, content, ImagePath, likes)
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE id = VALUES(id),
            reply_to_id = VALUES(reply_to_id),
            content = VALUES(content),
            ImagePath = VALUES(ImagePath),
            likes = VALUES(likes)
        SQL;


        $result = $mysqli->prepareAndExecute(
            $query,
            'iisss',
            [
                $postData->getId(), // on null ID, mysql will use auto-increment.
                $postData->getReplyToId(),
                $postData->getContent(),
                $postData->getImagePath(),
                $postData->getLikes()
            ],
        );

        if (!$result) return false;

        // insert_id returns the last inserted ID.
        if ($postData->getId() === null) {
            $postData->setId($mysqli->insert_id);
            $timeStamp = $postData->getTimeStamp() ?? new DataTimeStamp(date('Y-m-h'), date('Y-m-h'));
            $postData->setTimeStamp($timeStamp);
        }

        return true;
    }

    private function resultToPost(array $data): Post
    {
        return new Post(
            replyToId: $data["replyToId"],
            content: $data["content"],
            imagePath: $data["imagePath"],
            likes: $data["likes"],
            timeStamp: new DataTimeStamp($data['created_at'], $data['updated_at'])
        );
    }

    private function resultsToPosts(array $results): array
    {
        $Posts = [];

        foreach ($results as $result) {
            $computerParts[] = $this->resultToPost($result);
        }

        return $Posts;
    }
}
