# Defesa — roteiro de 10 a 12 minutos

Atende à seção 9 do [enunciado](enunciado.pdf): demonstrar o acionamento do pipeline, uma execução aprovada, uma reprovação, as evidências e a correção. O professor pode perguntar a cada integrante: as perguntas prováveis e as respostas estão em [`perguntas.md`](perguntas.md), e os dois ensaiam tudo, não só a própria parte.

Os números citados vêm do [`relatorio.md`](relatorio.md). Os slides ficam em [`slides.html`](slides.html) (abrir no navegador, setas trocam o slide).

## Como é a demonstração

A demonstração repete ao vivo a regressão da E4, sem tocar na `main`:

- A branch `demo/defesa` já está no GitHub com um commit que remove o filtro `is_approved` de `TestimonialService::getPaginated()`, a mesma linha do [experimento](experimento.md). Push em branch que não é a `main` não dispara o CI, então ela fica parada até o PR.
- **Acionamento:** abrir o PR `demo/defesa` → `main` durante a fala. O pipeline começa na hora.
- **Reprovação:** G3 e Quality gates vermelhos, 6 testes de R1 reprovados (154 aprovados), merge bloqueado. Conferido localmente em 23/11/2026 com a suíte de 160 testes.
- **Correção:** `git revert` do commit e push na mesma branch. O pipeline roda de novo e fica verde.
- **Fim:** o PR é fechado **sem merge** e a branch é apagada. O PR fechado fica no histórico como evidência.

