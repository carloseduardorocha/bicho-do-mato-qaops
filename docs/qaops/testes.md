# Testes — riscos, casos e lacunas

Entrega E2. Atende à etapa 4 da seção 5 do [enunciado](enunciado.pdf): casos positivos e negativos, testes unitários e de integração, com justificativa do que ficou de fora. Os riscos estão no [PLANO.md](PLANO.md).

## Estratégia

- **Unitário** (`tests/Unit/Services`): exercita um Service diretamente, sem rota, middleware ou controller. Os Services usam o Eloquent sem camada de repositório, por isso rodam com SQLite em memória em vez de dublês. Simular o Eloquent verificaria o dublê, e não o filtro da consulta.
- **Feature** (`tests/Feature`): integração por HTTP, passando por rota, middleware, validação, controller, Service, banco e view.
- **Arquivos:** todo disco é `Storage::fake('public')`. Os uploads são arquivos reais (`tests/Support/CreatesUploads.php`), porque o `UploadedFile::fake()` deduz o tipo pela extensão e deixaria passar um script renomeado para `.jpg`. Isso também dispensa a extensão GD.
- **Dados:** factories de `News`, `Partner`, `Testimonial` e `User`. O depoimento nasce pendente, como no site.

## Risco → teste → tipo

(+) caso positivo, (−) caso negativo.

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
| A rota `/admin/testimonials/pending` abre (+) | `TestimonialModerationTest`: `test_pending_route_*` | Feature |

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
| Falha ao atualizar preserva as imagens antigas (−) | `NewsServiceTest`: `test_failed_update_*` | Unitário |
| Excluir apaga as imagens dessa notícia e de nenhuma outra (+/−) | `NewsServiceTest`: `test_delete_*`, `test_cleanup_*` | Unitário |
| Remover uma imagem mantém as outras (+); notícia inexistente não apaga nada (−) | `NewsServiceTest`: `test_deleting_one_image_*`, `test_deleting_the_last_image_*`, `test_deleting_an_image_of_missing_news_*` | Unitário |
| Remover imagem não apaga arquivo de outro registro (−) | `NewsServiceTest`: `test_deleting_an_image_never_touches_*` | Unitário |
| CRUD completo pelo admin, com imagens no disco iguais às do banco (+) | `NewsCrudTest` | Feature |
| Dados ou arquivo inválido e falha ao salvar não deixam registro nem imagem (−) | `NewsCrudTest`: `test_invalid_*`, `test_one_invalid_file_*`, `test_failure_while_creating_*` | Feature |
| Atualizar notícia inexistente com imagem não deixa órfã (−) | `NewsCrudTest`: `test_updating_missing_news_*` | Feature |
| Erro de validação chega ao formulário e, no JSON, responde 422 (−) | `NewsCrudTest`: `test_validation_messages_*`, `test_removing_an_image_without_a_path_is_a_validation_error` | Feature |
| Notícia publicada abre no site (+); excluída some (−) | `NewsCrudTest`: `test_published_news_*`, `test_deleted_news_*` | Feature |

### Parceiros e usuários (fora de R1 a R4, cobertos na E5)

Entraram para o G4 bloquear também esses dois Services, antes só com alerta.

| Comportamento verificado | Teste | Tipo |
|---|---|---|
| Listar, paginar e buscar parceiros, sem excluídos (+/−) | `PartnerServiceTest`: `test_get_*`, `test_paginated_list_*` | Unitário |
| Criar com logo (+); falha ao criar apaga o logo enviado (−) | `PartnerServiceTest`: `test_create_*` | Unitário |
| Atualizar só os campos enviados; logo novo apaga o antigo, o mesmo logo fica (+) | `PartnerServiceTest`: `test_update_*` | Unitário |
| Parceiro inexistente ou falha ao salvar: some o logo novo, fica o antigo (−) | `PartnerServiceTest`: `test_update_of_a_missing_*`, `test_failed_update_*` | Unitário |
| Excluir (+/−) e limpar só os logos de parceiros excluídos (+) | `PartnerServiceTest`: `test_delete_*`, `test_cleanup_*` | Unitário |
| Senha sempre com hash; listar sem expor a senha (+) | `UserServiceTest`: `test_create_stores_*`, `test_get_all_*` | Unitário |
| Editar sem senha, ou com senha vazia, mantém a antiga (−); com senha nova, troca (+) | `UserServiceTest`: `test_update_*` | Unitário |
| E-mail repetido é recusado (−); a checagem ignora o próprio usuário em edição (+) | `UserServiceTest`: `test_create_with_a_repeated_email_fails`, `test_email_exists_*` | Unitário |

