# AI tasks with Mistral Code (remote & CLI)

This repo is set up so that coding tasks can be run either **locally via the CLI**
or **remotely via GitHub Issues** using [Mistral Code](https://docs.mistral.ai/vibe/code/cli/work-with-cli)
(the `mistral-vibe` CLI).

## Prerequisites (one-time)

1. **Add repo secret:** Settings → Secrets and variables → Actions →
   `MISTRAL_API_KEY` with an API key from the Mistral Console (Code > Vibe CLI).

## AI agent configuration

- `AGENTS.md` — entry point for all AI coding agents (Mistral Code, Junie, …),
  links to the full guidelines.
- `.ai/guidelines.md` — development guidelines (TDD, fixtures, setlist tests, changelog).
- `.ai/guidelines/Environment.md` — environment specifics (WSL2/DDEV).
- `.ai.json` — trusted commands (test, lint, fix, stan, ci via DDEV).

## Option A: remotely via an issue

Any open issue becomes a task:

- Add the **`ai-task` label** → the workflow starts, using the issue title + body as the prompt.
- Or **comment** `/ai` (optionally followed by extra instructions, e.g.
  `/ai only fix the Filterable rename, add a test`). Only owners/collaborators/members may use `/ai`.

What happens on the runner:

1. Checkout onto a fresh branch `ai/task-<number>`
2. `composer install` + PHP 8.3
3. `vibe --prompt "<issue content>" --max-turns 40 --output json` (programmatic mode,
   no interactive UI, auto-approve)
4. If there are changes: commit + push + **draft PR**; the link is posted as a comment on the issue
5. If there are no changes: a comment on the issue links to the run logs

You then only review the PR. Close the issue once the PR is merged.

### Follow-up on a pull request via review

Submit a review whose **body starts with `/ai`** (optionally followed by
instructions, e.g. `/ai please fix the naming as discussed in the inline comments`).
The agent then:

1. Checks out the PR head branch
2. Works on the review instructions (with PR title/body as context)
3. Pushes follow-up commits **to the existing PR** — no new PR is created

Only owners/collaborators/members may use `/ai` in reviews. Inline code review
comments alone do not trigger the agent — only the review summary body counts.

### Manual task without an issue

Actions tab → "AI Task (Mistral Code)" → **Run workflow** → enter a prompt.

## Option B: locally via the CLI

```bash
./scripts/ai-task.sh 49                                   # work on issue #49
./scripts/ai-task.sh "Add rename Foo::bar to Foo::baz in the SS 6.1 set"
./scripts/ai-task.sh 49 "Only fix the Filterable rename, add a tes
t"
```

The script creates an `ai/task-…` branch and starts `vibe` interactively,
so you can watch and steer the agent while it works. For headless /
scripted runs:

```bash
vibe --prompt "Fix all failing tests" --max-turns 40 --output json
```

## Security notes

- In the CI runner the agent only has the repo's `GITHUB_TOKEN` and can only
  create branches/PRs in this repo.
- Remote runs always produce **draft PRs** — nothing gets merged without your review.
- If `/ai` gets abused by strangers: tighten the `author_association` check in the
  workflow (e.g. `OWNER` only).
