<?php

declare(strict_types=1);

return [
    'form' => [
        'title' => 'Título',
        'url' => 'URL',
        'linkable_type' => 'Tipo',
        'linkable_id' => 'ID',
    ],
    'resource' => [
        'name' => [
            'label' => 'Nome',
        ],
        'locations' => [
            'label' => 'Localizações',
            'empty' => 'Não atribuído',
        ],
        'items' => [
            'label' => 'Itens',
        ],
        'is_visible' => [
            'label' => 'Visibilidade',
            'visible' => 'Visível',
            'hidden' => 'Oculto',
        ],
    ],
    'actions' => [
        'add' => [
            'label' => 'Adicionar ao Menu',
        ],
        'locations' => [
            'label' => 'Localizações',
            'heading' => 'Gerenciar Localizações',
            'description' => 'Escolha qual menu aparece em cada localização.',
            'submit' => 'Atualizar',
            'form' => [
                'location' => [
                    'label' => 'Localização',
                ],
                'menu' => [
                    'label' => 'Menu Atribuído',
                ],
            ],
            'empty' => [
                'heading' => 'Nenhuma localização registrada',
            ],
        ],
    ],
    'items' => [
        'expand' => 'Expandir',
        'empty' => [
            'heading' => 'Não há itens neste menu.',
        ],
    ],
    'custom_link' => 'Link Personalizado',
    'open_in' => [
        'label' => 'Abrir em',
        'options' => [
            'self' => 'Mesma aba',
            'blank' => 'Nova aba',
            'parent' => 'Aba pai',
            'top' => 'Aba superior',
        ],
    ],
    'notifications' => [
        'created' => [
            'title' => 'Link criado',
        ],
        'locations' => [
            'title' => 'Localizações de menu atualizadas',
        ],
    ],
    'panel' => [
        'empty' => [
            'heading' => 'Nenhum item encontrado',
            'description' => 'Não há itens neste menu.',
        ],
        'pagination' => [
            'previous' => 'Anterior',
            'next' => 'Próximo',
        ],
    ],
];
