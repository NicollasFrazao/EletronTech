# EletronTech

A PHP web system with engineering calculators (electrical, math, physics) for students and professionals in technical fields. It has a user area, a "shop" that sells packages of tools, an admin panel and a mobile web version.

Team project from about 2015-2016 (the mobile "Sobre" page says "ANYTECH - 2016").

## What it does

### Web user area (`Login.php`, `ET.php`)

- **Accounts**:
  - registration with client-side validation;
  - account confirmation and password recovery by email (PHPMailer over SMTP);
  - login and logout;
  - account deactivation with a reactivation date.
- **User area** (`ET.php`) loads each section in an iframe:
  - **Favoritos** (`Inicio.php`): favourite tools.
  - **Perfil** (`Perfil.php`): profile and cover photo, personal details, password change, night mode, and showing or hiding the tutorial.
  - **Eventos** (`Eventos.php`): personal events (create, edit, delete) with export to PDF (mPDF) or TXT.
  - **Licença** (`Licenca.php`): the user's current tool package, with a presentation video (`ET.mp4`).
  - **Ferramentas** (`Ferramentas.php`): the tools unlocked by the user's packages.
  - **Arquivos** (`Arquivos.php`): a personal file manager with folders, upload, download and an in-browser document viewer. Downloading `.php` and `.html` files is blocked.
  - `chat.html` is a chat interface with no backend.
- **Calculators** (`FEI/`):
  - Área e Perímetro, Capacitância Elétrica, Condutância Elétrica, Conversor de Grandezas, Disjuntor e Fiação, Iluminação Geral, Impedância Elétrica, Indutância Elétrica, Potência Geral, Potência de Iluminação, Quantificação de Tomadas, Rendimento de Motor, and a basic calculator.
  - Each tool has its own validation and calculation script in `FEI/script/`.
  - Each use is recorded in `tb_utilizacao`.
- **Diagramação de Projetos** (`FEI/projeto/`): a floor-plan editor for rooms ("cômodos"), with outlets, lighting points and window/door frames ("esquadrias"). It is drawn on canvas with KineticJS and saved to MySQL.
- **Eletron Tech Shop** (`ETS/`): a catalogue of tool packages, including user-built custom packages. "Buying" a package only writes it to the database for a number of days. There is no payment integration.

### Admin panel (`et-admin/`)

- Dashboard with RGraph charts: accesses, users online, activity, downloads and calculations.
- Gestão de Usuários: search, edit, activate/deactivate and delete users.
- User activity log and statistics.
- Reports exported to PDF with mPDF: the activity log and a user list.
- An admin file manager.

### Mobile version (`mobile/`)

- `index.php` sends small screens to `mobile/` and everything else to `Login.php`.
- Built with jQuery Mobile. It has login, registration, profile, password reset, feedback and "Sobre" screens.
- It has a larger calculator set than the web version: for example Bernoulli, Cálculo de Resistores, Consumo Elétrico, Conversor Binário, Medidor de BTU, Pisos e Azulejos, Quantificação de Blocos and Regra de Três.
- User, package and tool data is copied into a browser WebSQL database (`mobile/js/banco.js`) and synced with the server.
- The feedback form posts to a hard-coded remote URL on `anytech.com.br`.

### Other folders

- `agenda/` is a separate, smaller event-agenda module.

## Tech stack

- PHP 5 using the `mysql_*` extension, which was removed in PHP 7. No framework.
- MySQL, with stored procedures for some calculations (`Banco/Procedures.txt`).
- HTML, CSS and JavaScript, using jQuery 1.11, jQuery UI 1.11.4, jQuery Mobile 1.4.5, KineticJS 5.1.1 and RGraph.
- PHPMailer 5.1 for email. mPDF for PDF export: it is expected at `../../pdf/mpdf.php`, outside this repository, and is not included.

## Running locally

This is not practical as-is, because the database schema and the mPDF library are missing. To try it:

1. Use PHP 5.6 with Apache (for example the `php:5.6-apache` Docker image) and MySQL 5.x.
2. Create a database named `db_eletrontech`. Every `Conexao.php` holds its own connection settings, with `***REMOVED***` as user and password: `php/`, `ETS/php/`, `et-admin/php/`, `mobile/php/`, `FEI/php/`, `mobile/FEI/php/` and `agenda/`. The four `FEI/projeto/*_comodo.php` files have their own copies too. Change them to your values.
3. Recreate the tables. There is no complete schema. The code uses `tb_usuario`, `tb_pasta`, `tb_arquivo`, `tb_evento`, `tb_atividade`, `tb_ferramenta`, `tb_pacote`, `usuario_pacote`, `pacote_ferramenta`, `tb_utilizacao`, `tb_visita`, `tb_projeto`, `tb_comodo`, `tb_esquadria`, `tb_tomada`, `tb_ponto_eletrico`, `tb_estado` and `tb_cidade`. Partial definitions exist in:
   - `Banco/tb_acesso.txt` (the `tb_acesso` table);
   - `Banco/Procedures.txt` (two stored procedures);
   - `agenda/banco.txt` (the agenda module);
   - the `create table` statements in `mobile/js/banco.js`, which mirror the columns of `tb_usuario`, `tb_ferramenta`, `tb_pacote`, `tb_utilizacao`, `usuario_pacote` and `pacote_ferramenta`.
4. Put mPDF where the `include` expects it, or skip the PDF exports.
5. Email confirmation needs SMTP settings in `php/EnviarConfirmacao.php` and `php/RecuperarSenha.php`, and the `mobile/php/` copies.

## Project structure

```
index.php            redirect to mobile/ or Login.php by screen width
Login.php, ET.php    login and the user area shell
Inicio/Perfil/Eventos/Licenca/Ferramentas/Arquivos.php   user area sections
php/                 user-area endpoints (auth, profile, events, files, PDF/TXT export)
script/, css/        validation scripts, jQuery, styles
FEI/                 calculators; FEI/projeto/ floor-plan editor
ETS/                 Eletron Tech Shop (tool packages)
et-admin/            admin panel, RGraph, PDF reports
mobile/              jQuery Mobile version + WebSQL sync
agenda/              standalone agenda module
Banco/               SQL notes (procedures, tb_acesso) and a server-to-local sync script
Users/               sample uploaded profile/cover images
imagens/, icones/, Páginas/   images and screenshots
```

## Notes

- Legacy code: no tests, no dependency manager, and a lot of code duplicated between the web, mobile and admin parts.
- Security is weak by current standards:
  - passwords are stored Base64-encoded, not hashed;
  - SQL is built by string concatenation (`mysql_escape_string` in places);
  - the session checks are basic.
- File and folder names contain spaces and accents. `Thumbs.db` files are committed. `LEIA-ME.txt` is a to-do note in Latin-1.
- `ET.php` loads `Mensagens.php` but the file is `mensagens.php`, so that section breaks on case-sensitive filesystems.
- Database dumps, connection passwords and the developers page (with the other team members' names and contacts) were removed from the history. The connection files keep `***REMOVED***` placeholders.
- Third-party material:
  - RGraph is bundled under its CC BY-NC 3.0 licence (`et-admin/RGraph/license.txt`), which does not allow commercial use;
  - two sample images of commercial characters were removed from the repository.
