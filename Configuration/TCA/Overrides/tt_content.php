<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-LayoutGridWhite', // CType
        'Layout-Grid: White', // label
        '', // description
        [
            [
                ['name' => 'Layout-Grid: White', 'colPos' => 5, 'colspan' => 1]
            ],
            [
                ['name' => '100%', 'colPos' => 10]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/LayoutGridWhite.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-LayoutGridDarkblue', // CType
        'Layout-Grid: Darkblue', // label
        '', // description
        [
            [
                ['name' => 'Layout-Grid: Darkblue', 'colPos' => 5, 'colspan' => 1]
            ],
            [
                ['name' => '100%', 'colPos' => 10]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/LayoutGridDarkblue.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-LayoutGridDarkgray', // CType
        'Layout-Grid: Darkgray', // label
        '', // description
        [
            [
                ['name' => 'Layout-Grid: Darkgray', 'colPos' => 5, 'colspan' => 1]
            ],
            [
                ['name' => '100%', 'colPos' => 10]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/LayoutGridDarkgray.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid2Cols-50-50', // CType
        'Content-Grid: 2 Cols (50%-50%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 2 Cols (50%-50%)', 'colPos' => 5, 'colspan' => 2]
            ],
            [
                ['name' => '50%', 'colPos' => 10],
                ['name' => '50%', 'colPos' => 20]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid2Cols-50-50.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid2Cols-66-33', // CType
        'Content-Grid: 2 Cols (66%-33%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 2 Cols (66%-33%)', 'colPos' => 5, 'colspan' => 2]
            ],
            [
                ['name' => '66%', 'colPos' => 10],
                ['name' => '33%', 'colPos' => 20]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid2Cols-66-33.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid2Cols-33-66', // CType
        'Content-Grid: 2 Cols (33%-66%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 2 Cols (33%-66%)', 'colPos' => 5, 'colspan' => 2]
            ],
            [
                ['name' => '33%', 'colPos' => 10],
                ['name' => '66%', 'colPos' => 20]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid2Cols-33-66.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid3Cols-33-33-33', // CType
        'Content-Grid: 3 Cols (33%-33%-33%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 3 Cols (33%-33%-33%)', 'colPos' => 5, 'colspan' => 3]
            ],
            [
                ['name' => '33%', 'colPos' => 10],
                ['name' => '33%', 'colPos' => 20],
                ['name' => '33%', 'colPos' => 30]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid3Cols-33-33-33.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid3Cols-50-25-25', // CType
        'Content-Grid: 3 Cols (50%-25%-25%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 3 Cols (50%-25%-25%)', 'colPos' => 5, 'colspan' => 3]
            ],
            [
                ['name' => '50%', 'colPos' => 10],
                ['name' => '25%', 'colPos' => 20],
                ['name' => '25%', 'colPos' => 30]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid3Cols-50-25-25.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid3Cols-25-25-50', // CType
        'Content-Grid: 3 Cols (25%-25%-50%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 3 Cols (25%-25%-50%)', 'colPos' => 5, 'colspan' => 3]
            ],
            [
                ['name' => '25%', 'colPos' => 10],
                ['name' => '25%', 'colPos' => 20],
                ['name' => '50%', 'colPos' => 30]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid3Cols-25-25-50.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid4Cols-25-25-25-25', // CType
        'Content-Grid: 4 Cols (25%-25%-25%-25%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 4 Cols (25%-25%-25%-25%)', 'colPos' => 5, 'colspan' => 4]
            ],
            [
                ['name' => '25%', 'colPos' => 10],
                ['name' => '25%', 'colPos' => 20],
                ['name' => '25%', 'colPos' => 30],
                ['name' => '25%', 'colPos' => 40]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid4Cols-25-25-25-25.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid6Cols-16-16-16-16-16-16', // CType
        'Content-Grid: 6 Cols (16%-16%-16%-16%-16%-16%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 6 Cols (16%-16%-16%-16%-16%-16%)', 'colPos' => 5, 'colspan' => 6]
            ],
            [
                ['name' => '16%', 'colPos' => 10],
                ['name' => '16%', 'colPos' => 20],
                ['name' => '16%', 'colPos' => 30],
                ['name' => '16%', 'colPos' => 40],
                ['name' => '16%', 'colPos' => 50],
                ['name' => '16%', 'colPos' => 60]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid6Cols-16-16-16-16-16-16.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-FooterGrid', // CType
        'Footer-Grid: 4 Cols', // label
        '', // description
        [
            [
                ['name' => 'Footer-Grid: 4 Cols', 'colPos' => 5, 'colspan' => 4]
            ],
            [
                ['name' => 'col 1', 'colPos' => 10],
                ['name' => 'col 2', 'colPos' => 20],
                ['name' => 'col 3', 'colPos' => 30],
                ['name' => 'col 4', 'colPos' => 40]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/FooterGrid.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid2ColsForNesting-33-66', // CType
        'Content-Grid: 2 Cols for Nesting (33%-66%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 2 Cols for Nesting (33%-66%)', 'colPos' => 5, 'colspan' => 2]
            ],
            [
                ['name' => '33%', 'colPos' => 10],
                ['name' => '66%', 'colPos' => 20]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid2ColsForNesting-33-66.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid2ColsForNesting-50-50', // CType
        'Content-Grid: 2 Cols for Nesting (50%-50%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 2 Cols for Nesting (50%-50%)', 'colPos' => 5, 'colspan' => 2]
            ],
            [
                ['name' => '50%', 'colPos' => 10],
                ['name' => '50%', 'colPos' => 20]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid2ColsForNesting-50-50.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-LayoutGridLightgray', // CType
        'Layout-Grid: Lightgray', // label
        '', // description
        [
            [
                ['name' => 'Layout-Grid: Lightgray', 'colPos' => 5, 'colspan' => 1]
            ],
            [
                ['name' => '100%', 'colPos' => 10]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/LayoutGridLightgray.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid2ColsStructuredContent', // CType
        'Content-Grid: 2 Cols Structured Content', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 2 Cols Structured Content', 'colPos' => 5, 'colspan' => 2]
            ],
            [
                ['name' => '33%', 'colPos' => 10],
                ['name' => '66%', 'colPos' => 20]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid2ColsStructuredContent.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-LayoutGridTurquoise', // CType
        'Layout-Grid: Turquoise', // label
        '', // description
        [
            [
                ['name' => 'Layout-Grid: Turquoise', 'colPos' => 5, 'colspan' => 1]
            ],
            [
                ['name' => '100%', 'colPos' => 10]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/LayoutGridTurquoise.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid2ColsForNesting-66-33', // CType
        'Content-Grid: 2 Cols for Nesting (66%-33%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 2 Cols for Nesting (66%-33%)', 'colPos' => 5, 'colspan' => 2]
            ],
            [
                ['name' => '66%', 'colPos' => 10],
                ['name' => '33%', 'colPos' => 20]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid2ColsForNesting-66-33.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ScreenshotGrid', // CType
        'Screenshot-Grid:', // label
        '', // description
        [
            [
                ['name' => 'Screenshot-Grid:', 'colPos' => 5, 'colspan' => 1]
            ],
            [
                ['name' => '100%', 'colPos' => 10]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ScreenshotGrid.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-GDPRGridDarkgray', // CType
        'GDPR-Grid: Darkgray', // label
        '', // description
        [
            [
                ['name' => 'GDPR-Grid: Darkgray', 'colPos' => 5, 'colspan' => 1]
            ],
            [
                ['name' => '100%', 'colPos' => 10]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/GDPRGridDarkgray.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-LayoutGridBackgroundimage', // CType
        'Layout-Grid: Backgroundimage', // label
        '', // description
        [
            [
                ['name' => 'Layout-Grid: Backgroundimage', 'colPos' => 5, 'colspan' => 1]
            ],
            [
                ['name' => '100%', 'colPos' => 10]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/LayoutGridBackgroundimage.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid2ColsForNesting-10-90', // CType
        'Content-Grid: 2 Cols for Nesting (10%-90%)', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 2 Cols for Nesting (10%-90%)', 'colPos' => 5, 'colspan' => 2]
            ],
            [
                ['name' => '10%', 'colPos' => 10],
                ['name' => '90%', 'colPos' => 20]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid2ColsForNesting-10-90.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-ContentGrid2ColsForNestingDashboard', // CType
        'Content-Grid: 2 Cols for Nesting Dashboard', // label
        '', // description
        [
            [
                ['name' => 'Content-Grid: 2 Cols for Nesting Dashboard', 'colPos' => 5, 'colspan' => 2]
            ],
            [
                ['name' => '33%', 'colPos' => 10],
                ['name' => '66%', 'colPos' => 20]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/ContentGrid2ColsForNestingDashboard.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
    new \B13\Container\Tca\ContainerConfiguration(
        'container-Hints', // CType
        'Hints', // label
        '', // description
        [
            [
                ['name' => 'Hints', 'colPos' => 5, 'colspan' => 1]
            ],
            [
                ['name' => 'Hint', 'colPos' => 10]
            ]
        ] // grid configuration
    )
    )
        // set an optional icon configuration
        ->setIcon('EXT:cryptsharecom/Resources/Public/Icons/container/Hints.svg')
);