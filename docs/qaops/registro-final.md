# Registro final da dupla

Última página do [enunciado](enunciado.pdf). O detalhe das contribuições está na seção 9 do [relatório](relatorio.md).

| Campo | Registro |
|---|---|
| Integrante 1 | Carlos Rocha (`carloseduardorocha`) |
| Integrante 2 | Renato Piovesan (`renatopiovesan`) |
| Repositório | <https://github.com/carloseduardorocha/bicho-do-mato-qaops> |
| Contribuição do integrante 1 | Base do repositório (E0), pipeline no GitHub Actions com *branch protection* (E1), gates de cobertura e de segredos e as fichas dos gates (E3), revisão geral, relatório e defesa (E5). Revisou os PRs #2, #3 e #7. |
| Contribuição do integrante 2 | Suíte de testes de R1 a R4, injeção dos nove defeitos e correção dos sete bugs encontrados (E2), experimento aprovado → reprovado → corrigido (E4). Na revisão do PR #4, achou o `pipefail` ausente; revisou e aprovou os PRs #5, #6 e #8 e os da E5. |
| Limitação mais importante | A suíte roda em SQLite, sem MySQL nem navegador. Um defeito do banco real, como o BUG-7 (coluna de 255 caracteres para um texto de 500), passa por todos os gates e só foi verificado à mão. |
| Confirmação | ☐ Ambos revisaram o repositório, as evidências e o relatório. |

A caixa é marcada (☑) pelos dois depois de lerem o relatório, a [defesa](defesa.md) e as [perguntas](perguntas.md).
