<?php

namespace Models;

use Models\Interfaces\Model;
use Models\Traits\GenericModel;

class Post implements Model
{
    use GenericModel;

    // php 8のコンストラクタのプロパティプロモーションは、インスタンス変数を自動的に設定します。
    public function __construct(
        private string $content,
        private ?string $imagePath = null,
        private int $likes = 0,
        private ?int $id = null,
        private ?int $replyToId = null,
        private ?DataTimeStamp $timeStamp = null,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getReplyToId(): string | null
    {
        return $this->replyToId;
    }

    public function setName(int $replyToId): void
    {
        $this->replyToId = $replyToId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $count): void
    {
        $this->likes = $likes;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function getTimeStamp(): ?DataTimeStamp
    {
        return $this->timeStamp;
    }

    public function setTimeStamp(DataTimeStamp $timeStamp): void
    {
        $this->timeStamp = $timeStamp;
    }
}
