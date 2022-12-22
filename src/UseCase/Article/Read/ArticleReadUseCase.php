<?php

declare(strict_types=1);

namespace App\UseCase\Article\Read;

use App\Repository\ArticleRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ArticleReadUseCase
{
    private NormalizerInterface $normalizer;
    private ArticleRepository $articleRepository;

    public function __construct(
        NormalizerInterface $normalizer,
        ArticleRepository $articleRepository
    ) {
        $this->normalizer     = $normalizer;
        $this->articleRepository = $articleRepository;
    }

    public function getArticleById(int $id): array
    {
        $article = $this->articleRepository->findOneBy([
            'id' => $id,
            'isPublished' => true,
        ]);

        return $this->normalizer->normalize(
            $article,
            null,
            [
                'with' => ['tags'],
            ]
        );
    }
}
