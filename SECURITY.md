# Security policy

## Reporting a vulnerability

Please do not open a public issue. Report it privately through GitHub's
[private vulnerability reporting](https://github.com/NicollasFrazao/eletrontech/security/advisories/new)
with:

- what an attacker can do (for example: read another user's files or projects, sign in as someone
  else, upload something that runs on the server);
- the requests or the test that reproduce it;
- the commit you tested.

You can expect an acknowledgement within a week. Fixes are released on `master` and credited in the
advisory unless you prefer otherwise.

## Supported versions

Only the latest commit on `master` (v2) is supported. The 2015 code at the `v1` tag and the
`legacy/v1` branch is archived as submitted, has known weaknesses (Base64 passwords, SQL built from
strings) and will not be fixed; do not deploy it.
