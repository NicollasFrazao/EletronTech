---
type: doc
name: project-overview
description: What EletronTech does, for whom, the 2015 original as the functional reference, and the v2 roadmap
category: overview
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Project overview

EletronTech is a web application for electricians, electrical technicians and students: calculators
for the electrical, mathematical and physical quantities they work out by hand, and a floor-plan
editor for low-voltage residential electrical projects, following the Brazilian standard
**ABNT NBR 5410** and its simplified symbols.

It started as the final project of an IT technical course in 2015 (ETEC Doutora Ruth Cardoso,
São Vicente, Brazil): procedural PHP 5 with the `mysql_*` extension, jQuery, KineticJS and a separate
jQuery Mobile site. Version 2 rewrites it as a tested Laravel 13 application with a layered
architecture and the same features, completed and fixed. The plan is issue #2.

## Who it is for

The 2015 research (a survey of similar software and interviews with 17 building-construction
students) found that commercial tools are expensive, complex, often tied to AutoCAD and rarely in
Portuguese, and that wiring calculations and the time a project takes are the main difficulties.
EletronTech aims at people with less formal training: simple language, simplified symbols and
calculations that follow the standard.

## Features (v2 scope)

| Area | What it does | Phase |
| --- | --- | --- |
| Physical quantities | Exact value objects for voltage, current, power, apparent power, resistance, conductance, capacitance, inductance, charge, frequency, length and area, with their units and prefixes; the unit converter | E1 #4 |
| Electrical calculators | Breaker and wiring, general lighting, lighting power, outlet count, capacitance, conductance, impedance, inductance, general power, motor efficiency | E2 #5 |
| General calculators | Area and perimeter, construction quantities, a basic calculator and the extra tools of the mobile site | E3 #6 |
| Accounts | Registration, email confirmation, password recovery, profile and cover photos, night mode, deactivation with a reactivation date | E4 #7 |
| Packages and licences | Tool packages (ready-made and custom), the initial seven-day licence with a free package, the shop | E5 #8 |
| Floor-plan editor | Rooms, door and window frames, electrical points and outlets on a canvas, saved per project | E6 #9 |
| Events and files | Personal events with PDF/TXT export; a personal file manager with folders, upload and download | E7 #10 |
| Admin panel | Users, activity log, statistics and reports, with Filament | E8 #11 |
| Responsive UI | One responsive interface instead of the separate mobile site | E9 #12 |
| Release | Documentation, records and `v2.0.0` | E10 #13 |

Out of scope, because the 2015 documentation planned them but the code never had them (issue #14
and its sub-issues): circuits, breakers and the distribution board inside projects, the bill of
materials, single-line diagrams, payments, messages between users.

## The original as the functional reference

- **Code:** the tag [`v1`](https://github.com/NicollasFrazao/eletrontech/tree/v1) and the branch
  `legacy/v1` keep the 2015 code exactly as submitted. Read it to know what a feature did; never copy
  it (it stores passwords in Base64 and builds SQL from strings, see [security.md](security.md)).
- **Documentation:** [`docs/technical-documentation-pt-BR.pdf`](/docs/technical-documentation-pt-BR.pdf),
  in Portuguese: business rules (6.1), use cases (6.2), class diagram (6.3), requirements per screen
  F1–F25 (6.4), the database diagram (6.5) and data dictionary (6.6). Each calculator screen lists
  its inputs, outputs and validations.
- **Names:** the original is in Portuguese; v2 code is in English. The [glossary](glossary.md) maps
  one to the other, and is the source of every domain name in the code.

## Business rules carried over (documentation, section 6.1)

- A new account receives an initial licence of **seven days** with a free tool package.
- A user unlocks tools by acquiring packages, which change the tools available and the licence
  period. Packages are ready-made (tools grouped by category) or **custom** (the user picks every tool).
- In the floor-plan editor the user enters the dimensions of the building, draws rooms, then adds
  doors, windows and electrical points.
- Each use of a calculator is recorded (`tb_utilizacao` in the original), for the user's history and
  the admin statistics.
- A user can deactivate the account and reactivate it later.

## Stack

Laravel 13 on PHP 8.4, MySQL 8.4, queues on the database driver, Mailpit for mail in development,
Vite for assets, Filament for the admin panel (from E8). Docker Compose for the local environment.
