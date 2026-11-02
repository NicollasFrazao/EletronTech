## Description

<!-- What changes and why. If it fixes a defect, say what happened before. If it ports a feature
     from v1, name the screen of the technical documentation (F1–F25). -->

## Issue

<!--
The keyword must be one GitHub recognizes: `Closes`, `Fixes` or `Resolves`
(or `closed` / `fixed` / `resolved`). Anything else is a plain mention, and the
issue stays open after the merge without anyone noticing.

Pasting the issue URL does not link it either. Use the number: `Closes #123`.

Check after opening, because the failure is silent:
  gh pr view <N> --json closingIssuesReferences
-->

Closes #

## Verification

<!-- Results, not "tested": "24/24 tests, coverage 93.2%". `make gate` runs all of them. -->

- [ ] `composer pint`, `composer phpcs`, `npm run lint`
- [ ] `composer phpstan`, `composer phpmd`, `composer phpmnd`
- [ ] `composer deptrac`, `composer rector`, `composer unused`, `npm run check:unused`
- [ ] `composer test:coverage`
- [ ] `composer audit`, `npm audit --omit=dev --audit-level=high`
- [ ] `composer context:check`

## Risks and caveats

<!--
What the review must look at closely, and what was left out on purpose.
For a calculator: which formula and which NBR 5410 table it relies on.
For anything that reads a user's data: how ownership is checked.
-->
