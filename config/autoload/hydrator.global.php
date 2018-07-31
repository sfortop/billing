<?php
/**
 * billing
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */
declare(strict_types=1);

return [
    'hydrators' => [
        // set false on production environment
        'regenerate-always' => true,
        'path' => realpath(__DIR__) . '/../../data/hydrators',
        // list of FQN class names or namespaces which require generated hydrators
        'classmap' => [
            \Infrastructure\DTO\Payment::class,
            'Domain\Entity\\',
        ],
    ],

];