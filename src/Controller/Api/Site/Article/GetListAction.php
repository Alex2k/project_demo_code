<?php

declare(strict_types=1);

namespace App\Controller\Api\Site\Article;

use App\Controller\Api\BaseController;
use App\UseCase\Article\GetList\ArticleGetListUseCase;
use App\UseCase\Pagination;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * @Route("/api/site")
 */
class GetListAction extends BaseController
{
    use Pagination;

    private ArticleGetListUseCase $articleGetListUseCase;

    public const DEFAULT_ITEMS_PER_PAGE = 6;

    public function __construct(
        ArticleGetListUseCase $articleGetListUseCase
    ) {
        $this->articleGetListUseCase = $articleGetListUseCase;
    }

    /**
     * @Route("/articles", name="api-site-article-get-list", methods={"GET"})
     */
    public function __invoke(
        Request $request
    ): JsonResponse {
        $context = $request->query->all();

        return $this->handler($request, $context);
    }

    /**
     * @throws Throwable
     */
    public function execute(Request $request, array $context = [], array $data = []): array
    {
        $limitation = [];
        $limitation['page'] = $context['page'] ? (int) $context['page'] : 1;
        $limitation['per_page'] = $context['per_page'] ? (int) $context['per_page'] : self::DEFAULT_ITEMS_PER_PAGE;

        $articles = $this->articleGetListUseCase->getPublishedArticles($context, $limitation);
        $totalPublishedArticlesCount = $this->articleGetListUseCase->getTotalPublishedArticlesCount($context);

        return $this->wrapPagination($articles, $totalPublishedArticlesCount, $limitation);
    }
}
