# Perguntas prováveis da defesa

Apoio para a [defesa](defesa.md): o professor pode perguntar a cada integrante individualmente (§9 do [enunciado](enunciado.pdf)). As perguntas saem da análise crítica (§8) e das fichas dos gates (§6). Cada um estuda com mais cuidado a parte que **não** fez: o Renato, o pipeline e os gates; o Carlos, os testes e o experimento. As respostas resumem o [relatório](relatorio.md), onde está o detalhe.

## Para os dois: análise crítica (§8)

**Quais riscos foram cobertos e quais ficaram?**
R1 a R4 por testes que já provaram pegar defeito (9 defeitos injetados, 7 bugs reais, o experimento); R5 a R7 por ferramentas. Ficaram: regras do MySQL, navegador e formulário de parceiros e usuários; o *hash* da senha que ainda pode ir ao log (BUG-6); o aviso médio do `psy/psysh`; senha fraca, que o Gitleaks não pega.

**O feedback é rápido e compreensível?**
Rápido: de 31 s a 65 s, mediana de 36,5 s, porque os gates rodam em paralelo; o G3 reprovou 23 s depois do início. Compreensível: o check tem o nome do gate, cada teste que falha vira anotação no arquivo e na linha, e o *Summary* traz a tabela. A ressalva é o contador de rotas do G1, que mostrou 0 em todos os runs até ser corrigido.

**O que continua manual?**
A revisão do PR (que achou o `pipefail`, as senhas do seeder e o README que não subia o app), o teste contra o MySQL real, a conferência visual, a decisão sobre avisos altos e médios do G5 e o deploy.

**Qual o custo de manter?**
Os testes de feature dependem das telas e das mensagens: mudar um formulário pode exigir ajustar vários testes. O G4 obriga teste para toda linha nova nos Services. O `ci.yml` também tem lógica (Python e `jq`) que pode ter defeito, e versões de *actions* e do Gitleaks precisam de atualização.

**Automação isolada × prática DevOps/QAOps?**
Automação isolada roda as ferramentas sem mudar o fluxo. Aqui cada gate nasce de um risco, tem critério justificado, bloqueia o merge, a revisão do colega é obrigatória e a evidência fica no PR. Os PRs #1 a #4 entraram sem aprovação porque a proteção foi ligada depois: a revisão posterior do PR #4 achou o `pipefail`, e esse pipeline já estava na `main`.

**O que falta para implantação e observabilidade?**
Deploy só por push na `main` com gates verdes, num *environment* com aprovação manual e credenciais em *Secrets*; artefato imutável em vez de `git pull` no servidor; migrations testadas contra MySQL e backup antes de migrar; homologação com *smoke test*; logs sem dados sensíveis, monitoramento de 5xx e alerta; rollback rápido.

**Qual a limitação mais importante?**
A suíte roda em SQLite, sem MySQL nem navegador: um defeito do banco real, como o BUG-7 (coluna de 255 para texto de 500), passa por todos os gates.

**Como vocês dividiram o trabalho?**
Até a E4, cada um foi dono de uma área: o Carlos fez base, pipeline e gates (E0, E1, E3); o Renato fez a suíte de testes, a correção dos bugs e o experimento (E2, E4). Na E5, o Carlos fez as mudanças e o Renato revisou e aprovou os PRs.

## Para o Renato: pipeline e gates

**Como o pipeline é acionado?**
Todo push e todo PR para a `main` (`.github/workflows/ci.yml`). Um push novo na mesma branch cancela o run anterior, e o token do workflow só tem permissão de leitura.

**Por que um job por gate?**
Para o check do PR dizer exatamente qual gate falhou, e para rodarem em paralelo. A soma dos jobs seria bem maior que os ~37 s do run.

**O que faz o job "Quality gates"?**
Espera todos os outros, escreve a tabela aprovado/reprovado no *Summary* e reprova se qualquer gate falhou ou foi cancelado. É o check que resume a decisão.

**Por que o G4 depende do G3, e por que roda mesmo se o G3 falhar?**
O G4 lê a cobertura (Clover) medida na mesma execução dos testes. Roda mesmo com teste falhando porque cobertura e testes são gates diferentes e os dois resultados interessam.

**O que de fato bloqueia o merge?**
A *branch protection* da `main`: PR obrigatório, 1 aprovação do outro integrante, os 7 checks verdes (G1 a G6 e Quality gates) e branch atualizada com a `main`. Vale também para administradores.

**O que o G1 verifica, se não há build de front?**
`composer install` e `php artisan route:list`: o Laravel sobe e carrega as 44 rotas, o que pega dependência quebrada, erro de sintaxe e controller inexistente. Não renderiza views nem conecta no MySQL.

**Por que Larastan nível 5?**
Medimos: do nível 0 ao 5 aparecem 3 a 4 erros, todos defeitos reais; do 6 em diante saltam para 86, dos quais 82 são só falta de anotação de tipo. O nível 5 pega defeito sem virar trabalho de anotação. A baseline está vazia.

**De onde vêm os limites do G4?**
Da cobertura medida, arredondada para baixo em múltiplos de 5: `TestimonialService` 90%, `NewsService` 80%, `PartnerService` 80%, `UserService` 100%, total 85% (hoje 88,7%). É por arquivo para ninguém compensar um Service com outro. Não é 100% porque falta só o `catch` de falha do disco, que protege pouco os riscos.

