# Plano — Trabalho prático DevOps e QAOps

Trabalho final de Qualidade de Software (UFSM, Sistemas de Informação), em dupla: **Carlos** e **Renato**. Este arquivo é a fonte única do plano, das convenções e do andamento. Toda sessão (pessoa ou Claude) lê este arquivo antes de começar e marca o andamento aqui, no mesmo PR da entrega.

O enunciado do professor está em [`enunciado.pdf`](enunciado.pdf). Em dúvida sobre o que o trabalho pede, a resposta sai dele (cite a seção).

## Objetivo

Um pipeline no GitHub Actions que, a cada push e pull request, instala, faz o build, roda a análise estática, os testes e os quality gates, publica as evidências e **bloqueia o merge na `main`** quando um gate falha. A complexidade do sistema não é avaliada, e sim a qualidade integrada ao fluxo de entrega.

Entregáveis: repositório, pipeline, testes, pelo menos 3 quality gates justificados, experimento (aprovado → reprovado → corrigido), relatório de 6 a 10 páginas e defesa de 10 a 12 minutos.

## Sistema

Site da ONG Bicho do Mato: páginas públicas (home, notícias, parceiros, depoimentos) e admin com login (CRUD de notícias, parceiros, usuários e depoimentos, e moderação de depoimentos). Usa Laravel 12, Inertia + Vue, PHP 8.4, e a regra de negócio fica em `app/Services/`.

**Funcionalidade central:** depoimento enviado pelo público (`POST /depoimentos`) e moderado no admin (aprovar ou rejeitar). Só os aprovados aparecem no site.

## Riscos → verificações

| Risco | Verificação | Gate |
|---|---|---|
| R1. Depoimento não aprovado aparece no site | Unitário do `TestimonialService` + feature `GET /depoimentos` | Testes |
| R2. Visitante sem login acessa o `/admin` | Feature: cada grupo do admin redireciona para o login | Testes |
| R3. Envio público inválido é aceito (sem nome, arquivo que não é imagem, imagem grande) | Feature `POST /depoimentos`, casos negativos | Testes |
| R4. CRUD de notícias quebra ou deixa imagem órfã | Feature com `Storage::fake` | Testes + cobertura |
| R5. Código que não compila ou não sobe | Build do front + boot do Laravel | Build |
| R6. Bug de tipo ou código fora do padrão | Pint, Larastan, ESLint | Análise estática |
| R7. Dependência vulnerável ou segredo versionado | `composer audit`, `npm audit`, Gitleaks | Dependências / segredos |

## Quality gates

| # | Gate | Critério | Consequência |
|---|---|---|---|
| G1 | Build | `composer install`, `npm ci` e `npm run build` sem erro | Bloqueia |
| G2 | Análise estática | Pint sem diferença, Larastan sem erro novo (baseline aceita os antigos), ESLint sem erro | Bloqueia |
| G3 | Testes | 100% dos testes passando | Bloqueia |
| G4 | Cobertura | ≥ X% em `app/Services` (X medido na E3 e justificado) | Bloqueia |
| G5 | Dependências | Nenhuma vulnerabilidade crítica | Bloqueia |
| G6 | Segredos | Gitleaks sem achados | Bloqueia |

A ficha completa de cada gate (critério, justificativa, momento, evidência, consequência, limitação) fica em `docs/qaops/gates.md` (E3).

## Ferramentas

GitHub Actions + branch protection · PHP 8.4 · Node 22 · PHPUnit 11 com SQLite em memória · PCOV (cobertura) · Laravel Pint · Larastan · ESLint + Prettier · `composer audit` / `npm audit` · Gitleaks · artifacts (JUnit, cobertura em HTML) + resumo do job.

## Entregas e andamento

Ordem: E0 → (E1 e E2 em paralelo) → E3 → E4 → E5. Cada entrega tem a sua branch, o seu PR e um chat novo.

### E0. Base — Carlos
- [ ] Dependências instaladas, testes rodando localmente com SQLite em memória
- [ ] 12 testes quebrados do starter kit corrigidos ou removidos, com o motivo no PR
- [ ] `HasFactory` nos models `News`, `Partner` e `Testimonial` (libera a E2 sem mexer em `app/`)
- [ ] Pint aplicado uma vez no código todo (commit só de estilo)
- [ ] README: como instalar, rodar os testes e as verificações localmente
- [ ] Este plano na `main`

### E1. Pipeline — Carlos
- [ ] `.github/workflows/ci.yml` disparado por push e PR na `main`
- [ ] Jobs: dependências e build (G1), análise estática (G2), testes (G3), dependências (G5)
- [ ] Larastan instalado, com nível e baseline justificados
- [ ] Artifacts (JUnit, logs) e resumo do job com a tabela dos gates
- [ ] Branch protection na `main`: PR obrigatório, checks obrigatórios, 1 aprovação

### E2. Testes — Renato
- [ ] Factories de `News`, `Partner` e `Testimonial`
- [ ] Testes de R1 a R4, com casos positivos e negativos, unitários (`tests/Unit`) e de feature/integração (`tests/Feature`)
- [ ] `docs/qaops/testes.md`: tabela risco → teste → tipo, com justificativa do que ficou de fora

