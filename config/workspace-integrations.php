<?php

use Gedachtegoed\Workspace\Integrations\Composer\Aliases;
use Gedachtegoed\Workspace\Integrations\EditorDefaults\EditorDefaults;
use Gedachtegoed\Workspace\Integrations\IDEHelper\IDEHelper;
use Gedachtegoed\Workspace\Integrations\Larastan\Larastan;
use Gedachtegoed\Workspace\Integrations\PHPCodeSniffer\PHPCodeSniffer;
use Gedachtegoed\Workspace\Integrations\PHPCSFixer\PHPCSFixer;
use Gedachtegoed\Workspace\Integrations\Pint\Pint;
use Gedachtegoed\Workspace\Integrations\PrettierBlade\PrettierBlade;
use Gedachtegoed\Workspace\Integrations\TLint\TLint;
use Gedachtegoed\Workspace\Integrations\Workflows\Workflows;

return [
    EditorDefaults::class,
    PHPCodeSniffer::class,
    PrettierBlade::class,
    PHPCSFixer::class,
    IDEHelper::class,
    Workflows::class,
    Larastan::class,
    Aliases::class,
    // TLint::class,
    Pint::class,
];
