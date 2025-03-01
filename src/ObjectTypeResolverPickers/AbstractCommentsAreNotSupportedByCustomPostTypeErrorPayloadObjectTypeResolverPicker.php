<?php

declare(strict_types=1);

namespace PoPCMSSchema\CommentMutations\ObjectTypeResolverPickers;

use PoPCMSSchema\CommentMutations\ObjectModels\CommentsAreNotSupportedByCustomPostTypeErrorPayload;
use PoPCMSSchema\CommentMutations\TypeResolvers\ObjectType\CommentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver;
use PoPSchema\SchemaCommons\ObjectTypeResolverPickers\AbstractErrorPayloadObjectTypeResolverPicker;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;

abstract class AbstractCommentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolverPicker extends AbstractErrorPayloadObjectTypeResolverPicker
{
    private ?CommentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver $commentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver = null;

    final protected function getCommentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver(): CommentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver
    {
        if ($this->commentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver === null) {
            /** @var CommentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver */
            $commentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver = $this->instanceManager->getInstance(CommentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver::class);
            $this->commentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver = $commentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver;
        }
        return $this->commentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver;
    }

    public function getObjectTypeResolver(): ObjectTypeResolverInterface
    {
        return $this->getCommentsAreNotSupportedByCustomPostTypeErrorPayloadObjectTypeResolver();
    }

    protected function getTargetObjectClass(): string
    {
        return CommentsAreNotSupportedByCustomPostTypeErrorPayload::class;
    }
}
