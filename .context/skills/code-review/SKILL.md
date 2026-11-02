---
type: skill
name: Code Review
description: Review a change in this repository against its layer rules, documentation rules and gate. Use when reviewing a pull request or a local diff before merge
skillSlug: code-review
phases: [R, V]
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Code review

1. Run the gate on the branch: `make gate` (one check at a time). Record the numbers: tests,
   coverage, and any finding.
2. Read the diff by layer, domain first. For each file, check the list in
   [agents/code-reviewer.md](../../agents/code-reviewer.md): layer, units, ported formulas,
   ownership, doc comments, glossary names.
3. Check the docs moved with the code: doc comments on new public API, the glossary for new terms,
   `.context/docs/` and `docs/adr/` when a rule or a decision changed, and that the surfaces were
   re-exported (`composer context:check`).
4. Ask for the missing test rather than describing the bug.
5. One comment per finding, with the file and line, what goes wrong, and the smallest fix.
