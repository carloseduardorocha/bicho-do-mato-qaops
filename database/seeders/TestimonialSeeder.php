<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Copiar imagem padrão para storage
        $this->copyDefaultImage();

        $testimonials = [
            [
                Testimonial::NAME => 'Ana Paula Silva',
                Testimonial::DESCRIPTION => 'Adotei minha gatinha através da ONG e foi a melhor decisão da minha vida! A equipe é super atenciosa e acompanhou todo o processo. Minha Mel está super feliz e saudável. Recomendo muito o trabalho desta ONG!',
                Testimonial::IMAGE => 'testimonials/foto_de_perfil.png',
                Testimonial::IS_APPROVED => true,
            ],
            [
                Testimonial::NAME => 'Carlos Eduardo Santos',
                Testimonial::DESCRIPTION => 'Trabalho maravilhoso! Resgataram meu cachorro que estava perdido e cuidaram dele até eu encontrá-lo. A dedicação e o amor pelos animais são inspiradores. Gratidão eterna!',
                Testimonial::IMAGE => 'testimonials/foto_de_perfil.png',
                Testimonial::IS_APPROVED => true,
            ],
            [
                Testimonial::NAME => 'Mariana Costa',
                Testimonial::DESCRIPTION => 'Sou voluntária da ONG há 2 anos e posso afirmar que é um trabalho sério e comprometido com o bem-estar animal. Já ajudamos centenas de animais a encontrarem um lar. Vale muito a pena fazer parte dessa família!',
                Testimonial::IMAGE => 'testimonials/foto_de_perfil.png',
                Testimonial::IS_APPROVED => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        $this->command->info('✓ 3 Depoimentos criados com sucesso!');
    }

    /**
     * Copia a imagem padrão para o storage
     */
    private function copyDefaultImage(): void
    {
        $sourcePath = public_path('images/default/depoimentos/foto_de_perfil.png');
        $destPath = storage_path('app/public/testimonials/foto_de_perfil.png');

        // Criar diretório se não existir
        if (! File::exists(storage_path('app/public/testimonials'))) {
            File::makeDirectory(storage_path('app/public/testimonials'), 0755, true);
        }

        // Copiar arquivo se existir
        if (File::exists($sourcePath)) {
            File::copy($sourcePath, $destPath);
            $this->command->info('  → Imagem de depoimento copiada para storage');
        } else {
            $this->command->warn('  ⚠ Imagem padrão não encontrada em: '.$sourcePath);
        }
    }
}
