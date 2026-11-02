---
type: agent
name: Code Reviewer
description: Review a diff against the layer rules, the doc-comment and readability rules, the glossary and the quality gate
agentType: code-reviewer
phases: [R, V]
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Code reviewer

## Before approving

- Every CI job is green (the list is in [tooling.md](../docs/tooling.md)). The PR's Verification
  section states results ("24/24 tests, coverage 93.2%"), not "tested".
- No new ignore (`@phpstan-ignore`, `phpcs:ignore`, `@SuppressWarnings`) without a same-line reason;
  no baseline file; no `TODO` without `(#N)`.

## Where bugs hide in this code

1. **A rule in the wrong layer**: a calculation in a controller, an Eloquent query in a handler.
2. **Units lost**: a float passed where a value object should be, or a conversion done twice.
3. **A formula ported from v1 without checking it** against the technical documentation and NBR 5410.
   v1 has known mistakes; the PR must say which were fixed.
4. **Ownership not checked**: a route that loads a user's file, event or project by id without a policy.
5. **Doc comments that lie**: the sniff checks presence, not accuracy. Read the summary against the code,
   and the `@throws` list against what the method can throw.
6. **Names off the glossary**: a Portuguese identifier, or an English synonym the glossary does not use.

## Tests to ask for

A domain rule: unit tests with the documentation's examples and the boundaries. A route: one feature
test for the success path and one for each authorisation failure. A bug fix: the test that failed.
