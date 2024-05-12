<?php

namespace Models;

use Models\Interfaces\Model;
use Models\Traits\GenericModel;

class Post implements Model
{
    use GenericModel;

    // php 8のコンストラクタのプロパティプロモーションは、インスタンス変数を自動的に設定します。
    public function __construct(
        private ?int $id = null,
        private ?int $replyToId = null,
        private string $subject,
        private string $content,
        private ?string $imagePath = null,
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
    public function getReplyToId(): string
    {
        return $this->replyToId;
    }

    public function setName(int $replyToId): void
    {
        $this->replyToId = $replyToId;
    }
    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
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
