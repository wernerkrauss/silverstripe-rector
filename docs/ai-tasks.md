# AI Tasks mit Mistral Code (remote & CLI)

Dieses Repo ist so eingerichtet, dass Coding-Tasks wahlweise **lokal über die CLI**
oder **remote über GitHub Issues** von [Mistral Code](https://docs.mistral.ai/vibe/code/cli/work-with-cli)
(dem `mistral-vibe` CLI) ausgeführt werden können.

## Voraussetzungen (einmalig)

1. **Repo-Secret anlegen:** Settings → Secrets and variables → Actions →
   `MISTRAL_API_KEY` mit einem API-Key aus der Mistral Console (Code > Vibe CLI).

## Konfiguration für AI-Agenten

- `AGENTS.md` — Einstiegspunkt für alle AI-Coding-Agents (Mistral Code, Junie, …),
  verweist auf die vollständigen Guidelines.
- `.ai/guidelines.md` — Entwicklungsguidelines (TDD, Fixtures, Setlist-Tests, Changelog).
- `.ai/guidelines/Environment.md` — Umgebung (WSL2/DDEV).
- `.ai.json` — Trusted Commands (test, lint, fix, stan, ci via DDEV).

## Variante A: Remote per Issue

Ein offenes Issue wird zum Task:

- **Label `ai-task`** hinzufügen → Workflow startet, Issue-Titel + -Body werden als Prompt verwendet.
- Oder **Kommentar** mit `/ai` (optional gefolgt von Zusatzanweisungen, z. B.
  `/ai only fix the Filterable rename, add a test`). Nur Owner/Collaboratoren/Mitglieder dürfen `/ai` nutzen.

Ablauf im Runner:

1. Checkout auf frischen Branch `ai/task-<nummer>`
2. `composer install` + PHP 8.3
3. `vibe --prompt "<Issue-Inhalt>" --max-turns 40 --output json` (programmatic mode,
   kein interaktiver UI, Auto-Approve)
4. Bei Änderungen: Commit + Push + **Draft-PR**, Link wird als Kommentar am Issue gepostet
5. Ohne Änderungen: Kommentar am Issue mit Verweis auf die Run-Logs

Du reviewst dann nur noch den PR. Das Issue kannst du schließen, sobald der PR gemerged ist.

### Manueller Task ohne Issue

Actions-Tab → „AI Task (Mistral Code)" → **Run workflow** → Prompt eingeben.

## Variante B: Lokal per CLI

```bash
./scripts/ai-task.sh 49                                   # Issue #49 bearbeiten
./scripts/ai-task.sh "Add rename Foo::bar to Foo::baz in the SS 6.1 set"
./scripts/ai-task.sh 49 "Only fix the Filterable rename, add a test"
```

Das Skript legt einen Branch `ai/task-…` an und startet `vibe` interaktiv,
sodass du den Agenten beim Arbeiten siehst und steuern kannst. Für headless/
skriptgesteuerte Läufe:

```bash
vibe --prompt "Fix all failing tests" --max-turns 40 --output json
```

## Sicherheitshinweise

- Der Agent läuft im CI-Runner nur mit dem `GITHUB_TOKEN` des Repos und kann
  ausschließlich Branches/PRs in diesem Repo anlegen.
- Remote-Läufe erzeugen immer **Draft-PRs** – nichts wird ohne dein Review gemerged.
- Sollte `/ai` von Fremden missbraucht werden: die `author_association`-Prüfung im
  Workflow einschränken (z. B. nur `OWNER`).
