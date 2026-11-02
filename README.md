# EletronTech

Electrical calculators and a floor-plan editor for low-voltage residential electrical projects,
following the Brazilian standard ABNT NBR 5410, for electricians, electrical technicians and students.

**Version 2 is being rewritten** in Laravel 13 with a layered, tested architecture (plan: #2). This
branch holds the foundation: the Laravel skeleton, the Docker environment, the quality gate and the
engineering standards. The features arrive phase by phase (E1–E10).

## Run it

Requirements: Docker with Compose v2, and Node.js 22 for the front-end tooling and git hooks.

```bash
make setup   # dependencies and git hooks
make up      # app on http://localhost:8000, Mailpit on http://localhost:8025
make gate    # every CI check, one at a time
```

`docker compose up` alone also works on a fresh clone. Details in
[development-workflow.md](.context/docs/development-workflow.md).

## Documentation

- [Context index](.context/docs/README.md): overview, architecture, conventions, glossary, testing,
  security, tooling and technical debt. **Read [development-conventions.md](.context/docs/development-conventions.md)
  before changing anything.**
- [Architecture decision records](docs/adr/README.md).
- [CONTRIBUTING.md](CONTRIBUTING.md) and [SECURITY.md](SECURITY.md).
- [Technical documentation of 2015](docs/technical-documentation-pt-BR.pdf) (in Portuguese): the
  functional reference for v2.

## v1: the 2015 final project

EletronTech started as the final project (TCC) of the IT technical course (Técnico em Informática) at
ETEC Doutora Ruth Cardoso, Centro Paula Souza (São Vicente, Brazil), presented in June 2015:
procedural PHP 5 with `mysql_*`, jQuery, KineticJS and a jQuery Mobile site.

The original code is kept exactly as submitted, with its full README:

- tag [`v1`](https://github.com/NicollasFrazao/eletrontech/tree/v1);
- branch [`legacy/v1`](https://github.com/NicollasFrazao/eletrontech/tree/legacy/v1).

The team: Gustavo Alves de Araújo, João Gabriel de Almindo Vasconcelos, Lucas Sérgio Denhei
Alexandre, Luiz Carlos Marcelino Junior and Nícollas Frazão.

## License

The code is under the [MIT License](LICENSE). The 2015 technical documentation in
[`docs/`](docs/technical-documentation-pt-BR.pdf) is the team's work and is not covered by it.
