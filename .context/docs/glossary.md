---
type: doc
name: glossary
description: Domain vocabulary in English with the Portuguese of the 2015 original, and the only abbreviations allowed in names
category: reference
generated: 2026-11-02
status: filled
scaffoldVersion: "2.0.0"
---

# Glossary

The English term is the name in code (classes, methods, tables, routes). The Portuguese column is
what the 2015 code, its tables (`tb_*`) and the technical documentation call it, so a reader can go
from one to the other. Add a term here before using it in code.

## Electrical installation (NBR 5410)

| English (code) | Portuguese (original) | Meaning |
| --- | --- | --- |
| NBR 5410 | NBR 5410 | ABNT standard for low-voltage electrical installations, the reference for every calculation |
| Low voltage | Baixa tensão (BT) | Installations up to 1000 V AC, the scope of NBR 5410 and of this application |
| Electrical project | Projeto elétrico (`tb_projeto`) | A floor plan with its rooms and electrical points, owned by a user |
| Floor plan | Planta baixa | The top view of the building the project is drawn on |
| Project diagramming | Diagramação de projetos | The floor-plan editor (screen F17) |
| Room | Cômodo (`tb_comodo`) | A rectangle of the plan, with length, width, wall thickness, area and perimeter |
| Door or window frame | Esquadria (`tb_esquadria`) | A door or window on a room's wall: type, orientation, width, height |
| Electrical point | Ponto elétrico (`tb_ponto_eletrico`) | A place in a room where something electrical is installed |
| Outlet | Tomada (`tb_tomada`) | A socket outlet at an electrical point |
| General-purpose outlet | Tomada de uso geral (TUG, `tb_tug`) | An outlet for any appliance; NBR 5410 sets a minimum count and power per room |
| Specific-purpose outlet | Tomada de uso específico (TUE, `tb_tue`) | An outlet for one known appliance (shower, oven), sized by its power |
| Light point | Ponto de luz | A lighting point on the ceiling or wall |
| Switch | Interruptor (`tb_interruptor`) | A light switch at an electrical point |
| Circuit | Circuito | A group of points fed by one breaker (out of v2 scope, #15) |
| Breaker | Disjuntor | Protection device of a circuit, sized by current |
| Breaker rating (rated current, I_n) | Corrente nominal do disjuntor | The current a breaker is built for; IEC 60898-1 preferred values from 6 A to 125 A |
| Design current (I_B) | Corrente de projeto | The current a circuit's load draws: S / V, or S / (√3 × V) for three phases |
| Current-carrying capacity (I_Z) | Capacidade de condução de corrente | The current a conductor carries continuously (NBR 5410 table 36); I_B ≤ I_n ≤ I_Z |
| Loaded conductors | Condutores carregados | Conductors that carry the load current: two for one or two phases, three for three phases |
| Circuit purpose | Tipo de circuito (iluminação / força) | Lighting or power (outlets, appliances); sets the minimum section, 1.5 or 2.5 mm² (table 47) |
| Supply system | Sistema de fornecimento (monofásico, bifásico, trifásico) | Single-phase (phase and neutral), two-phase (between two phases) or three-phase |
| Wet room | Área molhada | Bathroom, kitchen, pantry, service area or laundry: 600 VA for each of the first three outlets |
| Distribution board | Quadro de luz / quadro de distribuição | Where the breakers are (out of v2 scope, #15) |
| Conductor / wire gauge | Condutor / fiação / bitola do fio | A circuit's wire and its cross-section in mm² |
| Conduit | Eletroduto | The pipe the conductors run through |
| Lighting calculation | Cálculo luminotécnico | Number of light points and total luminous flux for a room |
| Lumen method | Método dos lúmens | Φ = E × A / (u × d): the total flux a room needs, then the number of luminaires |
| Luminaire | Luminária | A light fitting with its lamps; its flux (lm) and power (W) are inputs of the lumen method |
| Room index (K) | Índice do local | c × l / (h × (c + l)), the room's proportions as the utilisation table reads them |
| Useful height | Altura útil | Height between the work plane and the luminaires (direct) or the ceiling (indirect) |
| Ceiling height | Pé-direito | Height from floor to ceiling |
| Work plane | Plano de trabalho | The height where the illuminance is wanted, such as a desk top |
| Luminaire suspension | Suspensão da luminária | How far a luminaire hangs below the ceiling |
| Lighting system | Sistema de iluminação | Direct, diffuse, semi-direct, semi-indirect or indirect |
| Reflectance | Refletância / coeficiente de reflexão | The share of light a surface (ceiling, walls, work plane) reflects, in percent |
| Utilisation factor (u) | Coeficiente de utilização | Share of the luminaires' flux that reaches the work plane, from a table by K and reflectances |
| Depreciation factor (d) | Fator de depreciação | Share of the flux left before the next cleaning, by room cleanliness and maintenance interval |
| Room cleanliness | Ambiente (limpo, normal, sujo) | How dirty the air is, for the depreciation factor |
| Maintenance interval | Manutenção (2500 h, 5000 h, 7500 h) | Hours of use between cleanings of the luminaires |
| Single-line diagram | Diagrama unifilar | Circuit diagram with one line per circuit (out of v2 scope, #17) |
| Bill of materials | Lista de materiais | Everything a project needs to be built (out of v2 scope, #16) |

## Calculators (tools)

| English (code) | Portuguese (original, `FEI/`) |
| --- | --- |
| Tool | Ferramenta (`tb_ferramenta`) — a calculator or the floor-plan editor |
| Area and perimeter | Área e Perímetro |
| Basic calculator | Calculadora (EletronTech Calc) |
| Electrical capacitance | Capacitância Elétrica |
| Electrical conductance | Condutância Elétrica |
| Unit converter | Conversor de Grandezas |
| Breaker and wiring | Disjuntor e Fiação |
| General lighting | Iluminação Geral |
| Electrical impedance | Impedância Elétrica |
| Electrical inductance | Indutância Elétrica |
| General power | Potência Geral |
| Lighting power | Potência de Iluminação |
| Outlet count | Quantificação de Tomadas |
| Motor efficiency | Rendimento de Motor |
| Resistor colour code, electrical consumption | Cálculo de Resistores (código de cores), Consumo Elétrico (mobile site only) |
| Binary converter, BTU meter, floor and wall tiles, block count, rule of three, Bernoulli | Conversor Binário, Medidor de BTU, Pisos e Azulejos, Quantificação de Blocos, Regra de Três, Bernoulli (mobile site only) |
| Calculator | Ferramenta de cálculo | A tool implementing the `Calculator` contract: an identifier, an input schema, a calculation |
| Calculator catalogue | Catálogo de ferramentas | Every calculator by identifier (`CalculatorCatalog`) |
| Input schema | Campos do formulário | The inputs a calculator reads: quantity with a default unit, pure number or choice, required or optional |
| Intermediate value | Valor intermediário | A step of a calculation shown with the answer: an area, a room index, a factor read from a table |
| Turns | Número de espiras | The turns of a coil; with the flux through each, N × Φ is the flux linkage |
| Useful, lost and input power | Potência útil, dissipada e total | A motor's output, its losses and what it takes from the supply; efficiency η = useful / input |
| Efficiency | Rendimento | Useful over input power, greater than 0 and at most 1 |
| Tariff | Tarifa | The price of one kWh on the electricity bill |
| Colour bands | Faixas de cores | Two digits, a multiplier and a tolerance on a resistor (IEC 60062) |
| Tolerance | Tolerância | How far a resistor may be from its nominal value, in percent; ±20% without a band |
| Tool use | Utilização (`tb_utilizacao`) — one recorded use of a tool by a user |

## Physical quantities

The classes of `app/Domain/Quantity/`. Each stores its value in the coherent unit of the table.

| English (code) | Portuguese | Coherent unit |
| --- | --- | --- |
| Voltage | Tensão | volt (V) |
| Current | Corrente | ampere (A) |
| Power (active power) | Potência (ativa) | watt (W) |
| Apparent power | Potência aparente | volt-ampere (VA) |
| Power factor | Fator de potência | dimensionless, greater than 0 and at most 1 |
| Reactive power | Potência reativa | volt-ampere reactive (var) |
| Resistance / impedance / reactance | Resistência / impedância / reatância | ohm (Ω) |
| Conductance | Condutância | siemens (S) |
| Capacitance | Capacitância | farad (F) |
| Inductance | Indutância | henry (H) |
| Charge | Carga elétrica | coulomb (C) |
| Energy | Energia / consumo | joule (J); the bill counts kilowatt-hours (kWh) |
| Duration | Tempo / período | second (s) |
| Frequency | Frequência | hertz (Hz) |
| Length | Comprimento | metre (m) |
| Area | Área | square metre (m²) |
| Magnetic flux | Fluxo magnético | weber (Wb) |
| Luminous flux | Fluxo luminoso | lumen (lm) |
| Illuminance | Iluminância | lux (lx); the foot-candle is one lumen per square foot |

| English (code) | Portuguese | Meaning |
| --- | --- | --- |
| Dimension | Grandeza | The kind of quantity a unit measures; units convert only within one dimension |
| Unit | Unidade de medida | A base unit with an optional prefix, such as kilowatt; identified in forms by `kilowatt`, `milliampere_hour` |
| Base unit | Unidade | A unit without its prefix: volt, ampere-hour, horsepower, inch |
| Prefix | Prefixo | pico, nano, micro, milli, centi, kilo, mega, giga |
| Coherent unit | Unidade coerente (SI) | The SI unit of a dimension without a prefix; what quantities store their value in |
| Metric horsepower | Cavalo-vapor (cv) | 735.49875 W; the horsepower (hp) is 745.69987158227022 W |
| CGS units (abvolt, statcoulomb...) | Unidades CGS | The electromagnetic (ab-) and electrostatic (stat-) units the 2015 converter offered |
| Precision | Precisão / arredondamento | How a result is rounded for display: significant digits or decimal places, always half up |

## Accounts, packages and licences

| English (code) | Portuguese (original) | Meaning |
| --- | --- | --- |
| User | Usuário (`tb_usuario`) | A registered person; an admin has `ic_admin = 1` in the original |
| Account confirmation | Confirmação de cadastro | Email link that activates a new account |
| Password recovery | Recuperação de senha / esqueceu a senha | Reset by email |
| Account deactivation | Desativação da conta (`ic_ativado`, `dt_reativar`) | The user disables the account until a reactivation date |
| Profile | Perfil | Personal details, profile photo (`im_usuario`), cover photo (`im_capa`), night mode |
| Night mode | Modo noturno | Dark theme preference |
| Package | Pacote (`tb_pacote`) | A set of tools with a cost; ready-made or custom |
| Custom package | Pacote customizado (`ic_custom`) | A package whose tools the user picked |
| Licence | Licença (`usuario_pacote`) | A user's right to a package between a start and an end date (`dt_inicio`, `dt_termino`, `qt_dias`) |
| Initial licence | Licença inicial | Seven days with a free package, granted on registration |
| Shop | Eletron Tech Shop (`ETS/`) | The package catalogue and the "purchase" screen |
| Favourites | Favoritos (`Inicio.php`) | The user's favourite tools on the home section |

## Events, files and administration

| English (code) | Portuguese (original) | Meaning |
| --- | --- | --- |
| Event | Evento (`tb_evento`) | A personal agenda entry: name, date, time, description |
| Folder | Pasta (`tb_pasta`) | A folder in the user's file manager; folders nest (`cd_subpasta`) |
| File | Arquivo (`tb_arquivo`) | An uploaded or generated file inside a folder |
| File manager | Gerenciador de arquivos (`Arquivos.php`) | Folders, upload, download, viewer |
| Activity | Atividade (`tb_atividade`) | A logged user action, shown in the admin activity log |
| Visit | Visita (`tb_visita`) | A page access by a user, for statistics |
| Access | Acesso (`tb_acesso`) | A login attempt with IP, browser and error count |
| Admin panel | Painel administrativo (`et-admin/`) | User management, logs, statistics, reports |

## Abbreviations allowed in names

`id`, `url`, `pdf`, `txt`, `sql`, `http`, `db`, `dto`, `nbr`, `tug`, `tue`, `va` (volt-ampere),
`btu` (British thermal unit).
Units are spelled out in names (`Power::fromWatts()`), symbols appear only in output.
