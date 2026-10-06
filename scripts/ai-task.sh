#!/usr/bin/env bash
# Run a coding task with Mistral Code (mistral-vibe CLI) against this repo.
#
# Usage:
#   ./scripts/ai-task.sh 49                 # work on issue #49 (title + body as prompt)
#   ./scripts/ai-task.sh "Add rename X to Y in the SS 6.0 set"
#   ./scripts/ai-task.sh 49 "Only fix the Filterable part, add a test"
#
# Requires:
#   - mistral-vibe CLI installed and authenticated (vibe --setup / MISTRAL_API_KEY)
#   - gh CLI with repo access, when passing an issue number
set -euo pipefail

usage() { sed -n '2,12p' "$0"; exit 1; }
[ $# -ge 1 ] || usage

ISSUE=""
INSTRUCTIONS=""

if [[ "$1" =~ ^[0-9]+$ ]]; then
  ISSUE="$1"
  shift
fi
[ $# -ge 1 ] && INSTRUCTIONS="$*"

PROMPT=""
if [ -n "$ISSUE" ]; then
  PROMPT="$(gh issue view "$ISSUE" --json title,body -q '.title + "\n\n" + .body')"
fi
if [ -n "$INSTRUCTIONS" ]; then
  [ -n "$PROMPT" ] && PROMPT="$INSTRUCTIONS

---
Issue #$ISSUE:
$PROMPT" || PROMPT="$INSTRUCTIONS"
fi
[ -n "$PROMPT" ] || { echo "No task given." >&2; exit 1; }

# Suggest a branch so agent changes stay separate
BRANCH="ai/task-$(date +%Y%m%d-%H%M%S)"
git rev-parse --git-dir > /dev/null 2>&1 || { echo "Not a git repo." >&2; exit 1; }
git checkout -b "$BRANCH" 2> /dev/null || echo "Note: branch $BRANCH already exists, staying on current branch."

echo "▶ Starting Mistral Code on branch $(git branch --show-current) ..."
# Interactive mode lets you review and steer the agent while it works.
# For scripted/headless use, run instead:
#   vibe --prompt "$PROMPT" --max-turns 40 --output json
vibe "$PROMPT"
