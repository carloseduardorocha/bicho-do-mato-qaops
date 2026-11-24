# Quality gates — ficha de cada gate

Entrega E3. Atende à seção 6 do [enunciado](enunciado.pdf): cada gate tem critério mensurável, relação com um risco, evidência e consequência, nos campos da "Ficha obrigatória de cada gate". Os riscos (R1 a R7) estão no [PLANO.md](PLANO.md) e os testes em [testes.md](testes.md).

## Como os gates rodam

- **Quando:** a cada push e pull request na `main` (`.github/workflows/ci.yml`).
- **Como:** cada gate é um job, para o check do PR mostrar qual gate falhou. G1, G2, G3, G5 e G6 rodam em paralelo. O G4 roda depois do G3, porque usa a cobertura medida na mesma execução dos testes. O job **Quality gates** junta tudo numa tabela aprovado/reprovado, no resumo do run (aba *Summary*).
- **Bloqueio:** a branch protection da `main` exige PR, 1 aprovação do outro integrante e todos os checks (G1 a G6 e Quality gates) verdes. Gate reprovado = merge bloqueado.
- **Mudar um limite** (cobertura, nível do Larastan, severidade do audit) é mudança de código e passa pelo mesmo PR com revisão. Ninguém afrouxa um gate sozinho.

## G1. Build

| Campo | Registro |
|---|---|
| Nome e critério | **Build.** `composer install` termina sem erro e o Laravel sobe, carregando todas as rotas (`php artisan route:list` com código de saída 0). |
| Justificativa | R5: código que não instala ou não sobe. Sem build de front (Blade + Bootstrap por CDN), subir o framework e carregar as rotas é o "empacotar e executar" deste sistema: pega dependência quebrada, erro de sintaxe e controller ou middleware inexistente numa rota. |
| Momento | Etapa "dependências e build", job `G1 Build`, em push e PR na `main`. |
| Evidência | Log do `composer install` e do `route:list` (artifact `g1-build-logs`), número de rotas carregadas no resumo do run e anotação de erro no PR. |
| Consequência | Bloqueia o merge. |
| Limitação/exceção | Não abre páginas nem conecta no MySQL de produção: um erro que só aparece ao renderizar uma view ou com o banco real passa pelo G1 (as views são cobertas, em parte, pelos testes de feature do G3). Sem exceção: build quebrado não tem como ir para a `main`. |

## G2. Análise estática

