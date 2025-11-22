<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Copiar imagens padrão para storage
        $this->copyDefaultImages();

        $user = User::first();

        $newsData = [
            [
                News::TITLE       => 'ONG Bicho do Mato estreia seu Site',
                News::DESCRIPTION => 'A ONG Bicho do Mato acaba de estrear seu site oficial, marcando um importante passo na comunicação com a comunidade e parceiros. A plataforma digital apresenta informações sobre os projetos desenvolvidos pela organização, formas de colaboração e histórias de animais resgatados. Com o novo canal, a ONG busca ampliar sua rede de apoiadores e facilitar o acesso a informações sobre adoção responsável, trabalho voluntário e doações. O site também traz um espaço dedicado aos depoimentos de pessoas que já contribuíram com a causa e acompanharam de perto o trabalho da equipe na proteção e cuidado com os animais.',
                News::AUTHOR_ID   => $user->id,
                News::IMAGES      => json_encode([
                    'news/noticias_1.jpg',
                    'news/noticias_2.jpg',
                    'news/noticias_3.jpg',
                ]),
            ],
            [
                News::TITLE       => 'Adoção de gatos registra aumento e traz esperança',
                News::DESCRIPTION => 'Nos últimos meses, ONGs e abrigos de proteção animal em diversas regiões do país têm comemorado uma boa notícia: o aumento nas adoções de gatos. Dados informais coletados por instituições como a ONG Bicho do Mato e outras organizações apontam um crescimento significativo na procura por felinos, especialmente após campanhas de conscientização intensificadas nas redes sociais. Especialistas em comportamento animal e protetores independentes apontam que esse avanço se deve à combinação de fatores como maior visibilidade nas redes sociais, percepção de que são animais independentes e adaptáveis a ambientes menores, e conscientização sobre a importância da adoção responsável.',
                News::AUTHOR_ID   => $user->id,
                News::IMAGES      => json_encode([
                    'news/noticias_4.jpg',
                    'news/noticias_5.jpg',
                ]),
            ],
            [
                News::TITLE       => 'Campanha de Vacinação para Animais de Rua',
                News::DESCRIPTION => 'A ONG Bicho do Mato, em parceria com veterinários voluntários, está promovendo uma grande campanha de vacinação gratuita para animais de rua. A iniciativa visa proteger cães e gatos abandonados contra doenças como raiva, cinomose e parvovirose. Durante três sábados consecutivos, equipes estarão em diferentes pontos da cidade oferecendo vacinas, vermífugos e orientações sobre cuidados básicos. A campanha também busca conscientizar a população sobre a importância da castração e da adoção responsável. Todos os animais vacinados receberão uma identificação e serão cadastrados no sistema da ONG para acompanhamento futuro.',
                News::AUTHOR_ID   => $user->id,
                News::IMAGES      => json_encode([
                    'news/noticias_6.jpg',
                    'news/noticias_7.jpg',
                    'news/noticias_1.jpg',
                ]),
            ],
        ];

        foreach ($newsData as $news) {
            News::create($news);
        }

        $this->command->info('✓ 3 Notícias criadas com sucesso!');
    }

    /**
     * Copia as imagens padrão para o storage
     */
    private function copyDefaultImages(): void
    {
        $sourceDir = public_path('images/default/noticias');
        $destDir = storage_path('app/public/news');

        // Criar diretório se não existir
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        // Copiar todas as imagens
        for ($i = 1; $i <= 7; $i++) {
            $sourceFile = $sourceDir . "/noticias_{$i}.jpg";
            $destFile = $destDir . "/noticias_{$i}.jpg";

            if (File::exists($sourceFile)) {
                File::copy($sourceFile, $destFile);
            }
        }

        $this->command->info('  → Imagens de notícias copiadas para storage');
    }
}