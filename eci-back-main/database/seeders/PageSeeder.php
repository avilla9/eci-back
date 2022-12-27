<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $pages = [
            [
                'title' => 'Home',
                'sections' => [
                    [
                        'title' => 'Novedades'
                    ],
                    [
                        'title' => 'Eventos'
                    ]
                ]
            ],
            [
                'title' => 'Campaña',
                'sections' => [
                    [
                        'title' => 'Lo que tengo que saber'
                    ],
                    [
                        'title' => 'Lo que tengo que aprender'
                    ],
                    [
                        'title' => 'Lo que tengo que hacer'
                    ],
                    [
                        'title' => 'Lo que he conseguido'
                    ],
                ]
            ],
            [
                'title' => 'Adopción',
                'sections' => [
                    [
                        'title' => 'Lo que tengo que saber'
                    ],
                    [
                        'title' => 'Lo que tengo que aprender'
                    ],
                    [
                        'title' => 'Lo que tengo que hacer'
                    ],
                    [
                        'title' => 'Lo que he conseguido'
                    ],
                ]
            ],
            [
                'title' => 'Conocimiento',
                'sections' => [
                    [
                        'title' => 'El Cliente',
                        'subtitle' => 'Hábitos de compra, tendencias, curiosidades',
                    ],
                    [
                        'title' => 'El Producto',
                        'subtitle' => 'Tendencias, nuevos productos, comparativas',
                    ],
                    [
                        'title' => 'El Trabajo',
                        'subtitle' => 'Consejos, buenas prácticas, ejemplos',
                    ],
                    [
                        'title' => 'La Actitud',
                        'subtitle' => 'Conocimiento, constancia, actitud positiva.',
                    ],
                    [
                        'title' => 'El Entorno',
                        'subtitle' => 'Macroeconómico, legal, social.',
                    ],
                    [
                        'title' => 'El Competidor',
                        'subtitle' => 'Ventajas competitivas, análisis, comparativas',
                    ],
                    [
                        'title' => 'La Compañía',
                        'subtitle' => 'El Grupo, su cultura, una marca líder y referencia en España.'
                    ]
                ]
            ],
            [
                'title' => 'Recompensas',
                'sections' => [
                    [
                        'title' => 'Challenge you',
                        'custom_class' => 'challenge-you',
                        'subtitle' => '¿Serás capaz de superarlos todos?',
                    ],
                    [
                        'title' => 'Share today',
                        'custom_class' => 'learn-today',
                        'subtitle' => 'Comparte y gana SECI COINs por ello.',
                    ],
                    [
                        'title' => 'Love today',
                        'custom_class' => 'wall-of-fame',
                        'subtitle' => 'Dinos lo que te gusta y gana SECI COINs por hacerlo!',
                    ],
                    [
                        'title' => 'Happy box',
                        'custom_class' => 'happy-box',
                        'subtitle' => '',
                    ],
                ],
            ],
            [
                'title' => 'Salas',
                'sections' => [
                    [
                        'title' => 'TOP DELEGADOS',
                        'description' => 'Información para ti y sobre tus agentes, ¿sabes para qué? ¡Pues claro! ¡Para que hables con ellos! ;)',
                    ],
                    [
                        'title' => 'TOP AGENTES',
                        'description' => 'Pues si, si puedes entrar aquí es que eres el MVP de tu delegación.',
                    ],
                    [
                        'title' => 'AGENTES EN FORMACIÓN',
                        'description' => 'Dicen que el conocimiento no ocupa lugar y todo lo que encontrarás aquí, ¡tampoco!',
                    ],
                ]
            ],
            [
                'title' => 'Accesos',
                'sections' => [['title' => 'Única']],
            ]
        ];

        for ($i = 0; $i < count($pages); $i++) {
            $pageId = DB::table('pages')->insertGetId(['title' => $pages[$i]['title']]);
            for ($j = 0; $j < count($pages[$i]['sections']); $j++) {
                $pages[$i]['sections'][$j]['page_id'] = $pageId;
            }
            Section::insert($pages[$i]['sections']);
        }
    }
}
