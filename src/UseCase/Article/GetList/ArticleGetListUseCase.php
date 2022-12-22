<?php

declare(strict_types=1);

namespace App\UseCase\Article\GetList;

use App\Repository\ArticleRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ArticleGetListUseCase
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

    public function getPublishedArticles(array $params, array $limitation = []): array
    {
        $criteria = [
            'isPublished' => true,
        ];

        $articles = $this->articleRepository->findBy(
            $criteria,
            ['publishedAt' => 'desc'],
            $limitation['per_page'] ?? null,
            isset($limitation['page']) && $limitation['per_page']
                ? ($limitation['page'] - 1) * $limitation['per_page']
                : null
        );

        $articlesData = [];
        foreach ($articles as $article) {
            $articlesData[] = $this->normalizer->normalize(
                $article,
                null,
                [
                    'with' => ['tags'],
                ]
            );
        }

        return $articlesData;
    }

    public function getTotalPublishedArticlesCount(array $params = []): int
    {
        $criteria = [
            'isPublished' => true,
        ];

        return $this->articleRepository->count($criteria);
    }
}