**Tempo do run hoje:** os 16 runs registrados levaram de 31 s a 65 s, com mediana de 36,5 s; os dois últimos (PR #8 e merge na `main`) levaram 34 s e 37 s. No experimento, o G3 reprovou 23 s depois do início. O roteiro reserva cerca de 1 min para cada run e preenche a espera com fala. Se nenhum check começar em 90 s, vale o plano B.

## Antes da defesa

- [ ] Ensaiar uma vez com cronômetro, os dois juntos, trocando quem fala cada bloco pelo menos uma vez.
- [ ] Conferir que a `demo/defesa` não tem PR aberto e está com o commit da regressão (`git log origin/demo/defesa -1`).
- [ ] Clone local atualizado e com a branch pronta: `git fetch && git switch demo/defesa && git pull`.
- [ ] Logado no GitHub no navegador e no `gh` (`gh auth status`).
- [ ] Abas abertas, na ordem:
  1. `slides.html`
  2. Comparação para abrir o PR: <https://github.com/carloseduardorocha/bicho-do-mato-qaops/compare/main...demo/defesa?expand=1>
  3. Run aprovado da `main`: o do merge deste relatório (ou [45305184824](https://github.com/carloseduardorocha/bicho-do-mato-qaops/actions/runs/45305184824))
  4. Plano B: PR [#7](https://github.com/carloseduardorocha/bicho-do-mato-qaops/pull/7) e o run reprovado [45247878043](https://github.com/carloseduardorocha/bicho-do-mato-qaops/actions/runs/45247878043)
- [ ] Terminal aberto na pasta do repo, fonte grande.
- [ ] Offline: `relatorio.pdf`, `slides.html` e a imagem `img/e4-merge-bloqueado.png` funcionam sem internet.

O Carlos opera o computador o tempo todo; quem fala no bloco diz o que clicar. Assim ninguém troca de cadeira no meio.

## Roteiro

| Tempo | Quem | O que falar | Na tela |
|---|---|---|---|
| 0:00–0:40 | Carlos | Quem somos, o sistema (site da ONG Bicho do Mato) e a ideia: cada push e PR passa por 6 gates e um gate vermelho bloqueia o merge. | Slide 1 |
| 0:40–1:50 | Renato | A funcionalidade estudada: depoimento do público nasce pendente e só aparece depois de aprovado. Os 7 riscos: R1 a R4 de comportamento (só teste pega), R5 a R7 de construção (ferramenta pega). | Slide 2 |
| 1:50–2:50 | Carlos | O pipeline: um job por gate, em paralelo, G4 depois do G3, e o Quality gates como juiz. A branch protection exige os 7 checks e 1 aprovação, inclusive para admin. | Slide 3 |
| 2:50–3:20 | Carlos | **Acionamento.** "Vamos repetir ao vivo o experimento da E4: esta branch tira uma linha, o filtro de aprovados." Mostrar o diff de 1 linha e clicar em *Create pull request*. | Aba 2 → PR novo, checks amarelos |
| 3:20–4:30 | Carlos | Enquanto roda: os 6 gates, o critério de cada um e por que todos bloqueiam. Destacar o G4 por Service e a limitação de cada gate. | Slide 4 |
| 4:30–6:30 | Renato | **Reprovação e evidências.** Voltar ao PR: G3 e Quality gates vermelhos, os outros 5 verdes, todos *Required*, merge bloqueado. Abrir o G3: as 6 anotações com arquivo e linha. Abrir o *Summary*: tabela dos gates e lista dos testes que falharam. Mostrar os artifacts (`g3-tests-junit`, `g4-coverage-report`). Explicar por que só o G3 reprovou: o código continua válido, no padrão e coberto. | PR → G3 → Summary → Artifacts |
| 6:30–6:50 | Renato | **Correção.** "Devolvemos a linha." O Carlos roda `git revert --no-edit HEAD && git push`. | Terminal → PR, checks amarelos |
| 6:50–8:00 | Carlos | **Execução aprovada**, enquanto a correção roda: o run verde da `main`. Tabela dos gates no *Summary*, cobertura por Service (88,7% no total), G5 com o aviso médio do `psy/psysh` que só alerta, G6 com os commits varridos. Os artifacts expiram em 90 dias, por isso o `experimento.md` guarda o log e a imagem. | Aba 3 → Summary → Artifacts |
| 8:00–8:40 | Renato | **Corrigido.** Voltar ao PR: 7 checks verdes, falta só a aprovação. Fechar o PR sem merge: é uma demonstração; no experimento original (PR #7) o merge foi feito com *merge commit* para guardar a falha e a correção. | PR verde → *Close pull request* |
| 8:40–9:30 | Renato | O experimento registrado: a previsão feita antes do run (só o G3 reprova, cobertura em 90,09%) se confirmou. O limite: um defeito só, escolhido sabendo que havia teste. | Slide 5 |
| 9:30–10:30 | Carlos | Análise crítica: a revisão humana achou o que os gates não achavam (`pipefail`, senhas do seeder, contador de rotas). Lição: ligar a branch protection antes do primeiro PR. | Slide 6 (esquerda) |
| 10:30–11:00 | Renato | Limitação mais importante: testes em SQLite, sem MySQL nem navegador (o BUG-7 só aparece no MySQL). Próximo passo: deploy só do que passou nos gates. "Obrigado, perguntas?" | Slide 6 (direita) |

Total: 11 min, com 1 min de folga para a espera do Actions.

## Plano B

| Problema | O que fazer |
|---|---|
| O run demora (nenhum check em 90 s, ou fila longa) | Seguir o roteiro e mostrar a reprovação no run gravado: PR [#7](https://github.com/carloseduardorocha/bicho-do-mato-qaops/pull/7), run reprovado [45247878043](https://github.com/carloseduardorocha/bicho-do-mato-qaops/actions/runs/45247878043) e corrigido [45250612311](https://github.com/carloseduardorocha/bicho-do-mato-qaops/actions/runs/45250612311). Voltar ao PR ao vivo no fim, se já tiver terminado. |
| O PR não abre pelo navegador | No terminal: `gh pr create --base main --head demo/defesa --title "demo: E4 regression live (do not merge)" --body "Live defense demo. Closed without merge."` |
| O push da correção falha | Mostrar a correção no PR #7 (commit `de93873`) e o run corrigido gravado. |
| Sem internet | Slides (offline), [`experimento.md`](experimento.md) com o trecho do log, a imagem `img/e4-merge-bloqueado.png` do PR bloqueado e a tabela dos três runs no `relatorio.pdf`. |
| Outros gates reprovados | G5 no PR #4 (run [45177015733](https://github.com/carloseduardorocha/bicho-do-mato-qaops/actions/runs/45177015733), crítica no `laravel/framework`) e G2 no PR #5 (run [45186604535](https://github.com/carloseduardorocha/bicho-do-mato-qaops/actions/runs/45186604535)), se o professor pedir. |

## Depois da defesa

Fechar o PR da demonstração sem merge (se ainda estiver aberto) e apagar a branch: `gh pr close <número> --delete-branch`.
