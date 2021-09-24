<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__.'/vendor/contao/easy-coding-standard/config/set/contao.php');

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::LINE_ENDING, "\n");

    $services = $containerConfigurator->services();
    $services
        ->set(HeaderCommentFixer::class)
        ->call('configure', [[
            'header' => "This file is part of Contao EstateManager.\n\n@see https://www.contao-estatemanager.com/\n@source https://github.com/contao-estatemanager/core\n@copyright Copyright (c) 2021 Oveleon GbR (https://www.oveleon.de)\n@license   https://www.contao-estatemanager.com/lizenzbedingungen.html",
        ]])
    ;
};
