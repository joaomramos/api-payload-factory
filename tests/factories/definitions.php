<?php

/**
 * @var \JumiaMarket\ApiPayloadFactory\ApiPayloadFactory $apiPF
 */
$apiPF->define('post/create', 1.1)
    ->setDefinition(
        [
            'category' => 'Magazines',
            'title' => 'Top Gear',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rutrum a nisi vitae blandit. Fusce sit amet nunc a eros egestas scelerisque ut quis neque.'
        ]
    );