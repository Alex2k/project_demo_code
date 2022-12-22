<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Site;

use App\Controller\Frontend\Site\Contract\PromoContract;
use App\UseCase\Article\Read\ArticleReadUseCase;
use App\UseCase\Expert\Read\ExpertReadUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function array_merge;

class ArticleController extends BaseController implements PromoContract
{
    private ArticleReadUseCase $articleReadUseCase;

    public function __construct(
        ArticleReadUseCase $articleReadUseCase
    ) {
        $this->articleReadUseCase = $articleReadUseCase;
    }

    /**
     * @Route("/articles/{id}", name="site-article")
     */
    public function __invoke(Request $request, int $id): Response
    {
        $article = $this->articleReadUseCase->getArticleById($id);

        return $this->render(
            'site2/article.html.twig',
            array_merge(
                $request->attributes->get('default_template_params'),
                [
                    'article' => $article,
                ]
            )
        );
    }
}