**Cobertura alta garante qualidade?**
Não. Mostra que a linha rodou, não que o teste conferiu o resultado. No experimento a cobertura continuou acima do limite com o defeito. Quem garante o comportamento é o G3; o G4 aponta código que nenhum teste executa.

**Por que o G5 só bloqueia vulnerabilidade crítica?**
Crítica num site público com login costuma permitir exploração remota. Alta e média geram alerta para não travar a entrega por um aviso sem correção. Já bloqueou de verdade: PR #4, crítica no `laravel/framework`, corrigida na mesma *major*.

**Por que o Gitleaks varre o histórico inteiro?**
Um segredo apagado do arquivo continua nos commits antigos, e o repositório é público. Já aconteceu: a senha do admin da ONG estava no seeder do original e foi reescrita em todos os commits antes de publicar.

**O que é o `pipefail` e por que importou?**
Nos passos `comando | tee log`, o bash ficava só com o código de saída do `tee`, que sempre dá certo. Sem `pipefail`, o G2 e o boot do G1 nunca reprovariam. Foi achado na revisão do PR #4 (pelo próprio Renato) e corrigido no PR #5, com um run vermelho de prova.

**Quais gates já reprovaram de verdade?**
G5 no PR #4, G2 no PR #5 (prova do `pipefail`) e G3 no experimento. G1, G4 e G6 não têm reprovação registrada no GitHub.

**Onde estão as evidências?**
Nos checks do PR, nas anotações no arquivo e na linha, no *Summary* do run e nos artifacts (logs, JUnit, cobertura em HTML, audit, Gitleaks). Expiram em 90 dias, por isso o `experimento.md` guarda o trecho do log e a imagem.

**E se alguém quiser afrouxar um gate?**
Limite é código: muda por PR, com revisão do outro. Falso positivo do Gitleaks vai para um `.gitleaksignore` revisado e exceção do Larastan para a baseline revisada; nenhum gate é desligado para passar um PR.

## Para o Carlos: testes e experimento

**Qual a diferença entre os testes unitários e os de feature?**
Unitários (68) chamam os Services direto, sem rota nem controller. Feature (92) são integração por HTTP: rota, middleware, validação, controller, Service, banco e view. São 160 no total.

**Por que os unitários usam SQLite em vez de *mocks*?**
Os Services usam o Eloquent direto, sem repositório. Com *mock*, o teste verificaria o dublê e não o filtro da consulta, que é justamente o defeito do experimento.

**Por que arquivo real e não `UploadedFile::fake()`?**
O arquivo falso do Laravel deduz o tipo pela extensão e aceitaria um script renomeado para `.jpg`. O disco é simulado (`Storage::fake`), mas o arquivo é real.

**Que casos negativos e de limite existem?**
Nome, texto e foto ausentes, vazios, no limite e um acima (100 e 500 caracteres, 2 MB); PDF, SVG e script disfarçado recusados. Toda recusa confere o erro no campo, nenhum registro no banco e nenhum arquivo no disco.

**Por que R2 não tem teste unitário?**
A regra está na ligação entre rota e middleware, que só existe no fluxo HTTP. Um teste falha se surgir um grupo novo do admin fora da verificação.

**Como vocês sabem que os testes pegam defeitos?**
Nove defeitos injetados à mão, um por vez, e todos pegos (de 1 a 11 testes reprovando). Os testes acharam 7 bugs reais, corrigidos no PR #3. E o experimento.

**Quais bugs os testes acharam?**
Exemplos: remover imagem apagava qualquer arquivo do disco público (BUG-2), a senha ia em texto puro para o log (BUG-6) e depoimento de 256 a 500 caracteres falhava no MySQL (BUG-7, verificado à mão porque o SQLite não impõe o tamanho).

**O que ficou de fora dos testes?**
Navegador (E2E), carga, regras do MySQL e formulário de parceiros e usuários pelo admin. A decisão de mostrar ou não o depoimento é do servidor, então E2E custaria muito para pouco risco.

**Qual foi a hipótese do experimento?**
Se alguém quebrar a moderação de depoimentos, o pipeline percebe e bloqueia o merge? Removemos o filtro `is_approved` da lista pública (R1).

**Por que essa alteração?**
Porque o código continua válido, no padrão e sem erro de tipo: só um teste de comportamento consegue perceber. É o caso que justifica o G3.

**O que vocês previram e o que aconteceu?**
Previsão registrada antes do run: só o G3 reprova, e o G4 cai para 90,09% no `TestimonialService`, ainda acima de 90%. Aconteceu isso: 6 testes de R1 reprovaram (2 unitários, 4 de feature) e nenhum outro gate.

**Por que o G4 não reprovou?**
Todas as linhas de `getPaginated()` continuaram executadas, só que sem o filtro. Saiu uma linha das 112 (100/111 = 90,09%).

**Por que o merge com *merge commit*?**
Para o histórico da `main` guardar o commit que quebra e o que corrige, como evidência do experimento.

**Por que um run levou 36 s e outro 49 s?**
Variação do ambiente do GitHub, não efeito da alteração: com um run de cada, não dá para concluir nada sobre tempo.

**Qual o limite do experimento?**
Um defeito só, num gate só, escolhido sabendo que havia teste. As reprovações reais do G2 e do G5 complementam, e um defeito fora de R1 a R4 pode passar.

**E se um teste for instável?**
O G3 não tolera falha: teste instável é corrigido, não ignorado. Um `markTestSkipped` não reprova, mas aparece como *Skipped* no *Summary* e precisa de justificativa no PR.
