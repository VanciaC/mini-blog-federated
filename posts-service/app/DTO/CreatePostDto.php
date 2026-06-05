<?php

namespace App\DTO;

class CreatePostDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $body,
        public readonly int $authorId,
    ) {}
}