Defeitos introduzidos à mão para conferir: senha vazia apagando a antiga (1 teste reprova), logo antigo mantido após a troca (1) e logo antigo apagado antes de salvar (3). Gravar a senha sem `Hash::make` não reprova nada, e está certo: o model `User` já faz o hash (cast `hashed`), então o comportamento não muda.

## Resultado

`php artisan test`, PHP 8.4, SQLite em memória, 23/11/2026: **160 testes, 160 aprovados, 0 pulados, 0 falhas**, 467 asserções, cerca de 5 s (133 até a E4, mais 27 de parceiros e usuários na E5).

**Os testes detectam defeitos?** Cada alteração abaixo foi feita, uma por vez, em uma cópia descartável do projeto, sobre a suíte da E2 (122 testes, 6 então pulados):

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

A E2 não alterou o código de produção: os testes que pegaram bugs entraram pulados. As correções vieram depois, na branch `fix/e2-bugs`, e nenhum teste está mais pulado. Contra o código anterior às correções, 17 dos 133 testes reprovam.

| Bug | Efeito | Correção | Teste |
|---|---|---|---|
| BUG-1 | Falha ao atualizar notícia apagava também as imagens antigas | `NewsService::update()` apaga só as imagens novas | `NewsServiceTest`: `test_failed_update_*` |
| BUG-2 | Remover imagem apagava qualquer arquivo do disco público | `deleteImageFromNews()` só apaga imagem da própria notícia; a rota responde 404 | `NewsServiceTest`: `test_deleting_an_image_never_touches_*`; `NewsCrudTest`: `test_removing_an_image_of_another_record_*` |
| BUG-3 | Atualizar notícia inexistente deixava imagem órfã | `NewsController::update()` confere a notícia antes de gravar | `NewsCrudTest`: `test_updating_missing_news_*` |
| BUG-4 | Erro de validação do admin virava erro genérico, ou 500 no JSON | Os 4 controllers repassam a `ValidationException`; o JSON responde 422 | `FormValidationTest`; `NewsCrudTest`: `test_validation_messages_*`, `test_removing_an_image_without_a_path_is_a_validation_error` |
| BUG-5 | `/admin/testimonials/pending` respondia 500 | A rota abre a tela de moderação | `TestimonialModerationTest`: `test_pending_route_*` |
| BUG-6 | Falha ao salvar usuário gravava a senha em texto puro no log | Senha retirada dos dados registrados | `UserPasswordLogTest` |
| BUG-7 | Depoimento de 256 a 500 caracteres falhava no MySQL (coluna de 255) | Migration aumenta a coluna para 500 | Sem teste automatizado: o SQLite não impõe o tamanho. Verificado à mão no MySQL 8.0, antes (erro) e depois (aceito) |

## O que ficou de fora e por quê

| Fora | Motivo |
|---|---|
| CRUD de parceiros e de usuários pelo admin (controllers e telas) | Fora de R1 a R4. Os Services foram cobertos na E5 (seção acima) e as rotas entram no controle de acesso do R2, mas não há teste de feature do formulário de parceiros e usuários. |
| Regras próprias do MySQL (tamanho de coluna, modo estrito) | A suíte usa SQLite em memória, para rodar rápido e sem serviço externo. |
| Login além do básico (limite de tentativas, "lembrar de mim") e CSRF | Código do framework. O Laravel desliga a verificação de CSRF durante os testes. |
| Upload real pela web (limites do PHP e do Nginx) e link `public/storage` | Dependem do ambiente de implantação. |
| Comandos `*:cleanup-images` | Só repassam para os Services; a limpeza de notícias e de depoimentos é testada neles. |
| Aparência, JavaScript das telas e navegador real (E2E) | Custo alto para os riscos escolhidos: a decisão de mostrar ou não o depoimento é do servidor. |
| Carga e desempenho | Nenhum risco do plano depende disso. |
