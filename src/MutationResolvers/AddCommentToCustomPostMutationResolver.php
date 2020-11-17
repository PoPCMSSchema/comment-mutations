<?php

declare(strict_types=1);

namespace PoPSchema\CommentMutations\MutationResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoPSchema\CommentMutations\Facades\CommentTypeAPIFacade;

class AddCommentToCustomPostMutationResolver extends AbstractMutationResolver
{
    /**
     * @return mixed
     */
    public function execute(array $form_data)
    {
        return null;
    }

    public function validateErrors(array $form_data): ?array
    {
        $errors = [];
        $translationAPI = TranslationAPIFacade::getInstance();
        return $errors;
    }
}
