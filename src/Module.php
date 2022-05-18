<?php

declare(strict_types=1);

namespace PoPCMSSchema\CommentMutations;

use PoP\Root\Module\AbstractModule;
use PoPCMSSchema\Users\Module as UsersModule;

class Module extends AbstractModule
{
    protected function requiresSatisfyingModule(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function getDependedModuleClasses(): array
    {
        return [
            \PoPCMSSchema\Comments\Module::class,
            \PoPCMSSchema\UserStateMutations\Module::class,
        ];
    }

    /**
     * Initialize services
     *
     * @param string[] $skipSchemaModuleClasses
     */
    protected function initializeContainerServices(
        bool $skipSchema,
        array $skipSchemaModuleClasses,
    ): void {
        $this->initServices(dirname(__DIR__));
        $this->initSchemaServices(dirname(__DIR__), $skipSchema);
        $this->initSchemaServices(
            dirname(__DIR__),
            $skipSchema || in_array(UsersModule::class, $skipSchemaModuleClasses),
            '/ConditionalOnModule/Users'
        );
    }
}