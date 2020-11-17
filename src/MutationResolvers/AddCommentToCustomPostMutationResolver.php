<?php

declare(strict_types=1);

namespace PoPSchema\CommentMutations\MutationResolvers;

use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\State\ApplicationState;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoPSchema\CommentMutations\Facades\CommentTypeAPIFacade;

class AddCommentToCustomPostMutationResolver extends AbstractMutationResolver
{
    public function validateErrors(array $form_data): ?array
    {
        $errors = [];
        if (empty($form_data[MutationInputProperties::CUSTOMPOST_ID])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('We don\'t know what post the comment is for. Please reload the page and try again.', 'pop-application');
        }
        if (empty($form_data[MutationInputProperties::COMMENT])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The comment is empty.', 'pop-application');
        }
        return $errors;
    }

    /**
     * @param mixed $comment_id
     */
    protected function additionals($comment_id, array $form_data): void
    {
        HooksAPIFacade::getInstance()->doAction('gd_addcomment', $comment_id, $form_data);
    }

    protected function getCommentData(array $form_data): array
    {
        // TODO: Integrate with `mustHaveUserAccountToAddComment`
        $cmsusersapi = \PoPSchema\Users\FunctionAPIFactory::getInstance();
        $vars = ApplicationState::getVars();
        $user_id = $vars['global-userstate']['current-user-id'];
        $author_url = $cmsusersapi->getUserURL($user_id);
        $comment_data = array(
            'userID' => $user_id,
            'author' => $cmsusersapi->getUserDisplayName($user_id),
            'authorEmail' => $cmsusersapi->getUserEmail($user_id),
            'author-URL' => $author_url,
            'author-IP' => $_SERVER['REMOTE_ADDR'],
            'agent' => $_SERVER['HTTP_USER_AGENT'],
            'content' => $form_data[MutationInputProperties::COMMENT],
            'parent' => $form_data[MutationInputProperties::PARENT_COMMENT_ID],
            'customPostID' => $form_data[MutationInputProperties::CUSTOMPOST_ID]
        );

        return $comment_data;
    }

    /**
     * @return mixed
     */
    protected function insertComment(array $comment_data)
    {
        $commentTypeAPI = CommentTypeAPIFacade::getInstance();
        return $commentTypeAPI->insertComment($comment_data);
    }

    /**
     * @param string[] $errors
     * @return mixed|null
     */
    /**
     * @return mixed
     */
    public function execute(array $form_data)
    {
        $comment_data = $this->getCommentData($form_data);
        $comment_id = $this->insertComment($comment_data);

        // Allow for additional operations (eg: set Action categories)
        $this->additionals($comment_id, $form_data);

        return $comment_id;
    }
}
