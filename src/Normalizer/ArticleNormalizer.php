<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\Entity\Article;
use App\Helper\ArrayHelper;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ArticleNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param Article|mixed $object
     *
     * @throws ExceptionInterface
     */
    public function normalize($object, ?string $format = null, array $context = []): array
    {
        $data = [
            'id' => $object->getId(),
            'image' => $object->getImage(),
            'title' => $object->getTitle(),
            'preview' => $object->getPreview(),
            'contentHtml' => $object->getContentHtml(),
            'contentMarkdown' => $object->getContentMarkdown(),
            'is_published' => $object->getIsPublished(),
            'publishedAt' => $object->getPublishedAt(),
            'createdAt' => $object->getCreatedAt(),
        ];

        if (ArrayHelper::inSubArray('tags', 'with', $context)) {
            $data['tags'] = [];
            foreach ($object->getTags() as $tag) {
                $data['tags'][] = $this->normalizer->normalize($tag);
            }
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, ?string $format = null): bool
    {
        return $data instanceof Article;
    }
}
