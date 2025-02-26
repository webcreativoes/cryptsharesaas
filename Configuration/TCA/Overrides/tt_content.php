<?php

defined('TYPO3') or die();

// Nutzung der B13 Container-Registry für TYPO3 12
$containerRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class);

$containerConfigurations = [
    ['container-LayoutGridWhite', 'Layout-Grid: White', 1, [10]],
    ['container-LayoutGridDarkblue', 'Layout-Grid: Darkblue', 1, [10]],
    ['container-LayoutGridDarkgray', 'Layout-Grid: Darkgray', 1, [10]],
    ['container-ContentGrid2Cols-50-50', 'Content-Grid: 2 Cols (50%-50%)', 2, [10, 20]],
    ['container-ContentGrid2Cols-66-33', 'Content-Grid: 2 Cols (66%-33%)', 2, [10, 20]],
    ['container-ContentGrid2Cols-33-66', 'Content-Grid: 2 Cols (33%-66%)', 2, [10, 20]],
    ['container-ContentGrid3Cols-33-33-33', 'Content-Grid: 3 Cols (33%-33%-33%)', 3, [10, 20, 30]],
    ['container-ContentGrid3Cols-50-25-25', 'Content-Grid: 3 Cols (50%-25%-25%)', 3, [10, 20, 30]],
    ['container-ContentGrid3Cols-25-25-50', 'Content-Grid: 3 Cols (25%-25%-50%)', 3, [10, 20, 30]],
    ['container-ContentGrid4Cols-25-25-25-25', 'Content-Grid: 4 Cols (25%-25%-25%-25%)', 4, [10, 20, 30, 40]],
    ['container-ContentGrid6Cols-16-16-16-16-16-16', 'Content-Grid: 6 Cols (16%-16%-16%-16%-16%-16%)', 6, [10, 20, 30, 40, 50, 60]],
    ['container-FooterGrid', 'Footer-Grid: 4 Cols', 4, [10, 20, 30, 40]],
    ['container-ContentGrid2ColsForNesting-33-66', 'Content-Grid: 2 Cols for Nesting (33%-66%)', 2, [10, 20]],
    ['container-ContentGrid2ColsForNesting-50-50', 'Content-Grid: 2 Cols for Nesting (50%-50%)', 2, [10, 20]],
    ['container-LayoutGridLightgray', 'Layout-Grid: Lightgray', 1, [10]],
    ['container-ContentGrid2ColsStructuredContent', 'Content-Grid: 2 Cols Structured Content', 2, [10, 20]],
    ['container-LayoutGridTurquoise', 'Layout-Grid: Turquoise', 1, [10]],
    ['container-ContentGrid2ColsForNesting-66-33', 'Content-Grid: 2 Cols for Nesting (66%-33%)', 2, [10, 20]],
    ['container-ScreenshotGrid', 'Screenshot-Grid', 1, [10]],
    ['container-GDPRGridDarkgray', 'GDPR-Grid: Darkgray', 1, [10]],
    ['container-LayoutGridBackgroundimage', 'Layout-Grid: Backgroundimage', 1, [10]],
    ['container-ContentGrid2ColsForNesting-10-90', 'Content-Grid: 2 Cols for Nesting (10%-90%)', 2, [10, 20]],
    ['container-ContentGrid2ColsForNestingDashboard', 'Content-Grid: 2 Cols for Nesting Dashboard', 2, [10, 20]],
    ['container-Hints', 'Hints', 1, [10]],
];

foreach ($containerConfigurations as [$identifier, $label, $colspan, $cols]) {
    $colPosArray = [];
    foreach ($cols as $col) {
        $colPosArray[] = ['name' => "{$label}", 'colPos' => $col];
    }

    $containerConfig = new \B13\Container\Tca\ContainerConfiguration(
        $identifier,
        $label,
        '',
        [
            [['name' => $label, 'colPos' => 5, 'colspan' => $colspan]],
            $colPosArray
        ]
    );

    $containerConfig->setIcon("EXT:cryptsharecom/Resources/Public/Icons/container/{$identifier}.svg");

    $containerRegistry->configureContainer($containerConfig);
}
