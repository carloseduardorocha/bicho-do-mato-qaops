# Testes — riscos, casos e lacunas

Entrega E2. Atende à etapa 4 da seção 5 do [enunciado](enunciado.pdf): casos positivos e negativos, testes unitários e de integração, com justificativa do que ficou de fora. Os riscos estão no [PLANO.md](PLANO.md).

## Estratégia

- **Unitário** (`tests/Unit/Services`): exercita um Service diretamente, sem rota, middleware ou controller. Os Services usam o Eloquent sem camada de repositório, por isso rodam com SQLite em memória em vez de dublês. Simular o Eloquent verificaria o dublê, e não o filtro da consulta.
- **Feature** (`tests/Feature`): integração por HTTP, passando por rota, middleware, validação, controller, Service, banco e view.
- **Arquivos:** todo disco é `Storage::fake('public')`. Os uploads são arquivos reais (`tests/Support/CreatesUploads.php`), porque o `UploadedFile::fake()` deduz o tipo pela extensão e deixaria passar um script renomeado para `.jpg`. Isso também dispensa a extensão GD.
- **Dados:** factories de `News`, `Partner`, `Testimonial` e `User`. O depoimento nasce pendente, como no site.

## Risco → teste → tipo

(+) caso positivo, (−) caso negativo, `skip` teste que expõe um bug aberto (ver [Bugs encontrados](#bugs-encontrados)).

### R1. Depoimento não aprovado aparece no site

| Comportamento verificado | Teste | Tipo |
|---|---|---|
| A lista pública traz só os aprovados, sem excluídos, com paginação (+/−) | `TestimonialServiceTest`: `test_paginated_list_*` (3 testes) | Unitário |
| A fila de moderação traz só os pendentes; a listagem geral traz todos (+/−) | `TestimonialServiceTest`: `test_pending_list_*`, `test_get_all_*` | Unitário |
| Busca por id: existente (+) e inexistente (−) | `TestimonialServiceTest`: `test_get_by_id_*` | Unitário |
| Criar sempre resulta em pendente, mesmo pedindo aprovação (−) | `TestimonialServiceTest`: `test_create_always_starts_as_pending_*` | Unitário |
| Aprovar publica só o escolhido (+); inexistente ou rejeitado falha (−) | `TestimonialServiceTest`: `test_approve_*`, `test_a_rejected_testimonial_*` | Unitário |
| Rejeitar despublica, exclui e apaga a imagem (+); inexistente falha (−) | `TestimonialServiceTest`: `test_reject_*` | Unitário |
| Editar o texto não muda a aprovação (+/−) | `TestimonialServiceTest`: `test_editing_the_text_*` | Unitário |
| `/depoimentos` e a home mostram aprovados (+) e escondem pendentes e excluídos (−) | `TestimonialVisibilityTest` | Feature |
| Envio → fila → aprovação → site, de ponta a ponta (+) | `TestimonialModerationTest`: `test_testimonial_sent_by_the_public_appears_only_after_approval` | Feature |
| Rejeitado, excluído, criado ou editado no admin não vira público (−) | `TestimonialModerationTest` | Feature |
| A rota `/admin/testimonials/pending` abre (+) | `TestimonialModerationTest`: `test_pending_route_*` | Feature, `skip` BUG-5 |

### R2. Visitante sem login acessa o `/admin` ou cria conta

| Comportamento verificado | Teste | Tipo |
|---|---|---|
| Cada rota de cada grupo (dashboard, parceiros, depoimentos, notícias, usuários) redireciona o visitante para a home (−) | `AccessControlTest`: `test_guest_is_redirected_*` | Feature |
| Nenhum grupo novo do admin fica fora da verificação acima | `AccessControlTest`: `test_every_admin_route_*` | Feature |
| Visitante não aprova, rejeita, cria, edita nem exclui, conferido no banco (−) | `AccessControlTest`: `test_guest_can_not_*` | Feature |
| `GET` e `POST /register` respondem 404 e nenhuma conta é criada (−) | `AccessControlTest`: `test_public_sign_up_*` | Feature |
| Usuário logado abre cada grupo e cria uma conta que consegue entrar (+) | `AccessControlTest`: `test_logged_in_user_*` | Feature |
| Login, senha errada e logout (+/−, já vinham da E0) | `AuthenticationTest`, `DashboardTest` | Feature |

R2 não tem teste unitário: a regra está na ligação entre rota e middleware e só existe no fluxo HTTP.

### R3. Envio público inválido é aceito

| Comportamento verificado | Teste | Tipo |
|---|---|---|
| Envio válido é salvo como pendente, com a imagem (+) | `TestimonialSubmissionTest`: `test_valid_submission_*` | Feature |
| O visitante não aprova o próprio depoimento com um campo extra (−) | `TestimonialSubmissionTest`: `test_visitor_can_not_approve_*` | Feature |
| Nome, texto ou foto ausente, em branco, longo demais ou de outro tipo (−, 9 casos) | `TestimonialSubmissionTest`: `test_submission_with_invalid_field_is_refused` | Feature |
| PDF, script com extensão `.jpg` e SVG são recusados (−) | `TestimonialSubmissionTest`: `test_file_that_is_not_an_image_*`, `test_script_disguised_*`, `test_svg_*` | Feature |
| Limites: 100 e 500 caracteres e 2 MB exatos passam (+); um a mais não passa (−) | `TestimonialSubmissionTest`: `test_name_and_text_at_the_maximum_*`, `test_image_*` | Feature |
| Falha ao salvar avisa o visitante e não deixa imagem órfã (−) | `TestimonialSubmissionTest`: `test_failure_while_saving_*` | Feature |
| O Service apaga a imagem nova se o salvamento falha (−) e a antiga quando ela é trocada ou o depoimento é excluído (+) | `TestimonialServiceTest`: `test_create_removes_*`, `test_update_*`, `test_delete_*`, `test_cleanup_*` | Unitário |

Toda recusa confere três coisas: erro no campo certo, nenhum registro no banco e nenhum arquivo no disco. A validação fica no controller, por isso os casos inválidos são de feature.

### R4. CRUD de notícias quebra ou deixa imagem órfã

| Comportamento verificado | Teste | Tipo |
|---|---|---|
| Listar, paginar e buscar, sem excluídas (+/−) | `NewsServiceTest`: `test_get_*`, `test_paginated_list_*` | Unitário |
| Criar (+); falha ao criar apaga as imagens (−) | `NewsServiceTest`: `test_create_*` | Unitário |
| Atualizar só os campos enviados (+); notícia inexistente apaga as imagens novas (−) | `NewsServiceTest`: `test_update_*` | Unitário |
| Falha ao atualizar preserva as imagens antigas (−) | `NewsServiceTest`: `test_failed_update_*` | Unitário, `skip` BUG-1 |
| Excluir apaga as imagens dessa notícia e de nenhuma outra (+/−) | `NewsServiceTest`: `test_delete_*`, `test_cleanup_*` | Unitário |
| Remover uma imagem mantém as outras (+); notícia inexistente não apaga nada (−) | `NewsServiceTest`: `test_deleting_one_image_*`, `test_deleting_the_last_image_*`, `test_deleting_an_image_of_missing_news_*` | Unitário |
| Remover imagem não apaga arquivo de outro registro (−) | `NewsServiceTest`: `test_deleting_an_image_never_touches_*` | Unitário, `skip` BUG-2 |
| CRUD completo pelo admin, com imagens no disco iguais às do banco (+) | `NewsCrudTest` | Feature |
| Dados ou arquivo inválido e falha ao salvar não deixam registro nem imagem (−) | `NewsCrudTest`: `test_invalid_*`, `test_one_invalid_file_*`, `test_failure_while_creating_*` | Feature |
| Atualizar notícia inexistente com imagem não deixa órfã (−) | `NewsCrudTest`: `test_updating_missing_news_*` | Feature, `skip` BUG-3 |
| Erro de validação chega ao formulário e, no JSON, responde 422 (−) | `NewsCrudTest`: `test_validation_messages_*`, `test_removing_an_image_without_a_path_is_a_validation_error` | Feature, `skip` BUG-4 |
| Notícia publicada abre no site (+); excluída some (−) | `NewsCrudTest`: `test_published_news_*`, `test_deleted_news_*` | Feature |

## Resultado

`php artisan test`, PHP 8.4, SQLite em memória, 22/11/2026: **122 testes, 116 aprovados, 6 pulados, 0 falhas**, 367 asserções, cerca de 5 s.

**Os testes detectam defeitos?** Cada alteração abaixo foi feita, uma por vez, em uma cópia descartável do projeto:

| Defeito introduzido | Testes que reprovam |
|---|---|
| Remover o filtro `is_approved` da lista pública (o mesmo da E4) | 6 |
| Criar depoimento já aprovado | 5 |
| Tirar o `auth.custom` do admin | 11 |
| Aceitar qualquer tipo de arquivo na foto | 4 |
| Tirar o limite de 2 MB | 1 |
| Tornar o nome opcional | 2 |
| Não apagar as imagens ao excluir a notícia | 2 |
| Não apagar as imagens quando falha criar ou atualizar a notícia | 3 |
| Descartar as imagens antigas ao enviar novas | 1 |

## Bugs encontrados

O código de produção não foi alterado na E2. Os testes descrevem o comportamento correto e, sem o `skip`, reprovam. Corrigido o bug, basta remover a linha `markTestSkipped`.

| Bug | Onde | Efeito |
|---|---|---|
| BUG-1 | `NewsService::update()` | Se salvar falha depois de um envio de imagens, apaga também as antigas, que o registro continua citando. Perda de dados. |
| BUG-2 | `NewsService::deleteImageFromNews()` | Apaga qualquer arquivo do disco público, mesmo de outra notícia, parceiro ou depoimento (exige login). |
| BUG-3 | `NewsController::update()` | Grava as imagens antes de conferir se a notícia existe. Se ela não existe, elas ficam órfãs. |
| BUG-4 | Controllers do admin | O `catch (\Throwable)` engole a `ValidationException`: o formulário só mostra um erro genérico, e o `delete-image` responde 500 em vez de 422. |
| BUG-5 | `routes/web.php` | `admin.testimonials.pending` aponta para um método inexistente e responde 500. |

Dois problemas foram vistos na leitura do código e **não** têm teste:

- **Texto de 256 a 500 caracteres.** A validação aceita até 500, mas a coluna `testimonials.description` tem 255. O SQLite não impõe esse tamanho. No MySQL em modo estrito, o envio falha.
- **Senha no log.** Quando criar ou editar usuário falha, `UserController` registra `$request->all()` e `UserService` registra `$data`, ambos com a senha em texto puro. O Gitleaks não detecta isso.

## O que ficou de fora e por quê

| Fora | Motivo |
|---|---|
| CRUD de parceiros e de usuários (`PartnerService`, `UserService`) | Fora de R1 a R4. Só entram no controle de acesso do R2. Como o G4 mede `app/Services` inteiro, isso reduz a cobertura e deve pesar na escolha do limite na E3. |
| Regras próprias do MySQL (tamanho de coluna, modo estrito) | A suíte usa SQLite em memória, para rodar rápido e sem serviço externo. |
| Login além do básico (limite de tentativas, "lembrar de mim") e CSRF | Código do framework. O Laravel desliga a verificação de CSRF durante os testes. |
| Upload real pela web (limites do PHP e do Nginx) e link `public/storage` | Dependem do ambiente de implantação. |
| Comandos `*:cleanup-images` | Só repassam para os Services; a limpeza de notícias e de depoimentos é testada neles. |
| Aparência, JavaScript das telas e navegador real (E2E) | Custo alto para os riscos escolhidos: a decisão de mostrar ou não o depoimento é do servidor. |
| Carga e desempenho | Nenhum risco do plano depende disso. |
