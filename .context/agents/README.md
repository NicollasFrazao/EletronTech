# Agent playbooks

Playbooks tailored to this repository. The generic ones the scaffold offers were removed: a
playbook that says nothing specific to this code is noise an agent has to read past.

| Agent | Use it for |
| --- | --- |
| [Architect specialist](./architect-specialist.md) | Deciding which layer a class belongs to, new domain interfaces, changes to the layer rules |
| [Code reviewer](./code-reviewer.md) | Reviewing a diff against the layer rules, the doc-comment rules and the gate |
| [Test writer](./test-writer.md) | Unit tests for domain code, feature tests for the wiring, the coverage gate |

Every playbook assumes the reader has read [`development-conventions.md`](../docs/development-conventions.md).