### E3. Gates finais — Carlos
- [ ] Cobertura com PCOV, limite medido sobre os testes da E2 (G4)
- [ ] Gitleaks no pipeline (G6)
- [ ] `docs/qaops/gates.md` com a ficha de cada gate

### E4. Experimento — Renato faz, Carlos revisa
- [ ] Run aprovado registrado
- [ ] PR com alteração controlada (remover o filtro `is_approved` no `TestimonialService`): pipeline vermelho, merge bloqueado
- [ ] Correção no mesmo PR: pipeline verde
- [ ] `docs/qaops/experimento.md` com os links dos 3 runs, onde e por que falhou, e o tempo de cada run

### E5. Relatório e defesa — os dois
- [ ] Carlos: seções 1, 4, 6 e 8 (feedback, tempo, custo de manutenção)
- [ ] Renato: seções 2, 3, 5 e 7
- [ ] Juntos: 8 (lacunas, evolução, deploy e observabilidade), 9, referências e o roteiro da defesa (quem fala o quê)

## Donos de cada área

| Área | Dono |
|---|---|
| `.github/`, `phpunit.xml`, `phpstan.neon`, `phpstan-baseline.neon`, `pint.json`, `.gitleaks.toml`, `docs/qaops/gates.md` | Carlos |
| `composer.json`/`composer.lock`, `package.json`/`package-lock.json` | Carlos |
| `tests/`, `database/factories/`, `docs/qaops/testes.md`, `docs/qaops/experimento.md` | Renato (depois da E0) |
| `app/`, `routes/`, `resources/`, `database/migrations/` (código de produção) | Compartilhado: só muda depois de combinar com o outro |
| `docs/qaops/PLANO.md` | Cada um marca só as próprias entregas |

## Como trabalhamos juntos

1. **Antes de mexer na área do outro, fale com ele.** Se a sua entrega precisa mudar um arquivo do outro ou do código compartilhado, pare e combine antes (mensagem ou comentário no PR). A sessão do Claude não muda esses arquivos sozinha: ela para e pede que a pessoa alinhe com o colega.
2. **Precisa de uma dependência nova?** Peça ao Carlos (dono do `composer.json` e do `package.json`), para evitar conflito nos lockfiles.
3. **Achou um bug no código de produção?** Não conserte por conta. Abra uma issue ou comente no PR e combinem quem corrige.
4. **Comece sempre da `main` atualizada:** `git switch main && git pull`, depois crie a branch.
5. **Nunca faça push direto na `main`** nem `push --force` em branch que o outro também usa.
6. **PR pequeno, de uma entrega só.** O outro revisa e aprova, ninguém faz merge do próprio PR sem a revisão.
7. **Antes do push**, rode localmente os testes e o lint que o pipeline roda.
8. **Nenhum segredo no repo:** `.env`, senhas e tokens ficam fora. O que o CI precisar vai em *Settings → Secrets*.
9. **Marque o andamento neste arquivo** no PR da entrega.
10. **Com o Claude:** ele pede permissão antes de cada commit (mostrando a mensagem e os arquivos), push e PR, e responde em português.

## Convenções

**Branch:** `<tipo>/e<N>-<assunto-curto>`, em minúsculas e com hífen. Exemplos: `chore/e0-base`, `ci/e1-pipeline`, `test/e2-testimonials`, `ci/e3-coverage-gate`, `test/e4-experiment`, `docs/e5-report`.

**Commit:** [Conventional Commits](https://www.conventionalcommits.org/), em inglês, no imperativo, com até 72 caracteres no título. É um commit por mudança lógica.
- Tipos: `feat`, `fix`, `test`, `ci`, `docs`, `style`, `refactor`, `chore`, `build`.
- Exemplos: `test: cover testimonial moderation visibility`, `ci: add static analysis job`, `style: apply laravel pint`.
- Sem trailer de coautoria de IA (`Co-Authored-By`, "Generated with…").
- Cada um commita com o próprio nome e o e-mail da própria conta GitHub (`git config user.name` / `user.email`), para os commits aparecerem como de cada integrante.

**Pull request:**
- Título no formato do commit, com a entrega: `ci(e1): add GitHub Actions pipeline`.
- Corpo:
  ```
  ## Entrega
  E<N> — <nome>
  ## O que muda
  - …
  ## Riscos / gates afetados
  R… / G…
  ## Como testar
  - …
  ## Evidências
  Link do run do Actions, prints se ajudar
  ```
- Revisor: o outro integrante. O merge é feito com **"Create a merge commit"**, para manter no histórico da `main` os commits de cada um e os do experimento (falha e correção).
- A branch é apagada depois do merge.

## Rodar localmente (sem Sail)

```bash
docker run --rm -v "$PWD":/app -w /app composer:2 install
npm ci && npm run build
docker run --rm -v "$PWD":/app -w /app -e DB_CONNECTION=sqlite -e DB_DATABASE=:memory: php:8.4-cli php artisan test
```

(A E0 confirma esses comandos e leva a versão final para o README.)