| Campo | Registro |
|---|---|
| Nome e critério | **Análise estática.** Pint `--test` sem diferença de estilo **e** Larastan nível 5 sem nenhum erro (a baseline, `phpstan-baseline.neon`, está vazia). |
| Justificativa | R6: bug de tipo ou código fora do padrão. O nível 5 pega defeito real (classe ou método inexistente, tipo de argumento errado, código morto) sem exigir anotação de tipo. Medido em `app/` (PR #4): níveis 0 a 5 dão 3 a 4 erros, e do nível 6 em diante saltam para 86, dos quais 82 são só falta de anotação, não defeito. O Pint mantém um estilo único entre os dois integrantes, para o diff do PR mostrar só a mudança real. |
| Momento | Etapa "análise estática", job `G2 Static analysis`, em push e PR na `main`. |
| Evidência | Logs do Pint e do Larastan (artifact `g2-static-analysis-logs`), tabela no resumo do run e anotação do Larastan no arquivo e na linha do erro. |
| Consequência | Bloqueia o merge. |
| Limitação/exceção | Não verifica comportamento, só a forma do código. Quando o gate entrou (PR #4), o Larastan achou 4 erros reais, guardados na baseline: 3 classes inexistentes em `app/Http/Kernel.php`, arquivo que o Laravel 12 nem carrega, e código inalcançável em `Authenticate.php`, depois de um `dd('aq')` de depuração esquecido. Os dois arquivos estavam mortos e foram apagados na E5, e a baseline ficou vazia. Ela continua existindo só para uma exceção revisada no PR (ex.: falso positivo do Larastan), nunca para esconder um defeito. |

## G3. Testes

| Campo | Registro |
|---|---|
| Nome e critério | **Testes.** 100% dos testes PHPUnit passando (unitários e de feature), com pelo menos 1 teste executado. Hoje são 133. |
| Justificativa | R1 a R4: regressão em comportamento crítico (depoimento não aprovado no site, visitante no admin, envio inválido aceito, imagem órfã). Qualquer teste falhando significa um desses riscos voltando. Por isso não há tolerância: um teste instável deve ser corrigido, não ignorado. |
| Momento | Etapa "testes automatizados", job `G3 Tests`, em push e PR na `main`. SQLite em memória, sem serviço externo. |
| Evidência | Relatório JUnit (artifact `g3-tests-junit`), tabela com aprovados, falhas e tempo no resumo do run, e cada teste que falhou anotado no arquivo e na linha. |
| Consequência | Bloqueia o merge. |
| Limitação/exceção | Só pega o que os testes verificam. Ficam de fora o CRUD de parceiros e de usuários e as regras próprias do MySQL ([testes.md](testes.md), "O que ficou de fora"). Teste com `markTestSkipped` não reprova, mas aparece como "Skipped" no resumo e precisa de justificativa no PR. |

## G4. Cobertura

| Campo | Registro |
|---|---|
| Nome e critério | **Cobertura de linhas em `app/Services`**, medida com PCOV na mesma execução do G3. Bloqueia se `TestimonialService` < **90%**, `NewsService` < **80%**, `PartnerService` < **80%**, `UserService` < **100%** ou o total de `app/Services` < **85%**. Um Service novo, ainda sem limite próprio, só gera alerta e entra no total. |
| Justificativa | R1, R3 e R4: área crítica sem verificação. A regra de negócio fica em `app/Services` e os riscos escolhidos estão em dois arquivos: `TestimonialService` (R1, R3, a funcionalidade central) e `NewsService` (R4). Por isso o limite é por arquivo, e não só um total: com um número único, alguém poderia tirar teste de depoimentos e compensar testando parceiros. Os limites saem da medição da E3 (tabela abaixo), arredondada para baixo em múltiplos de 5. Eles travam o nível que os testes da E2 alcançaram: código novo nesses Services sem teste reprova. Não pedimos 100% porque o que falta nos dois arquivos são caminhos de exceção do disco de imagens: o `catch` ao apagar uma imagem ou várias (grava um aviso e retorna), o `catch` da limpeza de imagens dos registros excluídos (grava o erro e repassa a exceção) e, no `NewsService`, o `return false` quando a imagem a apagar já não existe. Testá-los exige simular uma falha do disco ou um arquivo sumido, o que protege pouco R1, R3 e R4. `PartnerService` e `UserService` estão fora de R1 a R4 e até a E4 só geravam alerta (9,6% e 60%). Na E5 ganharam testes unitários e passaram a bloquear pela mesma regra de arredondamento: o `UserService` ficou em 100% porque não tem caminho de falha de disco, e o `PartnerService` fica sem os mesmos `catch` de disco dos outros. O piso de 85% no total segura o conjunto, inclusive um Service novo que ainda não tenha limite próprio. |
| Momento | Etapa "quality gates". O job `G4 Coverage` roda depois do `G3 Tests` (mesmo se algum teste falhar), em push e PR na `main`. |
| Evidência | Relatório de cobertura em HTML e Clover (artifact `g4-coverage-report`, abrir `coverage-html/index.html`), tabela por arquivo no resumo do run, anotação de erro no arquivo abaixo do limite e alerta para um Service novo abaixo do piso. |
| Consequência | Bloqueia o merge (os quatro Services e o total). Só alerta para um Service novo sem limite próprio. |
| Limitação/exceção | Cobertura mostra que a linha rodou, não que o teste conferiu o resultado: um teste sem asserção certa também "cobre". Quem garante o comportamento é o G3, e o G4 só aponta código que nenhum teste executa. A margem do `TestimonialService` é pequena (90,2% para 90%): uma linha nova sem teste já reprova, de propósito. O `UserService` em 100% faz o mesmo com qualquer linha nova. Linhas em `app/Http` (controllers) não entram na medida: são cobertas pelos testes de feature, mas a regra de negócio está nos Services. |

Medição que fundamenta os limites (PCOV, linhas). A E3 mediu com 133 testes e a E5 com 160, depois dos testes de parceiros e usuários:

| Arquivo | Risco | E3 | E5 | Limite |
|---|---|---|---|---|
| `TestimonialService` | R1, R3 | 101/112 (90,2%) | 101/112 (90,2%) | ≥ 90% (bloqueia) |
| `NewsService` | R4 | 93/110 (84,5%) | 93/110 (84,5%) | ≥ 80% (bloqueia) |
| `PartnerService` | — | 7/73 (9,6%), alerta | 62/73 (84,9%) | ≥ 80% (bloqueia desde a E5) |
| `UserService` | — | 30/50 (60,0%), alerta | 50/50 (100%) | 100% (bloqueia desde a E5) |
| **Total `app/Services`** | | 231/345 (67,0%), limite 65% | 306/345 (**88,7%**) | ≥ 85% (bloqueia) |

## G5. Dependências

| Campo | Registro |
|---|---|
| Nome e critério | **Dependências.** `composer audit` sobre o `composer.lock` sem nenhuma vulnerabilidade de severidade **crítica**. |
| Justificativa | R7: componente vulnerável. O `composer.lock` define exatamente o que vai para produção. Crítica bloqueia porque, num site público com área de login, costuma permitir exploração remota (o run 1 do PR #4 reprovou por uma crítica no `laravel/framework`, corrigida na mesma major). |
| Momento | Etapa "dependências e build", job `G5 Dependencies`, em push e PR na `main`. |
| Evidência | Relatório do audit em texto e JSON (artifact `g5-dependencies-audit`), contagem por severidade no resumo do run e anotação de cada crítica e alta. |
| Consequência | Bloqueia o merge com crítica, e o pacote é atualizado na mesma major (revisar e rodar os testes). Alta gera só alerta. |
| Limitação/exceção | Só conhece vulnerabilidades já publicadas no banco de avisos do Packagist/GitHub: falha nova ou sem CVE passa. Alta não bloqueia, para não travar a entrega por um aviso sem correção disponível, mas fica visível em todo run e deve ser resolvida no PR seguinte. Pacote abandonado é ignorado (`--abandoned=ignore`). A biblioteca do Bootstrap por CDN não passa pelo Composer e não é verificada. |

## G6. Segredos

| Campo | Registro |
|---|---|
| Nome e critério | **Segredos.** Gitleaks (v8.30.1, regras padrão) sem nenhum achado em **todo o histórico** do Git, não só no último commit. |
| Justificativa | R7: segredo versionado. Uma senha ou chave que entra num commit continua no histórico mesmo depois de apagada do arquivo, e o repositório é público. Isso já aconteceu neste repo: a senha do admin da ONG estava no `UserSeeder` do original e foi trocada por `change-me-in-env` em todos os commits antes de publicar. Na E5, o seeder deixou de ter qualquer senha: o primeiro admin vem do `.env` (`SEED_ADMIN_EMAIL`, `SEED_ADMIN_PASSWORD`) ou recebe uma senha aleatória. O gate impede que algo assim volte. |
| Momento | Etapa "quality gates", job `G6 Secrets`, em push e PR na `main`, com `fetch-depth: 0` (histórico completo). |
| Evidência | Relatório JSON do Gitleaks com os valores mascarados (artifact `g6-secrets-report`), número de commits varridos e tabela de achados (regra, arquivo, linha, commit) no resumo do run, e anotação no arquivo e na linha. |
| Consequência | Bloqueia o merge. O segredo deve ser revogado, porque já vazou, e removido do histórico. |
| Limitação/exceção | Detecta por padrões e entropia: senha fraca ou em formato próprio (ex.: `admin123` numa string comum) pode passar, e texto aleatório pode dar falso positivo. Foi o caso do `admin123` que o seeder trazia até a E5: o Gitleaks não acusou, a revisão manual achou, e ele continua nos commits antigos (só serve para um banco local recriado pelo seed). Falso positivo é tratado com o *fingerprint* do achado num `.gitleaksignore`, adicionado em PR com revisão do outro integrante, nunca desligando o job. Não verifica segredos fora do Git (Secrets do Actions, `.env` local). |
